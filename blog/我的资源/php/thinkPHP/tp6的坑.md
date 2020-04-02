<center>坑</center>
#### 1.	view模板问题

1.无论如何，哪怕是用默认的模板引擎，都需要使用命令行安装

```php
composer require topthink/think-view
```

对了，模板引入的`view`路径为`think\facade\View`



#### 2.	前端路由问题

​	前端我想写动态路由，

绝对路由就不说了

1.现在已经能够正常的传参

`http://serverName/index.php（或者其它入口文件）/控制器/操作/参数/值…`

前端动态路由如下：

```php
<a href="{:url('Articlef/articles',['articleName'=>$list.title])}">点击</a>
    
  //主要是方法url传参的问题url函数第一个参数定义路由，第二个参数为数组，可以往里面放键值对参数
```





后端接收：

```php
$qrticle = request()->get("articleName");	//request请求对象get接收


public function articles($articleName){		//此方法为参数绑定
	echo $articleName;
}
```





#### 3.	find和select

`find`和`select`最大的区别是，前者返回的是一条数据（`array`），后者返回的是一个数组的几条数据（二维数组）



#### 4.	redirect

`thinkphp`的重定向`redirect`

```php
return redirect("hellow/id/1");		//简单的重定向，带参数
//但是如上的重定向有个问题就是无法跳转到其他的控制器，只能是用绝对定位例如
	http://127.0.0.1:8080/administrators/all_article
```

但是可以如下：



```php
return redirect("../别的控制器/test/id/1");
return view("../别的目录/index");			//view也可以这样写
```



#### 5.	路由传参

关于路由传参的问题，

a标签的动态路由传参，上面第2个已经解答了。

此处简述一下，参数绑定传参的问题：

```php
public function test($id){
	echo $id;
}				//此处为参数绑定传参，的controller层
```



想要传进去的话可以有两种方式

+ 使用路由的方式

  ```php
  //在总路由route/app.php下定义
  Route::get("Articlef/articles/[:id]","Articlef/articles");
  		//url为http://127.0.0.1:8080/Articlef/articles/1
  				//此处就可以直接的使用路由传参的方式
  ```

  

+ 直接使用`url`

  ```php
  //可以直接使用url，来进行参数绑定传参
  //在浏览器的路由界面输入：
  http://127.0.0.1:8080/Articlef/articles/id/1
  				//这样，相当于设置id=1
  ```

  



#### 6.	中间件

中间件怎么写这里不做描述，只说全局中间件，应用中间件，控制器中间件，和多应用下的中间件。

##### 单应用

+ 全局中间件

单应用中间件，都是写在app目录下的`middleware`文件夹中的，如果想要其中一个中间件成为全局中间件的话，需要在app目录下的  `middleware`全局中间件定义文件中  定义

`middleware`全局中间件定义文件中

```php
//
<?php
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
//    \think\middleware\SessionInit::class,
       app\middleware\Check::class,     //此处为注册全局中间件

			//注册middleware目录中的Check称为全局中间件
];
```



+ 应用中间件

因为单应用模式下，只有一个应用，所以单应用模式的应用中间件，就是上面的全局中间件



+ 控制器中间件

首先我们在app下的`middleware`目录中，有一个中间件`check2`。

想要使用控制器中间件的话需要在控制器中注册。

在控制器`test3`中

```php
protected $middleware = [
        'app\middleware\Check3'     =>  ['except' 	=> ['index'] ],//排除index方法
        'app\middleware\Check2'     =>  ['only'   =>  ['test2'] ], //仅适用于test2方法
    ]; //此处引用，应用中间件Check2
				//此为注册控制器中间件
```





##### 多应用模式

+ 全局中间件

多应用模式下的全局中间件，和上面的单应用全局中间件一样，就不写了。

```php
<?php
// 全局中间件定义文件
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
     \think\middleware\SessionInit::class,
    app\admin\middleware\check::class             //此处为应用中全局中间件的声明
];		//此中间件check在admin应用下的middleware目录中

```





+ 应用中间件

  主要是：新建应用中间件定义文件	（ps.此文件不用注册，只需要copy全局中间件定义文件）



多应用模式下的应用中间件，适用于单独的应用。

首先，在应用目录新建一个`middleware`文件，这个文件就像`app`目录下的`middleware`全局中间件定义文件 一样

（ps.文件类型为`php File`）	

这样的话，应用目录中就有了，应用中间件定义文件了。然后再在该文件中写入：

```php
<?php
return [
    // 全局请求缓存
    // \think\middleware\CheckRequestCache::class,
    // 多语言加载
    // \think\middleware\LoadLangPack::class,
    // Session初始化
//    \think\middleware\SessionInit::class,
    app\admin\middleware\check::class             //此处为应用中间件的声明
			//注册应用目录下的middleware目录中的中间件
];
```

这样我们的应用中间件就能用了



+ 控制器中间件

多应用的控制器中间件和单应用的一样，看上面就好了





#### 7.	验证器

验证器的话，就没得那么多事，多应用也像单应用一样，直接在总`app`目录下创建`validte`目录然后碗里面添加验证器就行了，要用的话，直接引用路径就行了



#### 8.	模板的问题

关于模板的问题，

##### 模板放在哪

首先前端`html`模板可以放在，总的`view`目录里面（ps.也就是项目目录下的`view`目录），也可以放在应用目录下的`view`目录中（ps.最好放在`view`目录中）





##### 控制层怎么进模板

想要进模板的话，直接在控制器里面写`view()`助手函数，函数里面贴模板路径就好了。





##### 模板的静态文件放在哪

模板的静态文件(js,css,img,)放在`public`目录下，最好创一个`static`目录放在里面，然后模板要引用的话直引用就好了（ps.因为`public`是总的入口文件，项目进去默认就是从`public`进的）。

举例如下：

​	我的静态文件放在了`public/static/assets`下，如果要引用的话



```php+HTML
//静态路由
<link rel="stylesheet" href="/static/assets/css/main.css" />
//动态路由
<link rel="stylesheet" href="{:url('/static/assets/css/main.css')->suffix(false)}" />
			//如果有些不对的可以看F12里面的console，看哪些文件没加载进来，自己慢慢调
```







#### 9.	路由问题

单应用的话可以直接在根目录下的`route/app.php`中定义，

但是多应用的话要注意，需要下应用目录下新建`route`目录，里面放一个`route.php（php file）`





#### 10.	解析markdown

后端解析markdown的话需要使用`parserdown`直接在官方去下

```php
//使用compaser来安装
composer require erusev/parsedown
```

文件在项目目录的vendor/erusev里面。实际要在model层使用的话，直接use就好了

```php
use Parsedown;		//use的时候会自动提示位置

//类里面创建一个方法，来使用Parserdown的类
public static function getContent($id){        //后端解析md
        $article = articles::findOrEmpty($id);
        if(empty($article)) return false;

        $parsedown = new Parsedown();
        $article->content = $parsedown->text($article->content);
        return $article;

    }

```

控制层直接使用该方法就好了。

有可能前端传过去的数据不会解析。使用：

```php
{$data.content|raw}		//后面加一个|raw就会被认为不解析
```



#### 11.	editor

不懂`editor`话建议直接去官网下载。（ps.他家的官网没有学的，实例在安装包里面）



使用`editor`的过程中遇到了，一个最大的问题就是路径问题，我想装的编辑器，只有3个js,css文件。但是其中最重要的一个js，文件又会引入其他四个js文件。由于这四个js文件是自动引入的，所以我控制不了引入的路径的问题。

以至于我的js,cs文件在

```
http://127.0.0.1:8000/editor-md/lib/codemirror/codemirror.min.css
```



但是自动引入的路径，会自动加在当前路径的后面。一直为

```
http://127.0.0.1:8000/admin/article/editor-md/lib/codemirror/codemirror.min.css
```





这样我就实在没办法引用，后来唯一得解决办法就是，把编辑器放在入口文件处。这样的话就不会加上前面的路径了



所以是这样的：

```
http://127.0.0.1:8000/admin/		//此处为控制器名，不是控制器名和方法名
```





`editormd`的js代码如下：

```javascript
const blogEditor = editormd("test-editormd", {
		placeholder: '请输入内容',
		width: "100%",//编辑器高度
		height: 540,//编辑器宽度
		path: "editor-md/lib/",//这个路径为编辑器项目目录
		emoji: true,//是否开启emoji表情
		saveHTMLToTextarea: true,
		tex             : true,  // 默认不解析
		flowChart       : true,  // 默认不解析
		sequenceDiagram : true,  // 默认不解析
		markdown:"{$data}"		//默认内容
	});
	function getMd(){
		var md = blogEditor.getMarkdown();//获取编辑器内容
		document.getElementById('mdd').value = md;
		alert(md)

	}
```





#### 12.	filezilla

此软件要连接服务器的话可能要设置windows防火墙的问题和sftp连接的问题

