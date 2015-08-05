<?php

namespace common\models;

use Yii;
use common\models\TaskApplicant;
use common\models\Resume;

/**
 * This is the model class for table "{{%account_event}}".
 *
 * @property integer $id
 * @property string $date
 * @property integer $user_id
 * @property string $value
 * @property string $created_time
 * @property string $balance
 * @property integer $type
 * @property string $note
 * @property integer $related_id
 */
class AccountEvent extends \yii\db\ActiveRecord
{
    public static $TYPES = [
        0 => '导入',
        1 => '微信推荐红包',
    ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%account_event}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'created_time'], 'safe'],
            [['user_id', 'type', 'related_id'], 'integer'],
            [['value', 'balance', 'type'], 'required'],
            [['value', 'balance'], 'number'],
            [['note'], 'string', 'max' => 400]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '流水id',
            'date' => 'excel标记日期',
            'user_id' => '用户id',
            'value' => '变更金额',
            'created_time' => '变更时间',
            'balance' => '余额',
            'type' => '变更原因类型',
            'note' => '备注',
            'related_id' => '关联id（提现id 或 任务id）',
        ];
    }

    public function saveUploadData($excel_data){
        $import_data    = array();
        $errmsg         = "";
        foreach( $excel_data as $k => $v ){
            if( $k == 1 ){
                continue;
            }else{
                $saverow = $this->saveUploadDataByRow($v,$k);
                if( $saverow['result'] === true ){
                    $import_data[]   = $saverow['data'];
                }else{
                    $errmsg    .= $saverow['errmsg'];
                }
            }
        }
        if( $errmsg ){
            $errmsg   = "未导入信息：<br />".$errmsg;
        }
        return ['result'=>true,'import_data'=>$import_data,'errmsg'=>$errmsg];
    }

    public function saveUploadDataByRow($data,$key){
        // 验证任务和用户是否对应正确
        $task_applicant_obj = new TaskApplicant();
        $is_user_apply      = $task_applicant_obj->findBySql("
            SELECT t.title
            FROM jz_task_applicant a
            LEFT JOIN jz_task t ON a.task_id=t.id
            WHERE a.user_id=".$data['D']." AND t.gid='".$data['B']."'")
            ->asArray()->one();
        if( $is_user_apply['title'] ){
            // 验证用户信息是否正确
            $user_info  = Resume::find()
                ->where([
                    'user_id'=>$data['D'],
                    'name'=>$data['C'],
                    'phonenum'=>$data['E'],
                    'person_idcard'=>$data['F']
                ])
                ->one();
            if( $user_info ){
                return $this->saveUploadDataByRowSaveIt($data,$is_user_apply['title'],$user_info);
            }else{
                $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，用户信息不匹配<br />"; 
            }
        }else{
            $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，报名信息不匹配<br />";
        }
        return ['result'=>false,'errmsg'=>$errmsg];
    }

    public function saveUploadDataByRowSaveIt($data,$task_title,$user_info){
        $this->date     = Yii::$app->office_phpexcel->dateExceltoPHP($data['A']);
        $this->user_id  = $data['D'];
        $this->value    = $data['G'];
        $this->note     = $data['H'];
        $this->operator_id  = Yii::$app->user->id;
        $this->created_time = date("Y-m-d H:i:s");
        $this->related_id   = $data['B'];
        $this->balance  = 0;
        $this->type     = 0;
        $this->save();
        $data           = $this->toArray();
        $data['task_title'] = $task_title;
        $data['user_name']  = $user_info->name;
        $data['user_pbone'] = $user_info->phonenum;
        $data['user_idcard']= $user_info->person_idcard;
        return ['result'=>true,'data'=>$data];
    }

    public function getAccounts(){
        return $this->hasMany($this::className(), ['user_id' => 'user_id']);
    }

    public function extraFields(){
        return ['accounts'];
    }

}
