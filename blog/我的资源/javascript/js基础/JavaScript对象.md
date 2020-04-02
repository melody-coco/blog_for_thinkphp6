JavaScript的类更像是python的dict，JavaScript的构造函数更像是类

```
var car = {type:"Fiat", model:500, color:"white"};

var person = {
    firstName:"John",
    lastName:"Doe",
    age:50,
    eyeColor:"blue"
};
```

#### 1，JavaScript的对象有三种类型:

Object；Date;Array

---

#### 2，你可以通过两种方式访问对象属性:


person.lastName;

person["lastName"];

```
<script>
var person = {
    firstName: "John",
    lastName : "Doe",
    id : 5566,
    fullName : function() 
	{
       return this.firstName + " " + this.lastName;
    }
};
document.getElementById("demo").innerHTML = person.fullName();如果这里不添加()，调用的时候会把这个字段的内容打印出来而不是函数
</script>
```

---

#### 3，判断对象的属性
`typeof`(ps.详情见JavaScript杂记)

#### 4,Date对象

前面说了Date()也是一个对象
```
var k = new Date();
typeof k;   //输出为对象Object
```
下面是一些Date()对象的方法：

方法|	描述
--|--
getDate()|	从 Date 对象返回一个月中的某一天 (1 ~ 31)。
getDay()|	从 Date 对象返回一周中的某一天 (0 ~ 6)。
getFullYear()|	从 Date 对象以四位数字返回年份。
getHours()	|返回 Date 对象的小时 (0 ~ 23)。
getMilliseconds()|	返回 Date 对象的毫秒(0 ~ 999)。
getMinutes()|	返回 Date 对象的分钟 (0 ~ 59)。
getMonth()|	从 Date 对象返回月份 (0 ~ 11)。
getSeconds()|	返回 Date 对象的秒数 (0 ~ 59)。
getTime()|	返回 1970 年 1 月 1 日至今的毫秒数。
用法为:
```
var k = new Date();
document.write(k.getMonth())  //注意这个地方返回的月份数是从0开始到11为止的
```
---

#### 1,使用对象构造器
直接的就是这样
```
person = new OBject();
person.name="jack";
person.age="19";
person.color="red";
```
```
function person(name,age,color){
    this.name=name;
    this.age=age;
    this.color=color;
    this.changename=changename;
    function changename(name){
        this.name=name;
    }//这个地方是修改名字(ps.类的方法)
}//类可以使用for in循环
```

- 要在外面添加类的字段(ps.属性)的话就要使用prototype(最高的继承对象)
```
//接上面的
person.prototype.class="一班"//也可以用这种方式构建类的方法
```
#### 2,Number对象
JavaScript只有一种数字类型(ps.没有float,int之分)
- 八进制和十六进制
```
var x = 012;//0开头的是八进制
var y = 0x12;//0x开头的是十六进制
```
- 通过isNaN()来判断是否是数字型
```
var x = "rr";
var t = 222;
isNaN(x);//返回false
isNaN(y);//返回true
```
- String()对象就不说了在要记得方法里面有
- Date()对象也不说了要用自己查

#### 3,MATH对象
- random()函数返回0到1之间的随机数
- max()返回两个数中的较大数
- min()返回两个数之间的较小数

#### 4,RegExp对象
简单说就是正则表达式对象
```
var x = /\w+/gi;
```
[要看的话点这个](https://www.runoob.com/js/js-obj-regexp.html)或者是去看JavaScript的正则表达式

####  5 浏览器方法 (ps.Window.BOW对象)
```
var w=window.innerWidth;
var h=window.innerHeight;
x=document.getElementById("demo");
x.innerHTML="浏览器window宽度: " + w + ", 高度: " + h + "。"

```
- Screen对象
和上面的差不多
```
document.write("可用的宽度"+screen.availHeight);
document.write("可用的宽度"+screen.availWidth);
```
- location对象
这个其实没什么，就是一些常用的方法
```
location.hostname 返回 web 主机的域名
location.pathname 返回当前页面的路径和文件名
location.port 返回 web 主机的端口 （80 或 443）
location.protocol 返回所使用的 web 协议（http: 或 https:）
window.location.assign("https://www.baidu.com")
```

- Window History对象

这个对象基本上就两个方法，类似于在浏览器中点击后退``前进按钮
```
<button type="button" id="btn">前进按钮</button>
<button type="button" id="btn2">后退按钮</button>
<script>
var t=document.getElementById("btn");
var t2 = document.getElementById("btn2");
t.click=function(){
    window.history.forward()//前进
};
t2.onclick=function(){
  window.history.back()  
};
</script>
```

-  [JavaScript window navigator](https://www.runoob.com/js/js-window-navigator.html)这个没什么好讲的，要用的话，自己点进去看



#### 6 js原生ajax

```
function http(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onreadystatechange = function(){
        if (xhr.readyState == 4) {
                callback(xhr.responseText);
        }
    }
    xhr.send();
}//	这个是写接口调用的
```

