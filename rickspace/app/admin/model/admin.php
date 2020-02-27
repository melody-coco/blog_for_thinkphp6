<?php


namespace app\admin\model;


use think\Model;
use think\model\concern\SoftDelete;

class admin  extends Model
{
    protected $connection = "mysql";
    protected $table = "admin";
    protected $pk = 'id';
    protected $schema = [
        'id'            =>      "integer",
        'name'          =>      'varchar',
        'user'          =>      'varchar',
        'password'      =>      'varchar',
        'create_time'   =>      'date',
        'update_time'   =>      'date',
        'delete_time'   =>      'date'
    ];
    use SoftDelete;
    protected $deleteTime = "delete_time";

    public function article(){
        return $this->hasOne(articles::class,"admin_id");
    }
}