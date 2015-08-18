<?php
namespace common;

use Yii;
use common\models\District;
use common\models\ServiceType;

class Seo
{
    public static function makeSeoCode($city,$block,$type,$clearance_type,$company,$task_title,$page_type,$need_quantity='',$address='',$salary='',$detail='')
    {
        $company    = $company ? $company : '米多多兼职';
        
        $title      = Yii::$app->params['seo']['title'][$page_type];
        $title      = str_ireplace('[task_title]',$task_title,$title);
        $title      = str_ireplace('[city]',$city,$title);
        $title      = str_ireplace('[block]',$block,$title);
        $title      = str_ireplace('[type]',$type,$title);
        $title      = str_ireplace('[clearance_type]',$clearance_type,$title);
        $title      = str_ireplace('[company]',$company,$title);
        $title      = str_ireplace('[clearance_type]',$clearance_type,$title);

        $keywords      = Yii::$app->params['seo']['keywords'][$page_type];
        $keywords      = str_ireplace('[task_title]',$task_title,$keywords);
        $keywords      = str_ireplace('[city]',$city,$keywords);
        $keywords      = str_ireplace('[block]',$block,$keywords);
        $keywords      = str_ireplace('[type]',$type,$keywords);
        $keywords      = str_ireplace('[clearance_type]',$clearance_type,$keywords);
        $keywords      = str_ireplace('[company]',$company,$keywords);
        $keywords      = str_ireplace('[clearance_type]',$clearance_type,$keywords);

        $description      = Yii::$app->params['seo']['description'][$page_type];
        $description      = str_ireplace('[task_title]',$task_title,$description);
        $description      = str_ireplace('[city]',$city,$description);
        $description      = str_ireplace('[block]',$block,$description);
        $description      = str_ireplace('[type]',$type,$description);
        $description      = str_ireplace('[clearance_type]',$clearance_type,$description);
        $description      = str_ireplace('[company]',$company,$description);
        $description      = str_ireplace('[need_quantity]',$need_quantity,$description);
        $description      = str_ireplace('[address]',$address,$description);
        $description      = str_ireplace('[salary]',$salary,$description);
        $description      = str_ireplace('[detail]',$detail,$description);
        $description      = preg_replace('/\s/is','',$description);

        $seo_code   = ['title'=>$title,'keywords'=>$keywords,'description'=>$description];
        //print_r($seo_code);exit;
        return $seo_code;
    }

    public static function parseTaskListParam(){
        $param_one      = Yii::$app->request->get('param_one');
        $param_two      = Yii::$app->request->get('param_two');
        $param_three    = Yii::$app->request->get('param_three');

        if( $param_one ){
            $city_model = District::find()->where(['short_pinyin'=>$param_one,'level'=>'city'])->one();
            $city_id    = isset($city_model->id) ? $city_model->id : '';
            $city_pinyin= $param_one;
        }else{
            $city_id    = 3;
            $city_pinyin= 'bj';
        }
        
        if( $param_two != 'task' ){
            if( $param_two && $param_three ){
                $type_model = ServiceType::find()->where(['pinyin'=>$param_three])->one();
                $type_id    = isset($type_model->id) ? $type_model->id : '';
                $type_pinyin= $param_three;
                
                $block_model = District::find()
                    ->where(['short_pinyin'=>$param_two,'level'=>'district','parent_id'=>$city_id])
                    ->one();
                $block_id    = isset($block_model->id) ? $block_model->id : '';
                $block_pinyin= $param_two;
            }elseif( $param_two ){
                $type_model = ServiceType::find()->where(['pinyin'=>$param_two])->one();
                $type_id    = isset($type_model->id) ? $type_model->id : '';

                if( !$type_id ){
                    $block_model = District::find()->where(['short_pinyin'=>$param_two,'level'=>'district','parent_id'=>$city_id])->one();
                    $block_id    = isset($block_model->id) ? $block_model->id : '';
                    $block_pinyin= $param_two;
                    $type_pinyin = '';
                }else{
                    $block_id    = '';
                    $block_pinyin= '';
                    $type_pinyin = $param_two;
                }
            }else{
                $type_id     = '';
                $block_id    = '';
                $type_pinyin = '';
                $block_pinyin= '';
            }
        }else{
            $block_id    = '';
            $type_id     = '';
            $type_pinyin = '';
            $block_pinyin= '';
        }
        
        $seo_params = [
            'city_id'   => $city_id,
            'block_id'  => $block_id,
            'type_id'   => $type_id,
            'city_pinyin'   => $city_pinyin,
            'block_pinyin'  => $block_pinyin,
            'type_pinyin'   => $type_pinyin,
        ];
        //print_r($seo_params);exit;
        return $seo_params;
    }
}