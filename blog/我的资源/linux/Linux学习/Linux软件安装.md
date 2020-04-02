<center>Linux下的软件安装</center>
### 1.	Linux的软件包

Linux的软件包分为两种，一种是**源码包**，一种是**二进制包**



#### 1.1	源码包

实际上，源码包就是一大堆代码程序，是由程序员按照特定的格式和语法编写出来的。

我们甚至能直接对源码包进行更改，手动写代码添加我们自己需要的功能，和删除我们不需要的模块。

但是源码包的因为其中是“程序源码”，而不是二进制码，所以需要进行编译了后才能安装，源码包的编译比较耗费时间。而且对于初学者来说不熟悉程序语言，如果在编译过程中报错，将会极难解决



详情[点击](http://c.biancheng.net/view/2952.html)或者[点击Vip版](http://www.beylze.com/news/30517.html)







#### 1.2	二进制包

二进制包，就是上面的源码包成功编译了后的包。由于二进制包在发布前就已经完成了编译的工作，因此用户安装软件的速度较快，且安装过程报错几率大大减小。



目前主要有以下2大主流的二进制包管理系统：

+ RPM包管理系统：`centOS`,`Fedora`等红帽系的用的就是此包管理系统
+ DPKG包管理系统：`Ubuntu`，`Debian`等Debian系，用的就是此包管理系统



##### 1.1.2	RPM包统一命名规则



RPM 二进制包命令的一般格式如下：

```
包名-版本号-发布次数-发行商-Linux平台-适合的硬件平台-包扩展名
```



例如，RPM包的名称`httpd-2.2.15-15.el6.centos.1.i686.rpm`，其中：

+ httped：软件包名。这里需要注意，httped是包名，而`httpd-2.2.15-15.el6.centos.1.i686.rpm`通常-称为包全名，包名和包全名是不同的，在Linux命令中，有些命令（包的安装和升级）使用的是包全名，而有些命令（包的查询和卸载）

+ 2.2.15：包的版本号，版本格式通常为`主版本号.次版本号.修正号`。
+ 15：二进制包发布的次数，表示此RPM包是第几次编程生成的。
+ el*：软件发行商，el6 表示此包是由 Red Hat 公司发布，适合在 RHEL 6.x (Red Hat Enterprise Unux) 和 CentOS 6.x 上使用。
+ centOS：表示此包适用于CentOS平台。

+ i686：表示此包使用的硬件平台，目前的 RPM 包支持的平台如表 1 所示：

+ rpm：RPM 包的扩展名，表明这是编译好的二进制包，可以使用 rpm 命令直接安装。此外，还有以 src.rpm 作为扩展名的 RPM 包，这表明是源代码包，需要安装生成源码，然后对其编译并生成 rpm 格式的包，最后才能使用 rpm 命令进行安装。



想要了解详情[点击](http://c.biancheng.net/view/2921.html)或者[点击VIP版本](http://www.beylze.com/news/30511.html)（ps.注意SRPM其根本还是RPM包）



##### 1.2.3	RPM包的安装更新，卸载



[详情](http://c.biancheng.net/view/2872.html)

##### 1.2.4	RPM包的验证和数字证书

[详情](http://c.biancheng.net/view/820.html)





### 2.	yum

上面的`RPM`，和源码包，是根本，有时间的话还是多看看。不过`Linux`系统中，为了更好更方便的管理已经其依赖的关系而造处了`yum`(Debian系统中为`apt-get`)。



`yum`全称`Yellow dog Updater, Modified`

#### 2.1	安装`yum`

1. 先通过`rpm`命令查看是否已经安装

```
[root@localhost ~]# rpm -qa | grep yum
yum-metadata-parser-1.1.2-16.el6.i686
yum-3.2.29-30.el6.centos.noarch
yum-utils-1.1.30-14.el6.noarch
yum-plugin-fastestmirror-1.1.30-14.el6.noarch
yum-plugin-security-1.1.30-14.el6.noarch
```

> 不动怎么安装的话，网上一大堆，就不说了



#### 2.2	网络yum源搭建

使用`yum`安装软件包之前，需指定好`yum`下载`RPM`包的位置，换句话说，`yum`指的就是软件安装包的来源。

使用`yum`安装程序至少需要一个`yum`源，`yum`源既可以使用网络`yum`源，也可以将本地光盘作为`yum`源



> 此处只说网络的yum源搭建，不说本地光盘yum源





1. 查看源配置文件

+ `centOS`的源配置文件在`/etc/yum.repos.d/`目录下
+ `Debian`的源配置文件是`/etc/apt/sources.list`，



##### centOS源配置文件

`centOS`目录下的有多个`yum`配置文件，一般都是`CentOS-Base.repo`生效，所以要换源的话，直接修改它就好了。





`CentOS-Base.repo`内容如下：

```
[root@localhost yum.repos.d]# vim /etc/yum.repos.d/ CentOS-Base.repo
[base]
name=CentOS-$releasever - Base
mirrorlist=http://mirrorlist.centos.org/? release= $releasever&arch=$basearch&repo=os
baseurl=http://mirror.centos.org/centos/$releasever/os/$basearch/
gpgcheck=1
gpgkey=file:///etc/pki/rpm-gpg/RPM-GPG-KEY-CentOS-
```

> 其中参数含义分别为

- [base]：容器名称，一定要放在[]中。
- name：容器说明，可以自己随便写。
- mirrorlist：镜像站点，这个可以注释掉。
- baseurl：我们的 yum 源服务器的地址。默认是 CentOS 官方的 yum 源服务器，是可以使用的。如果你觉得慢，则可以改成你喜欢的 yum 源地址。
- enabled：此容器是否生效，如果不写或写成 enabled 则表示此容器生效，写成 enable=0 则表示此容器不生效。
- gpgcheck：如果为 1 则表示 RPM 的数字证书生效；如果为 0 则表示 RPM 的数字证书不生效。
- gpgkey：数字证书的公钥文件保存位置。不用修改





##### Debian源配置文件

> Debian源配置文件的话，则要简单得多

配置文件只有一个，不像`CentOS`那样。路径为：`/etc/apt/sources.list`。

​	

内容为：

```
[root@localhost ~]# less /etc/apt/sources.list
deb http://http.kali.org/kali kali-rolling main non-free contrib

deb-src http://http.kali.org/kali kali-rolling main non-free contrib

apt-get update 
apt-get upgrade 
apt-get dist-upgrade
```



要换源的话，直接在网上找源，同样格式替换上去就好了





### 3.	yum命令

> 此处只说`yum`命令，`apt-get`命令的话，直接去网上找就行了，区别应该不大的





#### yum 查询命令

+ `yum list`：查询所有已安装和可安装的软件包。

  ```
  [root@localhost ~]# yum list 
  ConsdeKit.i686 0.4.1-3.el6
  @anaconda-CentOS-201207051201 J386/6.3
  ConsdeKit-libs.i686 0.4.1-3.el6 @anaconda-CentOS-201207051201 J386/6.3
  ```

  



+ `yum list 包名`：查询执行软件包的安装情况。

  ```
  [root@localhost ~]# yum list samba
  Available Packages samba.i686 3.5.10-125.el6 c6-media
  ```

  

+ `yum search 关键字`：从`yum`源服务器上查找与关键字相关的所有软件包。

```
[root@localhost ~]#yum search samba
```



+ `yum info 包名`： 查询执行软件包的详细信息。例如：

  ```
  [root@localhost ~]# yum info samba
  ```





#### yum 安装命令



`yum`安装软件包的命令基本格式为：

```
[root@localhost ~]# yum -y install samba 
```

其中：

`install`：表示安装程序包。

`-y`：自动回答yes，如果不加-y，则会反复询问



实例1：

> 简单安装`gcc`(c语言编译器)

```
[root@localhost ~]# yum -y install gcc
```





#### yum 升级命令



`yum`升级程序包常用命令如下：

+ `yum -y update`：升级所有程序包。
+ `yum -y update 包名`：升级特定的软件包。





#### yum卸载命令

一般不要卸载软件，

除非你等确定此包以及它所有的依赖包不会对系统产生影响，否则不要用`yum`卸载。

（ps.因为依赖也会被卸载）



`yum`卸载指令的基本格式如下：

```
[root@localhost ~]# yum remove 包名
```







#### 4.	yum group



##### yum查询软件组包含的软件

既然是软件包组，说明包含不只一个软件包，通过 yum 命令可以查询某软件包组中具体包含的软件包，命令格式如下：

```
[root@localhost ~]#yum groupinfo 软件组名
\#查询软件组中包含的软件
```

例如，查询 Web Server 软件包组中包含的软件包，可使用如下命令：

```
[root@localhost ~]#yum groupinfo "Web Server"
\#查询软件组"Webserver"中包含的软件
```





##### yum 安装软件组

使用 yum 安装软件包组的命令格式如下：

```
[root@localhost ~]#yum groupinstall 软件组名
\#安装指定软件组，组名可以由grouplist查询出来
```

例如，安装 Web Server 软件包组可使用如下命令：

```
[root@localhost ~]#yum groupinstall "Web Server"
\#安装网页服务软件组
```





##### yum命令卸载软件组

yum 卸载软件包组的命令格式如下：

```
[root@localhost ~]# yum groupremove 软件组名
#卸载指定软件组
```

