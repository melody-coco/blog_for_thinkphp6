SEO(search Engine Optimization)

HTTP中有个请求头叫做Refer，还有一个同叫做USER-Agent，黑帽SEO就是利用这两个头来欺骗搜索引擎的，Referfer头用于告诉Web服务器，用户是哪个页面找过来的，而User-Agent头则用于告诉服务器用户使用的浏览器和操作系统。当用户通过搜索引擎打开此网站时，一般会引出源页面(Referer头)，如：
Referer:http/www.baidu.com/stn=baiduhome_pg&ie=utf-8

Referer:http//www.google.com.hk/search?newwindow=1&safe=strict

利用这点，黑帽SEO就可以用任何web语言进行针对搜索引擎的流量劫持，一般步骤如下。

①  建立劫持搜索引擎，如：以百度，谷歌等域名为关键字

②获取HTTP Referer头

③ 遍历搜索引擎，并与Referer的内容相比较，如果两者相同或者存在搜索关键字，那么页面将会发生跳转，也就是域名劫持。