<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->get('message/messageList', 'MessageController@userMessageList');
$app->get('message/unreadMessageNum', 'MessageController@unreadMessageNum');

$app->post('message/swingCommentPush', 'MessageController@swingCommentPush');
$app->post('message/userFollowingPush', 'MessageController@userFollowingPush');
$app->post('message/swingLikePush', 'MessageController@swingLikePush');
$app->post('message/swingRemotePush', 'MessageController@swingRemotePush');
$app->post('message/otherPush', 'MessageController@otherPush');
$app->post('message/swingToHotPush', 'MessageController@swingToHotPush');

$app->get('s3/speed', 'ExampleController@s3SpeedTest');


// talk
$app->post('talk/SubscribeTopic', 'TalkController@SubscribeTopic');
$app->post('talk/PushByTopic', 'TalkController@PushByTopic');
$app->post('talk/TalkTrace', 'TalkController@TalkTrace');

$app->get('HealthChecker', 'HealthCheckController@HealthChecker');

$app->group(['namespace' => 'App\Http\Controllers'], function () use ($app) {

});