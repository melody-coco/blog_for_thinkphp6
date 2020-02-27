<?php


namespace app\user\controller;


use app\admin\model\articles;
use app\BaseController;
//include("../../public/parsedown/Parsedown.php");

class Index extends BaseController
{
        public function index(){            //普通用户入口
//            echo "<br>user默认应用的默认目录";
//            return view('../view/user_index');
            $articles = articles::where("id","<>",0)->limit(4)->select();
//            dump(articles::getLastSql());

            return view('../view/index',["data"=>$articles]);
        }



        public function articles(){         //跳转到所有文章
            $articles = articles::where('id','<>',0)->order('id','asc')->paginate(5);
//            dump($articles->count());
//            dump(articles::getLastSql());

            return view('../view/articles',["data"=>$articles]);
        }


        public function article(){          //查看单独的文章

            $data = request()->param("id");
            $article = articles::getContent($data);         //使用parserDown的解析markDown   序言安装官方包
            return view('../view/article',['data'=>$article]);

//            $data = request()->param();
//            $article = articles::where('id',$data['id'])->find();
//            $parseDown = new Parsedown();
//
//            if(!empty($article)){
//                $article->content = $parseDown->text($article->content);
//            }

//            return view('../view/article',['data'=>$article]);
        }
}