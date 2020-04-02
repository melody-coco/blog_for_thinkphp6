XSS利用站点内信任的用户，而CSRF则伪装成受信任的用户请求受信任的网站。(攻击者利用目标用户的身份，以目标用户的名义执行某些非法操作)


例子：你想给某位用户转账1000元发出的请求链接会与http://www.bank.com/?name=xx&money=100类似，而攻击者构造链接(http://www.bank.com/?name=hack&money=100)，当目标用户访问了该URL后就会自动的向hack转账100元，而且这只涉及到目标用户的操作，攻击者并没有获取目标用户的cookie等信息

CSRF:攻击过程有以下两个重点：
    1.目标用户已经登陆
    2.目标用户访问了攻击者构造的URL


##### 利用CSRF漏洞：
CSRF漏洞经常用来制作蠕虫攻击，刷SEO流量等
##### 下面展示一次CSRF攻击：
1，在一个网站的博客系统发布文章的页面里，单击“发布文章”按钮并使用burp suite抓包

2，可以看到在butp suite中有一个自动构造CSRF PoC的功能（右击→Engagement tools→Generate PoC,）

3,Burp suite会生成一段HTML代码，此HTML代码即为CSRF漏洞的测试代码，单机“COPY HTML”按钮就可以拷贝

4，将CSRF发布到一个网站中，例如链接为 http://www.xxx.com/1.html

5,接着诱导用户访问http://www.xxx.com/1.html,当用户处于登录状态，并且在同一浏览器访问了该网址后，目标用户就会自动发送一遍文章


### SSRF(服务端请求伪造)
