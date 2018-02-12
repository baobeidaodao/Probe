<?php
/**
 * IDE Name: PhpStorm
 * Project : Probe
 * FileName: UserEventSubscriber.php
 * Author  : Li Tao
 * DateTime: 2018-02-11 11:43:00
 */

namespace App\Listeners;

use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserEventSubscriber
{
    /**
     * 处理用户登录事件。
     * @param $event
     */
    public function onUserLogin($event)
    {
        $actionLog = ActionLog::log(ActionLog::ACTION_LOGIN);
        // Log::info('event', [$event,]);
        // Log::info('event', [$actionLog,]);
    }

    /**
     * 处理用户注销事件。
     * @param $event
     */
    public function onUserLogout($event)
    {
        $actionLog = ActionLog::log(ActionLog::ACTION_LOGOUT);
    }

    /**
     * 为订阅者注册监听器。
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }

}