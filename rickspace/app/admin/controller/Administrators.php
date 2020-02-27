<?php


namespace app\admin\controller;


use app\admin\model\admin;
use app\admin\model\articles;
use app\BaseController;
use think\Exception;
use think\exception\ValidateException;
use think\facade\Request;
use think\facade\Session;
use think\facade\View;

class Administrators extends BaseController
{
    protected $middleware = [
        "app\admin\middleware\check"    =>  ['except' => ['admin_login']]
    ];
//    public function is_login(){         //验证登录
//
//        $session = session('?name');    //验证session
//        if(!$session) return 0;
//
//
//        $user = cookie("user");     //获取cookie
//        $admin = admin::where("user",$user) //验证cookie身份
//            ->find();
//
//        if ($admin) return true;            //返回身份验证结果
//        return false;
//    }


    public function login_out(){
        cookie("user",null);
        session("name",null);
        return view("../view/admin_login",["msg"=>3]);
    }







    public function all_article(){

//        if(!$this->is_login()) return view('../view/admin_login',["msg"=>3]);       //验证登录与否

//        echo "此处应输出所有的文章内容";
        $data = articles::with("admin")->order("create_time")->paginate(8);
//        return view("../view/admin_index",["data"=>$data]);
        return view("../view/index",["data"=>$data]);
//        return "输出成功";
    }



    public function admin_login(){
        if(request()->isGet()) return view("../view/admin_login",["msg"=>null]);


        $data = request()->param();

        try {           //使用验证器验证，账号密码的非法性
            validate(\app\validate\Admin::class)->check($data);
        }catch(ValidateException $e){
            echo $e->getMessage();
        }


        $admin = admin::where("user",$data["user"])->find();            //判断账号存在
        if(!$admin) return view("../view/admin_login",["msg"=>1]);

        if ($admin->password == $data["password"]){                     //验证管理员通过后，设置cookie
            cookie("user",$admin->user,15000);
            session("name",$admin->name);
            return redirect("all_article");
//            return "OK";
        }else{
            return view('../view/admin_login',["msg"=>2]);
        }
    }
}