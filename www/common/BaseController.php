<?php
namespace common;

use Yii;
use yii\web\Controller;


class BaseController extends Controller
{
    public function renderJson($data)
    {
        header('Content-type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        Yii::$app->end();
    }

    public function redirectHtml($to)
    {
        echo "
        <!DOCTYPE HTML>
        <html lang='en-US'>
            <head>
                <meta charset='UTF-8'>
                <script type='text/javascript'>
                    window.location.href = '$to';
                </script>
                <title>跳转</title>
            </head>
            <body>
                如果没有跳转，请<a href='$to'>点击这里</a>
            </body>
        </html>  
        ";
        Yii::$app->end();
    }

}
