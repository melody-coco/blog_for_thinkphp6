<center>Linux中的权限管理</center>
> 此篇中重要的东西都在理论当中

### 一，理论



#### 1.	Linux权限位

`Linux`系统中常见的文件权限操作有3中，即读(r)，写(w)，执行(x)，在`Linux`系统中每个文件都明确规定了不同身份用户的访问权限，通过`ls`命令即可看到。

```
除此之外，我们有时会看到s（针对可执行文件或目录，使文件在执行阶段，临时拥有文件所有者的权限）和t（针对目录，）
```



例如，我们以`root`的身份登录`Linux`，并执行如下命令：

```
[root@localhost ~]# ls -al
total 156
drwxr-x---.   4 root root 4096   Sep  8 14:06 .
drwxr-xr-x.  23 root root 4096   Sep  8 14:21 ..
-rw-------.   1 root root 1474 Sep  4 18:27 anaconda-ks.cfg
-rw-------.   1 root root 199   Sep  8 17:14 .bash_history
-rw-r--r--.   1 root root 24   Jan  6  2007 .bash_logout
...
```

可以看到，每行的第一列表示的就是各文件针对不同用户设定的权限，一共11位，但第1位用于表示文件的具体类型，最后一位此文件受`SELinux`的安全规则管理，这里暂且不做研究。



因此，为文件设定不同用户的读，写和执行权限，仅涉及到9位字符，以`ls`命令输出信息中的`.bash_logout`为例，设定不同用户的访问权限是`re-r--r--`，各权限位的含义如下

![介绍Linux文件的权限位](http://c.biancheng.net/uploads/allimg/190417/2-1Z41G11439421.gif)

从图中可以看到，Linux将访问文件的用户分为3类，分别是文件的所有者，所属组以及其他人。

很显然，Linux系统为3中不同的用户身份，分别规定了是否对文件具有读，写和执行权限。举例拿上图来说，文件所有者拥有对文件的读和写权限，但是没有执行权限；所属组中的用户只拥有读权限，也就是说所属组的用户只能读取文件内容，无法修改文件，其他人也是只能读取文件。



#### 2.	Linux读写执行权限(-r,-w,-x)的真正含义是什么？

> 此处讲一讲读(r)，写(w)，执行(x)权限到底指的是什么呢



##### rwx 权限对文件的作用

> 文件，是系统中用来储存数据的，包括普通的文本文件，数据库文件，二进制可执行文件等等。不同的权限对文件的含义如下表所示

| rwx 权限      | 对文件的作用                                                 |
| ------------- | ------------------------------------------------------------ |
| 读权限（r）   | 表示可读取此文件中的实际内容，例如，可以对文件执行 cat、more、less、head、tail 等文件查看命令。 |
| 写权限（w）   | 表示可以编辑、新增或者修改文件中的内容，例如，可以对文件执行 vim、echo 等修改文件数据的命令。注意，无权限不赋予用户删除文件的权利，除非用户对文件的上级目录拥有写权限才可以。 |
| 执行权限（x） | 表示该文件具有被系统执行的权限。Window系统中查看一个文件是否为可执行文件，是通过扩展名（.exe、.bat 等），但在 [linux](http://www.beylze.com/linuxjiaocheng/) 系统中，文件是否能被执行，是通过看此文件是否具有 x 权限来决定的。也就是说，只要文件拥有 x 权限，则此文件就是可执行文件。但是，文件到底能够正确运行，还要看文件中的代码是否正确 |

> 对文件来说，执行权限是最高权限。给用户或群组设定权限时，是否赋予执行权限需要慎重考虑，否则会对系统安装造成严重影响



##### rwx 权限对目录的作用

> 目录，主要用来记录文件名列表，不同的权限对目录的作用如表2所示。

| rwx 权限      | 对目录的作用                                                 |
| ------------- | ------------------------------------------------------------ |
| 读权限（r）   | 表示具有读取目录结构列表的权限，也就是说，可以看到目录中有哪些文件和子目录。一旦对目录拥有 r 权限，就可以在此目录下执行 ls 命令，查看目录中的内容。 |
| 写权限（w）   | 对于目录来说，w 权限是最高权限。对目录拥有 w 权限，表示可以对目录做以下操作：在此目录中建立新的文件或子目录；删除已存在的文件和目录（无论子文件或子目录的权限是怎样的）；对已存在的文件或目录做更名操作；移动此目录下的文件和目录的位置。一旦对目录拥有 w 权限，就可以在目录下执行 touch、rm、cp、mv 等命令。 |
| 执行权限（x） | 目录是不能直接运行的，对目录赋予 x 权限，代表用户可以进入目录，也就是说，赋予 x 权限的用户或群组可以使用 cd 命令。 |

> 对目录来说，如果只赋予`r`权限，则此目录是无法使用的。因为只能使用`ls`命令看目录结构，而不能使用`cd`命令进入目录
>
> 因此，对于目录来说，常用来设定目录的权限其实只有 0（---）、5（r-x）、7（rwx）这 3 种。



实例1：

> 某目录的权限如下

```
drwxr--r--.  3  root  root  4096  Jun 25 08:35   .ssh
```

问：系统中有个账号名称为`vbird`，此账户不在`root`群组中，请问`vbird`对这个目录有何权限？是否能切换到此目录中？

```
答：vbird对此目录只有r权限，因此vbird可以查看此目录下的文件名列表，但是因为vbird对此目录不具有x权限，因此vbird不能切换到此目录中
```



实例2：

> 假设有个账号名称为`jack`，他的家目录在`/home/jack`，jack对他的家目录具有rwx权限，若在此目录下有个名为`test`的文件，该文件的权限如下：

```
-rwx------. 1 root  root  4365 Sep 19 23:20  test
```

> 试问jack对此文件的权限如何，能否删除此文件。

```
答：由于jack对此文件是其他人的身份，所以此文件它无法读，无法写，无法执行。但是由于这个文件在他的家目录下，他对他的家目录具有[rwx]权限，所以他可以删除这个test文件。
```





#### 3.	umask默认权限值

Linux通过使用`umask`默认权限来给所有新建的文件和目录赋予初始权限的。

> 通过umask命令既可以知道默认权限的值
>
> ```
> [root@localhost ~]# umask 
> 0022
> ```
>
> 这里出来的是个4位数，这里只讲后3位数，第一位数表示的是文件所具有的特殊权限(SetUID,SetGID,Sticky BIT)，这个放在后面讲



注意，虽然`umask`默认权限是用来设定文件或目录的初始权限，但并不是直接将`umask`默认权限作为文件或目录的初始权限，还要对其进行“再加工”



##### umask 默认权限

文件和目录的真正初始权限，可通过以下的计算得到：

```
文件（或目录）的初始权限 = 文件（或目录）的最大默认权限 - umask权限
```



文件和目录的最大默认权限是不一样的。

+ 文件：对文件来讲，最大默认权限是`666`,即`rw-rw-rw-`，也就是说任何用户都没有执行权限。因为执行权限是最高权限，需要慎重处理。只能通过用户手工赋予

+ 目录：目录的最大默认权限为`777`



实例1：

> 文件的最大默认权限为`666`，换算成字母就是`rw-rw-rw`。`umask`值为`022`，换算成字母为`----w--w-`。把两个字母权限相减，得到`rw-r--r--`。

```
[root@localhost ~]# umask
0022
[root@localhost ~]# touch test
[root@localhost ~]# ll -al a test
-rw-r--r--. 1 root root 0 Apr 18 02:36 test
```



实例2：

> 目录的最大默认权限为`777`，换算成字母就是`drwxrwxrwx`，`umask`的值为022，也就是`----w--w-`，把两个权限值相减得到`rwxr-xr-x`。

```
[root@localhost ~]# umask
0022
[root@localhost ~]# mkdir test
[root@localhsot ~]# ll -al test
drwxr-xr-x. 2 root root 4096 Apr 18 02:36 test
```



实例3

> 在计算文件或目录的初始权限是，不能直接使用最大默认权限和 umask 权限的数字形式做减。例如，若 umask 默认权限的值为 033，按照数字形式计算文件的初始权限，666-033=633，但我们按照字母的形式计算会得到 （rw-rw-rw-) - (----wx-wx) = (rw-r--r--)，换算成数字形式是 644。





##### umask默认权限值得修改方法

修改方法有两种

+ 简单的修改环境变量中的`umask`值，系统重启就会失效

```
[root@localhost ~]# umask 
0022
[root@localhost ~]# umask 033
[root@localhost ~]# umask 
0033
```



+ 修改对应的环境变量配置文件`/etc/profile`

```
[root@localhost ~]# vim /etc/profile
...省略部分内容...
if [ $UID -gt 199]&&[ "'id -gn'" = "'id -un'" ]; then
    umask 002
    #如果UID大于199（普通用户），则使用此umask值
else
    umask 022
    #如果UID小于199（超级用户），则使用此umask值
fi
…省略部分内容…
```



#### 4.	ACL访问控制权限

> 此处只会简单的讲一下ACL访问控制权限

很多场景下，文件的权限:拥有者，所属组，其他人。这三种身份根本不够用。例如

```
	一个Linux系统中有一个目录是班级的项目目录。老师使用root用户，作为这个目录的属主，权限为rwx。学员都加入tgroup组作为班级的所属组，而其他班的学生作为other则没有权限。
	但是这一天，来了一位试听的学员st,此时这时候3种身份就不够用了
```



ACL，全称`Access Control List`的缩写，ACL可实现对单一用户设定访问文件的权限。也就是独立于传统方式（3种身份搭配3种权限），直接对`st`用户设定访问文件`r-x`的权限



设定ACL权限，常用命令有2个，分别是`setfacl`和`getfacl`命令，前者用于给指定文件或目录设定`ACL`权限，后者用于查看是否配置成功



##### setfacl,getfacl

`getfacl`命令用于查看文件或目录当前设定的`ACL`权限信息。基本格式为：

```
[root@localhost ~]# getfacl 文件名
```

> 此命令很简单，常常跟着`setfacl`一起使用



`setfacl`命令可直接设定用户或群组对指定文件的访问权限，基本格式为：

```
[root@localhost ~]# setfacl 选项 文件名
```

选项如下：

| 选项    | 功能                                                         |
| ------- | ------------------------------------------------------------ |
| -m 参数 | 设定 ACL 权限。如果是给予用户 ACL 权限，参数则使用 "u:用户名:权限" 的格式，例如 `setfacl -m u:st:rx /project` 表示设定 st 用户对 project 目录具有 rx 权限；如果是给予组 ACL 权限，参数则使用 "g:组名:权限" 格式，例如 `setfacl -m g:tgroup:rx /project` 表示设定群组 tgroup 对 project 目录具有 rx 权限。 |
| -x 参数 | 删除指定用户（参数使用 u:用户名）或群组（参数使用 g:群组名）的 ACL 权限，例如 `setfacl -x u:st /project` 表示删除 st 用户对 project 目录的 ACL 权限。 |
| -b      | 删除所有的 ACL 权限，例如 `setfacl -b /project` 表示删除有关 project 目录的所有 ACL 权限。 |
| -d      | 设定默认 ACL 权限，命令格式为 "setfacl -m d:u:用户名:权限 文件名"（如果是群组，则使用 d:g:群组名:权限），只对目录生效，指目录中新建立的文件拥有此默认权限，例如 `setfacl -m d:u:st:rx /project` 表示 st 用户对 project 目录中新建立的文件拥有 rx 权限。 |
| -R      | 递归设定 ACL 权限，指设定的 ACL 权限会对目录下的所有子文件生效，命令格式为 "setfacl -m u:用户名:权限 -R 文件名"（群组使用 g:群组名:权限），例如 `setfacl -m u:st:rx -R /project` 表示 st 用户对已存在于 project 目录中的子文件和子目录拥有 rx 权限。 |
| -k      | 删除默认 ACL 权限。                                          |

> 我寻思常用的就`-m`和`-x`



实例1：

> 使用`setfacl `命令的`-m`选项，来设定某用户对文件的ACL访问权限

```
[root@localhost ~]# setfacl -m u:admin:rwx /home/test1
			//赋予用户admin对/home/test1目录的ACL权限
			
[root@localhost ~]# ll -d /home/test1
drwxrwx---+ 2 root tgroup 4096 Apr 16 12:55 /home/test1
#如果查询时会发现，在权限位后面多了一个"+"，表示此目录拥有ACL权限

[root@localhost ~]# getfacl tt
#file: tt
#owner: root
#group: root
user::rwx
user:admin:r-x
group::rwx
mask::rwx
other::---
```

> 其他的就不写了



##### mask有效权限

> 上面的实例中，可以看到有一行`mask`。这个是什么呢

mask权限，指的是用户或群组能拥有的最大ACL权限，也就是说给用户或群组赋予的ACL权限最大不能超过mask权限。**超出部分做无效处理**

> 例如：如果把mask权限设置为r--，而使用`setfacl`设置的时候设置`rwx`，这样的话，因为`mask`权限的限制，只能拥有`r--`的权限。



`mask`权限可以使用`setfacl`命令手动更改，比如，更改 project 目录 mask 权限值为 r-x，可执行如下命令：

```
[root@localhost ~]# setfacl -m m:rx /project
#设定mask权限为r-x，使用"m:权限"格式
[root@localhost ~]# getfacl /project
#file：project
#owner：root
#group：tgroup
user::rwx
group::rwx
mask::r-x  <--mask权限变为r-x
other::---
```





#### 5.	Linux文件特殊权限(SUID,SGID,SBIT)



##### SUID

> 先看以下我们的修改密码的`passwd`命令
>
> ```
> [root@localhost ~]# ls -l /usr/bin/passwd
> -rwsr-xr-x. 1 root root 22984 Jan  7  2007 /usr/bin/passwd
> ```

>  可以看到，原本表示文件所有者权限中的x变成了s

上面这种权限通常称为`SetUID`，简称`SUID`特殊权限。

`SUID`特殊权限仅适用于可执行文件，所具有的功能是：只要用户对设有`SUID`的文件有执行权限，那么当用户执行此文件时，会以文件所有者的身份去执行此文件，一旦文件执行结束，身份的切换也随之消失。



```
这里简单的举一个例子：
	上面显示了passwd命令的权限配置，可以看到，passwd命令具有SUID权限。
	这意味着，当普通用户使用passwd命令尝试更改自己的密码时，实际上是以root的身份执行passwd命令，正因为如此，才能写入/etc/shadow文件(ps.shadow文件只有root才有权限)
	换句话说，如果我们把passwd命令的SUID权限给手动取消掉，这样的话修改密码没有问题，但是密码不能写进去/etc/shadow文件中了。
```



由此，我们可以总结出，SUID 特殊权限具有如下特点：

- 只有可执行文件才能设定 SetUID 权限，对目录设定 SUID，是无效的。
- 用户要对该文件拥有 x（执行）权限。
- 用户在执行该文件时，会以文件所有者的身份执行。
- SetUID 权限只在文件执行过程中有效，一旦执行完毕，身份的切换也随之消失。



##### SGID 

当`s`权限位于所属组的`x`权限时，就被称为`SetGID`，简称SGID特殊权限，例如：

```
[root@localhost ~]# ll /usr/bin/locate
-rwx--s--x. 1 root slocate 35612 8月24 2010 /usr/bin/locate
```

> 与SUID不同的是，SGID既可以对文件进行配置，也能对目录进行配置



1. SGID对文件的作用

与SUID类似，对文件来说，SGID具有以下特点：

+ SGID只针对可执行文件，普通文件赋予SGID没有意义
+ 用户需要对此可执行文件有`x`权限。
+ 用户在执行具有 SGID 权限的可执行文件时，用户的群组身份会变为文件所属群组；
+ SGID 权限赋予用户改变组身份的效果，只在可执行文件运行过程中有效；

> 其实，SGID 和 SUID 的不同之处就在于，SUID 赋予用户的是文件所有者的权限，而 SGID 赋予用户的是文件所属组的权限，就这么简单。



就以本节开头的 locate 命令为例，可以看到，/usr/bin/locate 文件被赋予了 SGID 的特殊权限，这就意味着，当普通用户使用 locate 命令时，该用户的所属组会直接变为 locate 命令的所属组，也就是 slocate。



locate 命令是用于在系统中按照文件名查找符合条件的文件的，当执行搜索操作时，它会通过搜索 /var/lib/mlocate/mlocate.db 这个数据库中的数据找到答案，此数据库的权限：

```
[root@localhost ~]# ll /var/lib/mlocate/mlocate.db
-rw-r-----. 1 root slocate 1838850 1月20 04:29 /var/lib/mlocate/mlocate.db
```

可以看到，mlocate.db 文件的所属组为 slocate，虽然对文件只拥有 r 权限，但对于普通用户执行 locate 命令来说，已经足够了。



2. SGID对目录的作用

> 事实上，SGID 也能作用于目录，且这种用法很常见。

当一个目录被赋予 SGID 权限后，进入此目录的普通用户，其有效群组会变为该目录的所属组，会就使得用户在创建文件（或目录）时，该文件（或目录）的所属组将不再是用户的所属组，而使用的是目录的所属组。



> 也就是说，只有当普通用户对具有 SGID 权限的目录有 rwx 权限时，SGID 的功能才能完全发挥。比如说，如果用户对该目录仅有 rx 权限，则用户进入此目录后，虽然其有效群组变为此目录的所属组，但由于没有 x 权限，用户无法在目录中创建文件或目录，SGID 权限也就无法发挥它的作用。



##### SBIT

`Sticky BIT`，简称`SBIT`特殊权限。可意为粘着位、粘滞位、防删除位等。



SBIT 权限仅对目录有效，一旦目录设定了 SBIT 权限，则用户在此目录下创建的文件或目录，就只有自己和 root 才有权利修改或删除该文件。

> 也就是说，当甲用户以目录所属组或其他人的身份进入 A 目录时，如果甲对该目录有 w 权限，则表示对于 A 目录中任何用户创建的文件或子目录，甲都可以进行修改甚至删除等操作。但是，如果 A 目录设定有 SBIT 权限，那就大不一样啦，甲用户只能操作自己创建的文件或目录，而无法修改甚至删除其他用户创建的文件或目录。

`Linux`系统中，储存临时文件的`/tmp`目录就设定有`SBIT`权限：

```
[root@localhost ~]# ll -d /tmp
drwxrwxrwt. 4 root root 4096 Apr 19 06:17 /tmp
```





> 简单的说，就是目录设置了`SBIT`权限了过后，目录中的文件就各是各的了，只能操作目录下属于自己的文件



##### SUID,SGID,SBIT设置

关于SUID,SGID,SBIT设置没懂得话，[点击](http://www.beylze.com/news/30556.html)

>  注意，不同的特殊权限，作用的对象是不同的，SUID 只对可执行文件有效；SGID 对可执行文件和目录都有效；SBIT 只对目录有效。



首先，使用`chmod`命令，给文件或目录设定权限有两种方式，使用数字形式和字母形式。例如：

```
[root@localhost ~]# chmod 755 test1
//或者
[root@localhost ~]# chmod u=rwx,go=rx test1
```

> 给文件或目录设定SUID，SGID和SBIT特殊权限，也可以使用这两种形式

我们知道，给`chmod`命令传递3个数字，即可实现给文件或目录设定普通权限。比如说，“755”表示所有者拥有 rwx 权限，所属组拥有 rx 权限，其他人拥有 tx 权限。

> 给文件或目录设定特殊权限，只需在这3个数字之前增加一个数字位，用来放置给文件或目录设定的特殊权限



SUID，SGID，SBIT分别对应的数字如下所示：

```
4 --> SUID
2 --> SGID
1 --> SBIT
```



实例1：

> 要给一个`test`文件新增SUID，SGID，SBIT权限的话直接:

> 通过字母的形式添加

```
[root@localhost ~]# chmod u+s,g+s.o+t test
[root@localhost ~]# ll test
-rwsr-sr-t. 1 root root Apr 19 23:54 test
```

> 但是这样是没有意义的，因为他只是个普通的文件，加上这三个权限也没意义，



实例2

> 条件和上面一样，不过此处使用的是数字的方式添加

```
[root@localhost ~]# chmod 7777 test
-rwsrwsrwt. 1 root root Apr 19 23:54 test
```



注意事项：

+ 通过数字添加的时候，后面的三个数字只是普通的`u,g,o`权限，前面的那个数字决定了SUID，SGID，SBIT权限。
+ 使用 chmod 命令给文件或目录赋予特殊权限时，原文件或目录中存在的 x 权限会被替换成 s 或 t，而当我们使用 chmod 命令消除文件或目录的特殊权限时，原本消失的 x 权限又会显现出来。

+ 不同的特殊权限，作用的对象是不同的，SUID 只对可执行文件有效；SGID 对可执行文件和目录都有效；SBIT 只对目录有效。





#### 6.Linux修改文件或目录的隐藏权限

> 管理`Linux`系统中的文件和目录。除了可以设定普通权限和特殊权限之外，还可以利用文件和目录具有的一些隐藏性。



##### chattr

`chattr`命令，修改文件或目录的隐藏属性，仅`root`用户才可以使用。基本格式

```
[root@localhost ~]# chattr [+-=] [属性] 文件或目录名
```

> +表示给文件或目录添加属性，-表示移除，=表示设定属性

选项如下：

| 属性选项 | 功能                                                         |
| -------- | ------------------------------------------------------------ |
| i        | 如果对文件设置 i 属性，那么不允许对文件进行删除、改名，也不能添加和修改数据； 如果对目录设置 i 属性，那么只能修改目录下文件中的数据，但不允许建立和删除文件； |
| a        | 如果对文件设置 a 属性，那么只能在文件中増加数据，但是不能删除和修改数据； 如果对目录设置 a 属性，那么只允许在目录中建立和修改文件，但是不允许删除文件； |
| u        | 设置此属性的文件或目录，在删除时，其内容会被保存，以保证后期能够恢复，常用来防止意外删除文件或目录。 |
| s        | 和 u 相反，删除文件或目录时，会被彻底删除（直接从硬盘上删除，然后用 0 填充所占用的区域），不可恢复。 |



实例1：

> 使用`chattr`命令来给文件添加隐藏属性

```
[root@localhost ~]# chattr +i test1
[root@localhost ~]# rm -rf test1
rm:cannot remove 'test1':Operation not permitted
#无法删除"ftesr"，操作不允许

	//移除隐藏属性
[root@localhost ~]# chattr -i test1
[root@localhost ~]# rm -rf test1
```



##### lsattr 

> 使用`chattr`命令配置文件或目录的隐藏属性后，可以使用`lsattr`来查看

`lsattr`命令，用于显示文件或目录的隐藏属性，基本格式如下：

```
[root@localhost ~]# lsattr [选项] 文件名或目录名
```



选项如下：

- -a：后面不带文件或目录名，表示显示所有文件和目录（包括隐藏文件和目录）
- -d：如果目标是目录，只会列出目录本身的隐藏属性，而不会列出所含文件或子目录的隐藏属性信息；
- -R：和 -d 恰好相反，作用于目录时，会连同子目录的隐藏信息数据也一并显示出来。



实例1：

> 使用`lsattr`命令来查看，文件的隐藏信息

```
[root@localhost ~]# lsattr test1
----i-------- test1
```



实例2：

> 使用`lsattr`命令`-a`选项查看

```
[root@localhost ~]# lsattr -a
----i-------- test1
-----a------- test2

//其实后面不加-a，效果也是一样的
[root@localhost ~]# lsattr 
----i-------- test1
-----a------- test2
```





### 二，	命令

#### 1.	chgrp	

`chgrp`命令用于修改文件的所属组，

> `chgrp`可以理解为"change group"的简称



基础格式为：

```
[root@localhost ~]# chgrp [-R] 所属组 文件名(目录名)
```

-R（注意是大写）选项长作用于更改目录的所属组，表示更改连同子目录中所有文件的所属组信息。

> 需要注意的是被改过后的新群组，必须存在。否则会报错



实例1：

> 使用`chgrp`来改变root目录下一个test文件的所属组为jack

```
[root@localhost ~]# chgrp jack test
						//修改成功，当然前提是得有jack组
[root@localhost ~]# ll test
-rw-r--r--. 1 root jack 78495 Nov 17 05:54 test
```





#### 2.	chown

`chown`主要用于修改文件(或目录)的所有者,除此之外，此命令也可以修改文件(或目录)的所属组。



`chown`命令的基本格式：

```
[root@localhost ~]# chown [-R] 所有者 文件(或目录)
```

> 如果要同时修改所有者和所属组，chown命令基本格式为：

```
[root@localhost ~]# chown [-R] 所有者:所属组 文件(或目录)
```

> 修改文件的所有者的目的一般都是为了更高的权限，



实例1：

> 修改`/home/user`目录的一个权限为`user`(原本权限为root)文件，这样`user`用户就能对此文件进行修改操作了

```
[root@localhost ~]# cd /home/user
[root@localhost user]# touch a
[root@localhost user]# ll a 
-rw-r-----. 1 root root 0 Apr 17 05:12 file
[root@localhost user]# su  - user
[user@localhost ~]$ cat a
cat:不允许的操作 #user用户不能查看test文件
[user@localhost ~]$ exit
[root@localhost ~]# chown user /home/user/a
[root@localhost ~]# su - user
[user@localhost ~]$ cat a 
abc
```



实例2：

> 简单实例同时修改所有者和所属组

```
[root@localhost ~]# chown user:user /home/user/a
```





#### 3.	chmod

`chmod`命令，可以让管理员能够手动的修改文件(或目录)的权限。设定文件权限的方式有两种，分别可以使用数字或者符号来进行权限的变更。



##### chmod命令使用数字修改文件权限

`Linux`系统中，文件的基本权限由 9个字符组成，以`rwxrw-r-x`为例，我们可以使用数字来代表权限，各个权限与数字的对应关系如下。

```
r --> 4
w --> 2
x --> 1
```

由于这9个字符分属3类用户，因此每种用户身份包含3个权限(r,w,x)，通过将3个权限对应的数组累加，最终得到的值即可作为每种用户所具有的权限。

拿`rwxrw-r-x`来说，所有者，所属组和其他人分别对应的权限值为：

```
所有者=rwx = 4+2+1 = 7
所属组=rw- = 4+2 = 6
其他人=r-x = 4+1 = 5
```

> 所以此权限对应的权限值就是765。



使用数字修改文件权限的`chmod`命令的基本格式为：

```
[root@localhost ~]# chmod [-R] 权限值 文件名
```

​			-R选项表示连同子目录中的所有文件，也都修改设定的权限





实例1：

> 使用`chmod`命令通过数字的方式修改文件权限

```
[root@localhost ~]# ls -al .test
-rw-r--r--. 1 root root 176 Sep 22 2004 .bashrc
[root@localhost ~]# chmod 777 .test
[root@localhost ~]# ll -al .test
-rwxrwxrwx. 1 root root 176 Sep 22 2004 .bashrc
```





##### chmod 命令使用字母修改权限

既然文件的基本权限就是3中用户身份（所有者，所属组和其他人）搭配3种权限(rwx)，`chmod`命令中用`u`,`g`,`o`分别代表3种身份，还用`a`表示全部的身份(all的缩写)。另外，`chmod`命令仍使用`r`,`w`,`x`分别表示读，写，执行权限。



基本格式如下图所示：

![chmod使用字母修改权限](http://c.biancheng.net/uploads/allimg/190417/2-1Z41G31209649.gif)



实例1：

> 使用`chmod`命令通过字母来修改权限

```
[root@localhost ~]# chmod u=rwx,go=rx test
				//设定所有者权限为rwx，所属组和其他人权限为rx

		//或者
[root@localhost ~]# chmod o+w test
				//设定test文件添加其他人w权限
```

