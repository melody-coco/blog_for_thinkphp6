<center>PHP数据类型</center>
### 一,	数据类型简介

​	PHP支持9种原视数据类型

​	

​	四种标量类型：

+ boolean(布尔型)

+ integer(整形)
+ float(浮点型，也称作Double。这是同一种)
+ string(字符串)



​	四种复合结构：

+ array (数组)
+ object (对象)
+ callble (可调用，回调函数)



​	两种特殊类型：

+ resource (资源)
+ NULL (无类型)



​	PHP官方文档还介绍了一些`伪类型`:

+ mixed (混合类型)
+ number (数字类型)
+ callback (回调类型，又称为callable)
+ array|Object (数组|对象类型)
+ void (无类型)



​	以及为伪变量$…。



### 二,	具体的数据类型

​		



#### 2.1,	Boolean布尔类型

​		详情点[这里](https://www.php.net/manual/zh/language.types.boolean.php)

​		布尔值不多说了吧

```php
<?php
	$booltest = true;
    if($booltest){
    echo 'booltest的值为true';
    }
?>
```

​		

​		转化为bool值：通过`(bool)`来进行强制转换

```
<?php
	$test = 5;
	echo (bool)5;
?>
```

​		当转换为`boolean`时，以下值被认为是`false`；	

+ 布尔值 FALSE 本身
+ 整型值 0（零）
+ 浮点型值 0.0（零）
+ 空字符串，以及字符串 "0"
+ 不包括任何元素的数组
+ 特殊类型 NULL（包括尚未赋值的变量）
+ 从空标记生成的 SimpleXML 对象





#### 2.2	integer整形

​		php的整形值可以为十进制，八进制，十六进制，二进制前面可以加`-`，`+`。

```php
<?php
	$a = 1234;		//普通int
	$b = -123;		//负数
	$c = 01234;		//八进制
	$d = 0x1324;	//十六进制
	$e = 0b1010;	//二进制
?>
```



​		整数溢出

​	如果给定的一个数超出了integer的范围，将会被解释为`float`，如果执行超出了`integer` 范围，也会返回`float`

```php
<?php
	$test_Number = 99999999999;
	echo var_dump($test_Number);
?>			//返回float(99999999999)
```



​		转换为整形

​		用(int)或者(integer)进行强制转换。也可以用intval()函数进行转换

​	将 resource 转换成 integer 时， 结果会是 PHP 运行时为 resource 分配的唯一资源号。

​		从浮点型转换，将会向下取整



#### 2.3	浮点型

​		浮点数float



​		转化为浮点数，使用`(float)`

```php
<?php
	$test = 5;
	echo var_dump((float)$test);
?>			//输出float(5)
```





#### 2.4	字符串

​		字符串运算符。

​		字符串可以用.连接起来，注意+没有这个功能。

​				例如:

```php
$a = 'a';
$c = $a.'b';
$a.+='d'
```

​		

​		转换成字符串的话用(string)或者strval()

```php
$test = 111;
echo (string)$test;
echo strval($test);
```

​		字符串可以用4种方式来表达

+ 单引号
+ 双引号
+ `heredoc`结构
+ `newdoc`语法结构



##### 2.4.1	单引号

​		定义一个字符串的最简单的方法就是使用\`\`

​		要表达一个单引号自身，需要使用`\`转义，而想要表达`\`自身，则用`\\`。其他任何方式的反斜线都会被当做反斜线本身，也就是说如果想要使用其他转义序列例如`\r`或者`\n`，并不代表任何特殊含义，就是单纯的是字符本身。

```php
<?php
    echo '可以一直的
    录入多行
    ';
	
	echo '\\  \'  "" ';		//输出\   '  ""
?>		php的''和""不一样，''中的字符不会被解析。""中的字符会被解析
```



##### 2.4.2	双引号

​		**用双引号的字符串里面可以加变量**

​		如果字符串是包围在`""`中，PHP将对一些特殊的字符进行解析：

| **序列** | **含义**                                                     |
| -------- | ------------------------------------------------------------ |
| *\n*     | 换行（ASCII 字符集中的 LF 或 0x0A (10)）                     |
| *\r*     | 回车（ASCII 字符集中的 CR 或 0x0D (13)）                     |
| *\t*     | 水平制表符（ASCII 字符集中的 HT 或 0x09 (9)）                |
| *\v*     | 垂直制表符（ASCII 字符集中的 VT 或 0x0B (11)）（自 PHP 5.2.5 起） |
| *\e*     | Escape（ASCII 字符集中的 ESC 或 0x1B (27)）（自 PHP 5.4.0 起） |



##### 2.4.3,	heredoc

​		heredoc是php里表达字符串的第三种方法，语法结构：<<<。

在该运算符之后要提供一个标识符，然后换行。接下来是字符串string本身，最后要用前面定义的标识符作为结束标志。

​		**heredoc实质就是一个字符串**

​		例子如下：

```php
$test = <<<eto
输出字符串
eto;
```

​		

###### 1.	heredoc中可以输出变量

```php
<?php
    $name = 'jack';
	echo <<<test
我的名字是$name
test;
?>
```



###### 2.Heredoc和类

​		Heredoc可以初始化静态值

```php
function jisuan{
	static $test = <<<ji
输出函数里的静态变量的值
ji;

class student(){
	const jt = <<<ll
这里的是php类的常量
ll;
	public $test = <<<k
这里的是类的属性使用heredoc	
k;
	}
}
```



###### 3,Here可以使用双引号

```
<?php
	$test = <<<"jisuanzhi"
这里Heredoc结构用了双引号
jisuanzhi;
?>
```



##### 2.4.4	newdoc

​		就像heredoc结构类似于双引号字符串，Now结构是类似于单引号字符串。Nowdoc结构很像heredoc结构，但是nowdoc中不进行解析操作。

​		*newdoc结构和heredoc类似*





#### 2.5	array数组

​		PHP中的数组其实更像是python中的dict

​		

##### 1.	定义数组

​		可以用`array()`语言结构来新建一个数组。他接受任意数量用逗号分隔的*键(key)=>值(value)*对			现在都用`[] `定义`array`

```php
array(
	key=>value,	//键可以为整数或者是字符串
	……			//value可以是任意类型的值
)
 //array中的key其他类型会被强制转换，float到int,bool到int
```



php中相同的`key`键名，后面的`key`会覆盖前面的值。

```php
<?php
	$list = array(
		1 => 'a',
		"1" => 'b',
		1.9 => 'c',
		true => 'd'
	)
	echo $list;
?>			//这里只会输出d
```



php 中的`key`为可选项，如果未指定`key`的话。PHP将会自动使用之前用过的`integer`键名加上1作为新的键名。

```php
<?php
	$test = array("a","b","c")
	var_dump($test[0]);
?>			//没有key的array会默认给自动递增。从使用过的最大integer键名加1
    		0=>"a",1=>"b",2=>"c"
    
    //以下为演示实例
    <?php
$array = array(
         "a",
         "b",
    6 => "c",
         "d",
);
var_dump($array);
?>		//0=>"a",1=>"b",6=>"c",7=>"d"
```



##### 2,	访问数组

​				PHP的数组单元的话可以通过`array[key]`来访问

​				（ps.python中list和dict都是通过`[]`来访问的）

​			

```php
<?php
	$array1 = array(
		"foo"=>"bar",
		42=>24,
		"multi"=>array(
			"test1" => array(
				"test2"=>2
			)
		)
	)
	var_dump($array1["multti"]["test1"]["test2"]);
?>

```

​			

##### 3,	新建修改数组

​			通过`[]`来进行新建修改，

​			如下：

```php
<?php
	$arr = array(1=>"a",2=>"b",3=>"c");
	
	$arr[] = "d";	//通过这种方式可以直接向array赋值新建。
	$arr["new"] = "e";	//新建类属性的方式，python不能用这种方式，只能append

	unset($arr[0]);		//删除这个值$arr[0]
	
	unset($arr[]);		//删除整个数组的值
?>
```

​			

`unset`会删除数组的key值，从而达到删除键值对的需求，

添加新的值时，会从之前删除的`integer`的最大值开始。

接上面的`unset`，看下面的`array_values`

```php
<?php
	$list = array(
		1=>"a",
    	2=>"b",
    	3=>"c"
)    
    foreach ($lsit as $key){
        unset($key);
    }				//循环全部删除array
	$list = array_values($list);
?>				//这个的话就可以恢复被删除的key
```



##### 4,	转换为数组

​		(array)或者array()

对于任意的integer,float,string,boolean,resource类型，如果将一个之转换为数组，将得到一个只有元素的数组，其下标为0

​		如果是`object`的话效果就会不一样，详情的话网上看



##### 5.	追加数组

```php
<?php
	$array = array('name'=>'jack','age'=>19);
	$array[] = ['sex'=>'man'];
?>			//追加数组
```





#### 2.6	Object对象

创建一个新的对象，如下：

```php
<?php
	class person{
		function console_my(){
			echo "输出内容"；
		}
	}
?>
```

关于转换为Object对象的话，详情自己去网上找



#### 2.7	Resource资源类型

​			

​			资源`resource`是一种特殊变量，保存了外部资源的一个引用。资源是通过专门的函数来建立和使用的。所有这些函数机器响应的资源类型见(附录)[https://www.php.net/manual/zh/resource.php]



​		随便举一个例子：

```php
<?php
$c = mysql_connect();
echo get_resource_type($c)."\n";
// 打印：mysql link

$fp = fopen("foo","w");
echo get_resource_type($fp)."\n";
// 打印：file

$doc = new_xmldoc("1.0");
echo get_resource_type($doc->doc)."\n";
// 打印：domxml document
?>
```

​		其他的在网上自己查看

​		

#### 2.8	NULL

​	null定义为一个变量没有值……





#### 2.9	Callback/callable

​		回调函数 Call/callable



​		传递，PHP是将函数以`string`形式传递的，可以使用任何内置或用户自定义函数，但除了语言结构如：`array()`，`ecoh`，`empty()`，`eval()`，`exit()`，`isset()`，`print`或`unset()`



简单的例子如下：

```php
<?php
	function myfunc(){
		echo '函数内容如下';
	}
	
	class Myclass{
		static function myClassfunc(){
			echo '类中的内容如下';
		}
	}

	//type 1:simple callback
	call_user_func("myfunc");

	//type 2:static class method call
	call_user_func(array('Myclass','myClassfunc'));

	//type 3:object call
	$obj = new Myclass();
	call_user_func(array($obj,'myClassfunc'));

	//type 4:static class method call
	call_user_func('Myclass::myClassfunc');

	// Type 5: Relative static class method call (As of PHP 5.3.0)
    class A {
        public static function who() {
            echo "A\n";
        }
    }

    class B extends A {
        public static function who() {
            echo "B\n";
        }
    }

    call_user_func(array('B', 'parent::who')); // A
	// Type 6: Objects implementing __invoke can be used as callables (since PHP 5.3)
    class C {
        public function __invoke($name) {
            echo 'Hello ', $name, "\n";
        }
    }

    $c = new C();
    call_user_func($c, 'PHP!');
?>
```





#### 2.20	伪类型

​		伪类型，一般是PHP 文档里用于指示参数可以使用的类型和值。简单说就像是伪代码那种的一样。

```php
//描述gettype()函数可以接受的数据类型
gettype ( mixed $var ) : string
```





#### 2.21	类型转换

​	类型转换的话就不多多说了，要用自己找



















### 三，	PHP数据类型(附)

​			字符串可以当做array使用通过array[12]的方式可以截取字符，也可以使用`substr()`和`substr_replace()`



#### 3.1	变量解析

​		当字符串用双引号或heredoc结构定义时，其中的变量将会被解析

​		变量解析分为两种：简单规则，复杂规则

​		

#### 3.1.1	简单语法

​		当php解析器遇到一个美元夫($)时，他会和其他的解析器一样

​		语法如下：

```php
<?php
	$test = 'jack';
	echo "这里使用双引号中的变量解析 $jack ".PHP_EOL
?>	
#同样的array和object也可以被解析
	<?php
		$list1 = array("red","blue","green");
		class student{
			var $name = 'jack';
			var $age = 19;
		}
		$student1 = new studnet();
		echo "第一个输出 $list1[0]".PHP_EOL;
		echo "我叫$studnet1->name "
	?>
```



#### 3.1.2	复杂语法(花括号)

​		复杂语法不是因为其语法复杂而得名，，而是它可以使用复杂的表达式。

​			语法：

```php
<?php
	$test = "this is a new day";
	echo "the text is {$test}";
	echo "the tect is { $test}";	//无效，
	echo "the is {$array["one"]}";	//有效，通过key
	echo "the is {$array[1][3]"
?>		#也可以这样
<?php
	class test{
	var $name = "jack";
	}
	$list1 = array(1,2,3,"name");
	$test = new test();
	echo "花括号也有数学小括号的作用{$test->{$list[3]}}"
?>							//上面这个式子输出的是jack
```

也有这种：

```php
<?php
	class test{
	const he = "number";
	var static $div = "idea";
    
    $number = "数字1";
    $idea = "数字2";
    echo "输出{${test::he}}";			//输出“数字1”
    echo "输出{${test::$div}}";		//输出“数字2”
	}
?>
```



#### 3.1.3	类型的转换

关于类型的转换用的着的话，可以自己去网上看看。以下知识点一部分的解释



##### array转化为object

​	array转化为`object`的话。(ps.以后用到的话再做笔记)

```php
$list = array(
	"name"=>"jack",
	"age"=>19,
)
		//转化为object的话第一个参数作为类名，其他的作为属性字段
```

​	

​	