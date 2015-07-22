<?php
namespace common;

use Yii;

class BaseFileLog
{
    /**
     *
     * saveLog
     *
     * @param array $content_arr 保存的内容
     * @param string $location 保存的类型，不同类型存入不同目录
     *
     */
    function saveLog($content_arr='',$log_type='location'){
        $content         = $this->arrayToStr($content_arr);

        $max_size        = Yii::$app->params['file_log']['max_size'];
        $log_base_url    = Yii::$app->params['file_log']['log_base_url'];
        $log_type_url    = $log_base_url.$log_type.'/';
        $log_save_url    = $log_type_url.date('Y-m-d');
        if( !file_exists($log_type_url) ){
            mkdir($log_type_url);
        }
        if( !file_exists($log_save_url) ){
            mkdir($log_save_url);
        }
     
        $file_logs      = scandir($log_save_url);
        array_shift($file_logs);
        array_shift($file_logs);
        if( count($file_logs) == 0 ){
            $log_save_name  = '1.log';
        }else{
            $file_logs_latest       = array_pop($file_logs);
            $file_logs_latest_size  = abs(filesize($log_save_url.'/'.$file_logs_latest));
            if( $file_logs_latest_size > $max_size ){
                list($fname,$ftype)  = explode('.',$file_logs_latest);
                $fname++;
                $log_save_name  = $fname.'.log';
            }else{
                $log_save_name  = $file_logs_latest;
            }
        }

        $log_filename   = $log_save_url.'/'.$log_save_name;

        $content        = $content."\n";
        file_put_contents($log_filename, $content, FILE_APPEND);
    }

    public function arrayToStr($content_arr){
        $content    = json_encode($content_arr);
        return $content;
    }
}
