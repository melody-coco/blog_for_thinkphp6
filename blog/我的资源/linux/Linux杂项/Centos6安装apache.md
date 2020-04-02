### 环境要求

- 系统 `CentOS 6.x`



### 步骤

+ 更新升级 `yum update`
+ 安装 `apache` 服务 `yum install httpd`
+ 开启 `apache` 服务`service httpd start`
+ 查看`apache`服务是否启动 `service httpd status`
+ 进入`apache`默认网站目录 `cd /var/www/html`
+ 创建文件并进行访问
  + `echo 11 > index.html`
  + `http://IP[:PORT]`



### 创建虚拟主机

+ 进入虚拟主机的配置目录 `cd /etc/httpd/conf.d/`
+ 创建并编辑 `vhosts.conf` `vim vhost.conf`

```
<VirtualHost *:8080>
    DocumentRoot 填写网站根目录的绝对文件夹地址
    ServerName 通过指定的域名进来,如果没有, 可以填写0.0.0.0代表所有域名都可以访问
    ErrorLog logs/jxk-error.log
    CustomLog logs/jkx-access.log
</VirtualHost>
```

+ 在 `httpd.conf` 里面添加监听端口

  - `vim /etc/httpd/conf/httpd.conf`
  - 添加 `Listen 8080`

+ 重启 `apache`

  > 如果想让虚拟机能被主机访问, CentOS6版本的关闭防火墙命令是
  >
  >  service iptables stop