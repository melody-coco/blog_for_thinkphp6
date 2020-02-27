<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class Admin extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'user'          =>      [ "require","max"=>25,'regex'=>'^[A-Za-z0-9]+$'],
        'password'      =>      ['require',"max"=>25, 'regex'=>'^[A-Za-z0-9]+$']

    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'user.require'          =>      "必须填名字",
        'user.max'              =>      "名字太长",
        'user.regex'            =>      "名字带有非法字符",
        'password.require'      =>      "名字必须填写",
        'password.max'          =>      "密码太长",
        'password.regex'        =>      "密码包含非法字符"
    ];
}
