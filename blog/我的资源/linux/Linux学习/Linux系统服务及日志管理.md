<center>Linux系统服务及日志管理</center>
> 此章分为了两个部分。第一部分为`Linux`系统服务管理，第二部分为`Linux`系统日志管理

> 每个部分又分为概念，命令和文件目录三个小部分

> 默认的例如文件夹后面加`.d`的话，那他就是一个目录，例如`/etc/rc.d/init.d/`和`/etc/sinete.d/`还有`/etc/rsyslog.d`。文件后面加`d`的话，那他就是一个服务`daemon`





## 一. Linux系统服务管理

### 1.	概念

#### 1.	Linux系统服务

系统服务是在后台运行的应用程序，并且可以提供一些本地系统或网络的功能。我们把这些应用程序称作服务，也就是 Service。不过，我们有时会看到 Daemon 的叫法，Daemon 的英文原意是"守护神"，在这里是"守护进程"的意思。



守护进程就是为了实现服务、功能的进程。比如，我们的 apache 服务就是服务（Service），它是用来实现 Web 服务的。那么，启动 apache 服务的进程是哪个进程呢？就是 httpd 这个守护进程（Daemon）。也就是说，守护进程就是服务在后台运行的真实进程。



##### 服务的分类

Linux 中的服务按照安装方法不同可以分为 RPM 包默认安装的服务和源码包安装的服务两大类。

其中，RPM 包默认安装的服务又因为启动与自启动管理方法不同分为独立的服务和基于 xinetd 的服务。服务分类的关系图如下图所示。

<img src="http://c.biancheng.net/uploads/allimg/181024/2-1Q02413195AP.jpg" alt="服务分类的关系图" style="zoom:80%;" />

RPM 包默认安装的服务。这些服务是通过 RPM 包安装的，可以被服务管理命令识别。

这些服务又可以分为两种：

- 独立的服务：就是独立启动的意思，这种服务可以自行启动，而不用依赖其他的管理服务。因为不依赖其他的管理服务，所以，当客户端请求访问时，独立的服务响应请求更快速。目前，Linux 中的大多数服务都是独立的服务，如 apache 服务、FTP 服务、Samba 服务等。
- 基于 xinetd 的服务：这种服务就不能独立启动了，而要依靠管理服务来调用。这个负责管理的服务就是 xinetd 服务。xinetd 服务是系统的超级守护进程，其作用就是管理不能独立启动的服务。当有客户端请求时，先请求 xinetd 服务，由 xinetd 服务去唤醒相对应的服务。当客户端请求结束后，被唤醒的服务会关闭并释放资源。这样做的好处是只需要持续启动 xinetd 服务，而其他基于 xinetd 的服务只有在需要时才被启动，不会占用过多的服务器资源。但是这种服务由于在有客户端请求时才会被唤醒，所以响应时间相对较长。


源码包安装的服务。这些服务是通过源码包安装的，所以安装位置都是手工指定的。由于不能被系统中的服务管理命令直接识别，所以这些服务的启动与自启动方法一般都是源码包设计好的。每个源码包的启动脚本都不一样，一般需要查看说明文档才能确定。





##### 查询已经安装的服务和区分服务

我们已经知道 Linux 服务的分类了，那么应该如何区分这些服务呢？首先要区分 RPM 包默认安装的服务和源码包安装的服务。源码包安装的服务是不能被服务管理命令直接找到的，而且一般会安装到 /usr/local/ 目录中。



也就是说，在 /usr/local/ 目录中的服务都应该是通过源码包安装的服务。RPM 包默认安装的服务都会安装到系统默认位置，所以是可以被服务管理命令（如 service、chkconfig）识别的。



在 RPM 包默认安装的服务中怎么区分独立的服务和基于 xinetd 的服务依靠 chkconfig 命令。chkconfig 是管理 RPM 包默认安装的服务的自启动的命令，这里仅利用这条命令的查看功能。使用这条命令还能看到 RPM 包默认安装的所有服务。命令格式如下：

```
[root@localhost ~]# chkconf --list [服务名]
```

选项：

+ --list：列出RPM包默认安装的所有服务的自启动状态；



> 注意：要查看或使用基于`xinetd`的服务，需要安装`xinetd`服务。命令`yum -y install xinetd`安装



实例1：

> 此处使用`chconf`命令查看系统RPM包默认安装的所有服务，以及基于`xinetd`的服务

```
[root@localhost ~]# chkconfig --list
      'systemctl list-dependencies [target]'。

aegis           0:关    1:关    2:开    3:开    4:开    5:开    6:关
netconsole      0:关    1:关    2:关    3:关    4:关    5:关    6:关
network         0:关    1:关    2:开    3:开    4:开    5:开    6:关
phpstudy        0:关    1:关    2:开    3:开    4:开    5:开    6:关
pure-ftpd       0:关    1:关    2:关    3:开    4:开    5:开    6:关

基于 xinetd 的服务：
        chargen-dgram:  关
        chargen-stream: 关
```





#### 2.	Linux端口

> 知道了一台服务器的IP地址，就可以找到这台服务器，但是这台服务器上有可能搭建了多个网络服务，比如 WWW 服务、FTP 服务、Mail 服务，那么我们到底需要服务器为我们提供哪个网络服务呢？这时就要靠端口（Port）来区分了，因为每个网络服务对应的端口都是固定的。

> WWW 服务对应的端口是 80，FTP 服务对应的端口是 20 和 21，Mail 服务对应的端口是 25 和 110



为了统一整个互联网的端口和网络服务的对应关系，以便让所有的主机都能使用相同的机制来请求或提供服务，同一个服务使用相同的端口，这就是协议。

计算机中的协议主要分为两大类：

- 面向连接的可靠的TCP协议（Transmission Control Protocol，传输控制协议）；
- 面向无连接的不可靠的UDP协议（User Datagram Protocol，用户数据报协议）；

关于查看系统中已经启动的服务，主要有两种查看方式，

一是查看文件`/etc/services`，其中有具体的对口对应的服务的信息，详情在`文件目录`标签的`/etc/services`中。

二是命令`netstat`，此命令可以查看当前端口对应的服务的信息，详情在`命令`标签的`netstat`命令中。



#### 3.	Linux独立服务的管理

> 所谓独立服务，就是RPM包安装的服务中，不基于`xinetd`的服务。

> 此处主要分为独立服务的启动和独立服务的自启动

##### 独立服务的启动管理

​	1.通过`/etc/rc.d/init.d`目录中的脚本文件来启动独立的服务。	

> 不过不止为什么我不能通过这种方法来启动服务。可能是版本更新，此方法已经不能使用了

```
[root@localhost ~]#/etc/init.d独立服务名 start| stop|status|restart|...
```

参数：

- start：启动服务；
- stop：停止服务；
- status：查看服务状态；
- restart：重启动服务；



实例1：

> 简单的使用`/etc/rc.d/init.d/httpd`，`apache`脚本来运行`apache`服务

```
[root@localhost ~]# /etc/rc.d/init.d/httpd start
```

> 不止为什么我不能使用这种方式来启动服务



2. 使用`systemctl`命令来启动独立服务

其实`systemctl`命令只是一个脚本，实质上还是通过调用`/etc/rc.d/init.d/`中的启动脚本来启动独立的服务，此命令可能不被`Debian`使用。

这里不详解，详情在`命令`标签的`systemctl`中



##### 独立服务的自启动管理



服务的启动和服务的自启动是两个概念。前者是手动的开启服务，后者是让服务自动的在Linux系统开机的时候开启。



独立服务的自启动方法有三种：

1. ​	使用`chkconfig`服务自启动管理命令

此处不详讲，想要了解的话去`命令`标签的`chkconfig`命令中看



2. 修改`/etc/rc.d/rc.local`文件

此处不详讲此文件的具体内容，详情去`文件目录`标签的`/etc/rc.d/rc.local`中去看



3. 使用`ntsysv`命令管理自启动

此处不详讲，具体的去`命令`标签的`ntsysv`命令去看



#### 4.	Linux基于xinetd服务的管理

> RPM包的服务分为：独立服务，基于`xinetd`的服务。

> 此处讲解：基于`xinetd`的服务启动与自启动

首先`Telnet`协议知道是什么东西吧，这玩意是基于`xinetd`的服务。接下来的讲解就是关于`Telnet`的



##### 基于`xinetd`的服务启动

基于 xinetd 的服务没有自己独立的启动脚本程序，是需要依赖 xinetd 的启动脚本来启动的。xinetd 本身是独立的服务，所以 xinetd 服务自己的启动方法和独立服务的启动方法是一致的。

但是，所有基于 xinetd 这个超级守护进程的其他服务就不是这样的了，必须修改该服务的配置文件，才能启动基于 xinetd 的服务。所有基于 xinetd 服务的配置文件都保存在 `/etc/xinetd.d/ `目录中。

> 简单概述一下，想要启动基于`xinetd`的服务，需要在`/etc/xinetd.d`目录中的对应文件中修改字段`disable`的值为`no`(默认是yes，不启动)。反之停用服务的话，就把`disable`的值改为`yes`

具体的用法在`文件目录`中的`/etc/xinetd/`中，有需要自己去看

>  注意：正常的话，要启动基于`xinetd`的服务，只有这一个方法。但是基于`xinetd`的服务，它的启动和自启动是是通用的，也就是说，我通过`chkconfig`命令设定基于`xinetd`的服务自启动的话，它就会直接启动

##### 基于xinetd的服务自启动

基于`xinetd`的服务自启动有两种方法。1是使用`chkconfig`命令。2是使用`nysysv`命令设置



方式1：通过`chkconfig`命令来设置基于`xinetd`服务的自启动

```
//首先使用chkconfig命令查看关于，Telnet服务的状态
[root@localhost ~]# chkconfig --list | grep Telnet
telnet:关闭											//此处可以看到是关闭的
													
[root@localhost ~]# chkconfig Telnet on				//此处不需要设置level，直接开启
[root@localhost ~]# chkconfig --list | grep Telnet
```



2的话就不说了，它类似于独立服务的`ntsysv`启动方法。

> 注意：正常的话，要启动基于`xinetd`的服务，只有通过`/etc/xinetd.d/目录`中的脚本一个方法。但是基于`xinetd`的服务，它的启动和自启动是是通用的，也就是说，我通过`chkconfig`命令设定基于`xinetd`的服务自启动的话，它就会直接启动



#### 5.	源码包服务的管理

> 上面写了RPM的独立服务的管理，和基于`xinetd`服务的管理。此处简述一下源码包服务的管理

##### 源码包的启动管理

源码包服务中所有的文件都会安装到指定目录当中，所以服务的管理脚本程序也会安装到指定目录中。源码包服务的启动管理方式就是在服务的安装目录中找到管理脚本，然后执行这个脚本

每个服务的启动脚本都是不一样的，我们怎么确定每个服务的启动脚本呢？还记得在安装源码包服务时，我们强调需要査看每个服务的说明文档吗（一般是 INSTALL 或 READEM）？在这个说明文档中会明确地告诉大家服务的启动脚本是哪个文件。



我们用 apache 服务来举例。一般 apache 服务的安装位置是 /usr/local/apache2/ 目录，那么 apache 服务的启动脚本就是 /usr/local/apache2/bin/apachectl 文件（查询 apache 说明文档得知）。启动命令如下：

```
[root@localhost ~]# /usr/local/apache2/bin/apachectl start
#会启动源码包安装的apache服务
```

> 注意，不管是源码包安装的 apache，还是 RPM 包默认安装的 apache，虽然在一台服务器中都可以安装，但是只能启动一因为它们都会占用 80 端口。

源码包服务的启动方法就这一种



##### 源码包的自启动管理

源码包服务的白启动管理也不能依靠系统的服务管理命令，而只能把标准启动命令写入 /etc/rc.d/rc.local 文件中。系统在启动过程中读取 /etc/rc.d/rc.local 文件时，就会调用源码包服务的启动脚本，从而让该服务开机自启动。命令如下：

```
[root@localhost ~]# vi /etc/rc.d/rc.local
#修改自启动文件
#!/bin/sh
#This script will be executed *after* all the other init scripts.
#You can put your own initialization stuff in here if you don11
#want to do the full Sys V style init stuff.
touch /var/lock/subsys/local 
/usr/local/apache2/bin/apachectl start		//此处的apachectl为apache服务的启动脚本
#加入源码包服务的标准启动命令，保存退出，源码包安装的apache服务就被设为自启动了
```



##### 让源码包服务被服务管理命令识别



在默认情况下，源码包服务是不能被系统的服务管理命令所识别和管理的，但是如果我们做一些设定，则也是可以让源码包服务被系统的服务管理命令所识别和管理的。不过笔者并不推荐大家这样做，因为这会让本来区别很明确的源码包服务和 RPM 包服务变得容易混淆，不利于系统维护和管理。



如果想让源码包服务被service命令所识别和管理，则只需做一个软链接把启动脚本链接到 `/etc/rc.d/init.d` 目录中即可。要想让源码包服务被 chkconfig 命令所是被，除了需要把服务的启动脚本链接到` /etc/rc.d/init.d/ `目录中，还要修改这个启动脚本，在启动脚本的开头加入如下内容：

```
#chkconfig:运行级别 启动顺序 关闭
    #指定httpd脚本可以被chkconfig命令所管理
    #格式是：chkconfig：运行级别 启动顺序 关闭顺序
    #这里我们让apache服务在3和5级别中能被chkconfig命令所管理，启动顺序是S86，关闭顺序是K76
    #(自定顺序，不要和系统中已有的启动顺序冲突)
	#例如chkconfig:35 86 76
	
#description:说明
	#此说明自定义就好
```

然后需要使用"chkconfig--add 服务名"的方式把服务加入 chkconfig 命令的管理中。命令格式如下：

```
[root@localhost ~]# chkconfig [选项][服务名]
```

选项：

- -add：把服务加入 chkconfig 命令的管理中；
- -del：把服务从 chkconfig 命令的管理中删除；


例如：

```
[root@localhost ~]# chkconfig -del httpd
#把apache服务从chkconfig命令的管理中删除
```

注意`ntsysv`的话其实和 chkconfig 命令使用同样的管理机制，也就是说配置好了`chkconfig`的话`ntsysv`也可以使用了。



#### 6.	Linux常见服务及功能

[Linux](http://c.biancheng.net/linux_tutorial/) 中的服务数量非常多，我们在学习时一直使用 apache 服务作为实例。很多人会产生困惑：其他的服务都是干什么的呢？它们有什么作用呢？是不是必须启动的呢？

本节，我们就来介绍 Linux 中常见服务及它们各自的作用。

在生产服务器上，安装完 Linux 之后有一步重要的工作，就是服务优化。也就是关闭不需要的服务，只开启需要的服务。因为服务启动得越多，占用的系统资源就越多，而且被攻击的可能性也増加了。如果要进行服务优化，就需要知道这些服务都有什么作用，如下表所示。

| 服务名称        | 功能简介                                                     | 建议 |
| --------------- | ------------------------------------------------------------ | ---- |
| acpid           | 电源管理接口。如果是笔记本电脑用户，则建议开启，可以监听内核层的相关电源事件 | 开启 |
| anacron         | 系统的定时任务程序。是 cron 的一个子系统，如果定时任务错过了执行时间，则可以通过 anacron 继续唤醒执行 | 关闭 |
| alsasound       | alsa 声卡驱动。如果使用 alsa 声卡，则开启                    | 关闭 |
| apmd            | 电源管理模块。如果支持 acpid，就不需要 apmd，可以关闭        | 关闭 |
| atd             | 指定系统在特定时间执行某个任务，只能执行一次。如果需要则开启，但我们一般使用 crond 来执行循环定时任务 | 关闭 |
| auditd          | 审核子系统。如果开启了此服务，那么 SELinux 的审核信息会写入 /var/log/audit/ audit.log 文件；如果不开启，那么审核信息会记录在 syslog 中 | 开启 |
| autofs          | 让服务器可以自动挂载网络中其他服务器的共享数据,一般用来自动挂载 NFS 服务。如果没有 NFS 服务，则建议关闭 | 关闭 |
| avahi-daemon    | avahi 是 zeroconf 协议的实现，它可以在没有 DNS 服务的局域网里发现基于 zeroconf 协议的设备和服务。除非有兼容设备或使用 zeroconf 协议，否则关闭 | 关闭 |
| bluetooth       | 蓝牙设备支持。一般不会在服务器上启用蓝牙设备，关闭它         | 关闭 |
| capi            | 仅对使用 ISND 设备的用户有用                                 | 关闭 |
| chargen-dgram   | 使用 UDP 协议的 chargen server。其主要提供类似远程打字的功能 | 关闭 |
| chargen-stream  | 同上                                                         | 关闭 |
| cpuspeed        | 可以用来调整 CPU 的频率。当闲置时，可以自动降低 CPU 频率来节省电量 | 开启 |
| crond           | 系统的定时任务，一般的 Linux 服务器都需要定时任务来协助系统维护。建议开启 | 开启 |
| cvs             | 一个版本控制系统                                             | 关闭 |
| daytime-dgram   | 使用 TCP 协议的 daytime 守护进程，该协议为客户机实现从远程服务器获取日期和时间的功能 | 关闭 |
| daytime-slream  | 同上                                                         | 关闭 |
| dovecot         | 邮件服务中 POP3/IMAP 服务的守护进程，主要用来接收信件。如果启动了邮件服务则开启：否则关闭 | 关闭 |
| echo-dgram      | 服务器回显客户服务的进程                                     | 关闭 |
| echo-stream     | 同上                                                         | 关闭 |
| firstboot       | 系统安装完成后，有一个欢迎界面，需要对系统进行初始设定，这就是这个服务的作用。既然不是第一次启动了，则建议关闭 | 关闭 |
| gpm             | 在字符终端 (ttyl~tty6) 中可以使用鼠标复制和粘贴，这就是这个服务的功能 | 开启 |
| haldaemon       | 检测和支持 USB 设备。如果是服务器则可以关闭，个人机则建议开启 | 关闭 |
| hidd            | 蓝牙鼠标、键盘等蓝牙设备检测。必须启动 bluetooth 服务        | 关闭 |
| hplip           | HP 打印机支持，如果没有 HP 打印机则关闭                      | 关闭 |
| httpd           | apache 服务的守护进程。如果需要启动 apache，就开启           | 开启 |
| ip6tables       | IPv6 的防火墙。目前 IPv6 协议并没有使用，可以关闭            | 关闭 |
| iptables        | 防火墙功能。Linux 中的防火墙是内核支持功能。这是服务器的主要防护手段，必须开启 | 开启 |
| irda            | IrDA 提供红外线设备（笔记本电脑、PDA’s、手机、计算器等）间的通信支持。建议关闭 | 关闭 |
| irqbalance      | 支持多核处理器，让 CPU 可以自动分配系统中断（IRQ)，提高系统性能。目前服务器多是多核 CPU，请开启 | 开启 |
| isdn            | 使用 ISDN 设备连接网络。目前主流的联网方式是光纤接入和 ADSL，ISDN 己经非常少见，请关闭 | 关闭 |
| kudzu           | 该服务可以在开机时进行硬件检测，并会调用相关的设置软件。建议关闭，仅在需要时开启 | 关闭 |
| lvm2-monitor    | 该服务可以让系统支持LVM逻辑卷组，如果分区采用的是LVM方式，那么应该开启。建议开启 | 开启 |
| mcstrans        | SELinux 的支持服务。建议开启                                 | 开启 |
| mdmonitor       | 该服务用来监测 Software RAID 或 LVM 的信息。不是必需服务，建议关闭 | 关闭 |
| mdmpd           | 该服务用来监测 Multi-Path 设备。不是必需服务，建议关闭       | 关闭 |
| messagebus      | 这是 Linux 的 IPC (Interprocess Communication，进程间通信）服务，用来在各个软件中交换信息。建议关闭 | 关闭 |
| microcode _ctl  | Intel 系列的 CPU 可以通过这个服务支持额外的微指令集。建议关闭 | 关闭 |
| mysqld          | [MySQL](http://c.biancheng.net/mysql/) 数据库服务器。如果需要就开启；否则关闭 | 开启 |
| named           | DNS 服务的守护进程，用来进行域名解析。如果是 DNS 服务器则开启；否则关闭 | 关闭 |
| netfs           | 该服务用于在系统启动时自动挂载网络中的共享文件空间，比如 NFS、Samba 等。 需要就开启，否则关闭 | 关闭 |
| network         | 提供网络设罝功能。通过这个服务来管理网络，建议开启           | 开启 |
| nfs             | NFS (Network File System) 服务，Linux 与 Linux 之间的文件共享服务。需要就开启，否则关闭 | 关闭 |
| nfslock         | 在 Linux 中如果使用了 NFS 服务，那么，为了避免同一个文件被不同的用户同时编辑，所以有这个锁服务。有 NFS 时开启，否则关闭 | 关闭 |
| ntpd            | 该服务可以通过互联网自动更新系统时间.使系统时间永远准确。需要则开启，但不是必需服务 | 关闭 |
| pcscd           | 智能卡检测服务，可以关闭                                     | 关闭 |
| portmap         | 用在远程过程调用 (RPC) 的服务，如果没有任何 RPC 服务，则可以关闭。主要是 NFS 和 NIS 服务需要 | 关闭 |
| psacct          | 该守护进程支持几个监控进程活动的工具                         | 关闭 |
| rdisc           | 客户端 ICMP 路由协议                                         | 关闭 |
| readahead_early | 在系统开启的时候，先将某些进程加载入内存整理，可以加快启动速度 | 关闭 |
| readahead_later | 同上                                                         | 关闭 |
| restorecond     | 用于给 SELinux 监测和重新加载正确的文件上下文。如果开启 SELinux，则需要开启 | 关闭 |
| rpcgssd         | 与 NFS 有关的客户端功能。如果没有 NFS 就关闭                 | 关闭 |
| rpcidmapd       | 同上                                                         | 关闭 |
| rsync           | 远程数据备份守护进程                                         | 关闭 |
| sendmail        | sendmail 邮件服务的守护进程。如果有邮件服务就开启；否则关闭  | 关闭 |
| setroubleshoot  | 该服务用于将 SELinux 相关信息记录在日志 /var/log/messages 中。建议开启 | 开启 |
| smartd          | 该服务用于自动检测硬盘状态。建议开启                         | 开启 |
| smb             | 网络服务 samba 的守护进程。可以让 Linux 和 Windows 之间共享数据。如果需要则开启 | 关闭 |
| squid           | 代理服务的守护进程。如果需要则开启：否则关闭                 | 关闭 |
| sshd            | ssh 加密远程登录管理的服务。服务器的远程管理必须使用此服务，不要关闭 | 开启 |
| syslog          | 日志的守护进程                                               | 开启 |
| vsftpd          | vsftp 服务的守护进程。如果需要 FTP 服务则开启；否则关闭      | 关闭 |
| xfs             | 这是 X Window 的字体守护进程，为图形界面提供字体服务。如果不启动图形界面，就不用开启 | 关闭 |
| xinetd          | 超级守护进程。如果有依赖 xinetd 的服务，就必须开启           | 开启 |
| ypbind          | 为 NIS (网络信息系统）客户机激活 ypbind 服务进程             | 关闭 |
| yum-updatesd    | yum 的在线升级服务                                           | 关闭 |



#### 7.	影响Linux系统性能的因素有哪些？

此处不详讲，[自己看](http://c.biancheng.net/view/6153.html)







### 2.	文件目录

#### 1.	/etc/services

> 此目录更多是用来查看：服务i与端口对应的信息，简单说，那个端口对应哪个服务。

我们查看一下内容：

```
[root@localhost ~]# less -Nm /etc/services
…省略部分输出…
ftp-data 20/tcp
ftp-data 20/udp
# 21 is registered to ftp, but also used by fsp
ftp 21/tcp
ftp 21/udp
fsp fspd
#FTP服务的端口
…省略部分输出…
smtp 25/tcp mail
smtp 25/udp mail
#邮件发送信件的端口
…省略部分输出…
http 80/tcp www www-http #WorldWideWeb HTTP
http 80/udp www www-http #HyperText Transfer Protocol
#WWW服务的端口
…省略部分输出…
pop3 110/tcp pop-3
# POP version 3
pop3 110/udp pop-3
#邮件接收信件的端口
…省略部分输出…
```





#### 2.	/etc/rc.d/init.d/目录

> 此目录中装的都是Linux系统的独立服务的启动脚本

> 不过不知为什么我不能通过这种方法来启动服务。可能是版本更新，此方法已经不能使用了

首先简单查看一下此目录的内容：

```
[root@localhost ~]# ls -l /etc/rc.d/init.d/
-rwxr-xr-x 1 root root  2164 12月 16 12:37 aegis
-rw-r--r-- 1 root root 18281 3月  29 2019 functions
-rwxr-xr-x 1 root root  4569 3月  29 2019 netconsole
-rwxr-xr-x 1 root root  7923 3月  29 2019 network
-rwxr-xr-x 1 root root   933 1月  14 15:37 phpstudy
-rwxr-xr-x 1 root root   983 1月  14 16:03 pure-ftpd
-rw-r--r-- 1 root root  1160 2月   5 00:29 README
```



此目录是除了使用`systemctl`命令，的另一种启动Linux系统中独立服务的方式

```
[root@localhost ~]#/etc/init.d独立服务名 start| stop|status|restart|...
```

参数：

- start：启动服务；
- stop：停止服务；
- status：查看服务状态；
- restart：重启动服务；



实例1：

> 简单的使用`/etc/rc.d/init.d/httpd`，`apache`脚本来运行`apache`服务

```
[root@localhost ~]# /etc/rc.d/init.d/httpd start
```

> 不止为什么我不能使用这种方式来启动服务



#### 3.	/etc/rc.d/rc.local

> 此文件主要用于设置RPM独立服务的自启动

先看一下此文件的内容：

```
[root@localhost ~]# less -Nm /etc/rc.d/rc.local
#!/bin/sh
#
#This script will be executed *after* all the other init scripts.
#You can put your own initialization stuff in here if you don't want to do the full Sys V style init stuff.
touch /var/lock/subsys/local
/etc/rc.d/init.d/httpd start
								#在文件中加入apache的启动命令
```

> 在最后一行加上`/etc/rc.d/init.d/httpd	start`就可以，设置`httpd`为自启动。

这样，只要重启之后，apache 服务就会开机自启动了。推荐大家使用这种方法管理服务的自启动，有两点好处：

- 第一，如果大家都采用这种方法管理服务的自启动，当我们碰到一台陌生的服务器时，只要查看这个文件就知道这台服务器到底自启动了哪些服务，便于集中管理。
- 第二，chkconfig 命令只能识别 RPM 包默认安装的服务，而不能识别源码包安装的服务。 源码包安装的服务的自启动也是通过 /etc/rc.d/rc.local 文件实现的，所以不会出现同一台服务器自启动了两种安装方法的同一个服务。


还要注意一下，修改 /etc/rc.d/rc.local 配置文件的自启动方法和 chkconfig 命令的自启动方法是两种不同的自启动方法。所以，就算通过修改 /etc/rc.d/rc.local 配置文件的方法让某个独立的服务自启动了，执行"chkconfig --list"命令并不到有什么变化。



#### 4.	/etc/xinetd.d/目录

> 此目录中装的都是：基于`xinetd`的服务的脚本。通过此目录中的文件，可以不用`chkconfig`就开启基于`xinetd`服务的脚本。

> 注意：正常的话，要启动基于`xinetd`的服务，只有这一个方法。但是基于`xinetd`的服务，它的启动和自启动是是通用的，也就是说，我通过`chkconfig`命令设定基于`xinetd`的服务自启动的话，它就会直接启动

首先，查看一下此目录中的内容：

```
[root@localhost ~]# ls -l /etc/xinetd.d/
-rw------- 1 root root 1157 11月  5 2016 chargen-dgram
-rw------- 1 root root 1159 11月  5 2016 chargen-stream
-rw------- 1 root root 1157 11月  5 2016 daytime-dgram
-rwx------ 1 root root 1157 11月  5 2016 Telnet	//Telnet协议连接。这是我们的实验目标
```

然后查看`Telnet`文件

```
[root@localhost ~]# less -Nm /etc/xinetd.d/Telnet
#default: on
#description: The telnet server serves telnet sessions; it uses \
#unencrypted username/password pairs for authentication.
service telnet
#服务的名称为telnet
{
flags = REUSE
#标志为REUSE，设定TCP/IP socket可重用
socketjtype = stream
#使用 TCP协议数据包
wait = no
#允许多个连接同时连接
user = root
#启动服务的用户为root
server = /usr/sbin/in.telnetd
#服务的启动程序
log_on_failure += USERID
#登录失败后，记录用户的ID
disable = yes
#服务不启动
}
```

如果要启动这里的`Telnet`的话，修改`disable`的字段值为`no`(默认为yes,不启动)。然后重启`xinetd`就好了

```
[root@localhost ~]#vi /etc/xinetd.d/telnet
#修改配置文件
service telnet {
…省略部分输出…
disable = no
#把 yes 改为no
}
[root@localhost ~]# systemctl restart xinetd.service		//重启xineted服务
[root@localhost ~]# chkconfig --list | grep Telnet
Telnet:开启
```

















### 3.	命令

#### 1.	netstat

> 此命令主要用于：查看Linux系统中服务对应的端口

`netstat`命令的基本格式如下：

```
[root@localhost ~]# netstat [选项]
```

选项：

- -a：列出系统中所有网络连接，包括已经连接的网络服务、监听的网络服务和 Socket 套接字；
- -t：列出 TCP 数据；           加上了`-t`和`-u`选项的话，就不会显示套件字了
- -u：列出 UDF 数据；
- -l：列出正在监听的网络服务（不包含已经连接的网络服务）；
- -n：用端口号来显示而不用服务名；
- -p：列出该服务的进程 ID (PID)；

> 一般的话，选项自己掂量着用就好了。不过`-n`和`-p`选项一般要加上



实例1：

> 使用`netstat -anp`命令，查看输出信息。包括`TCP`,`UDP`,`套件字`

```
[root@localhost ~]# netstat -anp
Proto Recv-Q Send-Q Local Address   Foreign Address     State       PID/Program name    
tcp     0     0     127.0.0.1:631     0.0.0.0:*         LISTEN      916/cupsd           
tcp     0     0     0.0.0.0:8090      0.0.0.0:*         LISTEN      1727/phpstudy 

udp     0     0     192.168.122.1:53  0.0.0.0:*                     1380/dnsmasq        
udp     0     0     0.0.0.0:67        0.0.0.0:*                     1380/dnsmasq 

Active UNIX domain sockets (servers and established)
Proto RefCnt Flags       Type       State      I-Node   PID/Program name     Path
unix   2     [ ACC ]     STREAM     LISTENING  5601453  5187/AliYunDun      省略
unix  2      [ ACC ]     STREAM     LISTENING     13843    1/systemd        省略
//此处只截取了一部分内容
```

输出信息分为两个部分，前者是`tcp`,`udp`信息具体字段含义如下：

- Proto：数据包的协议。分为 TCP 和 UDP 数据包；
- Recv-Q：表示收到的数据已经在本地接收缓冲，但是还没有被进程取走的数据包数量；
- Send-Q：对方没有收到的数据包数量；或者没有 Ack 回复的，还在本地缓冲区的数据包数量；
- Local Address：本地 IP : 端口。通过端口可以知道本机开启了哪些服务；
- Foreign Address：远程主机：端口。也就是远程是哪个 IP、使用哪个端口连接到本机。由于这条命令只能查看监听端口，所以没有 IP 连接到到本机；
- State:连接状态。主要有已经建立连接（ESTABLISED）和监听（LISTEN）两种状态，当前只能查看监听状态；
- PID/Program name：进程 ID 和进程命令；

后者是套件字`Socket`套件字的输出，具体字段含义如下：

- Proto：协议，一般是unix；
- RefCnt：连接到此Socket的进程数量；
- Flags：连接标识；
- Type：Socket访问类型；
- State：状态，LISTENING表示监听，CONNECTED表示已经建立连接；
- I-Node：程序文件的 i 节点号；
- Path：Socke程序的路径，或者相关数据的输出路径；

> 当然也可以使用`-t`,`-u`选项来过滤掉套件字的信息输出。



#### 2.	systemctl

> 此命令主要用处是，启动Linux系统服务。另一种启动服务的方式是`/etc/rc.d/init.d/`目录

`systemctl`命令，基本格式如下：

```
[root@localhsot ~]# systemctl start|stop|restart|enable... 服务名.service
```



实例1：

> 简单使用`systemctl`命令

```
[root@localhsot ~]# systemctl start phpstudy.service			//开启phpstudy服务

[root@localhost ~]# systemctl status phpstudy.service	     //查看phpstudy服务状态
```



#### 3.	chkconfig

> 此命令主要用于设置Linux服务的自启动管理。以及查看Linux中的系统服务

`chkconfig`命令，基本格式为：

```
[root@localhost ~]# chconfig --list      				//查看Linux中的系统服务
[root@localhost ~]# chkconfig --level 等级代号 服务名		//设置Linux服务的自启动
[root@localhost ~]# chkconfig [选项] 服务名				//管理Linux中的服务
```

第三种使用方法的，选项如下：

+ `--add`：增加所指定的系统服务，让`chkconfig`指令得以管理他，说白了就是添加服务
+ `--del`：删除所指定的系统服务，不再由`chkconfig`指令管理。说白了就是删除服务



实例1：

> 使用`chkconfig`命令来查看Linux系统中的服务

```
[root@localhost ~]# chkconfig --list
aegis           0:关    1:关    2:开    3:开    4:开    5:开    6:关
netconsole      0:关    1:关    2:关    3:关    4:关    5:关    6:关
network         0:关    1:关    2:开    3:开    4:开    5:开    6:关
phpstudy        0:关    1:关    2:开    3:开    4:开    5:开    6:关
pure-ftpd       0:关    1:关    2:关    3:开    4:开    5:开    6:关

基于 xinetd 的服务：
        chargen-dgram:  关
        chargen-stream: 关
        daytime-dgram:  关
```



实例2：

> 使用`chkconfig`命令来，增加和删除服务

> 此处怎加服务的话，一般增加的是源码包的服务。需要先把源码包的启动脚本软链接到`/etc/rc.d/init.d/`目录下之外。还需要往启动脚本文件里面写入两行内容。具体的操作在`概念`-->源码包服务的管理-->让源码包服务被服务管理命令识别。中
>
> 此处就只写上面步骤的最后部分，“使用`chkconfig`命令把服务加入`chkconfig`命令管理中”

```
[root@localhost ~]# chkconfig -add httpd
```



实例3：

> 使用`chkconfig --level 等级代号 服务名`命令来，设置服务的自启动

> 上面的`chkconfig --list`命令以及查看出了一些系统服务的自启动权限，1~6就是不同的自启动权限，

> 等级0表示：表示关机
> 等级1表示：单用户模式
> 等级2表示：无网络连接的多用户命令行模式
> 等级3表示：有网络连接的多用户命令行模式
> 等级4表示：不可用
> 等级5表示：带图形界面的多用户模式
> 等级6表示：重新启动

```
[root@localhost ~]# chkconfig --level 123456 httpd on	//修改apache的自启动为123456
```

> 不懂的，使用`--help`查看





#### 4.	ntsysv

> 此命令`Debian`没有

> 此命令主要用于：强制弹出一个图形化界面来设置管理系统服务的自启动。
>
> 以及管理上面`chkconfig --level`命令设置的等级代号，对应的自启动

`ntsysv`命令格式如下：

```
[root@localhost ~]# ntsysv [--level 运行级别]
```

选项：

- --level 运行级别：可以指定设定自启动的运行级别；

例如：

```
[root@localhost ~]# ntsysv --level 235
\#只设定2、3、5级别的服务自启动
[root@localhost ~]# ntsysv
\#按默认的运行级别设置服务自启动
```

执行命令后，会和 setup 命令类似，出现命令界面，如下图 所示。

<img src="http://c.biancheng.net/uploads/allimg/181024/2-1Q02415591C13.jpg" alt="ntsysv命令界面" style="zoom:80%;" />

> 在这里就可以选择自启动的系统服务，

> `ntsysv`命令不仅可以设置独立服务的自启动，开可以设置基于`xinetd`的服务自启动





## 二.	Linux系统日志管理

### 1.	概念



#### 1.	rsyslogd服务及启动方法

在 CentOS 6.x 中，日志服务已经由 rsyslogd 取代了原先的 syslogd。Red Hat 公司认为 syslogd 已经不能满足工作中的需求，rsyslogd 相比 syslogd 具有一些新的特点：

- 基于TCP网络协议传输日志信息。
- 更安全的网络传输方式。
- 有日志信息的即时分析框架。
- 后台数据库。
- 在配置文件中可以写简单的逻辑判断。
- 与syslog配置文件相兼容。


rsyslogd 日志服务更加先进，功能更多。但是，不论是该服务的使用，还是日志文件的格式，其实都是和 syslogd 服务相兼容的，所以学习起来基本和 syslogd 服务一致。

我们如何知道 [Linux](http://c.biancheng.net/linux_tutorial/) 中的 rsyslogd 服务是否启动了呢？如何查询 rsyslogd 服务的自启动状态呢？命令如下：

```
[root@localhost ~]# ps aux | grep "rsyslog" | grep -v "grep"
root 1139 0.0 0.2 35948 1500 ? Sl 09：40 0：00 /sbin/rsyslogd -i/var/run/syslogd.pid -c 5
#有rsyslogd服务的进程，所以这个服务已经启动了
[root@localhost ~]# chkconfig --list | grep rsyslog
rsyslog 0：关闭 1：关闭 2：启用 3：启用 4：启用 5：启用 6：关闭
#rsyslog服务在2、3、4、5运行级别上是开机自启动的
```


系统中的绝大多数日志文件是由 rsyslogd 服务来统一管理的，只要各个进程将信息给予这个服务，它就会自动地把日志按照特定的格式记录到不同的日志文件中。也就是说，采用 rsyslogd 服务管理的日志文件，它们的格式应该是统一的。

在 Linux 系统中有一部分日志不是由 rsyslogd 服务来管理的，比如 apache 服务，它的日志是由 Apache 软件自己产生并记录的，并没有调用 rsyslogd 服务。但是为了便于读取，apache 日志文件的格式和系统默认日志的格式是一致的。



#### 2.	Linux日志文件及其功能

日志文件是重要的系统信息文件，其中记录了许多重要的系统事件，包括用户的登录信息、系统的启动信息、系统的安全信息、邮件相关信息、各种服务相关信息等。这些信息有些非常敏感，所以在 [Linux](http://c.biancheng.net/linux_tutorial/) 中这些日志文件只有 root 用户可以读取。

 

那么，系统日志文件保存在什么地方呢？还记得 /var/ 目录吗？它是用来保存系统动态数据的目录，那么 /var/log/ 目录就是系统日志文件的保存位置。我们通过下表来说明一下系统中的重要日志文件。


| 日志文件          | 说 明                                                        |
| ----------------- | ------------------------------------------------------------ |
| /var/log/cron     | 记录与系统定时任务相关的曰志                                 |
| /var/log/cups/    | 记录打印信息的曰志                                           |
| /var/log/dmesg    | 记录了系统在开机时内核自检的信总。也可以使用dmesg命令直接查看内核自检信息 |
| /var/log/btmp     | 记录错误登陆的日志。这个文件是二进制文件，不能直接用Vi查看，而要使用lastb命令查看。命令如下： [root@localhost log]#lastb root tty1 Tue Jun 4 22:38 - 22:38 (00:00) #有人在6月4 日 22:38便用root用户在本地终端 1 登陆错误 |
| /var/log/lasllog  | 记录系统中所有用户最后一次的登录时间的曰志。这个文件也是二进制文件.不能直接用Vi 查看。而要使用lastlog命令查看 |
| /var/Iog/mailog   | 记录邮件信息的曰志                                           |
| /var/log/messages | 它是核心系统日志文件，其中包含了系统启动时的引导信息，以及系统运行时的其他状态消息。I/O 错误、网络错误和其他系统错误都会记录到此文件中。其他信息，比如某个人的身份切换为 root，已经用户自定义安装软件的日志，也会在这里列出。 |
| /var/log/secure   | 记录验证和授权方面的倍息，只要涉及账户和密码的程序都会记录，比如系统的登录、ssh的登录、su切换用户，sudo授权，甚至添加用户和修改用户密码都会记录在这个日志文件中 |
| /var/log/wtmp     | 永久记录所有用户的登陆、注销信息，同时记录系统的后动、重启、关机事件。同样，这个文件也是二进制文件.不能直接用Vi查看，而要使用last命令查看 |
| /var/tun/ulmp     | 记录当前已经登录的用户的信息。这个文件会随着用户的登录和注销而不断变化，只记录当前登录用户的信息。同样，这个文件不能直接用Vi查看，而要使用w、who、users等命令查看 |

> 其中，最重要的是`/var/log/messages`和`/var/log/secure`

除系统默认的日志之外，采用 RPM 包方式安装的系统服务也会默认把日志记录在 /var/log/ 目录中（源码包安装的服务日志存放在源码包指定的目录中）。不过这些日志不是由 rsyslogd 服务来记录和管理的，而是各个服务使用自己的日志管理文档来记录自身的日志。以下介绍的日志目录在你的 Linux 上不一定存在，只有安装了相应的服务，日志才会出现。服务日志如表 2 所示。


| 日志文件        | 说明                                |
| --------------- | ----------------------------------- |
| /var/log/httpd/ | RPM包安装的apache取务的默认日志目录 |
| /var/log/mail/  | RPM包安装的邮件服务的额外日志因录   |
| /var/log/samba/ | RPM色安装的Samba服务的日志目录      |
| /var/log/sssd/  | 守护进程安全服务目录                |



#### 3.	Linux日志文件的格式分析

只要是由日志服务 rsyslogd 记录的日志文件，它们的格式就都是一样的。所以我们只要了解了日志文件的格式，就可以很轻松地看懂日志文件。

日志文件的格式包含以下 4 列：

- 事件产生的时间。
- 产生事件的服务器的主机名。
- 产生事件的服务名或程序名。
- 事件的具体信息。



实例1：

> 通过查看`/var/log/secure`日志来理解日志的格式

```
[root@localhost ~]# less -Nm /var/log/secure
Jun 5 03：20：46 localhost sshd[1630]：Accepted password for root from 192.168.0.104 port 4229 ssh2
\# 6月5日 03：20：46 本地主机 sshd服务产生消息：接收从192.168.0.104主机的4229端口发起的ssh连接的密码
Jun 5 03：20：46 localhost sshd[1630]：pam_unix(sshd：session)：session opened for user root by (uid=0)
\#时间 本地主机 sshd服务中pam_unix模块产生消息：打开用户root的会话（UID为0）
Jun 5 03：25：04 localhost useradd[1661]：new group：name=bb， GID=501
\#时间 本地主机 useradd命令产生消息：新建立bb组，GID为501
Jun 5 03：25：04 localhost useradd[1661]：new user：name=bb， UID=501， GID=501， home=/home/bb， shell=/bin/bash
Jun 5 03：25：09 localhost passwd：pam_unix(passwd：chauthtok)：password changed for bb
```

我截取了一段日志的内容，注释了其中的三句日志，剩余的两句日志大家可以看懂了吗？其实分析日志既是重要的系统维护工作，也是一项非常枯燥和烦琐的工作。如果我们的服务器出现了一些问题，比如系统不正常重启或关机、用户非正常登录、服务无法正常使用等，则都应该先查询日志。

实际上，只要感觉到服务器不是很正常就应该查看日志，甚至在服务器没有什么问题时也要养成定时查看系统日志的习惯。



#### 4.	Linux日志服务器设置

> 上面的`/etc/rsyslog.config`文件中日志的处理。不仅可以把日志输出到固定的文件，还可以把日志不保存，而是发送给指定的邮箱。

我们知道，使用“@IP：端口”或“@@IP：端口”的格式可以把日志发送到远程主机上，那么这么做有什么意义吗？

假设我需要管理几十台服务器，那么我每天的重要工作就是查看这些服务器的日志，可是每台服务器单独登录，并且查看日志非常烦琐，我可以把几十台服务器的日志集中到一台日志服务器上吗？这样我每天只要登录这台日志服务器，就可以查看所有服务器的日志，要方便得多。

如何实现日志服务器的功能呢？其实并不难，不过我们首先需要分清服务器端和客户端。假设服务器端的服务器 IP 地址是 192.168.0.210，主机名是 localhost.localdomain；客户端的服务器 IP 地址是 192.168.0.211，主机名是 www1。我们现在要做的是把 192.168.0.211 的日志保存在 192.168.0.210 这台服务器上。实验过程如下：

```
#服务器端设定（192.168.0.210）：
[root@localhost ~]# vi /etc/rsyslog.conf		//配置rsyslog.config文件
…省略部分输出…
# Provides TCP syslog reception					//文件中开启514端口，允许接收日志
$ModLoad imtcp
$InputTCPServerRun 514
#取消这两句话的注释，允许服务器使用TCP 514端口接收日志
…省略部分输出…
[root@localhost ~]# service rsyslog restart		//重启rsyslog服务
#重启rsyslog日志服务
[root@localhost ~]# netstat -tlun | grep 514
tcp 0 0 0.0.0.0：514 0.0.0.0：* LISTEN
#查看514端口已经打开

#客户端设置（192.168.0.211）：
[root@www1 ~]# vi /etc/rsyslog.conf
#修改日志服务配置文件
*.* @@192.168.0.210：514
#把所有日志采用TCP协议发送到192.168.0.210的514端口上
[root@www1 ~]# service rsyslog restart
#重启日志服务
```



这样日志服务器和客户端就搭建完成了，以后 192.168.0.211 这台客户机上所产生的所有日志都会记录到 192.168.0.210 上。比如：

```
#在客户机上(192.168.0.211)
[root@wwwl ~]# useradd zhangsan
#添加zhansan用户提示符的主机名是www1)
#在限务器(192.168.0.210)上
[root@localhost ~]# vi /var/log/secure
#査看服务器的secure日志(注意:主机名是localhost)
Aug 8 23:00:57 wwwl sshd【1408]: Server listening on 0.0.0.0 port 22.
Aug 8 23:00:57 wwwl sshd[1408]: Server listening on :: port 22.
Aug 8 23:01:58 wwwl sshd[1630]: Accepted password for root from 192.168.0.101 port 7036 ssh2
Aug 8 23:01:58 wwwl sshd[1630]: pam_unix(sshd:session): session opened for user root by (uid=0)
Aug 8 23:03:03 wwwl useradd[1654]: new group: name=zhangsan, GID-505
Aug 8 23:03:03 wwwl useradd[1654]: new user: name=zhangsan, UXD=505, GID=505,
home=/home/zhangsan, shell=/bin/bash
Aug 8 23:03:09 wwwl passwd: pam_unix(passwd:chauthtok): password changed for zhangsan
#注意：查看到的日志内容的主机名是www1，说明我们虽然查看的是服务器的日志文件，但是在其中可以看到客户机的日志内容
```

需要注意的是，日志服务是通过主机名来区别不同的服务器的。所以，如果我们配置了日志服务，则需要给所有的服务器分配不同的主机名。



#### 5.	日志轮替

> **日志轮替的最主要的工作就是把旧的日志文件删除，从而腾出空间保存新的日志文件。**这项工作如果靠管理员手工来完成，那其实是非常烦琐的，而且也容易忘记。那么 [Linux](http://c.biancheng.net/linux_tutorial/) 系统是否可以自动完成日志的轮替工作呢？
>
> logrotate 就是用来进行日志轮替（也叫日志转储）的，也就是把旧的日志文件移动并改名，同时创建一个新的空日志文件用来记录新日志，当旧日志文件超出保存的范围时就删除。



###### 日志文件的命令规则

日志轮替最主要的作用就是把旧的日志文件移动并改名，同时建立新的空日志文件，当旧日志文件超出保存的范围时就删除。那么，旧的日志文件改名之后，如何命名呢？主要依靠 /etc/logrotate.conf 配置文件中的“dateext”参数。

如果配置文件中有“dateext”参数，那么日志会用日期来作为日志文件的后缀，如“secure-20130605”。这样日志文件名不会重叠，也就不需要对日志文件进行改名，只需要保存指定的日志个数，删除多余的日志文件即可。

如果配置文件中没有“dateext”参数，那么日志文件就需要进行改名了。当第一次进行日志轮替时，当前的“secure”日志会自动改名为“secure.1”，然后新建“secure”日志，用来保存新的日志；当第二次进行日志轮替时，“secure.1”会自动改名为“secure.2”，当前的“secure”日志会自动改名为“secure.1”，然后也会新建“secure”日志，用来保存新的日志；以此类推。



###### logrotate配置文件

查看一下`/etc/logrotate`文件的内容。

```
[root@localhost ~]# vi /etc/logrotate.conf
#see "man logrotate" for details
#rotate log files weekly
weekly
#每周对日志文件进行一次轮替
#keep 4 weeks worth of backlogs rotate 4
#保存4个日志文件,也就是说,如果进行了5次日志轮替，就会删除第一个备份曰志
#create new (empty) log files after rotating old ones create
#在日志轮替时,自动创建新的日志文件
#use date as a suffix of the rotated file dateext
#使用日期作为日志轮替文件的后缀
#uncomment this if you want your log files compressed #compress
#日志文件是否压缩。如果取消注释,则日志会在转储的同时进行压缩
#以上日志配置为默认配置,如果需要轮替的日志没有设定独立的参数,那么都会遵循以上参数
#如果轮替曰志配置了独立参数,那么独立参数的优先级更高
#RPM packages drop log rotation information into this directory include /etc/logrotate.d
#包含/etc/logrotate.d/目录中所有的子配置文件。也就是说,会把这个目录中所有的子配置文件读取进来，进行日志轮替
#no packages own wtmp and btmp -- we'11 rotate them here
#以下两个轮替曰志有自己的独立参数，如果和默认的参数冲突，则独立参数生效
/var/log/wtmp {
#以下参数仅对此目录有效
monthly
#每月对日志文件进行一次轮替
create 0664 root utmp
#建立的新日志文件,权限是0664,所有者是root,所属组是utmp组
minsize 1M
#日志文件最小轮替大小是1MB。也就是日志一定要超过1MB才会轮替，否则就算时间达到一个月，也不进行曰志轮替
rotate 1
#仅保留一个曰志备份。也就是只保留wtmp和wtmp.1曰志)
/var/log/btmp {
#以下参数只对/var/log/btmp生效
missingok
#如果日志不存在,则忽略该日志的警告信患
monthly
create 0600 root utmp
rotate 1
}
# system-specific logs may be also be configured here.
```

在这个配置文件中，主要分为三部分：

- 第一部分是默认设置，如果需要转储的日志文件没有特殊配置，则遵循默认设置的参数；
- 第二部分是读取 /etc/logrotate.d/ 目录中的日志轮替的子配置文件，也就是说，在 /etc/logrotate.d/ 目录中的所有符合语法规则的子配置文件也会进行日志轮替；
- 第三部分是对 wtmp 和 btmp 日志文件的轮替进行设定，如果此设定和默认参数冲突，则当前设定生效（如 wtmp 的当前参数设定的轮替时间是每月，而默认参数的轮替时间是每周，则对 wtmp 这个日志文件来说，轮替时间是每月，当前的设定参数生效）。



logrotate 配置文件的主要参数如下表 所示。

| 参 致                   | 参数说明                                                     |
| ----------------------- | ------------------------------------------------------------ |
| daily                   | 日志的轮替周期是毎天                                         |
| weekly                  | 日志的轮替周期是每周                                         |
| monthly                 | 日志的轮控周期是每月                                         |
| rotate数宇              | 保留的日志文件的个数。0指没有备份                            |
| compress                | 当进行日志轮替时，对旧的日志进行压缩                         |
| create mode owner group | 建立新日志，同时指定新日志的权限与所有者和所属组.如create 0600 root utmp |
| mail address            | 当进行日志轮替时.输出内存通过邮件发送到指定的邮件地址        |
| missingok               | 如果日志不存在，则忽略该日志的警告信息                       |
| nolifempty              | 如果曰志为空文件，則不进行日志轮替                           |
| minsize 大小            | 日志轮替的最小值。也就是日志一定要达到这个最小值才会进行轮持，否则就算时间达到也不进行轮替 |
| size大小                | 日志只有大于指定大小才进行日志轮替，而不是按照时间轮替，如size 100k |
| dateext                 | 使用日期作为日志轮替文件的后缀，如secure-20130605            |
| sharedscripts           | 在此关键宇之后的脚本只执行一次                               |
| prerotate/cndscript     | 在曰志轮替之前执行脚本命令。endscript标识prerotate脚本结束   |
| postrolaie/endscripl    | 在日志轮替之后执行脚本命令。endscripi标识postrotate脚本结束  |

这些参数中较为难理解的应该是 prerotate/endscript 和 postrotate/endscript，我们利用“man logrotate”中的例子来解释一下这两个参数。例如：

```
"/var/log/httpd/access.log" /var/log/httpd/error.log {
#日志轮替的是/var/log/httpd/中RPM包默认安装的apache正确访问日志和错误日志
    rotate 5
    #轮替5次
    mail www@my.org
    #把信息发送到指定邮箱
    size 100k
    #日志大于100KB时才进行日志轮替,不再按照时间轮替
    sharedscripts
    #以下脚本只执行一次
    postrotate
    #在日志轮替结束之后,执行以下脚本
    /usr/bin/killall -HUP httpd
    #重启apache 服务
endscript
#脚本结束
}
```

prerotate 和 postrotate 主要用于在日志轮替的同时执行指定的脚本，一般用于日志轮替之后重启服务。这里强调一下，如果你的日志是写入 rsyslog 服务的配置文件的，那么把新日志加入 logrotate 后，一定要重启 rsyslog 服务，否则你会发现，虽然新日志建立了，但数据还是写入了旧的日志当中。那是因为虽然 logrotate 知道日志轮替了，但是 rsyslog 服务并不知道。

同理，如果采用源码包安装了 apache、Nginx 等服务，则需要重启 apache 或 Nginx 服务，同时还要重启 rsyslog 服务，否则日志也不能正常轮替。

不过，这里有一个典型应用就是给予特定的日志加入 chattr 的 a 属性。如果系统文件加入了 a 属性，那么这个文件就只能增加数据，而不能删除和修改已有的数据，root 用户也不例外。

因此，我们会给重要的日志文件加入 a 属性，这样就可以保护日志文件不被恶意修改。不过，一旦加入了 a 属性，那么在进行日志轮替时，这个日志文件是不能被改名的，当然也就不能进行日志轮替了。我们可以利用 prerotate 和 postrotate 参数来修改日志文件的 chattr 的 a 属性。



###### 把自己的日志加入日志轮替

如果有些日志默认没有加入日志轮替（比如源码包安装的服务的日志，或者自己添加的日志），那么这些日志默认是不会进行日志轮替的，这样当然不符合我们对日志的管理要求。如果需要把这些日志也加入日志轮替，那该如何操作呢？

这里有两种方法：

- 第一种方法是直接在 /etc/logrotate.conf 配置文件中写入该日志的轮替策略，从而把日志加入轮替；
- 第二种方法是在 /etc/logrotate.d/ 目录中新建立该日志的轮替文件，在该轮替文件中写入正确的轮替策略，因为该目录中的文件都会被包含到主配置文件中，所以也可以把日志加入轮替。


我们推荐第二种方法，因为系统中需要轮替的日志非常多，如果全部直接写入 /etc/logrotate.conf 配置文件，那么这个文件的可管理性就会非常差，不利于此文件的维护。

说起来很复杂，我们举个例子。还记得我们自己生成的 /var/log/alert.log 日志吗？这个日志不是系统默认日志，而是我们通过 /etc/rsyslog.conf 配置文件自己生成的日志，所以默认这个日志是不会进行轮替的。如果我们需要把这个日志加入日志轮替策略，那该怎么实现呢？我们采用第二种方法，也就是在 /etc/logrotate.d/ 目录中建立此日志的轮替文件。



命令如下：

```
[root@localhost ~]# chattr +a /var/log/alert.log #先给日志文件赋予chattr的a属性，保证日志的安全
[root@localhost ~]# vi /etc/logrotate.d/alter
#创建alter轮替文件,把/var/log/alert.log加入轮替
/var/log/alert.log {
    weekly
    #每周轮替一次
    rotate 6
    #保留6个轮替曰志
    sharedscripts
    #以下命令只执行一次
    prerotate
    #在日志轮替之前执行
        /usr/bin/chattr -a /var/log/alert.log
        #在日志轮替之前取消a属性,以便让日志可以轮替
    endscript
    #脚本结朿
    sharedscripts
    postrotate
    #在日志轮替之后执行
        /usr/bin/chattr +a /var/log/alert.log
        #在日志轮替之后,重新加入a属性
    endscript
    sharedscripts
    postrotate
    /bin/kill -HUP $(/bin/cat /var/run/syslogd.pid 2>/dev/null) fi>/dev/null
    endscript
    #重启rsyslog服务，保证日志轮替正常进行
}
```



#### 6.	logrotate日志轮替命令

> 此命令主要是：直接进行日志的轮替，而忽略`/etc/logrotate.conf`配置文件

日志轮替之所以可以在指定的时间备份日志，是因为其依赖系统定时任务。如果大家还记得 /etc/cron.daily/ 目录，就会发现这个目录中是有 logrotate 文件的，查看一下这个文件，命令如下：

```
[root@localhost ~]# vi /etc/cron.daily/logrotate
#！/bin/sh
/usr/sbin/logrotate /etc/logrotate.conf >/dev/null 2>&1
#最主要的就是执行了logrotate命令
EXITVALUE=$?
if [ $EXITVALUE！= 0 ]; then
/usr/bin/logger -t logrotate "ALERT exited abnormally with [$EXITVALUE]"
fi
exit 0
```

也就是说，系统每天都会执行 /etc/cron.daily/logrotate 文件，运行这个文件中的“/usr/sbin/logrotate/etc/logrotate.conf>/dev/null 2>&1”命令。logrotate 命令会依据 /etc/logrotate.conf 配置文件的配置，来判断配置文件中的日志是否符合日志轮替的条件（比如，日志备份时间已经满一周），如果符合，日志就会进行轮替。所以说，日志轮替还是由 crond 服务发起的。



`log rotate`命令，基本格式为：

```
[root@localhost ~]# logrotate [选项] 配置文件名
```

选项：

- 如果此命令没有选项，则会按照配置文件中的条件进行日志轮替
- -v：显示日志轮替过程。加入了-v选项，会显示日志的轮替过程
- -f： 强制进行日志轮替。不管日志轮替的条件是否符合，强制配置文件中所有的日志进行轮替



实例1：

> 简单使用`logrotate`命令

```
[root@localhost ~]# logrotate -fv /etc/lorotate.conf
```

> 此命令会直接的轮替日志。



#### 7.	Linux日志分析工具(logwatch)安装及使用

日志分析工具会详细地查看日志，同时分析这些日志，并且把分析的结果通过邮件的方式发送给 root 用户。这样，我们每天只要查看日志分析工具的邮件，就可以知道服务器的基本情况，而不用挨个检查日志了。这样系统管理员就可以从繁重的日常工作中解脱出来，去处理更加重要的工作。



此工具需要手工安装：

```
[root@localhsot ~]# yum -y  install logwatch
```

安装完成之后，需要手工生成 logwatch 的配置文件。默认配置文件是 /etc/logwatch/conf/logwatch.conf，不过这个配置文件是空的，需要把模板配置文件复制过来。命令如下：

```
[root@localhost ~]# cp /usr/share/logwatch/default.conf/logwatch.conf /etc/logwatch/conf/logwatch.conf
#复制配置文件
```

> 不过貌似CentOS--7之后的就不用复制了



这个配置文件的内容中绝大多数是注释，我们把注释去掉，那么这个配置文件的内容如下所示：

```
[root@localhost ~]# vi /etc/logwatch/conf/logwatch.conf
#查看配置文件
LogDir = /var/log
#logwatch会分析和统计/var/log/中的日志
TmpDir = /var/cache/logwatch
#指定logwatch的临时目录
MailTo = root
#日志的分析结果，给root用户发送邮件
MailFrom = Logwatch
#邮件的发送者是Logwatch，在接收邮件时显示
Print =
#是否打印。如果选择“yes”，那么日志分析会被打印到标准输出，而且不会发送邮件。我们在这里不打印，#而是给root用户发送邮件
#Save = /tmp/logwatch
#如果开启这一项，日志分析就不会发送邮件，而是保存在/tmp/logwatch文件中
#如果开启这一项，日志分析就不会发送邮件，而是保存在/tmp/logwatch文件中
Range = yesterday
#分析哪天的日志。可以识别“All”“Today”“Yesterday”，用来分析“所有日志”“今天日志”“昨天日志”
Detail = Low
#日志的详细程度。可以识别“Low”“Med”“High”。也可以用数字表示，范围为0～10，“0”代表最不详细，“10”代表最详细
Service = All
#分析和监控所有日志
Service = "-zz-network"
#但是不监控“-zz-network”服务的日志。“-服务名”表示不分析和监控此服务的日志
Service = "-zz-sys"
Service = "-eximstats"
```

> ，logwatch 一旦安装，就会在 /etc/cron.daily/ 目录中建立“0logwatch”文件，用于在每天定时执行 logwatch 命令，分析和监控相关日志。



如果想要让这个日志分析马上执行，则只需执行 logrotate 命令即可。命令如下：

```
[root@localhost ~]# logwatch
#马上执行logwatch日志分析工具
[root01ocalhost ~]# mail
#查看邮件
Heirloom Mail version 12.4 7/29/08. Type ? for help, "/var/spool/mail/root": 5 messages 1 new 2 unread
1 logwatch@localhost.1 Fri Jun 7 11:17 42/1482 "Logwatch for localhost.localdomain ([Linux](http://c.biancheng.net/linux_tutorial/))"
U 2 logwatch@localhost.1 Fri Jun 7 11:19 42/1481 "Logwatch for localhost.localdomain (Linux)"
3 logwatch@localhost.1 Fri Jun 7 11:23 1234/70928 "Logwatch for localhost.localdomain (Linux)"
4 logwatch@localhost.1 Fri Jun 7 11:24 190/5070 "Logwatch for localhost.localdomain (Linux)"
5 logwatch@localhost.1 Fri Jun 7 11:55 41/1471 "Logwatch for localhost.localdomain (Linux)"
>N 6 logwatch@localhost.1 Fri Jun 7 11:57 189/5059 "Logwatch for localhost.localdomain (Linux)"
#第6封邮件就是刚刚生成的曰志分析邮件，"N"代表没有查看
& 6
Message 6:
From root@localhost.localdomain Fri Jun 7 11:57:35 2013 Return-Path: <root@localhost.localdomain>
X-Original-To: root
Delivered-To: root@localhost.localdomain
To: root@localhost.localdomain
From: logwatch@localhost.localdomain
Subject: Logwatch for localhost.localdomain (Linux)
Content-Type: text/plain; charset="iso-8859-1"
Date: Fri, 7 Jun 2013 11:57:33 +0800 (CST)
Status: R
######## Logwatch 7.3.6 (05/19/07) ################
Processing Initiated: Fri Jun 7 11:57:33 2013
Date Range Processed: all
Detail Level of Output: 0
Type of Output: unformatted
Logfiles for Host: localhost.localdomain
###################################################
#上面是曰志分析的时间和日期
...省略部分输出...
--------- Connections (secure-log) Begin-----------
#分析secure.log日志的内容。统计新建立了哪些用户和组，以及错误登录信息 New Users：
  bb (501)
  def (503)
  hjk (504)
  zhangsan (505)
  dovecot (97)
  dovenull (498)
  aa (500)

New Groups:
  bb (501)
  def (503)
  hjk (504)
  zhangsan (505)
  dovecot (97)
  dovenull (498)
  aa (500)

Failed logins:
  User root:
  (null): 3 Time(s)

Root logins on tty's: 7 Time(s).

**Unmatched Entries**
groupadd: group added to /etc/group: name=dovecot, GID=97: 1 Time(s)
groupadd: group added to /etc/group: name=dovenul1, GID=498: 1 Time(s)
groupadd: group added to /etc/gshadow: name=dovecot: 1 Time(s)groupadd: group added to /etc/gshadow: name=dovenull: 1 Time(s)
--------Connections (secure-log)End-------
-------------SSHD Begin-------------------
#分析SSHD的日志。可以知道哪些IP地址连接过服务器
SSHD Killed: 7 Time(s)
SSHD Started: 24 Time(s)
Users logging in through sshd:
192.168.0.104: 10 times
192.168.0.108: 8 times
192.168.0.101: 6 times
192.168.0.126: 4 times
192.168.0.100: 3 times
192.168.0.105: 3 times
192.168.0.106: 2 times
192.168.0.102: 1 time
192.168.0.103: 1 time
SFTP subsystem requests: 3. Time(s)
**Unmatched Entries**
Exiting on signal 15 : 6 time(s)
----------------SSHD End-----------

--------------- yum Begin ---------
#统计yum安装的软件。可以知道我们安装了哪些软件

Packages Installed:
  perl-YAML-Syck-1.07-4.el6.i686
  perl-Date-Manip-6.24-1.el6.noarch
  logwatch-7.3.6-49.el6.noarch
-----------yum End-------------

--------Disk Space Begin-------
#统计磁盘空间情况
Filesystem Size Used Avail Use% Mounted on
/dev/sda3 20G 1.9G 17G 11% /
/dev/sda1 194M 26M 158M 15% /boot
/dev/sr0 3.5G 3.5G 0 100% /mnt/cdrom
---------Disk Space End-----------------
#########Logwatch End ##################
```



### 2.	文件目录



#### 1.	一些日志文件路径

| 日志文件          | 说 明                                                        |
| ----------------- | ------------------------------------------------------------ |
| /var/log/cron     | 记录与系统定时任务相关的曰志                                 |
| /var/log/cups/    | 记录打印信息的曰志                                           |
| /var/log/dmesg    | 记录了系统在开机时内核自检的信总。也可以使用dmesg命令直接查看内核自检信息 |
| /var/log/btmp     | 记录错误登陆的日志。这个文件是二进制文件，不能直接用Vi查看，而要使用lastb命令查看。命令如下： [root@localhost log]#lastb root tty1 Tue Jun 4 22:38 - 22:38 (00:00) #有人在6月4 日 22:38便用root用户在本地终端 1 登陆错误 |
| /var/log/lasllog  | 记录系统中所有用户最后一次的登录时间的曰志。这个文件也是二进制文件.不能直接用Vi 查看。而要使用lastlog命令查看 |
| /var/Iog/mailog   | 记录邮件信息的曰志                                           |
| /var/log/messages | 它是核心系统日志文件，其中包含了系统启动时的引导信息，以及系统运行时的其他状态消息。I/O 错误、网络错误和其他系统错误都会记录到此文件中。其他信息，比如某个人的身份切换为 root，已经用户自定义安装软件的日志，也会在这里列出。 |
| /var/log/secure   | 记录验证和授权方面的倍息，只要涉及账户和密码的程序都会记录，比如系统的登录、ssh的登录、su切换用户，sudo授权，甚至添加用户和修改用户密码都会记录在这个日志文件中 |
| /var/log/wtmp     | 永久记录所有用户的登陆、注销信息，同时记录系统的后动、重启、关机事件。同样，这个文件也是二进制文件.不能直接用Vi查看，而要使用last命令查看 |
| /var/tun/ulmp     | 记录当前已经登录的用户的信息。这个文件会随着用户的登录和注销而不断变化，只记录当前登录用户的信息。同样，这个文件不能直接用Vi查看，而要使用w、who、users等命令查看 |



#### 2.	/etc/rsyslog.conf

> 此目录主要用于配置：哪个服务的什么等级的日志信息会被记录在哪个位置的。也就是说，日志服务的配置文件中主要定义了服务的名称、日志等级和日志记录位置。

此配置文件的基本格式如下所示：

```
authpriv.* /var/log/secure
#服务名称[连接符号]日志等级 日志记录位置
#认证相关服务.所有日志等级 记录在/var/log/secure日志中
```



###### 服务名称

我们首先需要确定 rsyslogd 服务可以识别哪些服务的日志，也可以理解为以下这些服务委托 rsyslogd 服务来代为管理日志。这些服务如下表 所示。

| 服务名称                     | 说 明                                                        |
| ---------------------------- | ------------------------------------------------------------ |
| auth(LOG AUTH)               | 安全和认证相关消息 (不推荐使用authpriv替代）                 |
| authpriv(LOG_AUTHPRIV)       | 安全和认证相关消息（私有的）                                 |
| cron (LOG_CRON)              | 系统定时任务cront和at产生的日志                              |
| daemon (LOG_DAEMON)          | 与各个守护进程相关的曰志                                     |
| ftp (LOG_FTP)                | ftp守护进程产生的曰志                                        |
| kern(LOG_KERN)               | 内核产生的曰志（不是用户进程产生的）                         |
| Iocal0-local7 (LOG_LOCAL0-7) | 为本地使用预留的服务                                         |
| lpr (LOG_LPR)                | 打印产生的日志                                               |
| mail (LOG_MAIL)              | 邮件收发信息                                                 |
| news (LOG_NEWS)              | 与新闻服务器相关的日志                                       |
| syslog (LOG_SYSLOG)          | 存syslogd服务产生的曰志信息（虽然服务名称己经改为reyslogd，但是很多配罝依然沿用了 syslogd服务的，所以这里并没有修改服务名称） |
| user (LOG_USER)              | 用户等级类别的日志信息                                       |
| uucp (LOG_UUCP>              | uucp子系统的日志信息，uucp是早期[Linux](http://c.biancheng.net/linux_tutorial/)系统进行数据传递的协议，后来 也常用在新闻组服务中 |



###### 连接符号

日志服务连接日志等级的格式如下：

日志服务[连接符号]日志等级 日志记录位置

在这里，连接符号可以被识别为以下三种。

1. “.”代表只要比后面的等级高的（包含该等级）日志都记录。比如，“cron.info”代表cron服务产生的日志，只要日志等级大于等于info级别，就记录。
2. “.=”代表只记录所需等级的日志，其他等级的日志都不记录。比如，“*.=emerg”代表人和日志服务产生的日志，只要等级是emerg等级，就记录。这种用法极少见，了解就好。
3. “.！”代表不等于，也就是除该等级的日志外，其他等级的日志都记录。





###### 日志等级

每个日志的重要性都是有差别的，比如，有些日志只是系统的一个日常提醒，看不看根本不会对系统的运行产生影响；但是有些日志就是系统和服务的警告甚至报错信息，这些日志如果不处理，就会威胁系统的稳定或安全。如果把这些日志全部写入一个文件，那么很有可能因为管理员的大意而忽略重要信息。

比如，我们在工作中需要处理大量的邮件，笔者每天可能会接收到200多封邮件。而这些邮件中的绝大多数是不需要处理的普通信息邮件，甚至是垃圾邮件。所以笔者每天都要先把这些大量的非重要邮件删除之后，才能找到真正需要处理的邮件。但是每封邮件的标题都差不多，有时会误删除需要处理的邮件。这时笔者就非常怀念Linux的日志等级，如果邮件也能标识重要等级，就不会误删除或漏处理重要邮件了。

邮件的等级信息也可以使用“man 3 syslog”命令来查看。日志等级如表 2 所示，我们按照严重等级从低到高排列。



| 等级名称             | 说 明                                                        |
| -------------------- | ------------------------------------------------------------ |
| debug (LOG_DEBUG)    | 一般的调试信息说明                                           |
| info (LOG_INFO)      | 基本的通知信息                                               |
| nolice (LOG_NOTICE)  | 普通信息，但是有一定的重要性                                 |
| warning(LOG_WARNING) | 警吿信息，但是还不会影响到服务或系统的运行                   |
| err(LOG_ERR)         | 错误信息, 一般达到err等级的信息已经可以影响到服务成系统的运行了 |
| crit (LOG_CRIT)      | 临界状况信思，比err等级还要严®                               |
| alert (LOG_ALERT)    | 状态信息，比crit等级还要严重，必须立即采取行动               |
| emerg (LOG_EMERG)    | 疼痛等级信息，系统已经无法使用了                             |
| *                    | 代表所有日志等级。比如，“authpriv.*”代表amhpriv认证信息服务产生的日志，所有的日志等级都记录 |



###### 日志记录位置



日志记录位置就是当前日志输出到哪个日志文件中保存，当然也可以把日志输出到打印机打印，或者输出到远程日志服务器上（当然，远程日志服务器要允许接收才行）。日志的记录位置也是固定的：

- 日志文件的绝对路径。这是最常见的日志保存方法，如“/var/log/secure”就是用来保存系统验证和授权信息日志的。
- 系统设备文件。如“/dev/lp0”代表第一台打印机，如果日志保存位置是打印机设备，当有日志时就会在打印机上打印。
- 转发给远程主机。因为可以选择使用 TCP 和 UDP 协议传输日志信息，所以有两种发送格式：如果使用“@192.168.0.210：514”，就会把日志内容使用 UDP 协议发送到192.168.0.210 的 UDP 514 端口上；如果使用“@@192.168.0.210：514”，就会把日志内容使用 TCP 协议发送到 192.168.0.210 的 TCP 514 端口上，其中 514 是日志服务默认端口。当然，只要 192.168.0.210 同意接收此日志，就可以把日志内容保存在日志服务器上。
- 用户名。如果是“root”，就会把日志发送给 root 用户，当然 root 要在线，否则就收不到日志信息了。发送日志给用户时，可以使用“*”代表发送给所有在线用户，如“mail.**”就会把 mail 服务产生的所有级别的日志发送给所有在线用户。如果需要把日志发送给多个在线用户，则用户名之间用“，”分隔。
- 忽略或丢弃日志。如果接收日志的对象是“~”，则代表这个日志不会被记录，而被直接丢弃。如“local3.* ~”代表忽略 local3 服务类型所有的日志都不记录。



###### /etc/rsyslog.config内容

查看一下此文件的具体内容

```
[root@localhost ~]# vi /etc/rsyslog.conf
#查看配置文件的内容
#rsyslog v5 configuration file
# For more information see /usr/share/doc/rsyslog-*/rsyslog_conf.html
# If you experience problems, see http://www.rsyslog.com/doc/troubleshoot.html
*### MODULES ###
#加载棋块
$ModLoad imuxsock # provides support for local system logging (e.g. via logger command)
#加载imixsock模块，为本地系统登录提供支持
$ModLoad imklog # provides kernel logging support (previously done by rklogd)
#加载imklog模块，为内核登录提供支持
#$ModLoad immark # provides --MARK-- message capability
#加载immark模块，提供标记信息的能力
# Provides UDP syslog reception
#$ModLoad imudp
#SUDPServerRun 514
#加载UPD模块，允许使用UDP的514端口接收采用UDP协议转发的日志
# Provides TCP syslog reception
#$ModLoad imtcp
#$InputTCPServerRun 514
#加栽TCP摸块,允许使用TCP的514编口接收采用TCP协议转发的日志
#### GLOBAL DIRECTIVES ####
#定义全局设置
#Use default timestamp format
#ActionFileDefaultTemplate RSYSLOG_TraditionalFileFormat #定义曰志的时间使用默认的时间戳格式
#File syncing capability is disabled by default. This feature is usually not required,
#not useful and an extreme performance hit
#$ActionFileEnableSync on
#文件同步功能。默认没有开启,是注释的
#Include all config files in /etc/rsyslog.d/
$IncludeConfig /etc/rsyslog.d/*.conf
#包含/etx/rsyslog.d/目录中所有的".conf"子配置文件。也就是说，这个目录中的所有子配置文件也同时生效
#### RULES ####
#日志文件保存规则
#Log all kernel messages to the console.
#Logging much else clutters up the screen.
#kern.* /dev/console
#kern服务.所有曰志级别 保存在/dev/console
#这个日志默认没有开启,如果需要，则取消注释
#Log anything (except mail) of level info or higher.
#Don't log private authentication messages!
*.info;mail.none;authpriv.none;cron.none /var/log/messages
#所有服务.info以上级到的日志保存在/var/log/messages日志文件中
#mail, authpriv^ cron的B志不记录在/var/log/messages曰志文件中，因为它们部有自己的曰志文件
#所以/var/log/messages日志是最重要的系统日志文件，需要经常查看
#The authpriv file has restricted access.
authpriv.* /var/log/secure
#用户认证服务所有级别的日志保存在/vai/1og/secure日志文件中
#Log all the mail messages in one place.
mail.* -/var/log/maillog
#mail服务的所有级别的日志保存在/var/log/maillog 日志文件中
#"-"的含义是日志先在内存中保存.当曰志足够多之后.再向文件中保存
# Log cron stuff
cron.* /var/log/cron
#计対任务的所有日志保存在/var/log/cron日志文件中
# Everybody gets emergency messages
#所有日志服务的疼痛等级日志对所有在线用户广播
#Save news errors of level crit and higher in a special file. uucp,news.crit /var/log/spooler
#uucp和news曰志服务的crit以上级别的日志保存在/var/log/sppoler曰志文件中
#Save boot messages also to boot.log
local7.* /var/log/boot.log
#loacl7 日志服务的所有日志写入/var/log/boot.log 日志文件中 #会把开机时的检测信息在显示到屏幕的同时写入/var/log/boot.log 日志文件中
# ### begin forwarding rule ###
#定义转发规到
#The statement between the begin ... end define a SINGLE forwarding
#rule. They belong together, do NOT split them. If you create multiple
# forwarding rules, duplicate the whole block!
# Remote Logging (we use TCP for reliable delivery)
#
# An on-disk queue is created for this action. If the remote host is
# down, messages are spooled to disk and sent when it is up again. #SWorkDirectory /var/lib/rsyslog # where to place spool files #$ActionQueueFileName fwdRulel # unique name prefix for spool files
#$ActionQueueMaxDiskSpace 1g # 1gb space limit (use as much as possible)
#$ActionQueueSaveOnShutdown on # save messages to disk on shutdown
#$ActionQueueType LinkedList t run asynchronously
#$ActionResumeRetryCount -1 # infinite retries if host is down
# remote host is: name/ip:port, e.g. 192.168.0.1:514, port optional #*•* @6remote-host:514
# ### end of the forwarding rule ##
```

> 其实系统已经非常完善地定义了这个配置文件的内容，系统中重要的日志也已经记录得非常完备。如果是外来的服务，如 apache、Samba 等服务，那么这些服务的配置文件中也详细定义了日志的记录格式和记录方法。所以，日志的配置文件基本上不需要我们修改，我们要做的仅仅是查看和分析系统记录好的日志而已。



#### 3.	/etc/logrotate.conf

> 此文件是用来进行日志轮替的文件。(ps.轮替的意思就是：把旧的日志文件移动并改名，同时创建一个新的空日志文件用来记录新日志，当旧日志文件超出保存的范围时就删除。)

此文件的详细内容在`概念`-->日志轮替-->logrotate配置文件

这里就不做过多描述了



#### 4.	/etc/logrotate.d/

> 此目录被上面的`/etc/logrotate`文件包含在内。所以此目录中文件的效果和`/etc/logrotate`文件是一样的都是进行日志的轮替，也遵循`/etc/logrotate`的格式规则。
>
> 一般除了系统目录外，要新建日志的目录，就需要对新的日志目录进行轮替。这种情况的话可以在`/etc/logrotate`文件中建立轮替规则，不过最好在`/etc/logrotate.d/`目录下新建文件来建立日志目录的轮替规则







### 3.	命令



#### 1.	logrotate



> 此命令主要是：直接进行日志的轮替，而忽略`/etc/logrotate.conf`配置文件

日志轮替之所以可以在指定的时间备份日志，是因为其依赖系统定时任务。如果大家还记得 /etc/cron.daily/ 目录，就会发现这个目录中是有 logrotate 文件的，查看一下这个文件，命令如下：

```
[root@localhost ~]# vi /etc/cron.daily/logrotate
#！/bin/sh
/usr/sbin/logrotate /etc/logrotate.conf >/dev/null 2>&1
#最主要的就是执行了logrotate命令
EXITVALUE=$?
if [ $EXITVALUE！= 0 ]; then
/usr/bin/logger -t logrotate "ALERT exited abnormally with [$EXITVALUE]"
fi
exit 0
```

也就是说，系统每天都会执行 /etc/cron.daily/logrotate 文件，运行这个文件中的“/usr/sbin/logrotate/etc/logrotate.conf>/dev/null 2>&1”命令。logrotate 命令会依据 /etc/logrotate.conf 配置文件的配置，来判断配置文件中的日志是否符合日志轮替的条件（比如，日志备份时间已经满一周），如果符合，日志就会进行轮替。所以说，日志轮替还是由 crond 服务发起的。



`log rotate`命令，基本格式为：

```
[root@localhost ~]# logrotate [选项] 配置文件名
```

选项：

- 如果此命令没有选项，则会按照配置文件中的条件进行日志轮替
- -v：显示日志轮替过程。加入了-v选项，会显示日志的轮替过程
- -f： 强制进行日志轮替。不管日志轮替的条件是否符合，强制配置文件中所有的日志进行轮替



实例1：

> 简单使用`logrotate`命令

```
[root@localhost ~]# logrotate -fv /etc/lorotate.conf
```

> 此命令会直接的轮替日志。