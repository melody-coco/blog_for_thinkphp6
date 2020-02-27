<?php


namespace app\admin\controller;


use app\admin\model\articles;

class Index
{
    public function index(){
//        echo "此处测试多应用模式得其中一个app,admin的访问";
//        return redirect('../articlef/article_insert');
//        $data = request()->param();
        $data = session('data');            //重定向传参是从session里面传参
//        echo json_encode($data);
        if (!empty($data)) return view('../view/admin_article_insert',["data"=>$data]);
        return view('../view/admin_article_insert',["data"=>null]);
    }

    public function testshow(){
        return "此处是testshow";
    }
}