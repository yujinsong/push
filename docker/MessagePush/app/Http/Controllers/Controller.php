<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //

    public function response($code, $data = array(), $msg = ''){
        $result['code']    = $code;
        $result['msg']      = $msg;
        $result['data']     = $data? $data : null;

        $parse = array(
            '200'    => 'success',
            '400' => 'param error',
            '401' => 'verify error',
            '402' => 'token error',
            '403' => 'Forbidden',
            '404' => 'not found',
            '410' => 'third party error',
            '500' => 'service error'
        );

        $result['msg'] = $result['msg']? $result['msg'] : $parse[$code];

        return response()->json($result);
    }
}
