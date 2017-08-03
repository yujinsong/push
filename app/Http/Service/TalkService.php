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

    public static function PushByTag($topic, $title, $description, $content) {
        return PushService::talkPushByTag($topic, $title, $description, $content);
    }

    public static function talkTrace($trace_id) {
        PushService::talkTrace($trace_id);
    }
}