<center>PHP运算符</center>
### 一,	运算符优先级

​	结合方向	运算符	附加信息

​	无	clone new	clone 和 new
​	左	[	array()
​	右	**	算术运算符
​	右	++ -- ~ (int) (float) (string) (array) (object) (bool) @	类型和递增／递减
​	无	instanceof	类型
​	右	!	逻辑运算符
​	左	* / %	算术运算符
​	左	+ - .	算术运算符和字符串运算符
​	左	<< >>	位运算符
​	无	< <= > >=	比较运算符
​	无	== != === !== <> <=>	比较运算符
​	左	&	位运算符和引用
​	左	^	位运算符
​	左	|	位运算符
​	左	&&	逻辑运算符
​	左	||	逻辑运算符
​	左	??	比较运算符
​	左	? :	ternary
​	right	= += -= *= **= /= .= %= &= |= ^= <<= >>=	赋值运算符
​	左	and	逻辑运算符
​	左	xor	逻辑运算符
​	左	or	逻辑运算符





### 二,	运算符



#### 2.1	算术运算符

​	例子	名称	结果

​	-$a	取反	$a 的负值。
​	$a + $b	加法	$a 和 $b 的和。
​	$a - $b	减法	$a 和 $b 的差。
​	$a * $b	乘法	$a 和 $b 的积。
​	$a / $b	除法	$a 除以 $b 的商。
​	$a % $b	取模	$a 除以 $b 的余数。
​	$a ** $b	Exponentiation	Result of raising $a to the $b'th power. Introduced in PHP 5.6.



除法运算符总是返回浮点数。只有在下列情况例外：两个操作数都是整数并且正好整除

取模算远的操作数在运算之前都会转换



#### 2.2	赋值运算

​		PHP的赋值分为**传值赋值**和**引用赋值**



##### 2.2.1	传值赋值

​	传值赋值就是平时用那种赋值的方法，把一个变量的值赋给另一个变量。

```php
<?php
	$test = 1;
	$test2 = $test;
	echo $test2;
?>				//输出1
```





##### 2.2.2	引用赋值

​		引用赋值简述就是，把一个变量的指针赋给另一个变量。两个变量指针都是指向同一个内存。

```php
<?php
	$test = 1;
    $test1 = &$test;
    $test = 2;
    echo $test1;	//输出内容为2
?>			//引用赋值改变一个另一个变量也会变
```



#### 2.3	位运算符

​	略详情[点击](https://www.php.net/manual/zh/language.operators.comparison.php)





#### 2.4	比较运算

比较运算说白了比较



| 例子 | 名称 | 结果 |
| ---- | ---- | ---- |
|$a == $b	|等于|	TRUE，如果类型转换后 $a 等于 $b。|
|$a === $b	|全等	|TRUE，如果 $a 等于 $b，并且它们的类型也相同。|
|$a != $b	|不等	|TRUE，如果类型转换后 $a 不等于 $b。|
|$a <> $b	|不等	|TRUE，如果类型转换后 $a 不等于 $b。|
|$a !== $b	|不全等|	TRUE，如果 $a 不等于 $b，或者它们的类型不同。|
|$a < $b	|小与|	TRUE，如果 $a 严格小于 $b。|
|$a > $b	|大于	|TRUE，如果 $a 严格大于 $b。|
|$a <= $b	|小于等于|	TRUE，如果 $a 小于或者等于 $b。|
|$a >= $b	|大于等于|	TRUE，如果 $a 大于或者等于 $b。|
|$a <=> $b	|太空船运算符（组合比较符）|	当$a小于、等于、大于$b时 分别返回一个小于、等于、大于0的integer 值。 PHP7开始提供.|
|$a ?? $b ?? $c	|NULL 合并操作符|	从左往右第一个存在且不为 NULL 的操作数。如果都没有定义且不为 NULL，则返回 NULL。PHP7开始提供。|



##### 三元运算符

​	`?:`

​		`bool?输出1:输出2`前面是bool的表达式，中间是当bool为`true`时的输出，最后是当`bool`为`false`的输出

例子：

```php
<?php
	$a =1 ;
    $b = 2;
    echo ($a>$b?1:2)
?>			
```



#### 2.5	错误控制符

​	PHP支持一个错误控制运算符：@当将其放置在一个PHP白哦大师之前，该表达式可以产生的任何错误信息都被忽略.

​	实例如下，（详情自己网上看）：

```php
<?php
/* Intentional file error */
$my_file = @file ('non_existent_file') or
    die ("Failed opening file: error was '$php_errormsg'");

// this works for any expression, not just functions:
$value = @$cache[$key];
// will not issue a notice if the index $key doesn't exist.

?>				//这个地方是放在打开文件，如果没打开的话不会报错
```



#### 2.6	执行运算符

​							(ps.执行运算符等价于`shell_exec()`函数)

PHP支持一个执行运算符：反引号(``)。注意这不是单引号！PHP将尝试将反引号中的内容作为shell命令来执行，并将其输出信息返回。使用反引号运算符。

```php
//示例如下
<?php
	$qqt = `ls -al`;
	echo "<p>$qqt</p>"
?>						//返回的将会是
```



#### 2.7	递增递减运算符

​		和其他语言的递增递减一样的

​	

| 例子 | 名称 | 效果                          |
| ---- | ---- | ----------------------------- |
| ++$a | 前加 | $a 的值加一，然后返回 $a。    |
| $a++ | 后加 | 返回 $a，然后将 $a 的值加一。 |
| --$a | 前减 | $a 的值减一， 然后返回 $a。   |
| $a-- | 后减 | 返回 $a，然后将 $a 的值减一。 |



#### 2.8	逻辑运算



| 例子       | 名称            | 结果                                                      |
| :--------- | :-------------- | :-------------------------------------------------------- |
| $a and $b  | And（逻辑与）   | **`TRUE`**，如果 $a 和 $b 都为 **`TRUE`**。               |
| $a or $b   | Or（逻辑或）    | **`TRUE`**，如果 $a 或 $b 任一为 **`TRUE`**。             |
| $a xor $b  | Xor（逻辑异或） | **`TRUE`**，如果 $a 或 $b 任一为 **`TRUE`**，但不同时是。 |
| ! $a       | Not（逻辑非）   | **`TRUE`**，如果 $a 不为 **`TRUE`**。                     |
| $a && $b   | And（逻辑与）   | **`TRUE`**，如果 $a 和 $b 都为 **`TRUE`**。               |
| $a \|\| $b | Or（逻辑或）    | **`TRUE`**，如果 $a 或 $b 任一为 **`TRUE`**。             |



#### 2.9	字符串运算符

字符串连接符不是其他语言的`+`。而是`.`表示连接。`.=`表示`+=`



#### 2.10	数组运算符

​	注意哈，这个是数组的运算符

| 例子      | 名称   | 结果                                                         |
| :-------- | :----- | :----------------------------------------------------------- |
| $a + $b   | 联合   | $a 和 $b 的联合。                                            |
| $a == $b  | 相等   | 如果 $a 和 $b 具有相同的键／值对则为 **`TRUE`**。            |
| $a === $b | 全等   | 如果 $a 和 $b 具有相同的键／值对并且顺序和类型都相同则为 **`TRUE`**。 |
| $a != $b  | 不等   | 如果 $a 不等于 $b 则为 **`TRUE`**。                          |
| $a <> $b  | 不等   | 如果 $a 不等于 $b 则为 **`TRUE`**。                          |
| $a !== $b | 不全等 | 如果 $a 不全等于 $b 则为 **`TRUE`**。                        |





#### 2.11	类型运算符

instanceof用于确定一个PHP变量是否属于某一类`class`实例

​		实例如下：

```python
<?php
	class test{}
	$test = new test();
	var_dump($test instanceof test);	//输出true 
?>
```



`isintance`也可以用上图的实例来确定一个类的字类对象(ps.也会返回`true`)





​		也可以用来检查`interfance`接口类。

```php
<?php
	interface a {
		public function test();
	}
	class test extends a{
        public function test(){
            echo "hellow";
        }
    }
	$testObject = new test();
	var_dump($test isinstanceof a);
?>
```

