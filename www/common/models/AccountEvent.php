<?php

namespace common\models;

use Yii;
use common\models\TaskApplicant;
use common\models\User;
use common\models\Resume;
use common\models\WithdrawCash;
use common\models\Payout;
use common\BaseActiveRecord;

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
class AccountEvent extends BaseActiveRecord
{
    public static $TYPES = [
        0 => '导入',
        10 => '微信推广红包',
        20 => '提现',
    ];

    const TYPES_UPLOAD      = 0;
    const TYPES_WEICHAT_RECOMMEND  = 10;
    const TYPES_WITHDRAW    = 20;

    public static $LOCKEDS = [
        0 => '否',
        1 => '是',
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
            [['user_id', 'type', 'related_id','locked'], 'integer'],
            [['value', 'balance', 'type'], 'required'],
            [['value', 'balance'], 'number'],
            [['task_gid'], 'string'],
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
            'date' => '日期',
            'user_id' => '用户id',
            'value' => '金额',
            'created_time' => '上传时间',
            'balance' => '余额',
            'type' => '变更原因类型',
            'note' => '备注',
            'related_id' => '提现id',
            'task_gid' => '任务id',
            'locked'    => '锁住',
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
        // 验证用户信息是否正确
        $user_id_obj= User::find()->where(['username'=>$data['D']])->one();
        $user_id    = isset($user_id_obj->id) ? $user_id_obj->id : 0;
        $user_info  = Resume::find()
            ->where([
                'name'=>$data['C'],
                'user_id'=>$user_id,
            ])
            ->one();
        if( $user_info ){
            // 验证任务和用户是否对应正确
            $task_applicant_obj = new TaskApplicant();
            $is_user_apply      = $task_applicant_obj->findBySql("
                SELECT t.title
                FROM jz_task_applicant a
                LEFT JOIN jz_task t ON a.task_id=t.id
                WHERE a.user_id=".$user_info->user_id." AND t.gid='".$data['B']."'")
                ->asArray()->one();
            if( $is_user_apply['title'] ){
                // 验证是否重复录入
                $account_chongfu    = AccountEvent::find()->where([
                    'date'      => $data['A'], 
                    'user_id'   => $user_info->user_id,
                    'value'     => $data['E'],
                    'task_gid'  => $data['B'],
                    'note'      => $data['F'],
                ])->one();
                if( $account_chongfu ){
                    $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，重复录入<br />";
                }else{
                    return $this->saveUploadDataByRowSaveIt($data,$is_user_apply['title'],$user_info);
                }
            }else{
                $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，报名信息不匹配<br />";
            }
        }else{
            $errmsg    = "第[".$key."]行：用户ID[".$data['D']."]，用户信息不匹配<br />"; 
        }

        return ['result'=>false,'errmsg'=>$errmsg];
    }

    public function saveUploadDataByRowSaveIt($data,$task_title,$user_info){
        $model          = new AccountEvent();
        $model->date     = Yii::$app->office_phpexcel->dateExceltoPHP($data['A']);
        $model->user_id  = $user_info->user_id;
        $model->value    = $data['E'];
        $model->note     = $data['F'];
        $model->operator_id  = Yii::$app->user->id;
        $model->created_time = date("Y-m-d H:i:s");
        $model->task_gid     = $data['B'];
        $model->related_id   = '';
        $model->balance  = 0;
        $model->type     = 0;
        $model->save();
        $data           = $model->toArray();
        $data['task_title'] = $task_title;
        $data['user_name']  = $user_info->name;
        $data['user_pbone'] = $user_info->phonenum;
        
        // update user_account
        $user_account_obj = new UserAccount();
        $user_account_obj->updateUserAccount($user_info->user_id);
        
        return ['result'=>true,'data'=>$data];
    }

    public function getAccounts(){
        return $this->hasMany($this::className(), ['user_id' => 'user_id']);
    }

    public function getUserinfo(){
        return $this->hasOne(Resume::className(),['user_id' => 'user_id']);
    }

    public function extraFields(){
        return ['accounts'];
    }

}
