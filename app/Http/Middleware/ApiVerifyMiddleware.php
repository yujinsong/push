<?php
/**
 * Created by PhpStorm.
 * User: yujs
 * Date: 2017/6/6
 * Time: 下午4:46
 */

namespace App\Http\Middleware;

use Closure;

class ApiVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($_ENV['APP_VERIFY'] == 'true'){
        }

        return $next($request);
    }
}