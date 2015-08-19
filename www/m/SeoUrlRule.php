<?php

namespace m;

use Yii;
use yii\web\UrlRule;
use yii\base\Object;
use yii\web\UrlRuleInterface;
use common\models\District;
use common\models\ServiceType;


class SeoUrlRule extends UrlRule
{

    public function parseRequest($manager, $request)
    {
        $path    = $request->getPathInfo();
        $url     = $request->getUrl();
        if( stripos($url,'?') || !$path ){
            return false;
        }

        $result  = Yii::$app->cache->get($path);
        //$result = '';
        if( !$result ){
            $path_arr   = explode('/',$path);
            $path_city  = isset($path_arr[0]) ? $path_arr[0] : 'beijing';
            if( $path_city == 'task' ){
                $path_city = 'beijing';
            }
            $path_two   = isset($path_arr[1]) ? $path_arr[1] : '';
            $path_three = isset($path_arr[2]) ? $path_arr[2] : '';
            $city_id    = '3';
            $districts_id = '';
            $type_id    = '';
            $city_pinyin    = 'beijing';
            $districts_pinyin = '';
            $type_pinyin    = '';

            $cities = District::findAll(['level'=>'city', 'is_alive'=>1]);
            $cs_pinyins= [];
            foreach($cities as $city){
                $cs_pinyins[$city->id] = $city->seo_pinyin;
            }
            if( $path_city && $city_id = array_search($path_city,$cs_pinyins) ){
                $city_pinyin= $path_city;
                if( $path_two != 'task' ){
                    $districts  = District::findAll(['level'=>'district','parent_id'=>$city_id, 'is_alive'=>1]);
                    $ds_pinyins = [];
                    foreach($districts as $district){
                        $ds_pinyins[$district->id] = $district->seo_pinyin;
                    }
                    if( $path_two && $districts_id = array_search($path_two,$ds_pinyins) ){
                        $districts_pinyin = $path_two;
                        // 有第二个参数，并且为区
                        $stypes     = ServiceType::findAll(['status'=>0]);
                        $ts_pinyin  = [];
                        foreach( $stypes as $type ){
                            $ts_pinyin[$type->id] = $type->pinyin;
                        }
                        if( $path_three && $type_id = array_search($path_three,$ts_pinyin) ){
                            $type_pinyin = $path_three;
                            // 有第三个参数，并且为类型
                        }else{
                            // 无第三个参数
                        }
                    }else{
                        $stypes     = ServiceType::findAll(['status'=>0]);
                        $ts_pinyin  = [];
                        foreach( $stypes as $type ){
                            $ts_pinyin[$type->id] = $type->pinyin;
                        }
                        if( $path_two && $type_id = array_search($path_two,$ts_pinyin) ){
                            $type_pinyin = $path_two;
                            // 有第二个参数，并且为类型
                        }else{
                            // 无第二个参数
                        }
                    }
                }
            }else{
                return false;
            }

            $result = [
                0   => 'task/index',
                1   => [
                    'city_id'       => $city_id,
                    'districts_id'  => $districts_id,
                    'type_id'       => $type_id,
                    'city_pinyin'       => $city_pinyin,
                    'districts_pinyin'  => $districts_pinyin,
                    'type_pinyin'       => $type_pinyin,
                ],
            ];
            
            Yii::$app->cache->add($path,$result);
        }
        return $result;
    }

}
