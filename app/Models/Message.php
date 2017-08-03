<?php
namespace App\Models;

use App\Http\Service\CommonService;
use Illuminate\Database\Eloquent\Model;
use App\Http\Service\DBConnService;
use Illuminate\Support\Facades\DB;

/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/6/3
 * Time: 下午4:19
 */
class Message extends Model
{
    protected $table = 'message';

    private static $fields = "id, sender_id, sender_pic_path, user_id, type, type, type_detail, 
        title, subhead, content, img_id, uri, created_time";

    /**
     * 获取用户消息列表
     *
     * @param $user_id
     * @param $offset
     * @param $limit
     */
    public static function getMessageList($user_id, $offset, $limit) {
        $fields = self::$fields;
        $sql = "SELECT $fields FROM swaying_message WHERE user_id = ? ORDER BY id DESC LIMIT ?,?";
        $result = DBConnService::readConn()->select($sql, [$user_id, $offset, $limit]);

        return CommonService::objToArray($result);
    }


    public static function getMessageCnt($user_id, $last_id, $type) {
        $sql = "SELECT count(*) AS cnt FROM swaying_message WHERE user_id = ? AND `type` = ? AND id > ?";
        $result = DBConnService::readConn()->selectOne($sql, [$user_id, $type, $last_id]);

        return $result->cnt;
    }

    public static function addMessage($message_data) {

    }
}