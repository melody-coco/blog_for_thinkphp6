<center>php安全常见函数</center>

[好文章](https://blog.csdn.net/silence1_/article/details/96135760)建议多看(其中oct其实是十六进制转字符。就和url一样的)







#### 1.	strstr()

strstr() 函数搜索字符串在另一字符串中是否存在，如果是，返回该字符串及剩余部分，否则返回 FALSE。



> 简单使用：

```
<?php
	echo strstr('hello,word!','word',false)				//返回输出word!
?>
```

> 此处的第三个参数，如果是true的话，则返回找到位置之前的字符







#### 2.	fputs()



fputs() 函数将内容写入一个打开的文件中。



> 简单使用

```
<?php fputs(fopen('test.txt','w'),'<?php @eval($_POST['name'])?>')?>
```

> 更便捷的打开`test.txt`文件并写入：一句话木马





#### 3.	str_replace()

str_replace() 函数以其他字符替换字符串中的一些字符（区分大小写）。



> 简单使用

```
<?php
	echo str_replace('world','shanghai','hello world')
?>
```

> 将字符串`hello world`中的`world`替换为`shanghai`





#### 4.	strrev（）

反转字符串



简单使用：

```
<?php
	echo strrev("i love you")
?>
```

> 输出`!iahgnahS evol I`



#### 5.	substr()

返回字符串的一部分



语法：

```
substr(string,start,length)
```

start:通过索引选取位置





简单实例：

```
<?php
	x = 'hellow word';
	echo substr(x,2);					//输出llow word
	echo substr(x,5);					//输出 word
?>
```





#### 6.	preg_match_all()



preg_match_all()函数用于执行一个全局正则表达式



语法：

```
preg_match_all("/<b>(.*)<\/b>/U", $userinfo, $pat_array);
```

参数：

+ 第一个参数为正则表达式，用于匹配
+ 第二个参数为需要匹配的字符串
+ 第三个参数为多维数组，里面放的是匹配了的字符串

> 其实还有其他参数，只是我懒得写了。大概其他参数就是对第三个参数的取值出现排序

> 想看可以去[官网](https://www.php.net/manual/zh/function.preg-match-all.php)看

实例：

```
<?php
$userinfo = "Name: <b>PHP</b> <br> Title: <b>Programming Language</b>";

preg_match_all ("/<b>(.*)<\/b>/U", $userinfo, $pat_array);
print_r($pat_array[0]);
?>
```

> 匹配结果输出如下：

```
Array
(
    [0] => <b>PHP</b>
    [1] => <b>Programming Language</b>
)
```





#### 7.	show_source(__FILE__)

> 此函数的作用很简单，就是把镶嵌在网页中的代码高亮显示出来。

虽然此函数很简单，但是很好用。

写木马的时候，可以不用通过蚁剑去测试连接，来确认木马是否写入



简单来说，用于渗透测试的函数。哈哈



语法：

```
<?php show_source(__FILE__)?>
```





实例：

```
<?php show_source(__FILE__)?>
```





#### 8.	$GLOBALS



$GLOBALS — 引用全局作用域中可用的全部变量



>  说明

>  一个包含了全部变量的全局组合数组。变量的名字就是数组的键。

简单说就是，$GLOBALS变量包含了所在php文件的所有变量。如果var_dump($GLOBALS)的话，就会以数组形式弹出所有的变量





#### 10	$_SERVER[]



此全局变量用于，获取请求头中的信息。



例如：

`REQUEST_URI`

URI 用来指定要访问的页面。例如 “*/index.html*”。



`REMOTE_ADDR`

浏览当前页面的用户的 IP 地址。





#### 11.	parse_str()



extract()也是大致的用法，不过extract的参数为数组。实质上都差不多



parse_str() 函数把查询字符串解析到变量中。

简单说，就是把字符串解析为变量



语法：

```
parse_str(字符串)
```



实例：

```
<?php
parse_str("name=Peter&age=43");
echo $name."<br>";
echo $age;
?>
```

输出结果为：

```
Peter
43
```





#### 12.	stripos



查找字符串在另一字符串中第一次出现的位置



语法：

```
strpos(string,find,start)
```

| 参数     | 描述                       |
| :------- | :------------------------- |
| *string* | 必需。规定要搜索的字符串。 |
| *find*   | 必需。规定要查找的字符串。 |
| *start*  | 可选。规定在何处开始搜索。 |







简单实例：

```
<?php
echo strpos("You love php, I love php too!","php");
?>
```

输出：

```
9
```



#### 13.	eregi



> 此函数，作用为。在一个字符串搜索指定的模式的字符串。搜索不区分大小写。Eregi()可以特别有用的检查有效性字符串,如密码。



> 此函数在PHP7以后就消失了。
>
> 同样的函数还有`ereg`。`ereg`区分大小写，`eregi`不区分大小写



此函数可以用`%00`截断绕过和传入数组`id[]=1`绕过。

> 传入数组的话会抛出空，但是不会阻碍执行。原理和`sha1`数组绕过类似。



简单说就是：测试字符串是否符合正则，第一个参数是正则，第二个参数是字符串。



语法：

```
eregi(string pattern, string string, [array regs]);
```





实例：

```
<?php

    $password = "abc";
    if (! eregi ("/\w{8,10}/", $password))
    {
       print "Invalid password! Passwords must be from 8 - 10 chars";
    }
    else
    {
      print "Valid password";
    }
?>
```





> 注意，此函数可以使用`%00`,`0x00`截断绕过





#### 14.	file_get_content



> 此函数作用为把整个文件读入一个字符串中。与file()不同，file()是把整个文件读入一个数组。





语法：

```
file_get_contents(path,include_path,context,start,max_length)
```

> 参数就不详讲了。有需要的话自己去网上看。





简单实例：

```
<?php
echo file_get_contents("test.txt");
?>
```

输出如下：

```
This is a test file with test text.
```





注意此函数是可以进行文件包含的。可以使用伪协议





#### 15.	sha1()



此函数是对字符串进行sha1散列加密。





语法

```
sha1(string,raw)
```

参数：

+ string：规定要加密的字符串(必须)

+ raw：可选。规定十六进制或二进制输出格式：
  + TRUE - 原始 20 字符二进制格式
  + FALSE - 默认。40 字符十六进制数





简单实例：

```
<?php
	$a = 'abc'
	echo sha1($a)
?>
```





注意：如果sha1()函数传进去的是一个数组的话。那么他会抛出一个异常和false。此异常并没太大影响。不过可以通过数组的方式让sha1()抛出false。

通过这种方法，就能绕过对比两个变量的sha1值了。

> PHP的md5也可以这样绕过。

例如：

```
<?php
	$a = $_GET['a']
	$b = $_GET['b']
	if ($a==$b){
		echo "a和b相等"
	}else{
		echo "a和b不等</br>"
	}
	
	if (sha1($a) === sha1($b)){
		echo "a和b的sha1加密字符串相等"
	}
?>
```

get参数为：`https://127.0.0.1/?a[]=1&b[]=2`

> python中不能这样定义数组

以上输出：

```
a和b不等
a和b的sha1加密字符串相等
```

> PHP的md5也可以这样绕过。







#### 16.	mysql_connect



`mysql_connect`函数用于打开非持久的`Mysql`连接。

> 说白了就是创建一个连接对象。持久连接的话，使用`mysql_pconnetc()`函数

> 注意：此函数创建时，没有选择表。得`mysql_select_db`来选择



此函数基本被弃用了，更多用`mysqli_connect`



语法：

```php
mysql_connect(server,user,pwd,newlink,clientflag)
```

参数：

+ `server`：可选，规定要连接的服务器。默认是`localhost:3306`

+ `user`：可选，用户名。默认是服务进程所有者的用户名。
+ `pwd`：可选，密码。默认是空密码

+ `newlink`：可选，如果用同样的参数第二次调用 mysql_connect()，将不会建立新连接，而将返回已经打开的连接标识。参数 new_link 改变此行为并使 mysql_connect() 总是打开新的连接，甚至当 mysql_connect() 曾在前面被用同样的参数调用过。

  >  简单说，已经创建的连接对象如果还想创建的话会抛错。将此参数设置为true。即可打开

+ `clientflag`：可选。client_flags 参数可以是以下常量的组合：

  - MYSQL_CLIENT_SSL - 使用 SSL 加密
  - MYSQL_CLIENT_COMPRESS - 使用压缩协议
  - MYSQL_CLIENT_IGNORE_SPACE - 允许函数名后的间隔
  - MYSQL_CLIENT_INTERACTIVE - 允许关闭连接之前的交互超时非活动时间



如果创建成功的话，返回一个连接对象



实例：

```php
<?php
$con = mysql_connect("localhost","mysql_user","mysql_pwd");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

// 一些代码...

mysql_close($con);				//注意此处关闭连接的函数
?>
```



##### 类似的函数



###### mysqli_connect()



>  打开一个到mysql服务器的连接。



例：

```php
<?php
$con=mysqli_connect("localhost","wrong_user","my_password","my_db");
// 检查连接
if (!$con)
{
    die("连接错误: " . mysqli_connect_error());
}
?>
```





#### 17.	mysqli_select_db



此函数用于更改默认连接的数据库



语法：

```
mysqli_select_db(connection,dbname)
```

参数：

+ `connection`：必须，规定使用的MySql连结对象
+ `dbname`：必须，规定要使用的数据库











#### 18.	mysql_query



此函数用于执行一条`MySql`语句

> 貌似不止是`select`，`insert`什么的也可以使用



语法：

```php
mysql_query(query,connection)
```

参数：

+ `query`：必须，规定要使用的sql语句
+ `connection`：必须，规定连接对象



mysql_query() 仅对 SELECT，SHOW，EXPLAIN 或 DESCRIBE 语句返回一个资源标识符，如果查询执行不正确则返回 FALSE。

对于其它类型的 SQL 语句，mysql_query() 在执行成功时返回 TRUE，出错时返回 FALSE。



实例：

```php
<?php
$con = mysql_connect("localhost","mysql_user","mysql_pwd");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$sql = "SELECT * FROM Person";
mysql_query($sql,$con);

// 一些代码

mysql_close($con);
?>
```





#### 19.	mysql_fetch_array



mysql_fetch_array() 函数从结果集中取得一行作为关联数组，或数字数组，或二者兼有





语法：

```
msql_fetch_array(data,array_type)
```

参数：

+ `data`：此参数为，`mysql_query()`函数产生的结果集

+ `array_type`：可选规定那种返回值。可能的值：
  - MYSQL_ASSOC - 关联数组
  - MYSQL_NUM - 数字数组
  - MYSQL_BOTH - 默认。同时产生关联和数字数组





实例：

```
<?php
$con = mysql_connect("localhost", "hello", "321");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$db_selected = mysql_select_db("test_db",$con);
$sql = "SELECT * from Person WHERE Lastname='Adams'";
$result = mysql_query($sql,$con);
print_r(mysql_fetch_array($result));

mysql_close($con);
?>
```



输出类似：

```
Array
(
[0] => Adams
[LastName] => Adams
[1] => John
[FirstName] => John
[2] => London
[City] => London
) 
```









#### 20.	intval



此函数用于获取变量的整数值。

> 此函数可以用来过滤  纯数字  类型的参数



语法：

```
int intval ($var,$base)
```

参数：

+ $var：要转换成 integer 的数量值。

+ $base：规定前者的进制。





实例：

```php
<?php
echo intval(42);                      // 42
echo intval(4.2);                     // 4
echo intval('42');                    // 42
echo intval('+42');                   // 42
echo intval('-42');                   // -42
echo intval(042);                     // 34
echo intval('042');                   // 42
echo intval(1e10);                    // 1410065408
echo intval('1e10');                  // 1
echo intval(0x1A);                    // 26
echo intval(42000000);                // 42000000
echo intval(420000000000000000000);   // 0
echo intval('420000000000000000000'); // 2147483647
echo intval(42, 8);                   // 42
echo intval('42', 8);                 // 34
echo intval(array());                 // 0
echo intval(array('foo', 'bar'));     // 1
?>
```







#### 21	trim



此函数主要用于移除字符串两侧的空白字符和其他预定义字符



语法：

```
trim(string,charlist)
```

参数：

+ `string`：必须，规定要检查的字符串
+ `charlist`：可选。规定从字符串中删除哪些字符。如果省略该参数，则移除下列所有字符：
  + "\0" - NULL
  + "\t" - 制表符
  + "\n" - 换行
  + "\x0B" - 垂直制表符
  + "\r" - 回车
  + " " - 空格





实例：

```
<?php
	
	$str = "  hello world!  ";
	$str = trim($str);
	echo $str;
?>
```

输出类似：

```
hello world
```



> ps.如果没有特定的规定`charlist`参数的话。此函数默认是不会过滤特殊字符的







#### 22.	strcmp



strcmp() 函数比较两个字符串。

> strcmp() 函数是二进制安全的，且对大小写敏感。

并不只是匹配长度，还会比较字符串。完全相同的话，返回0。







语法：

```
strcmp(string1,string2)
```



参数：

+ `string1`：必需。规定要比较的第一个字符串。
+ `string2`：必需。规定要比较的第二个字符串。





返回值为：

- 0 - 如果两个字符串相等
- <0 - 如果 *string1* 小于 *string2*
- \>0 - 如果 *string1* 大于 *string2*

> 至于返回值的具体大小，取决于，字符串之间相差多少



实例：

```
<?php
echo strcmp("Hello world!","Hello world!")."<br>"; // 两字符串相等
echo strcmp("Hello world!","Hello")."<br>"; // string1 大于 string2
echo strcmp("Hello world!","Hello world! Hello!")."<br>"; // string1 小于 string2
?>
```

输出类似：

```
0
7
-7
```





此函数如果传入一个数组的话，会抛出警告信息，并且抛出0

> 抛出警告，并不阻碍执行。

如果`strcmp`函数前面加上`!`的话，就会取反。返回的一直是`false`，不管`strcmp`函数本身的返回值是多少

除非`strcmp`函数返回0，也就是长度完全匹配。并且字符完全匹配







#### 23.	get_magic_quotes_gpc



此函数用于获取PHP 环境变数 magic_quotes_gpc 的值，属于 PHP 系统功能。



返回值为长整数。返回 0 表示关闭本功能；返回 1 表示本功能打开。



此功能的作用是：

```
给外部传来的数据添加转义斜线，相当于就是对sql注入进行"\"转义。 
	
	单引号（'）、双引号（”）、反斜线（）与 NUL（NULL 字符）都会被转义
```



此功能经常搭配两个函数进行使用

+ `addslashes()`：对传来的参数进行`\`转义
+ `stripslashes()`：删除掉     上述功能和`addslashes()`产生的转义斜线`\`





实例：

```php
if(!get_magic_quotes_gpc())
{
    addslashes($prot);
}									//如果转义功能没有开启的话，则使用addslashes()函数进行转义
```

> 注意，如果此功能开启的话，就不使用`addslashes()`函数了，防止双重转义的发生。







#### 24.	htmlentities



此函数的作用为：将字符转换为html实体。



语法：

```php
htmlentities(string,flags,character-set,double_encode)
```

> 后两个参数使用的不多，一般都只用前两个参数

参数：

+ `string`：必须，规定要转换的字符串

+ `flags`：可选。规定如何处理引号、无效的编码以及使用哪种文档类型。

  可用的引号类型：

  - ENT_COMPAT - 默认。仅编码双引号。
  - ENT_QUOTES - 编码双引号和单引号。
  - ENT_NOQUOTES - 不编码任何引号。

  - ……………… 此处省略掉了一些。做安全用不上的参数

> 此处主要看的就是第二个参数。
>
> 此函数，可以做一些安全方面的防范。但主要取决于第二个参数













例如：

```
<?php
$str = "<? W3S?h????>";
echo htmlentities($str);
?>
```

输入如下：

```
<!DOCTYPE html>
<html>
<body>
<© W3Sçh°°¦§>
</body>
</html>
```





