<center>变量</center>
### 一,	变量



#### 1.变量概念

​	PHP中的变量用一个美元符号跟变量名来表示。变量名是区分大小写的。

​				简例：

```
<?php
	$ff = "字符串";
	$_if = "字符串二";
?>
```



变量默认总是**传值赋值**，也就是说，当将一个表达式的值赋予一个变量时，。这意味着，当一个变量的值赋值给另一个变量时，改变其中一个变量的值，将不会影响到另一个变量。



PHP还提供另一种给变量赋值的方式：**引用赋值**。这意为着，上面的例子中，改变前者的内容，后者的的内容也会变。

引用赋值的符号为`&`.

```php
<?php
	$test = 'qq';
	$test1 = &$test;
	$test = 'www';
	echo $test;				//输出www
	echo $test1;			//输出www
?>		//ps.只有有名字的变量才可以被引用赋值
```





#### 2,	预定义变量

​		简单说，就像是特定的方法一样。其中变量如下：

- [超全局变量](https://www.php.net/manual/zh/language.variables.superglobals.php) — 超全局变量是在全部作用域中始终可用的内置变量
- [$GLOBALS](https://www.php.net/manual/zh/reserved.variables.globals.php) — 引用全局作用域中可用的全部变量
- [$_SERVER](https://www.php.net/manual/zh/reserved.variables.server.php) — 服务器和执行环境信息
- [$_GET](https://www.php.net/manual/zh/reserved.variables.get.php) — HTTP GET 变量
- [$_POST](https://www.php.net/manual/zh/reserved.variables.post.php) — HTTP POST 变量
- [$_FILES](https://www.php.net/manual/zh/reserved.variables.files.php) — HTTP 文件上传变量
- [$_REQUEST](https://www.php.net/manual/zh/reserved.variables.request.php) — HTTP Request 变量
- [$_SESSION](https://www.php.net/manual/zh/reserved.variables.session.php) — Session 变量
- [$_ENV](https://www.php.net/manual/zh/reserved.variables.environment.php) — 环境变量
- [$_COOKIE](https://www.php.net/manual/zh/reserved.variables.cookies.php) — HTTP Cookies
- [$php_errormsg](https://www.php.net/manual/zh/reserved.variables.phperrormsg.php) — 前一个错误信息
- [$HTTP_RAW_POST_DATA](https://www.php.net/manual/zh/reserved.variables.httprawpostdata.php) — 原生POST数据
- [$http_response_header](https://www.php.net/manual/zh/reserved.variables.httpresponseheader.php) — HTTP 响应头
- [$argc](https://www.php.net/manual/zh/reserved.variables.argc.php) — 传递给脚本的参数数目
- [$argv](https://www.php.net/manual/zh/reserved.variables.argv.php) — 传递给脚本的参数数组



#### 3.	变量范围

​		变量的范围即他定义的上下问背景，。大部分的PHP变量只有一个单独的范围。这个单独的范围同样包含`include`和`require`引入的文件。例如：

```php
<?php
    $a = 1;
    include 'b.inc';
?>
```



变量范围，全局范围，局部变量什么的就不用说了



##### 1,	global

​		global的作用为声明全局变量。

​		简例如下：

```php
<?php
	$a = '1';
	$b = '2';
	function test(){
		gloabl $a,$b;
		$b = $a + $b;
	}
	echo $b;			//这里输出3
?>
```



​		`$GLOBALS`替代global.

```php
<?php
	$a = 1;
	$b = 2;
	fucntion test(){
		$GLOBALS['b'] = $GLOBALS['a'] + $GLOBALS['b'];
		
	}
	test();
	echo $b;		//这里的$GLOBAL就像是一个全局的对象
?>					//这里$GLOBSAL['b']就像是引用数组
```

##### 2.	static



​		变量范围的另一个重要特性是静态变量，静态变量仅在局部函数域中存在，但当程序执行离开此作用时，其值并不丢失。看看下面的例子。





```php
<?php
	function test(){
		static $a = 1;
		echo $a;
		$a++;
	}
	echo test();		//输出1
	echo test();		//输出2
?>				//$a不会一直被初始化为1
```

普通的函数中的变量，当函数运行完了的时候，变量被清零。而使用`static`静态变量时，则不会直接被清零



`static`修饰的变量不能被对象访问，只能通过类来访问，而`static`的方法可以被对象访问

`static`赋值时不能使用表达式



##### 3,	可变变量

​	简单说就是一个变量的值，用来当做另一个变量的变量名，

​		动态的去设置变量名		

例如：

```php
<?php
	$a = 'hellow';
	$$a = 'fff';		//变量名为一个变量名
	echo "$a, ${$a}"	//等价于	echo "$a,$hellow" 
?>				//ps.也可以使用$fff来表示上面的可变变量
    $a = "world"   
        		//这里再修改$a的值的话是不能用的，因为已经设置了$hellow为fff
```



##### 4,	PHP以外的变量

​	

###### 1.	HTML表单(get和post)



​		一个表单：

```html
<form action="foo.php" method="POST">
    Name:  <input type="text" name="username"><br />
    Email: <input type="text" name="email"><br />
    <input type="submit" name="submit" value="Submit me!" />
</form>
```



​		访问数据：

```php
   echo $_POST['username'];
   echo $_REQUEST['username'];
   
   import_request_variables('p', 'p_');
   echo $p_username;
   echo $HTTP_POST_VARS['username'];
```





###### 2.	cookie

​	cookie的话不说了，需要自己再看看



###### 3.	.

.为连接符	







### 二.	常量

​		

#### 1.	语法

使用`define()`函数来定义常量，或者使用`const`关键字在类定义之外定义常量。

常量定义时，前面不加任何修饰符

常量只能包含标量数据(`boolean`，`integer`，`float`和`string`)。可以定义`rtesouce`常量，但应该避免





​		常量可以被类或者对象访问到

```php
<?php
	define("test","hellow world");
	echo test;
?>
```



```php
<?php
	const test = 'hellow word';
	echo test;
?>
```



#### 2,	魔术常量

​		一些*魔术常量*

	名称	说明
| **`__LINE__`**      | 文件中的当前行号。                                           |
| ------------------- | ------------------------------------------------------------ |
| **`__FILE__`**      | 文件的完整路径和文件名。如果用在被包含文件中，则返回被包含的文件名。自 PHP 4.0.2 起，**`__FILE__`** 总是包含一个绝对路径（如果是符号连接，则是解析后的绝对路径），而在此之前的版本有时会包含一个相对路径。 |
| **`__DIR__`**       | 文件所在的目录。如果用在被包括文件中，则返回被包括的文件所在的目录。它等价于 *dirname(__FILE__)*。除非是根目录，否则目录中名不包括末尾的斜杠。（PHP 5.3.0中新增） = |
| **`__FUNCTION__`**  | 函数名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该函数被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。 |
| **`__CLASS__`**     | 类的名称（PHP 4.3.0 新加）。自 PHP 5 起本常量返回该类被定义时的名字（区分大小写）。在 PHP 4 中该值总是小写字母的。类名包括其被声明的作用区域（例如 *Foo\Bar*）。注意自 PHP 5.4 起 __CLASS__ 对 trait 也起作用。当用在 trait 方法中时，__CLASS__ 是调用 trait 方法的类的名字。 |
| **`__TRAIT__`**     | Trait 的名字（PHP 5.4.0 新加）。自 PHP 5.4 起此常量返回 trait 被定义时的名字（区分大小写）。Trait 名包括其被声明的作用区域（例如 *Foo\Bar*）。 |
| **`__METHOD__`**    | 类的方法名（PHP 5.0.0 新加）。返回该方法被定义时的名字（区分大小写）。 |
| **`__NAMESPACE__`** | 当前命名空间的名称（区分大小写）。此常量是在编译时定义的（PHP 5.3.0 新增）。 |

