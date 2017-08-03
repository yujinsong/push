<?php

namespace App\Http\Service;

use App\Http\Service\LogService;

/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/6/3
 * Time: 下午5:24
 */
class CommonService
{
    /**
     * 获取配置参数信息
     *
     * @param $key
     * @return mixed|string
     */
    public static function getEnv($key) {
        if (empty($key)) {
            return "";
        }

        $value = env($key, "");
        if (empty($value)) {
            LogService::getInstance()->warn(" the configure $key is empty!");
            return "";
        } else {
            return $value;
        }
    }

    /**
     * 将描述同一种语言的多种不同表示统一（en-us, en -> en)
     *
     * @param $lang
     * @return mixed|string
     */
    public static function langTransform($lang) {
        // 默认的语言
        $default_lang = self::getEnv('APP_LOCALE');

        if (empty($lang)) {
            return $default_lang;
        }
        $lang_arr = explode('_', $lang);
        if ($lang_arr[0] == 'en') {
            // 以 en 开头的是英语语言
            return 'en';
        } else if ($lang_arr[0] == 'ar') {
            // 阿拉伯语言
            return 'ar';
        }

        if($lang == 'zh-CN' || $lang == 'zh-TW') {
            // 中文语言或者是台湾语言
            return $lang;
        } else {
            // 没有配置的语言,返回默认
            return $default_lang;
        }
    }

    /**
     * 获取13位时间戳
     * @return int
     */
    public static function timeStamp(){
        list($tmp1, $tmp2) = explode(' ', microtime());

        return (int)(($tmp2 + $tmp1) * 1000);
    }

    /**
     * 计算request消耗的时间(单位是毫秒)
     *
     * @param $start_time
     * @return float
     */
    public static function requestElapsedTime($start_time) {
        return round((microtime(true) - $start_time) * 1000, 2);
    }

    /**
     * 获取http头信息
     *
     * @param $key
     * @return string
     */
    public static function httpHeader($key) {
        if (empty($key)) {
            return "";
        }

        $key = mb_strtoupper($key);
        $key = "HTTP_$key";

        if (isset($_SERVER[$key])) {
            return $_SERVER[$key];
        } else {
            return "";
        }
    }

    public static function objToArray($data) {
        if (empty($data)) {
            return [];
        } else {
            return json_decode(json_encode($data), true);
        }
    }
}