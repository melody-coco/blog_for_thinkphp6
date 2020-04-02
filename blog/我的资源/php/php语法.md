<center>PHP语法</center>
### 一，PHP基本语法

#### 	1.	指令分隔符

​			简单说PHP需要在每个语句后用分号结束指令，，PHP代码中的结束标记隐含的表示了一个分号。在PHP代码段的最后一行可以不用分号结束

```php
<?php 
	echo '输出1';
	echo '输出二，后面带了分号'
?>
```





#### 	2.	PHP标记

​			解析一个文件时,php会寻找其实标记和结束标记。也就是<?php和?>，PHP会根据标记解析这其中的代码。

​		

​			如果文件内容为纯PHP代码，文件可以删除结束标记，此行为可以避免一些失误

```php

<?php echo '77777777';
```

​			

​			php高级分离术,

​	简单说就是在php的条件语句中，如果条件为false的话即使位于php标记符之外，也不会输出

```php
<?php if(1 == 1):?>
    <p>输出true</p>
<?php else:?>
    <p>输出false</p>
<?php endif?>
```



#### 3,	PHP的标记类型

​		一共四种标记类型：

```php
<?php echo '这是第一种最常用的输出方式'?>

<script language="php">
	echo '这是第二种js的方式';
</script>

<? echo '这是第三种方法，短标记' ?>
    
<% echo '这是第四种翻译方式' %>
```

​		

#### 4,	php注释

​			简单说php注释有三种方法

​		1,	单行注释`//`

```php
<?php 
    echo '单行注释不会影响php的结束标记';
	//这是被注释掉的内容	?>	
```

​		2,	多行注释`/*………… */`

```php
<?php echo '多行注释会注释掉php的结束标记'
	/*	这是被多行注释，注释掉的内容
?>
	*/									ps.此为错误示范
```

​		3，`#`注释

```php
<?php
	echo ' #注释和单行注释//一样的'	#这是被注释掉的内容
?>
```



#### 5,	引用对象的函数，变量，常量

​	定义一个类如下：

```php
<?php
	class student{
		var $name;
    	const sex = 'man';
		var $age;
		function set_Student(){
			$this->name = 'jack';
			$this->age =array(1,2,3,4);
		}
	}
	$student1 = new student();		//创建对象
	$student->set_Studnet();	//使用对象的函数
	echo $student1->name,{$student1->age[0]};
	echo $student1::sex;	//输出对象的变量
?>			//输出对象的常量。也可以输出变量
```

