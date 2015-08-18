<?php

namespace m;


use yii\web\UrlRuleInterface;
use common\models\District;
use common\models\ServiceType;


class SeoUrlRule extends Object implements UrlRuleInterface
{

    public function parseRequest($manager, $request)
    {
        $cities = District::findAll(['level'=>'city', 'is_alive'=>1]);
        $cs_pinyins= [];
        foreach($cities as $city){
            $cs_pinyins[] = $city->short_pinyin;
        }
        $stypes = ServiceType::findAll();
        $path = $request->getPathInfo();
    }

}
