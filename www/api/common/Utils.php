<?php
namespace api\common;
use common\models\User;


class Utils
{

    public static function formatProfile($user, $password=''){
        return [
            'id'=> $user->id,
            'username'=> $user->username,
            'password'=> $password,
            'invited_count' => User::find()->where(
                ['invited_by'=>$user->id])->count(),
            'access_token'=> $user->access_token,
            'resume' => $user->resume?$user->resume->toArray():null,
            ];
    }

}
