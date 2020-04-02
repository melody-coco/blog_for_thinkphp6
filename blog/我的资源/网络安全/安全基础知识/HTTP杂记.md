1，HTTP通过80端口的明文传输，HTTPS通过443端口的加密传输，身份认证的网络协议。

HTTPS缓存不如HTTP高效，流量成本高，HTTPS连接服务端资源占用高很多，支持访客多的网站需要投入更多的成本，（最好像12306一样普通主页HTTP，有关于用户信息等方面的使用HTTPS）

2,HttpOnly

如果cookie中设置了HttpOnly属性，那么通过程序(js脚本，applet等)将无法读取到Cookie信息，这样能有效的防止XSS攻击。
```
//java设置cookie
response.setHeader("Set-Cookie", "JSESSIONID=" + sessionid + ";Secure;HttpOnly")//设置Secure;HttpOnly
response.setHeader("x-frame-options", "SAMEORIGIN");//设置x-frame-options
```