HTML时间是发生在HTML元素上的事情。
当在HTML页面中使用JavaScript时，JavaScript可以触发这些事件

HTML时间可以是浏览器事件，也可以是用户行为。

以下是HTML事件的实例：
- HTML页面完成加载
- HTML input字段改变时
- HTML按钮被点击
通常，当事件被触发时，JavaScript可以执行一些代码。

可以直接在html元素中写javascript：例如：
```
<button type="button" onclick="this.innerHTML=Date()>按钮</button>
```

### 常见的HTML事件
下面是一些常见的HTML事件的列表:

事件 |	描述
--|--
onchange|	HTML 元素改变
onclick|	用户点击 HTML 元素
onmouseover|	用户在一个HTML元素上移动鼠标
onmouseout|	用户从一个HTML元素上移开鼠标
onkeydown|	用户按下键盘按键
onload|	浏览器已完成页面的加载


#### JavaScript 可以做什么?
事件可以用于处理表单验证，用户输入，用户行为及浏览器动作:

- 页面加载时触发事件
- 页面关闭时触发事件
- 用户点击按钮执行动作
- 验证用户输入内容的合法性
- 等等 ...

可以使用多种方法来执行 JavaScript 事件代码：
- HTML 事件属性可以直接执行 JavaScript 代码
- HTML 事件属性可以调用 JavaScript 函数
- 你可以为 HTML 元素指定自己的事件处理程序
- 你可以阻止事件的发生。
- 等等 ...
