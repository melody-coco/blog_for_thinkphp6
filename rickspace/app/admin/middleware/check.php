<?php


namespace app\admin\middleware;


use app\admin\model\admin;
use think\Exception;

class check
{
    public function handle($request,\Closure $next){
        $data = $request->pathinfo();
        if($data === 'administrators/admin_login.html'){
            return $next($request);
        }

        $user = cookie("user");     //获取cookie
        try {
            $admin = admin::where("user",$user) //验证cookie身份
            ->find();
        }catch (Exception $e){
            echo $e->getMessage();
        }

        if ($admin) return $next($request);            //返回身份验证结果
        return view("../view/admin_login",["msg"=>3]);


    }
}