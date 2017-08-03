<?php
namespace App\Http\Service;

use xmpush\Builder;
use xmpush\Message;
use xmpush\Sender;
use xmpush\Constants;
use xmpush\IOSBuilder;
use xmpush\Subscription;
use xmpush\Tracer;

//include(app_path('Libary/MiPush/autoload.php'));
include_once (__LIB__ . '/MiPush/autoload.php');

/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/6/3
 * Time: 下午5:15
 */
class PushService
{
    public static function push($system_type, $alias_list, $description, $uri,
                                $bundle_id, $type = 0, $is_message = 1, $through = 0) {
        if ($system_type == 'Android') {
            return self::AndroidPush($alias_list, $description, $uri, $bundle_id, $type,
                $is_message, $through);
        } elseif ($system_type == 'iOS') {
            return self::iOSPush($alias_list, $description, $uri, $bundle_id, $is_message);
        } else {
            return -1;
        }
    }

    public static function iOSPush($alias_list, $description, $uri, $bundle_id, $is_message = 1) {
        if (CommonService::getEnv('APP_ENV') !== 'production') {
           Constants::useSandbox();
        } else {
            Constants::useOfficial();
        }

        $ios_bundle_id = empty($bundle_id) ? CommonService::getEnv('IOS_BUNDLE_ID') : $bundle_id;
        Constants::setBundleId($ios_bundle_id);
        Constants::setSecret(CommonService::getEnv('MI_IOS_SECRET'));

        $builder = new IOSBuilder();
        $builder->description($description);
        // sound
        $builder->soundUrl('default');
        // notify icon
        $builder->badge(1);
        $builder->extra('is_message', $is_message);
        $builder->extra('uri', $uri);
        $builder->build();

        $sender = new Sender();
        $send_result = $sender->sendToAlias($builder, $alias_list)->getRaw();

        return $send_result;

    }

    public static function AndroidPush($alias_list, $description, $uri, $bundle_id,
                                       $type = 0, $is_message = 1, $through = 1) {
        if (CommonService::getEnv('APP_ENV') !== 'production') {
            Constants::useSandbox();
        } else {
            Constants::useOfficial();
        }

        if (empty($bundle_id)) {
            Constants::setPackage(CommonService::getEnv('ANDROID_PACKAGE'));
        } else {
            Constants::setPackage($bundle_id);
        }
        Constants::setSecret(CommonService::getEnv('MI_AN_SECRET'));

        $builder = new Builder();
        // 通知栏的title
        $builder->title(CommonService::getEnv('APP_NAME'));
        // 通知栏的description
        $builder->description($description);
        // 这是一条通知栏消息，如果需要透传，把这个参数设置成1,同时去掉title和description两个参数
        $builder->passThrough($through);
        $builder->extra(Builder::intentUri, $uri);
        // 应用在前台是否展示通知，如果不希望应用在前台时候弹出通知，则设置这个参数为0
        $builder->extra(Builder::notifyForeground, 1);
        // 此处设置预定义点击行为，1为打开app 2为打开应用内指定页面  3为打开网页
        $builder->extra(Builder::notifyEffect, 2);
        $builder->extra('is_message', $is_message);
        // 通知类型。最多支持0-4 5个取值范围，同样的类型的通知会互相覆盖，不同类型可以在通知栏并存
        $builder->notifyId($type);
        $builder->build();

        $sender = new Sender();
        $send_result = $sender->sendToAlias($builder, $alias_list)->getRaw();

        return $send_result;
    }


    public static function talkSubscribeByAlias($token, $topic, $device_model='iOS') {
        if (CommonService::getEnv('APP_ENV') !== 'production') {
            Constants::useSandbox();
        } else {
            Constants::useOfficial();
        }

        if ($device_model == 'Android') {
            Constants::setPackage(ConstantService::$TALK_MI_ANDROID_PACKAGE_NAME);
            Constants::setSecret(ConstantService::$TALK_MI_ANDROID_SECRET);
        } else {
            Constants::setPackage(ConstantService::$TALK_MI_IOS_PACKAGE_NAME);
            Constants::setSecret(ConstantService::$TALK_MI_IOS_SECRET);
        }
        $subscribe = new Subscription();
        return $subscribe->subscribeTopicByAlias(array($token), $topic);
    }

    public static function talkPushByTag($topic, $title, $description, $content, $device_model='iOS') {
        if (CommonService::getEnv('APP_ENV') !== 'production') {
            Constants::useSandbox();
        } else {
            Constants::useOfficial();
        }

        if ($device_model == 'Android') {
            Constants::setPackage(ConstantService::$TALK_MI_ANDROID_PACKAGE_NAME);
            Constants::setSecret(ConstantService::$TALK_MI_ANDROID_SECRET);
        } else {
            Constants::setPackage(ConstantService::$TALK_MI_IOS_PACKAGE_NAME);
            Constants::setSecret(ConstantService::$TALK_MI_IOS_SECRET);
        }

        $sender = new Sender();
        $androidMessage = new Builder();
        $androidMessage->title($title);
        $androidMessage->description($description);
        $androidMessage->payload($content);
        $androidMessage->notifyType(1);

        $androidMessage->build();

        return $sender->broadcast($androidMessage, $topic, 1);
    }

    public static function talkTrace($trace_id) {
        Constants::setPackage(ConstantService::$TALK_MI_IOS_PACKAGE_NAME);
        Constants::setSecret(ConstantService::$TALK_MI_IOS_SECRET);
        $tracer = new Tracer();
        $result = $tracer->getMessageStatusById($trace_id);
        print_r($result);
    }
}