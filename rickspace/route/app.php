<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


Route::get('user', function (){
    return 'hello,ThinkPHP6!';
});

Route::get('hello/:name', 'index/hello');
Route::get('user/Index/index.html',function (){
    return "欢迎";
});
Route::get('ii',function (){
    return "你好啊";
});
Route::get('admin/articlef/article_search',function(){
    return "成功抵达";
});
Route::get('admin2',function (){
    return "输出内容如下";
});
Route::get('ss',function(){
    return "执行成功";
});
Route::get('admins','admin/administrators/admin_login');

///editor-md/lib/codemirror
//'editor-md/lib/codemirror'