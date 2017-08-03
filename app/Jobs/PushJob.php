<?php
/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/6/7
 * Time: 下午4:33
 */

namespace App\Jobs;

use App\Http\Service\MessageService;
use Illuminate\Contracts\Queue\ShouldQueue;


class PushJob extends Job implements  ShouldQueue
{
    protected $sender_id;
    protected $user_id;
    protected $type_detail;
    protected $data_info = array(
        'swing_id' => '',
        'img_id' => '',
        'music_id' => '',
        'content' => '',
        'title' => '',
        'subhead' => '',
        'uri' => '',
        'remote_num' => ''
    );

    public function __construct($sender_id, $receiver_id, $type_detail, $data_info = []) {
        $this->sender_id    = $sender_id;
        $this->user_id      = $receiver_id;
        $this->type_detail  = $type_detail;
        $this->data_info    = $data_info;
    }

    public function handle() {
        MessageService::delayPush($this->sender_id, $this->user_id, $this->type_detail,
            $this->data_info);
    }


}