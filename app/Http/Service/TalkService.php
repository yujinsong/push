<?php
/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/8/1
 * Time: 下午6:33
 */

namespace App\Http\Service;


class TalkService
{
    public static function SubscribeTag($device_id, $topic) {
        return PushService::talkSubscribeByAlias($device_id, $topic);
    }

    public static function PushByTag($topic, $description, $uri, $device_model='iOS') {
        $result =  PushService::talkPushByTag($topic, $description, $uri, $device_model);
        LogService::getInstance()->info("push result", ['result' => $result]);
        return 1;
    }

    public static function talkTrace($trace_id) {
        PushService::talkTrace($trace_id);
    }
}