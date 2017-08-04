<?php
/**
 * Created by PhpStorm.
 * User: Sway
 * Date: 16/11/28
 * Time: 上午10:18
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;

class HealthCheckController extends Controller
{

    /**
     * php-fpm 健康检查
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function HealthChecker() {
        $data = array(
            'code' => 0,
            'msg' => 'success',
            'data' => array()
        );
        return response()->json($data);
    }
}