<?php

namespace api\miduoduo\v1\models;

use Yii;

use common\models\TaskApplicantOnlinejob;


class TaskApplicantOnlinejobAction extends \yii\rest\CreateAction
{

    public function run()
    {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);
        $data = Yii::$app->getRequest()->getBodyParams();

        $needinfo_arr = [];
        foreach( $data as $k => $v ){
            if( is_numeric($k) ){
                $needinfo_arr[$k] = $v;
                unset($data[$k]);
            }
        }
        $data['needinfo'] = serialize($needinfo_arr);

        $model->load($data, '');
        
        if ($model->save()) {
            if( !isset($data['has_sync_wechat_pic']) || $data['has_sync_wechat_pic'] != 1 ){
                Yii::$app->job_queue_manager->add('wechat-download-img/down',
                    ['id'=>$model->id]
                );
            }
        } elseif (!$model->hasErrors()) {
            return ['success'=>false,"message"=> "添加失败"];
        }

        return ['success'=>true,"message"=> "添加成功",'result'=>$model];
    }

}
