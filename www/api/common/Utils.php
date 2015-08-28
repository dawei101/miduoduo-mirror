<?php
namespace api\common;
use common\models\User;
use common\models\Resume;


class Utils
{

    public static function formatProfile($user, $password=''){
        $profile = [
            'id'=> $user->id,
            'username'=> $user->username,
            'password'=> $password,
            'invited_count' => User::find()->where(
                ['invited_by'=>$user->id])->count(),
            'access_token'=> $user->access_token,
            'resume' => $user->resume?['1'=>1]:null,
            'has_resume' => !empty($user->resume),
            'has_wechat' => !empty($user->weichat),
            'id_extam_status' => $user->resume?$user->resume->exam_status:false,
            'is_virgin' => $user->is_virgin,
            'last_city' => [],
        ];
        if ($user->last_location){
            $city = $user->last_location->city;
            $profile['last_city'] = ['id'=>$city->id, 'short_name'=>$city->short_name];
        }
        return $profile;
    }

}
