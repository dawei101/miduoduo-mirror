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
            'wechat' => !empty($user->weichat),
            'has_wechat' => !empty($user->resume),
            'id_examed' => $user->resume?($this->resume->exam_status==Resume::EXAM_DONE):false,
            'last_city' => [],
        ];
        if ($user->last_location){
            $city = $user->last_location->city;
            $profile['last_city'] = ['id'=>$city->id, 'short_name'=>$city->short_name];
        }
        return $profile;
    }

}
