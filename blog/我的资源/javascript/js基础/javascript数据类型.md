<br>换行

###### 值类型(基本类型)：字符串（String）、数字(Number)、布尔(Boolean)、对空（Null）、未定义（Undefined）、Symbol。

###### 引用数据类型：对象(Object)、数组(Array)、函数(Function)。

###### 注：Symbol 是 ES6 引入了一种新的原始数据类型，表示独一无二的值。


---

#### 1，在javascript的字符串中可以使用引号
==但是不能匹配包围字符串的引号==
```
实例
var answer="It's alright";
var answer="He is called 'Johnny'";
var answer='He is called "Johnny"';
```

#### 2，JavaScript中只有一种数字类型。
数字可以带小数点，也可以不带
极大或极小的数字可以通过科学（指数）计数法来书写

#### 3，Javascript布尔
布尔值只能有两个值：true或法false
```
var x = true;
var y = false;
```

#### 4,JavaScript数组Array
下面代码创建名为cars的数组：
```
var cars = new Array();
cars[0] = "1";
cars[1] = "2";
cars[2] = "3";
cars[3] = "4";
或者
var cars = new Array("1","2","3","4")

```

#### 5,JavaScript对象
对象由花括号分隔。在括号内部，对象的属性以名称和值对的形式 (name : value) 来定义。属性由逗号分隔：
```
var student={name="jack",age:"11",school:"sichuan"}
```

上面的studnet对象有三个字段分别是name,age,school

寻址方法：
```
name=student.name//这种就像是正常的对象寻址
name=student["name"]//这种更像是python里字典的寻址
```
总的来说javascript里的对象很像是python的字典(dict)

区别就是python里的字典的key要用""包裹
#### 6，Undefined(不含有值)和Null(空值)
Undefined这个值表示变量不含有值
可以通过将变量的值设置为null来清空变量
```
cars = null
person = null
```

#### 7,声明变量类型
当你声明新的变量时，可以使用关键词"new"来声明其类型:
```
var z = new String;
var x = new Number;
var c = new Boolean;
var v = new Array;
var b = new Object;
```


---

## 数据类型的转换

##### 1，全局方法String()可以将括号内的数字，字母，变量，表达式转换为String。(ps.toString()方法也是同样的效果，不过用法有一点不同)
```
String(x)
String(123)
String(1+2) 
String(new Date())
先两者相加再转化为字符串返回

x.toString()
(123).toString()
(1+2).toString()
false.toString()
```

##### 2,将字符串转化为数字`Number()`
全局方法`Number()`可以将字符串转换为数字

空字符串转换为0.
其他的字符串会转换成NaN(ps.不是哥数字)。
```
Number("3.14") //返回3.14
Number(" ")  //返回0
Number("")  //返回0
Number("99  88")  //返回NaN
```
##### 一元运算符+

```
var y = "5";   //y是一个字符串
var x = +y;  //x是一个数字
```
如果变量不能转换，它仍然会是一个数字，但值为NaN（不是一个数字）：
```
var y = "jack";  //y是一个字符串

var x = +y; //x是一个数字(NaN)
```
##### 将布尔值转换为数字；
```
Number(false)   //返回0
Number(true)   //返回1
```
##### 将日期转换为数字
```
d = new Date();
Number(d)    //返回1573981009394

日期的方法getTime()也有相同的效果。
var d = new Date;
d.getTime()   //返回1573981009394
```