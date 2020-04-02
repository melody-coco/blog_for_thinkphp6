<center>杂记</center>
### 一,特殊函数

#### 1	ctrl + 箭头

ctrl加小键盘的箭头，可以快速的跳到当前行的，当前句子的右边，或左边

#### 1.1	var_dump()

​		var_dump()函数用于输出变量的相关信息。返回表达式的类型和值

```php
<?php
	$test = 5;
    var_dump($test);	//var_dump可以直接输出(像echo一样)
?>		//输出int(5)
```



#### 1.2	substr()

```php
$test_1 = substr("abcdefg",1,2);
$test_2 = substr("abcdefg",2);
前面的是字符串，第二个是开始的索引，第三个是length
```



#### 1.3	unset()

​		在PHP的`array`中使用`unset(数组的值)`可以删除该数组的`key`从而变相删除`array`

```php
<?php
	$list = array(1,2,3,4);
	unset($list[0]);		//删除list[0]的索引
	unset($list);			//删除整个list的索引
?>
```



#### 1.3.1	reset()

`reset()`函数的话就是相对对于上面的`unset()`函数的删除索引来**恢复索引**



上面说的是**错的** `reset()`的作用为 把array的指针指到第一个



​		

```php
<?php
$arr = array("one", "two", "three");
reset($arr);
while (list(, $value) = each($arr)) {
    echo "Value: $value<br>\n";
}

foreach ($arr as $value) {
    echo "Value: $value<br />\n";
}
?>
```





#### 1.4	foreach as()循环



#### 1.5	list()



把数组中的值赋值给一些变量：

```php
<?php
	$test = array(1,2,3);
	list($a,$b,$c) = $test;
	echo "第一$a,第二$b,第三$c";
?>				//直接实例化的变量
```

```php
<?php
$array = [
    [1, 2],
    [3, 4],
];

foreach ($array as list($a, $b, $c)) {
    echo "A: $a; B: $b; C: $c\n";
}
?>		//c不会被输出
```





#### 1.5.2	each()

​	此函数用于将数组中的每个值返回,并且指针向前移,

​	简单说就是像是`for  in`循环中的遍历一样,配合`list()`函数可以使用while来进行遍历.

​		示例如下:

```php
<?php
$arr = array("one", "two", "three");
reset($arr);
while (list($key, $value) = each($arr)) {
    echo "Key: $key; Value: $value<br />\n";
}

foreach ($arr as $key => $value) {
    echo "Key: $key; Value: $value<br />\n";
}
?>
```





#### 1.6	unset()





#### 1.7	array_values()



#### 1.8	__invoke()

​			当把一个类（对象）以函数的方式调用时就会使用到这个魔术方法。

```php
class student{
	public funciton __invoke($name){
		echo "对不起，无法调用$name";
	}
}
$stu = new studnet();
echo $stu("777");
```



#### 1.9	extend继承



#### 1.20	implode()

​	把数组转化为字符串。

```php
<?
	$arr = array("a","b","c","d");
	echo implode("",$arr);		//中间的用第一个参数连接
?>
```



#### 1.21	arraymap()

就像是pyhthon中的map函数一样，第二个参数的数组循环使用第一个参数的方法。

```php
<?php
	$arr = array(1,2,3,5);
	$fun = function($a){
		return 2*$a
	}
	$list = array_map($fun,$arr);
?>		//该函数的返回值为数组	
```



#### 1.22	implode()函数

​		此函数主要用胡把数组转化为字符串。

```php
<?php
	$arr = array(1,2,3,4,5,6);
	echo  implode("",$arr);
?>					//此处使用implode来进行转化
```



#### 1.21	__invoke()

​	`__invoke`为类的一个的魔术方法，

​	作用为，当把`class`当做一个函数使用时的魔术方法。

```php
<?php
	class test{
		public function ji($a){
			echo $a;
		}
	}
	$kk = new test();
	$kk('7777');
?>
```



#### 1.22	isset()

此函数检测变量是否为空。

```php
$tt = 'test';
var_dump(isset($tt));			//输出true
```



#### 1.23	get_class()

此函数用于返回一个对象的所属类。

```php
<?php
	class tt{
	piblic $ t1 = "test";
	}
	$tt = new tt();
	echo get_class($tt);
?>
```





#### 1.24	访问类的内容方式

​	`->`（对象运算符）访问对象	和属性,	`->`右边的属性不加`$`

​	`::`(双冒号)	访问静态属性静态方法以及常量(const)	类的内部也可以用此访问			`::`右边的属性要加`$`





#### 1.25	表达式

表达式本来该写一个`makedown`的 

表达式就不用多说了，懂得都懂，

有需求的自己上网查



#### 1.26	继承的关键字

`extends` 通过此关键字来继承	包括PHP中`interface`的继承也得用`extends`

```php
<?php
	class test1 {
		const t = 11;
	}
	class test2 extends test1{
		const y = 1;
	}
?>
```



#### 1.27	interface的关键字

`implements`通过此关键字来进行使用`interface`关键字。

```php
<?php
interface a {
	public function a();
}


class test implements a {
	public function a(){
		echo "hellow"
	}
}
?>
```





#### 1.28	self

PHP 中，在类里面，成员方法访问静态属性的话，不用`$this`伪变量，而是用`self::name`关键字

```php
<?php
	class test{
		public static $name = 'jack';
		
		public funtion show(){
			echo self::$name;
		}
	}
?>
```

