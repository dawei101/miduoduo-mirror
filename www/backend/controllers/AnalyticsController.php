<?php

namespace backend\controllers;

use Yii;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\BDataBaseController;
use common\models\DataDaily;



class AnalyticsController extends BDataBaseController
{

    public function behaviors()
    {
        $bhvs = parent::behaviors();
        return $bhvs;
    }

    public function renderChart($title, $days, $labels, $city_id, $data_type,
                $unit=''){

        $label_keys = array_keys($labels);
        $dateStart = date("Y-m-d", strtotime('-' . $days . ' days'));
        $dateEnd = date('Y-m-d', strtotime('today'));
        $rows   = $this->getDataRows($data_type, $city_id, $dateStart, $dateEnd, $label_keys);

        $datas = [];
        foreach ($label_keys as $k){
            $datas[$k] = [];
        }
        usort($rows, function($a, $b){
            return ($a['date'] < $b['date']) ? -1 : 1;
        });
        $dates = [];
        foreach ($rows as $row){
            foreach($label_keys as $k){
               $datas[$k][$row['date']] = isset($row[$k])?intval($row[$k]):0;
            }
            $dates[] = $row['date'];
        }
        return $this->render('chart',[
            'title'     => $title,
            'labels'    => $labels,
            'datas'     => $datas,
            'dates'     => $dates,
            'unit'      => $unit,
            'dateStart' => $dateStart,
            'dateEnd'   => $dateEnd,
            'days'      => $days,
            'data_type' => $data_type,
            'city_id'   => $city_id,
        ]);
 
    }

    public function actionUser($days = 100, $city_id = 0)
    {
        $labels = [
                       'zczl'     =>'注册总量',
                       'zczl'     =>'注册总量',
                       'jlzl'     =>'简历总量',
                       'tdzl'     =>'投递总量',
                       'tdrs'     =>'投递人数',
                       'jrzczl'   =>'当日注册总量',
                       'jrjlzl'   =>'当日简历总量',
                       'jrtdzl'   =>'当日投递总量',
                       'jrtdrs'   =>'当日投递人数',
                       'jrxyhtd'  =>'当日新用户投递',
                       ];
        return $this->renderChart('用户统计', $days, $labels, $city_id, $data_type=1);
    }

    public function actionWechat($days = 100, $city_id = 0)
    {
        $labels = [
                       'zgz'      =>'剩余关注',
                       'jrgz'     =>'当日关注',
                       'ztd'      =>'总退订',
                       'jrtd'     =>'当日退订',
                       'jrtsrs'   =>'当日推送人数',
                       'jrtszl'   =>'当日推送总量',
                       'jrwxzc'   =>'当日微信注册',
                       'jrwxtdrs' =>'当日微信投递人数',
                       'jrwxtdzl' =>'当日微信投递总量',
                        ];
        return $this->renderChart('微信统计', $days, $labels, $city_id, $data_type=3);
    }
    public function actionTask($days = 100, $city_id = 0)
    {
        $labels = [
                       'ztl'     =>'总贴量',
                       'zzxtl'   =>'总在线贴量',
                       'htxz'    =>'后台新增',
                       'zqxz'    =>'抓取新增',
                       'zqxz'    =>'抓取新增',
                       'yhxz'    =>'用户新增',
                       'zdsh'    =>'总待审核',
                       'zgq'     =>'总过期',
                       'jrgq'    =>'当日过期',
                       ];
        return $this->renderChart('任务统计', $days, $labels, $city_id, $data_type=2);
    }

    public function actionClearup(){
        DataDaily::deleteAll();
        $this->redirect('/');
    }

    protected function findModel($id)
    {
        if (($model = DataDaily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
