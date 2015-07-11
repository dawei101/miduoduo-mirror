<?php
namespace backend;

use Yii;
use common\models\DataDaily;
use backend\BBaseController;
use common\models\User;
use common\models\Resume;
use common\models\TaskApplicant;

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
     * @param array $labels 查询的字段数组
            $labels     = array(
                1   => 'tdrs',
                2   => 'zczl',
            );
     * @return array $dataRows 返回展示列表
            Array
            (
                [0] => Array
                    (
                        [tdrs] => 236
                        [zczl] => 34
                        [data] => 2015-07-07
                    )
                [1] => Array
                    (
                        [tdrs] => 236
                        [zczl] => 34
                        [data] => 2015-07-08
                    )
            )
     *
     */
    public function getDataRows($type=1,$city_id,$dateStart,$dateEnd,$labels){
        $where  = '';
        
        // 城市筛选
        $city_id   = is_numeric($city_id) ? $city_id : 0;
        if( $city_id ){
            $where  .= " AND `city_id`=".$city_id." ";
        }

        // 起止时间不能大于今天
        $currentTime    = time();
        $timeStart      = strtotime($dateStart);
        $timeEnd        = strtotime($dateEnd);
        $currentDate    = date("Y-m-d",$currentTime);
        if( $timeStart > $currentTime ){
            $dateStart  = $currentDate;
        }
        if( $timeEnd > $currentTime ){
            $dateEnd  = $currentDate;
        }

        // 时间筛选
        if( $dateStart && $dateEnd ){
            $where  .= " AND date BETWEEN '".$dateStart."' AND '".$dateEnd."' ";
        }

        // 根据选择的日期段，生成时间列
        $dateStart;
        $dateEnd; 
        $dataArr    = range(strtotime($dateStart), strtotime($dateEnd), 24*60*60);
        $dataArr    = array_map(create_function('$v', 'return date("Y-m-d", $v);'), $dataArr);

        // 检查所选时间段是否是新的数据，如果不是，则更新统计数据
        $this->checkDataNew($dataArr,$type,$city_id);

        // 执行查询
        $data   = DataDaily::findBySql("
            SELECT
                *, sum(`value`)
            FROM
                jz_data_daily
            WHERE
                type = '".$type."'
                ".$where."
            GROUP BY date,`key`        
        ")->asArray()->all();

        // 最终返回的数据
        $dataRows   = array();
        // 遍历第一层--日期
        foreach( $dataArr as $k1 => $v1 ){
            $data2          = array();
            // 遍历第二层--字段
            foreach( $labels as $k2 => $v2 ){
                // 遍历第三层--值
                foreach( $data as $k3 => $v3 ){
                    if( $v3['date'] == $v1 && $v3['key'] == $v2 ){
                        $data2[$v3['key']]  = $v3['value'];
                    }
                }
            }
            $data2['date']  = $v1;
            $dataRows[]  = $data2;
        }

        // 完毕后，吧今天的数据干掉
        // 偷懒，先统一查出全部的存入库里，然后再删掉今天的，因为今天的数据要实时查询
        $DataDaily  = new DataDaily();
        $DataDaily->deleteAll("`date`='".$currentDate."'");

        return $dataRows;
    }

    /**
     *
     * checkDataNew 检查日期范围内，数据统计是存在，如果不是则查询保存
     *
     * @author suixb
     * @param array $dataArr 时间范围数组
     * @param int type 统计类型
     * @return boolean 更新成功与否
     *
     */
    private function checkDataNew($dataArr,$type,$city_id){
        $datastr        = implode("','",$dataArr);
        $datastr        = "'".$datastr."'";

        // 首先查询这些日期的数据是否存在
        $isExistArr     = DataDaily::find()
            ->where(' `city_id`='.$city_id.' AND `date` in('.$datastr.') AND `type`='.$type.' GROUP BY `date`')->asArray()
            ->all();
        
        // 找到不存在的
        $notExistArr    = array();
        foreach( $isExistArr as $k2 => $v2 ){
            if( in_array($v2['date'],$dataArr)  ){
                // 已经有啦，跳过
                $notExistArr[]  = $v2['date'];
                foreach( $dataArr as $k1 => $v1 ){
                    if( $v1 == $v2['date'] ){
                        unset($dataArr[$k1]);
                        break;
                    }
                }
            }
        }
        $notExistArr    = $dataArr;

        // 开始处理没有记录的
        // 1 用户端 数据
        // 城市的问题暂时不考虑
        if( $type == 1 ){
            foreach( $notExistArr as $k3 => $v3 ){
                $model  = new DataDaily();
                $model->date    = $v3;
                $model->type    = $type;

                // 注册总量
                $zczl   = User::findBySql("SELECT count(2) 'zczl' FROM jz_user WHERE LEFT(`created_time`,10)<='".$v3."'")->asArray()->one(); 
                $zczl   = $zczl['zczl'];
                $model_zczl  = clone $model;
                $model_zczl->key    = 'zczl';
                $model_zczl->value  = $zczl;
                $model_zczl->save();

                // 今日注册总量
                $jrzczl   = User::findBySql("SELECT count(2) 'jrzczl' FROM jz_user WHERE LEFT(`created_time`,10)='".$v3."'")->asArray()->one(); 
                $jrzczl   = $jrzczl['jrzczl'];
                $model_jrzczl  = clone $model;
                $model_jrzczl->key    = 'jrzczl';
                $model_jrzczl->value  = $jrzczl;
                $model_jrzczl->save();

                // 简历总量
                $jlzl   = Resume::findBySql("SELECT count(2) 'jlzl' FROM jz_resume WHERE LEFT(`created_time`,10)<='".$v3."'")->asArray()->one(); 
                $jlzl   = $jlzl['jlzl'];
                $model_jlzl  = clone $model;
                $model_jlzl->key    = 'jlzl';
                $model_jlzl->value  = $jlzl;
                $model_jlzl->save();

                // 今日简历总量
                $jrjlzl   = User::findBySql("SELECT count(2) 'jrjlzl' FROM jz_resume WHERE LEFT(`created_time`,10)='".$v3."'")->asArray()->one(); 
                $jrjlzl   = $jrjlzl['jrjlzl'];
                $model_jrjlzl  = clone $model;
                $model_jrjlzl->key    = 'jrjlzl';
                $model_jrjlzl->value  = $jrjlzl;
                $model_jrjlzl->save();

                // 投递总量
                $tdzl   = User::findBySql("SELECT count(2) 'tdzl' FROM jz_task_applicant WHERE LEFT(`created_time`,10)<='".$v3."'")->asArray()->one(); 
                $tdzl   = $tdzl['tdzl'];
                $model_tdzl  = clone $model;
                $model_tdzl->key    = 'tdzl';
                $model_tdzl->value  = $tdzl;
                $model_tdzl->save();

                // 今日投递总量
                $jrtdzl   = User::findBySql("SELECT count(2) 'jrtdzl' FROM jz_task_applicant WHERE LEFT(`created_time`,10)='".$v3."'")->asArray()->one(); 
                $jrtdzl   = $jrtdzl['jrtdzl'];
                $model_jrtdzl  = clone $model;
                $model_jrtdzl->key    = 'jrtdzl';
                $model_jrtdzl->value  = $jrtdzl;
                $model_jrtdzl->save();

                // 投递人数
                $tdrs   = User::findBySql("SELECT count(DISTINCT(user_id)) 'tdrs' FROM jz_task_applicant WHERE LEFT(`created_time`,10)<='".$v3."'")->asArray()->one(); 
                $tdrs   = $tdrs['tdrs'];
                $model_tdrs  = clone $model;
                $model_tdrs->key    = 'tdrs';
                $model_tdrs->value  = $tdrs;
                $model_tdrs->save();

                // 今日投递人数
                $jrtdrs   = User::findBySql("SELECT count(DISTINCT(user_id)) 'jrtdrs' FROM jz_task_applicant WHERE LEFT(`created_time`,10)='".$v3."'")->asArray()->one(); 
                $jrtdrs   = $jrtdrs['jrtdrs'];
                $model_jrtdrs  = clone $model;
                $model_jrtdrs->key    = 'jrtdrs';
                $model_jrtdrs->value  = $jrtdrs;
                $model_jrtdrs->save();
            }
        }

        // 2 职位 数据
        // 城市的问题暂时不考虑
        if( $type == 2 ){
            foreach( $notExistArr as $k3 => $v3 ){
                $model  = new DataDaily();
                $model->date    = $v3;
                $model->type    = $type;

                // 总贴量
                $ztl    = User::findBySql("SELECT count(2) 'ztl' FROM jz_task WHERE LEFT(`created_time`,10)<='".$v3."'")->asArray()->one(); 
                $ztl    = $ztl['ztl'];
                $model_ztl  = clone $model;
                $model_ztl->key    = 'ztl';
                $model_ztl->value  = $ztl;
                $model_ztl->save();

                // 总在线贴量
                $zzxtl   = User::findBySql("SELECT count(2) 'zzxtl' FROM jz_task WHERE status=0 AND LEFT(`created_time`,10)<='".$v3."'")->asArray()->one(); 
                $zzxtl   = $zzxtl['zzxtl'];
                $model_zzxtl  = clone $model;
                $model_zzxtl->key    = 'zzxtl';
                $model_zzxtl->value  = $zzxtl;
                $model_zzxtl->save();
                

                // 后台新增
                $htxz   = Resume::findBySql("SELECT count(2) 'htxz' FROM jz_task WHERE LEFT(`created_time`,10)='".$v3."'")->asArray()->one(); 
                $htxz   = $htxz['htxz'];
                $model_htxz  = clone $model;
                $model_htxz->key    = 'htxz';
                $model_htxz->value  = $htxz;
                $model_htxz->save();
                

                // 抓取新增
                //$zqxz   = User::findBySql("SELECT count(2) 'zqxz' FROM jz_resume WHERE LEFT(`created_time`,10)='".$v3."'")->asArray()->one(); 
                $zqxz   = 0;
                $model_zqxz  = clone $model;
                $model_zqxz->key    = 'zqxz';
                $model_zqxz->value  = $zqxz;
                $model_zqxz->save();
                

                // 用户新增
                //$yhxz   = User::findBySql("SELECT count(2) 'yhxz' FROM jz_task_applicant WHERE LEFT(`created_time`,10)<='".$v3."'")->asArray()->one(); 
                $yhxz   = 0;
                $model_yhxz  = clone $model;
                $model_yhxz->key    = 'yhxz';
                $model_yhxz->value  = $yhxz;
                $model_yhxz->save();
                

                // 总待审核
                //$zdsh   = User::findBySql("SELECT count(2) 'zdsh' FROM jz_task_applicant WHERE LEFT(`created_time`,10)='".$v3."'")->asArray()->one(); 
                $zdsh   = 0;
                $model_zdsh  = clone $model;
                $model_zdsh->key    = 'zdsh';
                $model_zdsh->value  = $zdsh;
                $model_zdsh->save();
                

                // 总过期
                $zgq   = Resume::findBySql("SELECT count(2) 'zgq' FROM jz_task WHERE `to_date`<'".$v3."'")->asArray()->one(); 
                $zgq   = $zgq['zgq'];
                $model_zgq  = clone $model;
                $model_zgq->key    = 'zgq';
                $model_zgq->value  = $zgq;
                $model_zgq->save();
                

                // 今日过期
                $jrgq   = Resume::findBySql("SELECT count(2) 'jrgq' FROM jz_task WHERE `to_date`='".$v3."'")->asArray()->one(); 
                $jrgq   = $jrgq['jrgq'];
                $model_jrgq  = clone $model;
                $model_jrgq->key    = 'jrgq';
                $model_jrgq->value  = $jrgq;
                $model_jrgq->save();
            }
        }
    }

}