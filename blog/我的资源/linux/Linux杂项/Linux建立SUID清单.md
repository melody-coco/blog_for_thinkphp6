<center>Linux中建立一个SUID清单来防止黑客对SUID的恶意篡改</center>

> 此处只是小点，有需要的话，还是建议弄一下[原链接](http://www.beylze.com/news/30553.html)

# 不要轻易设置SetUID（SUID）权限，否则会带来重大安全隐患！



SetUID权限设置不当，会给 [linux](http://www.beylze.com/linuxjiaocheng/) 系统造成重大安全隐患。

前面的例子中，我们试验了将 passwd 命令取消 SUID 权限，这会导致 passwd 命令的功能失效。那么，如果我们手动给默认无 SetUID 权限的系统命令赋予 SetUID 权限，会出现什么情况呢？

比如说，我们尝试给 Vim 赋予 SetUID 权限：

```
[root@localhost ~]# chmod u+s /usr/bin/vim
[root@localhost ~]# ll /usr/bin/vim
-rwsr-xr-x. 1 root root 1847752 Apr 5 2012 /usr/bin/vim
```

此时你会发现，即便是普通用户使用 vim 命令，都会暂时获得 root 的身份和权限，例如，很多原本普通用户不能查看和修改的文件，竟然可以查看了，以 /etc/passwd 和 /etc/shadow 文件为例，普通用户也可以将自己的 UID 手动修改为 0，这意味着，此用户升级成为了超级用户。除此之外，普通用户还可以修改例如 /etc/inittab 和 /etc/fstab 这样重要的系统文件，可以轻易地使系统瘫痪。

其实，任何只有管理员可以执行的命令，如果被赋予了 SetUID 权限，那么后果都是灾难性的。普通用户可以随时重启服务器、随时关闭看得不顺眼的服务、随时添加其他普通用户的服务器，可以想象是什么样子。所以，SetUID 权限不能随便设置。

有读者可能会问，如何防止他人（例如黑客）对 SetUID 权限的恶意篡改呢？这里，给大家提供以下几点建议：

1. 关键目录要严格控制写权限，比如 "/"、"/usr" 等。
2. 用户的密码设置要严格遵守密码规范。
3. 对系统中默认应该有 SetUID 权限的文件制作一张列表，定时检査有没有列表之外的文件被设置了 SetUID 权限。


前面 2 点不再做过多解释，这里就最后一点，给大家提供一个脚本，仅供参考。

首先，在服务器第一次安装完成后，马上查找系统中所有拥有 SetUID 和 SetGID 权限的文件，把它们记录下来，作为扫描的参考模板。如果某次扫描的结果和本次保存下来的模板不一致，就说明有文件被修改了 SetUID 和 SetGID 权限。命令如下：

```
[root@localhost ~]# find / -perm -4000 -o -perm -2000 > /root/suid.list
\#-perm安装权限査找。-4000对应的是SetUID权限，-2000对应的是SetGID权限
\#-o是逻辑或"or"的意思。并把命令搜索的结果放在/root/suid.list文件中
接下来，只要定时扫描系统，然后和模板文件比对就可以了。脚本如下：
[root@localhost ~]#vi suidcheck.sh
\#!/bin/bash
find / -perm -4000 -o -perm -2000 > /tmp/setuid.check
\#搜索系统中所有拥有SetUID和SetGID权限的文件，并保存到临时目录中
for i in $(cat /tmp/setuid.check)
\#循环，每次循环都取出临时文件中的文件名
do
  grep $i /root/suid.list > /dev/null
  \#比对这个文件名是否在模板文件中
  if ["$?"!="o"]
  \#检测测上一条命令的返回值，如果不为0，则证明上一条命令报错
  then
    echo "$i isn't in listfile! " >>/root/suid_log_$(date +%F)
    \#如果文件名不在模板文件中，则输出错误信息，并把报错写入日志中
  fi
done
rm -rf/tmp/setuid.check
\#删除临时文件
[root@localhost ~]# chmod u+s /bin/vi
\#手工给vi加入SetUID权限
[root@localhost ~]# ./suidcheck.sh
\#执行检测脚本
[root@localhost ~]# cat suid_log_2013-01-20
/bin/vi isn't in listfile!
\#报错了，vi不在模板文件中。代表vi被修改了SetUID权限
```

这个脚本成功的关键在于模板文件是否正常。所以一定要安装完系统就马上建立模板文件，并保证模板文件的安全。

注意，除非特殊情况，否则不要手工修改 SetUID 和 SetGID 权限，这样做非常不安全。而且就算我们做实验修改了 SetUID 和 SetGID 权限，也要马上修改回来，以免造成安全隐患。