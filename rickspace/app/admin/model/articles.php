<?php


namespace app\admin\model;


use think\Model;
use think\model\concern\SoftDelete;
use function Composer\Autoload\includeFile;
use Parsedown;

//include('/parsedown/Parsedown.php');
//include __DIR__.'../../../public/parsedown/Parsedown.php';

class articles extends Model
{
    protected $table = "articles";
    protected $pk    = "id";
    protected $schema=[
        "id"        =>      "integer",
        "title"     =>      "varchar",
        "content"   =>      "varchar",
        "create_time"=>     "date",
        "update_time"=>     "date",
        "delete_time"=>     "date",
        "record"     =>     "integer",
        "admin_id"  =>      "integer"
    ];

    use SoftDelete;
    protected $deleteTime = "delete_time";

    public function admin(){            //一对一关联
        return $this->belongsTo(admin::class,"admin_id");
    }




    public static function getContent($id){        //后端解析md
        $article = articles::findOrEmpty($id);
        if(empty($article)) return false;

        $parsedown = new Parsedown();
        $article->content = $parsedown->text($article->content);
//        echo $article->content."<br>";
        return $article;

    }
}