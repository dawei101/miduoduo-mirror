<?php
 
namespace api\modules\v1\controllers;
 
use api\modules\BaseActiveController;
use common\Utils;
 
/**
 * Resume Controller API
 *
 * @author dawei
 */
class UploadImageController extends BaseActiveController
{
    public $modelClass = '';
    public $auto_filter_user = true;
    public $user_identifier_column = 'user_id';

    public function actionUpload(){
        return $this->uploadImage($_FILES);
    }

    private function uploadImage($files){
        $image_key = '';
        foreach( $files as $k => $v ){
            $image_key  = $k;
            $ext = pathinfo($v['name'], PATHINFO_EXTENSION);
            $is_image = Utils::checkUploadFileIsImage($ext);

            if( $is_image ){
                $filename = Utils::saveUploadFile($files[$image_key]);
                return ['success' => true, 'filename' => $filename, 'msg' => '图片上传成功'];
            }else{
                return ['success' => false, 'filename' => '', 'msg' => '文件格式错误'];
            }
        }
    }

}
