<?php
/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/6/5
 * Time: 下午4:15
 */

namespace App\Http\Service;

use Illuminate\Support\Facades\DB;

class DBConnService
{
    private static $read_conn = null;
    private static $write_conn = null;

    private function __construct() {}

    public static function writeConn() {
        if (self::$write_conn === null) {
            self::$write_conn = DB::connection('write');
        }

        return self::$write_conn;
    }

    public static function readConn() {
        if (self::$read_conn === null) {
            self::$read_conn = DB::connection('read');
        }

        return self::$read_conn;
    }

}