<?php
namespace backend;

use Yii;
use common\models\DataDaily;
use backend\BBaseController;


/**
 * WeichatErweimaController implements the CRUD actions for WeichatErweima model.
 */
class BDataBaseController extends BBaseController
{
    public function behaviors()
    {
        $bhvs = parent::behaviors();
        return $bhvs;
    }

    // 根据 类型、时间、城市 查询统计方法
    /**
     * getDataRows 返回统计记录
     * 
     * @author suixb
     * @param int $type 类型，如 统计分类，1：核心指标-用户端、2：核心指标-职位、3：微信日报...
     * @param int $city 城市，如果没有传入城市，默认查询全部城市的数据
     * @param date $dateStart 查询起始日期
     * @param date $dateEnd 查询结束日期
     * @return array $dataRows 返回展示列表
     *
     */
    public function getDataRows($type=1,$city='',$dateStart='',$dateEnd=''){
        echo 'OMG';exit;
    }

}