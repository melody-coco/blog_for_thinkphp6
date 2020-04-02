函数的话就不多讲了，函数大多一样
语法：
```
function  函数名(){
    
}
```

调用函数，(ps.也可以在一个函数中调用另一个函数)
```
function myFunction(a,b)
{
        return a*b;
}

document.getElementById("demo").innerHTML=myFunction(4,3);
```

#### 局部变量：
局部变量在函数中定义，生存期为函数运行后删除

#### 全局变量：
全局变量在函数外定义，生存周期为页面关闭后删除

#### 向未声明的JavaScript变量分配值：

如果把值分配给一个未声明的变量，该变量将被自动作为windows的一个属性(ps.也就是视为一个全局变量)，


#### 作用域

作用域的问题就不用说了，全局变量作用域：
局部变量作用域：
未声明变量作用域：



---

# 函数部分进阶

#### 1，函数表达式
也就是匿名函数
```
var x = function(a,b){return a*b};
var z = x(2,3);
```
函数储存到变量中，不需要函数名称，通常通过变量名来调用

#### 2，函数提升，
简单说就是和JavaScript的变量提升的一样，可以先使用再定义

#### 3，自调用函数
简单说就是自己调用自己，

```
(func(){
 document.write("hellow")   
})();    //网页加载完毕的时候会直接打印出hellow（ps.调用自己）
```

#### 4,函数作为一个值使用
```
function jjk(a,b){
    return a*b;
}
var x = jjk(1,2)*4;
```

#### 5,函数是对象
```
argument属性
function my(a,b){
    return arguments.length;//arguments是把参数列表，相当于把参数封装list
}//这个地方返回的是一个参数的个数
```

#### 6, [箭头函数](https://www.runoob.com/js/js-function-definition.html)


---

## 参数部分
#### 1,默认参数
默认参数没什么好说的
```
function mm(a,b=1){
    return a*b;
}
var x = mm(12); //如果没有默认参数有不传参的话，undefined
```

---
## 函数调用部分
#### 1.1作为一个函数调用
```
function kk(){
    document.write("hellow");
}
kk();  //打印出hellow
```
>  1.2,全局对象

```
function kk(){
    return this;
}
kk(); //返回的是windows对象
```
#### 2，函数作为方法使用
```
var person={
    name:"jack",
    age:"20",
    xinxi:function (){
        return this.name+"，"+this.age;
    }
}
person.xinxi()  //打印出jack，20
```
```
var person = (){
    name:"jack",
    age:"19",
    xinxi:function(){
        return this;
    }
}
var t = person.xinxi()  //调用函数，打印出[object Object](ps.所有者对象本身)
```
#### 3,使用构造函数调用函数
```
function kk(name,age){
    this.name=name;
    this.age=age;
}
var jj =new kk("jack","28");//这个地方
jj.name;    //返回jack
```

#### 4,作为函数方法调用,(ps.相对于2真正的函数作为方法调用)
```
function jj(a,b){
    return a*b;
}
var nn = jj.call(nn,5,2);
```
还可以这样用：
```
var obj={
    name:"jack",
    age:"19",
    hanshu:function(){
        document.write(this.name+this.age);
    }
}
var jjk = {
    name:"kk",
    age:"ll"
}
obj.hanshu.call(jjk);  //输出kk11
```

---
# <center>闭包</center>
[想看的话](https://www.runoob.com/js/js-function-closures.html)

简单的说就是作用域的问题

使函数拥有私有变量变成可能，
```
function ggk(){
    var i=0; 
    function kkg(){
        return i+=1;
    }
}
var u = ggk();
ducoment.getElementById("button").innerHTML=u();计数器
```
简单说就是没有执行外部函数ggk直接反复执行内部函数kkg