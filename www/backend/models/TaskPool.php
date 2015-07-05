<?php

namespace backend\models;

use Yii;

use common\models\Task;
use common\models\TaskAddress;
use common\models\Company;
use common\models\ServiceType;
use common\models\District;

/**
 * This is the model class for table "{{%task_pool}}".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $city
 * @property string $origin_id
 * @property string $origin
 * @property double $lng
 * @property double $lat
 * @property string $details
 * @property integer $has_poi
 * @property integer $has_imported
 * @property string $created_time
 */
class TaskPool extends \common\BaseActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'origin_id', 'origin', 'details'], 'required'],
            [['lng', 'lat'], 'number'],
            [['details'], 'string'],
            [['has_poi', 'status'], 'integer'],
            [['created_time'], 'safe'],
            [['company_name', 'city'], 'string', 'max' => 200],
            [['origin_id', 'origin'], 'string', 'max' => 45],
            [['origin_id', 'origin'], 'unique', 'targetAttribute' => ['origin_id', 'origin'], 'message' => '已抓取过'],
            ['status', 'default', 'value'=>0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => '公司名',
            'city' => '城市',
            'origin_id' => '来源id',
            'origin' => '来源',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'details' => '细节',
            'has_poi' => '位置精准？',
            'status' => '状态',
            'status_label' => '状态',
            'created_time' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     * @return TaskPoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaskPoolQuery(get_called_class());
    }

    public function getStatus_options()
    {
        return [
            0=> '未处理',
            10=> '已导入',
            11=>'已放弃',
        ];
    }

    public function getStatus_label()
    {
        return $this->status_options[$this->status];
    }

    public function getOrigin_url()
    {
        if ($this->origin=='xiaolianbang'){
            return 'http://m.xiaolianbang.com/pt/' . $this->origin_id . '/detail';
        }
    }

    public function list_detail()
    {
        $s = [];
        foreach(json_decode($this->details) as $attr=>$value){
            $s[$attr] = $value ;
        }
        return $s;
    }

    public function exportTask()
    {
        if ($this->status!=0){
            return false;
        }
        $ds = $this->list_detail();
        $task = new Task;
        $task->title = $ds['title'];

        $cp = 3;
        foreach (Task::$CLEARANCE_PERIODS as $k=>$v)
        {
            $cp = $v==$ds['clearance_period']?$k:$cp;
        }
        $task->clearance_period = $cp;

        $task->salary = intval($ds['salary']);
        if ($task->salary!=0){
            $su = null;
            foreach(Task::$SALARY_UNITS as $k=>$v){
                if ($v==$ds['salary_unit']){
                    $su = $k;
                }
            }
            $task->salary_unit = $su;
        } else {
            $task->salary_unit = 0;
        }

        $task->from_date = $ds['from_date'];
        $task->to_date = $ds['to_date'];
        $task->need_quantity = intval($ds['need_quantity']);
        $task->detail = $ds['content'];
        $task->address = $ds['address'] or '不限';
        $task->user_id = 0;

        $task->company_id = 0;

        if ($this->company_name){
            $com = Company::find()->where([
                'name'=>$this->company_name,
            ])->one();
            if (!$com){
                $com = new Company;
                $com->name = $this->company_name;
                $com->contact_name = $ds['contact']?$ds['contact']:'无';
                $com->contact_phone = $ds['phonenum']?$ds['phonenum']:'00000000000';
                $com->contact_email = $ds['email'];
                $com->save();
            }
            $task->company_id = $com->id;
        }

        $task->contact = $ds['contact']?$ds['contact']:'无';
        $task->contact_phonenum= $ds['phonenum']?$ds['phonenum']:'00000000000';

        $task->service_type_id = $this->getServiceTypeId($ds['origin'], $ds['category_name']);
        $task->city_id = $this->getCityId($this->city);

        $task->save();

        if ($this->lat){
            $ta = new TaskAddress;
            $ta->lat = $this->lat;
            $ta->lng = $this->lng;
            $ta->address = $ds['address'];
            $ta->city = $this->city;
            $ta->task_id = $task->id;
            $ta->save();
        }
        $this->status = 10;
        $this->save();
        return $task;
    }

    private $_stype_dict = [];

    public function getServiceTypeId($origin, $category_name)
    {
        if (!$this->_stype_dict){
            $sts = ServiceType::find()->all();
            foreach($sts as $t){
                $this->_stype_dict[$t->name] = $t->id;
            }
        }
        $arr = [];
        if ($origin=='xiaolianbang'){
            $arr = [
                "发单" => "传单",
                "家教" => "家教",
                "礼仪" => "礼仪模特",
                "实习" => "实习生",
                "展会" => "会展",
                "促销" => "促销",
                "客服" => "客服",
                "小时工" => "小时工", 
                "志愿者" => "志愿者",
            ];
        }
        $category_name = isset($arr[$category_name])?$arr[$category_name]:$category_name;
        if (isset($this->_stype_dict[$category_name])){
            return $this->_stype_dict[$category_name];
        }
        return $this->_stype_dict['其他'];
    }


    public function getCityId($name)
    {
        $city = District::find()->where(['level'=>'city'])->andWhere(
            ['like', 'name', $name . '%', false])->one();
        return $city->id;
    }
}
