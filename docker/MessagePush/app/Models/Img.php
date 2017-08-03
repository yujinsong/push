<?php
namespace App\Models;

use App\Http\Service\CommonService;
use \Illuminate\Database\Eloquent\Model;
use App\Http\Service\DBCommService;

/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/6/5
 * Time: 下午5:14
 */
class Img extends Model
{
    public static function getImg($img_id) {
        $sql = "SELECT id, owner_type, `type`, title, user_id, ratio, created_time FROM 
          swaying_res_img WHERE id = ?";
        $result = DBConnService::readConn()->selectOne($sql, [$img_id]);

        return CommonService::objToArray($result);
    }
}