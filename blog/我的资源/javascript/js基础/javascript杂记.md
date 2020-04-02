==`javascript`//是注释，多行注释`/*点击*/`==
在javascript的字符串中可以使用引号

但是不能匹配包围字符串的引号(ps.使用\"",转移符号也可以)

实例
```
var answer="It's alright";
var answer="He is called 'Johnny'";
var answer='He is called "Johnny"';
```
#### 1,mach

`obj.src.mach(str)`匹配前面的对象的obj的src里面是否匹配字符串str，是的话返回true，否的话返回false
#### 2，isNaN(x)

判断x的值是否是int类型，如果是的话返回True，否的话，返回False

#### 3，x.replace(/(\w+),\s*(\w+)/g,"1111")

replace是替换的意思(ps.括号里面的g是全局变量的意思),将匹配的正则表达式替换为"111"

#### 4,Object.innerHTML="新的文字"
前面的Object是前端获取的标签对象,innerHTML的意思是覆盖显示在前端内容处

#### 5,外部的JavaScript
<Script src="myScript.js"></Script>
也可以把脚本保存到外部文件中。外部文件通常包含被多个网页使用的代码。

外部 JavaScript 文件的文件扩展名是 .js。

如需使用外部文件，请在 <script> 标签的 "src" 属性中设置该 .js 文件：

#### 6,Date函数(ps.打印简单日期)

#### 7，
break |	用于跳出循环。
--- | ---
catch |	语句块，在 try 语句块执行出错时执行 catch 语句块。
continue |	跳过循环中的一个迭代。
do ... while |	执行一个语句块，在条件语句为 true 时继续执行该语句块。
for |	在条件语句为 true 时，可以将代码块执行指定的次数。
for ... in |	用于遍历数组或者对象的属性（对数组或者对象的属性进行循环操作）。
function |	定义一个函数
if ... else |	用于基于不同的条件来执行不同的动作。
return |	退出函数
switch |	用于基于不同的条件来执行不同的动作。
throw |	抛出（生成）错误 。
try |	实现错误处理，与 catch 一同使用。
var |	声明一个变量。
while |	当条件语句为 true 时，执行语句块。 

8，转义的特殊字符

代码|	输出
--|--
\'	|单引号
\"|	双引号
\\|	反斜杠
\n|	换行
\r|	回车
\t|	tab(制表符)
\b|	退格符
\f|	换页符

#### 9，类似于python的匿名函数
`kkp = (age<18)?"年纪太小":"年纪刚好"`
true的话kkp被赋值"年纪太小",false的话kkp被赋值"年纪刚好"

#### 10，typeof判断类型
和python的type()函数是一样的

使用方法
```
document.write(typeof "sichuan")
```
直接当成是一个值拿来用就好了

#### 11.null和undefined
null是空，undefined是未定义

简单来说，就是两种的值是一样的，但是类型是不一样的null是Object，undefined是undefined

如果定义的变量没有赋值的话他的类型是undefined
```
var kkp;
document.write(typeof kkp);
```

null的话是把值抛到空
```
var ii = "shuzi";
var ii;
document.write(typeof ii)
```

#### 12，对象的属性`constructor`
`constructor`属性返回所有JavaScript变量的构造函数
```
实例
"John".constructor                 // 返回函数 String()  { [native code] }
(3.14).constructor                 // 返回函数 Number()  { [native code] }
false.constructor                  // 返回函数 Boolean() { [native code] }
```

#### 13,try{}catch(err){}finally{}
这哥就不用说了把，忘了的话自己去度娘

try{写入可能会报错的代码}catch(err){前面的err是报错信息，在这里打印出来}finally{写入无论异常与否都会执行的代码}

#### 14,debugger(ps.代码调试关键字，使用F12关键字调试才会执行)
这个关键字的作用是停止执行JavaScript，如果代码没有执行到`debbugger`的话，就不会调用

#### 15，JavaScript变量提升
JavaScript中默认把所有的函数声明提升到函数的顶部

JavaScript中，变量可以在使用后声明，也就是变量可以先赋值使用再声明。

==但是如果是使用了后再赋值声明的话就不行==

例：
```
实例1：
x = 1;
y = 2;
elem = document.getElementById("demo")
elem.innerHTML = x+" "+y
var x;
var y;  //输出的为12

实例2：
x = 1;
elem = document.getElementById("demo")
elem.innerHTML = x+" "+y;
var y = 2;  //输出的为1 undefined
```
所以不能未赋值就使用(JavaScript从上往下执行)

#### 16，严格模式(use strict)
简单说就是严格模式，相当于就是必须按照代码规范来书写，使用了`use strict`这语句的话就会开启严格模式，严格模式同样的也受作用域的限制，

[了解严格模式](https://www.runoob.com/js/js-strict.html)

#### 17，\==与===
这两种等号都是比较运算，但是前面的是粗略比较，后面是要比较类型和值(ps.必须全等)

#### 18,h5的input必填
属性：`required`

`<input type="text" id="name" required="required">`这里的输入框必填

#### 19,indexof和lastindexof的区别
前者是从前面开始检索，后者是从后面开始开始检索

但是lastindexof返回的数依然是从前面开始算的，
```
var x = "abccccdefg";
alert(x.indexof("c"));//结果为2
alert(x.lastindexof("c"));//结果为5
```

#### 20，javascript的this关键字

- 单独使用this他指向的是全局对象
`var v = this;//object window`
- 函数中使用this指向的也是全局对象
`function kk(){
    return this;  //object window
}`

- 事件中的this指向了接受HTML元素
`<button onclick="this.style.display='none'">按钮（ps.点击就会消失）</button>`
  
- 对象方法中的this绑定自身
`var person(){
    name:"jack",
    age:"14",
    school:"sichuan",
    fool:function(){
        return this.name+this.age
    }
}  //这个地方的this调用的是对象自身`

- 显式函数绑定
在下面实例中，当我们使用 person2 作为参数来调用 person1.fullName 方法时, this 将指向 person2, 即便它是 person1 的方法：
```
var person1 = {
  fullName: function() {
    return this.firstName + " " + this.lastName;
  }
}
var person2 = {
  firstName:"John",
  lastName: "Doe",
}
person1.fullName.call(person2);  // 返回 "John Doe"   //这里call的作用就是修改this指向的对象
```

#### 21，javascript的let和const(ps.都是声明,这两者不能使用后再声明)
这两者的作用都是在块级作用域内部重新定义变量的值
```
let 一般是在块级作用域内部使用
例：
var x= 1;
{
    let x = 2;//这里的话输出x的值为2
}
    //这里输出x的值为1
    
    并且在一个作用域中不能同时存在对一个变量的两次声明
```

```
const的作用大致和上面相同只是const定义的变量不能修改
(ps.并且声明的时候必须赋值初始化)

错误示范：
const o = 1;
    o = 2;
但是可以这样改变：
const x=[1,2,3,4,5,6];
x[0] = 77;  //输出77
或者:
const p = {name:"jack",age:"17",color:"red"};
p.name=bill;  //输出p.name为bill

```
#### 22,a标签的#
```
<a id="#java">点击这个链接就会跳转</a>
<a id="java">被跳转的位置</a>
```

#### 23,[JavaScript代码规范](https://www.runoob.com/js/js-conventions.html)

### 24，JavaScript计时事件
1.1. 设置一个循环事件，每3秒循环一次内部函数
`var x = setInterval(function(){alert("你好")},3000)`//这个地方的三千是毫秒数，为3秒

> 1.2.移除这个计时事件

`clearInterval(x);`

2.1.设置一个定时的事件，触发后3秒后开始执行内部函数 

`var t = setTimeout(function(){alert("第一个函数")},3000)`

> 2.2.清除的方法和上面的1.2一样：
```
clearTimeout(t);
```

#### 25, 回调函数callback
```
function a(callback)
{   
    alert("我是parent函数a！");
    alert("调用回调函数");
    callback();
}
function b(){
alert("我是回调函数b");
  
}
function c(){
alert("我是回调函数c");
  
}
  
function test()
{               //之所以不直接在函数a里面写函数b是为了灵活性，这就是函数调用
    a(b);
   a(c);
}
```

#### 26，document.querySelectorAll()
> 获取所有的固定类型的标签(这个是静态获取，最好还是用document.getElementsByTagName)

这两个返回的都是一个list