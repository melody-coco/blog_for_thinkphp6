#### 什么是 Razor ？
Razor 是一种将基于服务器的代码添加到网页中的标记语法
Razor 具有传统 ASP.NET 标记的功能，但更容易使用并且更容易学习
Razor 是一种服务器端标记语法，与 ASP 和 PHP 很像
Razor 支持 C# 和 Visual Basic 编程语言

- Razor 代码块包含在 @{ ... } 中
- 内联表达式（变量和函数）以 @ 开头
- 代码语句用分号结束
- 变量使用 var 关键字声明
- 字符串用引号括起来
- C# 代码区分大小写
- C# 文件的扩展名是 .cshtml
```
<html>
<body>
@{ var x = "这是一条语句"}
<p>第一条语句显示的是：@x</p>
@{ var y = "这是第二条信息";
    var z = "这是第三条信息"
}
<p>@y 这是中间的语句 @z</p>

</body>
</html>
```


#### Razor直接显示数据的语句

```
<body>
@RenderPage("header.cshtml")
<p>这是中间的语句</p>
@RenderPage("footer.cshtml")
</body>
```