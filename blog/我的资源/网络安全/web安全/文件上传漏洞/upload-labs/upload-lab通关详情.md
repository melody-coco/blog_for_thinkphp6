<center>upload-labs通过详情</center>

[upload-labs中常用的函数](https://www.jianshu.com/p/90911e993f9c)









#### 1.前端js绕过



第一关没什么好说的。

只需要把`shell.php`修改后缀为`shell.png`

然后burp抓包。`filename`修改为`shell.php`就好了





#### 2.	MIME绕过



估计此关为MIME绕过。

过关的话，还是像上一关一样。修改`shell.php`为`shell.png`然后burp抓包，重新修改为`shell.php`



>  此处因为点击上传的时候，文件后缀为`.png`所以此处的`MIME`类型也为`image/png`所以不用修改`MIME`，直接修改文件后缀就行了







#### 3.	黑名单绕过#

黑名单绕过。此题中`.asp,.aspx,.php,.jsp`后缀文件都不被允许上传。

> 其实此题中我并没有成功。



黑名单的话，使用`.phtml`，`.php5`，`.php3`这种后缀就可以绕过。

不过绕过归绕过。却并不能解析到。需要`.htaccess`文件，来配合解析才能正确的解析到php文件。

> 不过，我并没有成功的上传`.htaccess`文件





此题中只需要把`shell.php`。后缀修改为`shell.phtml`就可以绕过黑名单。



> 不过实际上，后端对文件名还有一次改名。而且这个不能被截断。所以导致我没办法解析到







#### 4.	.htaccess绕过





此题中，后端应该是设置了黑名单。`.php  .phtml  .php5`等后缀都不能通过。

​			但是`wireshark`的`.pcap`却能同通过



所以此题中我们使用`.htaccess`方法来绕过。



+ 首先把`shell.php`文件名，修改为`shell.png`。然后上传

+ 接着上传一个`.htaccess`文件。该文件内容如下：

  ```
  AddType application/x-httpd-php .png
  ```




这样就完成了。直接用蚁剑连接`shell.png`地址就行了。

因为此处的`shell.png`被解析为了`php`文件。





#### 5.大小写绕过#



此题测试的话，就可以发现，后端还是做了黑名单。

但是此题中对大小写并不敏感。

于是乎，我们可以修改`shell.php`为`shell.PHP`。这样就能绕过了





不过不知道为什么，可能是因为我用的kali上docker的原因。后端对大小写敏感，并连接不上蚁剑

> emm……其实我测试了一下。发现我win10上也没办法连接上`shell.PHP`。不知道为什么





#### 6.空格绕过#





此题中，其实可以看看空格，我不知道还能空格绕过

查看文件源码的话，其实就会发现。在原来的基础上，没有使用`trim()`对两侧的空格进行绕过。



所以此处可以通过空格来绕过。

上传`shell.php`，通过burp抓包。修改文件名为`shell.php .`

查看后端源码可以发现。后端会过滤掉最后面的`.`。所以就可以通过此方式来绕过`.php`的黑名单。





