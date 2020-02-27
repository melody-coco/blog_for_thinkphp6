<?php


namespace app\admin\validate;


use think\facade\Validate;

class Admin extends Validate
{
    public function handle($request,\Closure $next)
    {
        echo "此处check2执行了应用的中间件";
        echo "<br>";
        return $next($request);
    }
}