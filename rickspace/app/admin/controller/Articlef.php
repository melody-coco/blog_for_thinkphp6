<?php


namespace app\admin\controller;


use app\admin\model\articles;
use app\BaseController;

class Articlef extends BaseController
{


    public function article_update(){               //更新文章
        if(request()->isGet()){

            $id = request()->get("id");   //获取前端要修改的article的id
            $article = articles::where("id",$id)->find(); //找出article

//            return view("../view/admin_article_insert",[      //使用编辑器之后，把更新重定向到index里面去，如此编辑器采用的了
//                "data"      =>      $article
//            ]);
            echo $article;
            return redirect("../../admin")->with('data',$article);



        }elseif (request()->isPost()){

            $token = request()->checkToken('__token__');    //验证token
            if (!$token) return "请勿测试，如若不听，系统会自动报警";

            $data = request()->param();                         //获取参数进行修改
            $article = articles::where("id",$data['id'])->find();
            $article->title = $data['title'];
            $article->content = $data['content'];
            $article->save();

            return redirect('../administrators/all_article');  //重定向到首页
        }else{
            echo "对不起你的请求出现了错误，请重试";
        }
    }


    public function article_delete(){       //删除文章
        $id = request()->param();
        articles::destroy($id);
        return redirect("../administrators/all_article");
    }


    public function article_insert(){       //添加文章
//        if(request()->isGet()) return view('../view/admin_article_insert');
        if(request()->isGet()) return redirect('http://127.0.0.1:8000/admin'); //修改编辑器时候改的

        if(!request()->checkToken("__token__")) return "请勿进行渗透测试，如若不听，本系统会自动报警";

        $data = request()->param();
        echo "获取到的content为：".$data['content'];
        $article = new articles();
        $article->title = $data['title'];
        $article->content = $data['content'];
        $article->record = 0;
        $article->admin_id = 1;         //  此处的传作者id暂时为1
        $article->save();

        return redirect("../administrators/all_article");
    }



    public function article_search(){
        $data = request()->param("search");
        $article = articles::where('title','like',"%$data%")
            ->whereOr("content",'like',"%$data%")
            ->select();
//        dump(articles::getLastSql());

        return view("../view/index",["data"=>$article]);
    }
}