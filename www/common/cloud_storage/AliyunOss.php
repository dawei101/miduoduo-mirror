<?php
namespace common\cloud_storage;

use yii\base\Component;

class AliyunOss extends Component
{

    public $host;

    public function uploadFile($img)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://www.example.com/process.php");
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$vars);  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


    }

    public function addHeaders()
    {
        $headers = [];
        $headers[] = 'X-MicrosoftAjax: Delta=true';

    }

}
