<?php
/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/8/1
 * Time: 上午9:21
 */

namespace App\Http\Controllers;


use App\Http\Service\CommonService;
use App\Http\Service\LogService;
use App\Http\Service\TalkService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class TalkController extends Controller
{
    public function SubscribeTopic() {
        $start_time = microtime(true);

        $validator = Validator::make(Request::all(), [
            'device_id' => 'required',
            'topic' => 'required'
        ]);

        if ($validator->fails()) {
            $log = [
                'request' => Request::all(),
                'response' => [],
                'msg' => $validator->errors(),
                'elapsed_time' => 0
            ];
            LogService::getInstance()->error('SubscribeTag error', $log);
            return $this->response(400);
        }

        $device_id = Request::input('device_id');
        $topic = Request::input('topic');
        $result = TalkService::SubscribeTag($device_id, $topic);

        print_r($result);
        $result = 1;
        $end_time = CommonService::requestElapsedTime($start_time);
        $log = [
            'request' => Request::all(),
            'response' => '',
            'msg' => 'swingRemotePush success!',
            'elapsed_time' => $end_time
        ];
        if ($result < 0) {
            $log['msg'] = 'push error';
            LogService::getInstance()->error('otherPush error', $log);
            return $this->response(500);
        } else {
            $log['msg'] = 'push error';
            LogService::getInstance()->info('otherPush success', $log);
            return $this->response(200);
        }
    }

    public function PushByTopic() {
        $start_time = microtime(true);

        $validator = Validator::make(Request::all(), [
            'topic' => 'required',
            'title' => 'required',
            'description' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            $log = [
                'request' => Request::all(),
                'response' => [],
                'msg' => $validator->errors(),
                'elapsed_time' => 0
            ];
            LogService::getInstance()->error('PushByTag error', $log);
            return $this->response(400);
        }

        $topic = Request::input('topic');
        $title = Request::input('title');
        $description = Request::input('description');
        $content = Request::input('content');
        $result = TalkService::PushByTag($topic, $title, $description, $content);

        $end_time = CommonService::requestElapsedTime($start_time);
        $log = [
            'request' => Request::all(),
            'response' => '',
            'msg' => 'swingRemotePush success!',
            'elapsed_time' => $end_time
        ];
        if ($result < 0) {
            $log['msg'] = 'push error';
            LogService::getInstance()->error('otherPush error', $log);
            return $this->response(500);
        } else {
            $log['msg'] = 'push error';
            LogService::getInstance()->info('otherPush success', $log);
            return $this->response(200);
        }
    }

    public function TalkTrace() {
        $trace_id = "Xcx01b73501669358839VF";
        TalkService::talkTrace($trace_id);
    }

}