#### 1,查找HTML元素

- 通过id查找HTML元素`var x = ddocument.getElementById("demo")`
- 通过标签名查找HTML元素`var x = document.getElementByTagName("p")`
- 通过类名找到HTML元素`var x =document.getElementByClassName("demo")`

#### 2,改变HTML内容
- 改变HTML内容
```
var x = document.getElementById("demo");
x.innerHTML="标题";
```
- 改变HTML属性
```
var t= docuemnt.getElementByTagName("image");
t.src="1.jpg";
```
#### 3,改变HTML样式
- 改变HTML样式
```
<p id="demo1">改变字体样式</p>
<script>
document.getElementById("demo1").style.color="red";
docuemtn.getElementById("demo1").style.fontSize="larger";
</script>
```

- 使用事件
```
<button type="button" onclick="document.getElementById("demo1").style.color='red'">
```

#### 4,HTML事件
- `onclick`,`onload`,`onunload`,`onchange`,`onmouseover`和`onmouseout`,`onmousedown`和`onmouseup`,不常用的`onfocus`

#### 5,addEventListener()方法
- 添加监听事件
在原元素添加事件句柄
```
docuemnt.getElementById("demo").addEventListener("click",function);
添加监听事件，当click发生时调用fun函数
```
可以在一个元素中添加多个监听事件，

`addEventListener("click",function,true)`事实上监听事件后面有一个可选参数(类型为布尔)，true的话就会是事件捕获，先调用外部的监听事件，在调用里面的监听事件，(ps.比如说div中的p1，两者都来监听事件，默认为冒泡，内部先执行)

反之则为捕获，

- removeEventListener()方法
接上面的监听事件来移除
```
document.getElementById("demo").removeEventListener("click",function)//元素，事件触发的方式，，函数必须和前面相同

```

#### 6,HTML DOM 元素(节点)
- 创建新的节点元素`appendChild()`
```
var tt = document.createElement("p");
var ttt = document.createTextNode("这是一个新的段落。");
tt.appendChild(ttt);
var element = document.document.getElementById("div1");
element.appendChild(tt);//添加了一个元素
```
- 创建新的HTML元素(节点) -insertBefore()
```
var tt = document.creatElement("p");
var ttt = document.createTextNode("这是新的段落");
tt.appendChild(ttt);
var x = document.getElementById("div1");
var y = document.getElementById("p1");
x.insertBefore(tt,y);//在p1前面往div1里面添加新的元素节点
```
- 移除已存在的元素
```
//接上面的div1
x.removeChild(y);
```
- 替换HTML元素
```
var tt = documentt.createElement("p");
var ttt = docuemnt.createTextNode("这是一条内容");
tt.appendChild(ttt);
x.replaceChild(tt,y);
```

#### 7,document.getElementByTagName()
上面这个获取到的是所有的标签，可以把他当成一个列表。(ps.实质上不是一个列表)
- `var x = document.querySelectAll("p");`作用同样是获取到所有的p标签元素(ps.上面这个很像)
```
pcoll=document.querySelectorAll("p")

plist=document.getElementsByTagName("p")
以上 pcoll 返回的就是固定的值。

而获取 plist 后, 若 html 页面有变化且刚好添加或移除了 p 标签, 此时plist也会跟着变。
```



