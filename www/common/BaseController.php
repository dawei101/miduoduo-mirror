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

    public function redirectHtml($to, $msg='')
    {
        echo "
        <!DOCTYPE HTML>
        <html lang='en-US'>
            <head>
                <meta charset='UTF-8'>
                <script type='text/javascript'>
            " . 'setTimeout("window.location.href = \''.$to.'\';", 3000);'
            . " </script>
                <title>跳转</title>
            </head>
            <body>
                <p >
                如果没有跳转，请<a href='$to'>点击这里</a>
                </p>
                <p>". $msg ."</p>
            </body>
        </html>
        ";
        Yii::$app->end();
    }

}
