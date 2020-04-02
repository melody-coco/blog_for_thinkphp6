<center>PHP的流程控制语句</center>
### 一,定义

略(ps.没什么好写的)



### 二,具体的函数



#### 1.1	if

`if`没什么好书的，PHP中的语法如下:

```php
<?php
	$a = 1;
	$b = 2;
	if($a > $b){
		echo "输出内容";
	}
?>
```



#### 1.2	else

else也没什么好说的.

​	`if`和`elseif`不被满足时运行`else`

```php
<?php
	$a = 1;
	$b = 2;
	if($a > $b){
		echo "a比b大";
	}else{
		echo "或许是b比a大";
	}
?>
```



####  1.3	elseif/else if

这个也没-什么好说的.只是说一下格式而已.



​	不像是`python`的`elif`,PHP而是`elseif`或者是`else if`.

```php
<?php
	$a = 1;
	$b = 2;
	if ($a > $b){
		echo "输出a比b大";
	}elseif{
		echo "输出b比a大";
	}else{
		echo "输出b和a一样大";
	}
?>
```



#### 1.4	流程控制的替代语法

​	替代与反简单书就是用`:`代替`{}`



简单说这个的话,就像是`Django`中的前端页面镶嵌`python`代码

​	比如:

```php+HTML
<?php
	$a = 1;
	$b = 2;
	if ($a > $b):
?>
	<p>输出html内容</p>
<?php
	elseif ($a < $b):
?>
	<p>输出html内容elseif里面</p>
<?php
	else:
?>
	<p>输出html内容else内容</p>
<?php endif ?>
```



#### 1.5	while

while就不用说了,仍然可以使用`:`嵌套html使用.

```php+HTML
<?php
	while (true){
		echo "输出while的内容"
	}
?>
```





#### 1.5	do   while

​	先循环一次,再判断是否循环(执行再判断)



#### 1.6	for

就和`java`的for循环一样.

示例如下:

```php
<?php
	for(i=0;i<10,i++){
		echo "这是PHP的for循环";
	}
?>
```



#### 1.7	foreach    as

循环语句,就像是`python`的for   in循环一样.

(ps.PHP没有`for	in`循环)

示例如下:

```php
<?php
	$list = array(1,2,3,4,5,6,7);
	foreach ($list as &$i){
		$i = 2*$i;
	}
?>
```

还有一些的话可以去杂记里面看`list()`,`each()`,还有`unset()`和`reset()`看



#### 1.8	break

​	简单说就是结束当前循环或者其他的流程控制语句

break可以加一个参数来选择退出几层;

```php
<?php
$arr = array('one', 'two', 'three', 'four', 'stop', 'five');
while (list (, $val) = each($arr)) {
    if ($val == 'stop') {
        break;    /* You could also write 'break 1;' here. */
    }
    echo "$val<br />\n";
}

/* 使用可选参数 */

$i = 0;
while (++$i) {
    switch ($i) {
    case 5:
        echo "At 5<br />\n";
        break 1;  /* 只退出 switch. */
    case 10:
        echo "At 10; quitting<br />\n";
        break 2;  /* 退出 switch 和 while 循环 */
    default:
        break;
    }
}
?>
```





#### 1.9	continue



就和java的continue一样的,暂时跳过这层循环



#### 1.10	switch

switch不多bb自己[看](https://www.php.net/manual/zh/control-structures.switch.php)





#### 1.11	declare

​	这个的话自己后面需要的话自己看.



#### 1.12	return

简单说就是结束函数,并且返回参数



#### 1.13	require

和`include`作用一样,不同之处就是此函数失败会终止脚本.而`include`只会弹出警告



#### 1.14	include

建议要看的话去官网[看看](https://www.php.net/manual/zh/function.include.php)

当一个文件被包含时，语法解析器在目标文件的开头脱离 PHP 模式并进入 HTML 模式，到文件结尾处恢复。由于此原因，目标文件中需要作为 PHP 代码执行的任何代码都必须被包括在[有效的 PHP 起始和结束标记](https://www.php.net/manual/zh/language.basic-syntax.phpmode.php)之中。

包含文件的话仍然可以使用`return`来返回参数来传值赋值给变量:

```php
return.php
<?php

$var = 'PHP';

return $var;

?>

noreturn.php
<?php

$var = 'PHP';

?>

testreturns.php
<?php

$foo = include 'return.php';

echo $foo; // prints 'PHP'

$bar = include 'noreturn.php';

echo $bar; // prints 1

?>
```



#### 1.15	require_once

此函数的话,其他和`include_once`一样,不同之处,同样是执行失败的问题



#### 1.16	include_once

此函数反复包含同一个文件的话,只会包含一次



#### 1.17	goto

*goto* 操作符可以用来跳转到程序中的另一位置。该目标位置可以用目标名称加上冒号来标记，而跳转指令是 *goto* 之后接上目标位置的标记。PHP 中的 *goto* 有一定限制，目标位置只能位于同一个文件和作用域，也就是说无法跳出一个函数或类方法，也无法跳入到另一个函数。也无法跳入到任何循环或者 switch 结构中。可以跳出循环或者 switch，通常的用法是用 *goto* 代替多层的 *break*。

```php
<?php
goto a;
echo 'Foo';
 
a:
echo 'Bar';		//输出bar
?>			//跳转到脚本的另一个位置
```

