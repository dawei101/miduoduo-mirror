<?php

use common\models\SysMessage;


class Message
{
    public function send($user_id, $title, $message)
    {
        $message = new SysMessage;
        $message->user_id = $user_id;
        $message->read_flag = false;
        $message->title = $title;
        $message->message = $message;
        $message->has_sent = true;
        $message->save();
    }
}
