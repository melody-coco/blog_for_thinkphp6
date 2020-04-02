<center>php函数</center>
### 一,函数

​		



#### 1.1	一个简单的函数

```php
<?php
	function test(){
		return "输出函数的内容";
	}
	test();
?>
```





#### 1.2	函数的参数



##### 1.引用传参:

​			引用传参的话,函数修改了值的话.外部的该函数也会改变值.

```php
<?php
	function test(&$a){
		$a .= "添加的参数";
	}
	$str = "原本的函数";
	test($a);
	echo $a;		//输出的值为"原本的函数添加的函数"
?>
```





##### 2.	默认参数

默认参数就不用说了把.

```php+HTML
<?php
function makecoffee($type = "cappuccino")
{
    return $type;
}
echo makecoffee();		//输出cappuccino
echo makecoffee(null);	//输出null
echo makecoffee("espresso");	//输出espresso
?>
```



注意:默认参数的话需要注意位置,默认参数在右



##### 3.		类型声明



| Type                                                         | Description                                                  | Minimum PHP version |
| :----------------------------------------------------------- | :----------------------------------------------------------- | :------------------ |
| Class/interface name                                         | The parameter must be an [*instanceof*](https://www.php.net/manual/zh/language.operators.type.php) the given class or interface name. | PHP 5.0.0           |
| *self*                                                       | The parameter must be an [*instanceof*](https://www.php.net/manual/zh/language.operators.type.php) the same class as the one the method is defined on. This can only be used on class and instance methods. | PHP 5.0.0           |
| [array](https://www.php.net/manual/zh/language.types.array.php) | The parameter must be an [array](https://www.php.net/manual/zh/language.types.array.php). | PHP 5.1.0           |
| [callable](https://www.php.net/manual/zh/language.types.callable.php) | The parameter must be a valid [callable](https://www.php.net/manual/zh/language.types.callable.php). | PHP 5.4.0           |
| [bool](https://www.php.net/manual/zh/language.types.boolean.php) | The parameter must be a [boolean](https://www.php.net/manual/zh/language.types.boolean.php) value. | PHP 7.0.0           |
| [float](https://www.php.net/manual/zh/language.types.float.php) | The parameter must be a [float](https://www.php.net/manual/zh/language.types.float.php)ing point number. | PHP 7.0.0           |
| [int](https://www.php.net/manual/zh/language.types.integer.php) | The parameter must be an [integer](https://www.php.net/manual/zh/language.types.integer.php). | PHP 7.0.0           |
| [string](https://www.php.net/manual/zh/language.types.string.php) | The parameter must be a [string](https://www.php.net/manual/zh/language.types.string.php). | PHP 7.0.0           |

说白了就是设定传入的参数的类型.`array`,`string`,或者是

对象,类,(子类的话也可以进入父类限定的函数),

示例如下:

```php
<?php
class C {}
class D extends C {}

// This doesn't extend C.
class E {}

function f(C $c) {
    echo get_class($c)."\n";
}

f(new C);
f(new D);
f(new E);
?>
```



#### 1.3	返回值

​	简单说就是函数返回的玩意儿



​	其他的都没意思就只有这个:

##### 返回值类型限制声明

PHP 7 增加了对返回值类型声明的支持。 就如 [类型声明](https://www.php.net/manual/zh/functions.arguments.php#functions.arguments.type-declaration)一样, 返回值类型声明将指定该函数返回值的类型。同样，返回值类型声明也与 [有效类型](https://www.php.net/manual/zh/functions.arguments.php#functions.arguments.type-declaration.types) 中可用的参数类型声明一致。

[严格类型](https://www.php.net/manual/zh/functions.arguments.php#functions.arguments.type-declaration.strict) 也会影响返回值类型声明。在默认的弱模式中，如果返回值与返回值的类型不一致，则会被强制转换为返回值声明的类型。在强模式中，返回值的类型必须正确，否则将会抛出一个**TypeError**异常.

```php
<?php
function sum($a, $b): float {
    return $a + $b;
}

// Note that a float will be returned.
var_dump(sum(1, 2));
?>					//输出float(3)
```



#### 1.4	可变函数



PHP支持可变函数的概念。这意味着如果一个函数名后有圆括号，PHP将寻找与变量同名的函数，并且尝试执行它。

​		实例如下：

```php
<?php
	function test1(){
		echo "输出函数1";
	}
	function test2(){
		echo "输出函数2";
	}
	function test3(){
		echo "输出函数3";
	}
	$a = "test1";
	$b = "test2";
	$c = "test3";
	echo $a();			//输出函数1
	echo $b();			//输出函数2
	echo $c();			//输出函数3
?>
```



同样的也可以用这种方法来使用变量值来替代，想要调用的对象名。

<?php
calss Test{
	public name(){
		echo "hellow";
	}
}
$test = new Test();
$a = "test";
$a->name;			//输出hellow
?>



#### 1.5	内置函数

​	这一章不讲，自己有需求自己[看](https://www.php.net/manual/zh/functions.internal.php)





#### 1.6	匿名函数

​		匿名函数也称为闭包函数，允许创建一个没有指定名称的函数。

​		PHP匿名函数语法如下：

```php
<?php
	$test = function($name){
		echo "hellow world $name";
	}
	$test("jack");			//也可以不加参数
?>
```





闭包可以从父作用域继承变量。任何此类变量都应用`use`传递进去。

```php
<?php
	$message = "你好啊";
	
	$test = funciton () use ($message){
		echo $message;
	}				//输出“你好啊”
?>
```

