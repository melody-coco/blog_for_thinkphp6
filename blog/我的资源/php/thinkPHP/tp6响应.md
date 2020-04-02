<center>TP6响应</center>
#### 1.	响应输出

| 输出类型     | 快捷方法 | 对应Response类           |
| :----------- | :------- | :----------------------- |
| HTML输出     | response | \think\Response          |
| 渲染模板输出 | view     | \think\response\View     |
| JSON输出     | json     | \think\response\Json     |
| JSONP输出    | jsonp    | \think\response\Jsonp    |
| XML输出      | xml      | \think\response\Xml      |
| 页面重定向   | redirect | \think\response\Redirect |
| 附件下载     | download | \think\response\Download |



```php
return jsonp($data);				//json格式渲染输出
return response($data);				//response渲染输出
//ps.不用在当前控制器，导入（use）响应的命名空间
```







#### 2.	响应参数





##### 设置响应数据：

`Response`基类提供了`data`方法用于设置响应数据。

​	(ps.这里的为链式调用)

```php
return response()->data($data1);			//ps.下面为json格式
return json()->data($data2)			//
```

`data`方法设置的只是原始数据，不一定是最终的输出数据，最终响应的输出数据会更具当前的`Response`响应类型做自动转换，例如：

```php
json()->data($data);
//最终的输出数据为 json_encode($data)转换后的数据.
```



##### 设置状态码

`Response`基类提供了`code`方法用于设置响应数据，但是一般都是直接调用助手函数拆入状态码。例如：

```php
return json($data2,999);
return view($data1,666);	//view不能直接渲染json数据
```

链式调用如下：

```php
return json($data1)->code(999);
```



##### 设置头信息

使用`Response`类的`header`设置响应的头信息

```php
return json($data1)->code(888)->header([
	'Cache-control' => 'no-cache,must-revalidate'
]);
```

除了`header`方法之外，`Response`基类还提供了常用头信息的快捷设置方法：

| 方法名         | 作用                      |
| :------------- | :------------------------ |
| `lastModified` | 设置`Last-Modified`头信息 |
| `expires`      | 设置`Expires`头信息       |
| `eTag`         | 设置`ETag`头信息          |
| `cacheControl` | 设置`Cache-control`头信息 |
| `contentType`  | 设置`Content-Type`头信息  |

除非你要清楚自己在做什么，否则不要随便更改这些头信息，每个`Response`子类都有默认的`contentType`信息，一般无需设置。

你可以使用`getHeader`方法获取当前响应对象实例的头信息。







##### 设置额外参数

有些时候，响应输出需要设置一些额外的参数，例如：
在进行`json`输出的时候需要设置`json_encode`方法的额外参数，`jsonp`输出的时候需要设置`jsonp_handler`等参数，这些都可以使用`options`方法来进行处理，例如：

```php
return jsonp($data)->options([
    'var_jsonp_handler'     => 'callback',
    'default_jsonp_handler' => 'jsonpReturn',
    'json_encode_param'     => JSON_PRETTY_PRINT,
]);
```

##### 关闭当前的请求缓存

支持使用`allowCache`方法动态控制是否需要使用请求缓存。

```php
// 关闭当前页面的请求缓存
return json($data)->code(201)->allowCache(false);
```





自定义响应自己官方文档[看](https://www.kancloud.cn/manual/thinkphp6_0/1037527)





#### 3.	重定向

使用`redirect`助手函数进行重定向

```php
<?php
	namespace app\controller;
	
	class Index 
	{
		public function index(){
			return redirect('http://www.thinkphp.cn');
		}
	}
?>		//重定向是向浏览器发新的url然后浏览器自动进行新的跳转
```



##### 重定向传参，

如果是站内重定向，可以支持URL组装，有两种方式组装URL，第一种是直接使用未完整的地址(`/`开头)

```php
return redirect('/index/hello/name/thinkphp');	//index控制器的hello方法
```



第二种是调用`url`函数生成。

```php
return redirect((string) url('hello',['name'=>'jack']));
```



### 记住请求地址

​	(ps.这里的没试过，但是看懂了。以后要记得试一试)

在很多时候，我们重定向的时候需要记住当前请求地址（为了便于跳转回来），我们可以使用`remember`方法记住重定向之前的请求地址。

下面是一个示例，我们第一次访问`index`操作的时候会重定向到`hello`操作并记住当前请求地址，然后操作完成后到`restore`方法，`restore`方法则会自动重定向到之前记住的请求地址，完成一次重定向的回归，回到原点！（再次刷新页面又可以继续执行）

```php
<?php
namespace app\controller;

class Index
{
    public function index()
    {
        // 判断session完成标记是否存在
        if (session('?complete')) {
            // 删除session
            session('complete', null);
            return '重定向完成，回到原点!';
        } else {
            // 记住当前地址并重定向
            return redirect('hello')
                ->with('name', 'thinkphp')
                ->remember();
        }
    }

    public function hello()
    {
        $name = session('name');
        return 'hello,' . $name . '! <br/><a href="/index/index/restore">点击回到来源地址</a>';
    }

    public function restore()
    {
        // 设置session标记完成
        session('complete', true);
        // 跳回之前的来源地址
        return redirect()->restore();
    }
}
```







#### 4.	文件下载

使用助手函数`download`进行下载

```php
public function download(){
	return download('img/5552.jpg','神奇宝贝求.png');	//可以省略后缀
}		//下载路径为public目录起始。这里为public下的img目录中的5552.png
```

可以设置下载的有效期:

```php
public function test(){
	return download('img/5552.png','神奇宝贝求')->expire(10);
}							//设置10秒的有效期
```



| 方法      | 描述                   |
| :-------- | :--------------------- |
| name      | 命名下载文件           |
| expire    | 下载有效期             |
| isContent | 是否为内容下载         |
| mimeType  | 设置文件的mimeType类型 |

助手函数提供了内容下载的参数，如果需要直接下载内容，可以在第三个参数传入`true`：

```php
public function download()
{
    $data = '这是一个测试文件';
    return download($data, 'test.txt', true);
}				//第三个参数选择true，下载的test.txt内容为：这是一个测试文件
```