<center>Linux用户管理和组管理</center>
> 什么是UID，什么是GID这种程度就不说了。[详情](http://c.biancheng.net/view/839.html)或[这个](http://www.beylze.com/news/30556.html)



### 一，	Linux中关于用户和用户组的文件

> 以下简单的讲一下`Linux`中关于用户和用户组的文件



#### 1.	/etc/passwd

`/etc/passwd`是`Linux`中系统用户配置文件，储存了系统中所有用户的基本信息，并且所有的用户都可以对此文件执行读操作



> 先使用命令，查看一下`/etc/passwd`内容

```
[root@localhost ~]# less -Nm /etc/passwd 
root:x:0:0:root:/root:/bin/bash
bin:x:1:1:bin:/bin:/sbin/nologin
daemon:x:2:2:daemon:/sbin:/sbin/nologin
adm:x:3:4:adm:/var/adm:/sbin/nologin
一共26行,此处不做过多输出
```

> uid小于等于499的用户，全是系统正常运行所必须的用户，称之为`伪用户`，无法使用这些用户来登录，但是也不能删除，删除会导致系统不能正常运行



具体的字段含义如下：

```
用户名:密码:uid(用户ID):gid(组ID):描述性信息:主目录:默认shell
```

> 这里只简述一下具体的作用，



#####  用户名

用户名说白了就是一串字符串，`Linux`是通过`uid`识别用户的，用户名只是为了用户记忆。`/etc/passwd`文件中就定义了用户名和`UID`之间的对应关系



##### 密码

此处的`x`，表示用户设有密码，但不是真正的密码。真正的密码保存在`/etc/shadow`文件中。但是也不能删除此处的`x`，如果删除了`x`，Linux系统会认为该用户没有密码。从而导致可以只输入用户名就可以登录(ps.只能在无密码登录，不能远程登陆)。



##### UID

`UID`，每个用户拥有一个唯一的`uid`，系统通过`uid`来识别不同的用户。

| UID范围   | 用户身份                                                  |
| --------- | --------------------------------------------------------- |
| 0         | 超级用户,Linux中就是通过uid为0。来识别超级用户的          |
| 1~499     | 系统用户(伪用户)。此范围的UID保留给系统使用。作为保留账户 |
| 500~65535 | 普通用户，2.6x内核后Linux系统已经可以支持很多很多的uid了  |



##### GID 

全称`Group ID`，简称`组id`。表示用户初始组的`组id`。

> 此处显示的为初始组`GID`。

初始组：用户创建的时候就会创建一个组名与用户名相同的组。每个用户只能拥有				一个初始组。(ps.当然创建的时候也能手动指定已有的组为初始组)			

附加组：指用户可以加入多个其他的组，并且拥有这些组的权限。每个用户只能有				一个初始组。除了初始组外，用户再加入其他的用户组，这些用户组就是				该用户的附加组



##### 描述性信息

emmm……，这个字段没什么吊用，只说用来解释这个用户的意义而已。



#####  主目录

也就是用户登录有具有操作权限的目录，通常称之为用户的`主目录`或`家目录`。

`root`用户的主目录为`/root`。普通用户主目录为`/home/用户名`。例如`jack`用户主目录为`/home/jack`。



##### 默认的Shell

`Shell`就是`Linux`的命令解释器，是用户和Linux内核沟通的桥梁。

> 默认的话`Linux`系统默认的命令解释器为(/bin/bash)。

在`/etc/passwd`文件中，这个字段可以理解为用户登录后拥有的权限,例如

```
jack:x:1001:1001::/home/jack:/sbin/nologin
				//修改为这样的话，用户就不能登录了
jack:x:1001:1001::/home/jack:/usr/bin/passwd
				//修改为这样的话，用户就只能修改自己的密码
```

> 注意此处不能写入和登录无关的命令(如`ls`)，系统不会识别，意味着用户不能登录





#### 2.	/etc/shadow

> /etc/shadow文件用于储存`Linux`系统中用户的密码信息，与上面的/etc/passwd中的密码`x`对应。此文件又称为“影子文件”

以前密码是放在`/etc/passwd`中的，但是此文件所有用户都有读权限，所以就换到`/etc/shadow`中了。



先使用一下命令，看一下`/etc/shadow`中的内容：

```shell
[root@localhost ~]# less -Nm /etc/shadow
root: $6$9w5Td6lg
$bgpsy3olsq9WwWvS5Sst2W3ZiJpuCGDY.4w4MRk3ob/i85fl38RH15wzVoom ff9isV1 PzdcXmixzhnMVhMxbvO:15775:0:99999:7:::
bin:*:15513:0:99999:7:::
daemon:*:15513:0:99999:7:::
…省略部分输出…
```

和`/etc/passwd`文件一样，文件中每一行代表的是一个用户，同样使用`:`作为分隔符，此处的每行用户信息被分隔成了9个字段。具体含义如下：

```
用户名：密码(加密后的字符串)：最后一次修改时间：密码最小修改时间间隔：密码有效期：密码需要变更前的提醒天数：密码过期后的宽限天数：账号失效时间：保留字段
```

> 接下来，分别讲解这9个字段。



##### 用户名

和`/etc/passwd`文件中的用户名一样的，只说表达用户名而已。



##### 加密密码

此字段表示的是真正密码加密后的字段。`Linux`使用的是`SHA512`散列加密算法。

```
此处的密码乱码不能随便，如果随便改了，会导致系统无法识别密码，很多软件通过这个功能，密码前面加上`!`，`*`或`x`来使密码失效
```

> 所有伪用户的密码都是`!!`或`*`的，代表没有密码，是不能登录的。如果新创建的用户不设定密码，那么他的这一行也会是`!!`，代表：没有密码，不能登录



##### 最后一次修改时间

此字段表示最后一次修改时间，此处的`root`用户显示的是15775。

是因为时间是从`1970-01-01`，开始计算的，距今为止多少天。

可以使用以下命令换算：

```
[root@localhost ~]# date -d '1970-01-01 15775 days'
2013年03月11日 星期一 00:00:00 CST
```



##### 最小修改时间间隔

字面意思，就是修改了时间后，最少需要多少天才能再次修改。如果该字段为10，则表示修改密码后起码10天，才能再次修改。



##### 密码有效期

字面意思：就是密码自创建时间起，过了多少时间就得再次修改密码。否则该账户密码进行过期阶段。一般这里都会设定为`99999`，也就是273年。如果修改为90，则表示密码创建或修改后90天内必须再次修改密码。



##### 密码变更前警告天数

字面意思：接上面的，距离90的有效期，快过期了。此字段就表示，距离过期前还有多少天开始提醒用户，修改密码。该字段的默认值为7，就表示密码过期前的7天，开始提醒用户修改密码。



##### 密码过期都宽限天数

此字段也称为`口令失效日`。字面意思：当密码有效期过了后还没有修改密码，此时则密码过期。此字段的作用就是：密码过期后，字段规定的宽限天数内账户还能登录系统。如果过了此宽限天数，则是全部禁用



##### 账号失效时间

通第三个字段`密码的最后一次修改时间`一样，都是使用`1970-01-01`以来的总天数来作为账户的失效时间。该字段表示，只要过了失效时间，无论密码过期与否，都将无法使用！

> 此字段通常在具有收费服务的系统中



##### 保留字

此字段暂时拿来还没什么用，等待新功能的加入。





####　3.	/etc/group

> `/etc/group`是用户组配置文件，用户组的所有信息都放在此文件中。

此文件是记录组`ID`和组名相对应的文件。`etc/passwd`中的第四个字段记录的就是用户的初始组`ID`,那么此组的组名就是要在`/etc/group`文件中查找



先使用命令查看`/etc/group`中的内容：

```shell
[root@localhost ~]# less -Nm /etc/group	
root:x:0:
bin:x:1:bin,daemon
daemon:x:2:bin,daemon
…省略部分输出…
lamp:x:502:
```

> 此文件中每一行代表的是一个用户组。当创建一个用户后，会自动的创建一个用户组作为新用户的初始组（ps.当然也可以手动改）组GID不一定和用户UID一样。



每一行被分为了四个字段，具体如下：

```
组名:密码:GID（组ID）:组中的用户
```



##### 组名

就是用户组的名称，有字母或数字构成。同`/etc/passwd`中的用户名一样，组名不能重复



##### 组密码

和`/etc/passwd`文件一样，此处的`x`仅仅是密码标识，标识有密码，真正的密码在`/etc/gshadow`文件中。



##### 组ID(GID)

此组ID，就是群组的ID号，`Linux`系统中就是通过`GID`来区分用户组的，同用户名一样，组名只是为了方便管理员记忆



##### 组中的用户

此字段列出每个群组包含的所有用户。需要注意的是，如果该用户组是这个用户的初始组，则该用户不会写入这个字段，可以这么理解，该字段显示的用户都是这个用户组的附加用户。



#### 4.	/etc/gshadow

为了安全性，组用户信息储存在`/etc/group`中，组密码信息存储在`/etc/gshadow`中



首先还是先用命令查看一下`/etc/gshadow`中的信息。

```
[root@localhsot ~]# less -Nm /etc/gshadow
root:::
bin:::bin, daemon
daemon:::bin, daemon
...省略部分输出...
lamp:!::
```

可以看到一共有4个字段，每个字段的含义如下：

```
组名:组密码:组管理员:组附加用户列表
```



##### 组名

同`/etc/group`文件中的组名相对应



##### 组密码

对于大多数用户而言，通常不设置密码，因此该字段常为空，但有时为`!`，指的是该群组没有组密码，但也不设有群组管理员。



##### 组管理员

从系统管理员的角度来说，该文件最大的作用为创建群组管理员。考虑到Linux系统中帐号太多，超级管理员`root`可能比较忙碌，特设此群组管理员来帮超级管理员来分担。



##### 组中的附加用户

该字段显示这个用户组中有哪些附加用户，和`/etc/group`中附加组显示的内容相同。





#### 5./etc/login.defs

`/etc/login.defs`文件用于在创建用户时，对用户的一些基本属性做默认设置，例如指定用户`UID`和`GID`的范围，用户的过期时间，密码的最大长度等等。

> 下表中，对文件中的各个选项做出了具体的解释

| 设置项                   | 含义                                                         |
| ------------------------ | ------------------------------------------------------------ |
| MAIL_DIR /var/spool/mail | 创建用户时，系统会在目录 /var/spool/mail 中创建一个用户邮箱，比如 lamp 用户的邮箱是 /var/spool/mail/lamp。 |
| PASS_MAX_DAYS 99999      | 密码有效期，99999 是自 1970 年 1 月 1 日起密码有效的天数，相当于 273 年，可理解为密码始终有效。 |
| PASS_MIN_DAYS 0          | 表示自上次修改密码以来，最少隔多少天后用户才能再次修改密码，默认值是 0。 |
| PASS_MIN_LEN 5           | 指定密码的最小长度，默认不小于 5 位，但是现在用户登录时验证已经被 PAM 模块取代，所以这个选项并不生效。 |
| PASS_WARN_AGE 7          | 指定在密码到期前多少天，系统就开始通过用户密码即将到期，默认为 7 天。 |
| UID_MIN 500              | 指定最小 UID 为 500，也就是说，添加用户时，默认 UID 从 500 开始。注意，如果手工指定了一个用户的 UID 是 550，那么下一个创建的用户的 UID 就会从 551 开始，哪怕 500~549 之间的 UID 没有使用。 |
| UID_MAX 60000            | 指定用户最大的 UID 为 60000。                                |
| GID_MIN 500              | 指定最小 GID 为 500，也就是在添加组时，组的 GID 从 500 开始。 |
| GID_MAX 60000            | 用户 GID 最大为 60000。                                      |
| CREATE_HOME yes          | 指定在创建用户时，是否同时创建用户主目录，yes 表示创建，no 则不创建，默认是 yes。 |
| UMASK 077                | 用户主目录的权限默认设置为 077。                             |
| USERGROUPS_ENAB yes      | 指定删除用户的时候是否同时删除用户组，准备地说，这里指的是删除用户的初始组，此项的默认值为 yes。 |
| ENCRYPT_METHOD SHA512    | 指定用户密码采用的加密规则，默认采用 SHA512，这是新的密码加密模式，原先的 [Linux](http://c.biancheng.net/linux_tutorial/) 只能用 DES 或 MD5 加密。 |



#### 6.	/etc/default/useradd

> 此文件和上面的文件一起，作为新增用户的默认配置文件

| 参数                  | 含义                                                         |
| --------------------- | ------------------------------------------------------------ |
| GR0UP=100             | 这个选项用于建立用户的默认组，也就是说，在添加每个用户时，用户的初始组就是 GID 为 100 的这个用户组。但 CentOS 并不是这样的，而是在添加用户时会自动建立和用户名相同的组作为此用户的初始组。也就是说这个选项并不会生效。  Linux 中默认用户组有两种机制：一种是私有用户组机制，系统会创建一个和用户名相同的用户组作为用户的初始组；另一种是公共用户组机制，系统用 GID 是 100 的用户组作为所有新建用户的初始组。目前我们采用的是私有用户组机制。 |
| HOME=/home            | 指的是用户主目录的默认位置，所有新建用户的主目录默认都在 /home/下，刚刚新建的 lamp1 用户的主目录就为 /home/lamp1/。 |
| INACTIVE=-1           | 指的是密码过期后的宽限天数，也就是 /etc/shadow 文件的第七个字段。这里默认值是 -1，代表所有新建立的用户密码永远不会失效。 |
| EXPIRE=               | 表示密码失效时间，也就是 /etc/shadow 文件的第八个字段。默认值是空，代表所有新建用户没有失效时间，永久有效。 |
| SHELL=/bin/bash       | 表示所有新建立的用户默认 Shell 都是 /bin/bash。              |
| SKEL=/etc/skel        | 在创建一个新用户后，你会发现，该用户主目录并不是空目录，而是有 .bash_profile、.bashrc 等文件，这些文件都是从 /etc/skel 目录中自动复制过来的。因此，更改 /etc/skel 目录下的内容就可以改变新建用户默认主目录中的配置文件信息。 |
| CREATE_MAIL_SPOOL=yes | 指的是给新建用户建立邮箱，默认是创建。也就是说，对于所有的新建用户，系统都会新建一个邮箱，放在 /var/spool/mail/ 目录下，和用户名相同。例如，lamp1 的邮箱位于 /var/spool/mail/lamp1。 |







### 二，Linux用户和组管理命令

#### 1.	useradd

`Linux`系统中，可以使用`useradd`命令新建用户，此命令的基本格式如下：

```shell
[root@localhost ~]# useradd [选项] 用户名
```



该命令选项如下：

| 选项        | 含义                                                         |
| ----------- | ------------------------------------------------------------ |
| -u UID      | 手工指定用户的 UID，注意 UID 的范围（不要小于 500）。        |
| -d 主目录   | 手工指定用户的主目录。主目录必须写绝对路径，而且如果需要手工指定主目录，则一定要注意权限； |
| -c 用户说明 | 手工指定/etc/passwd文件中各用户信息中第 5 个字段的描述性内容，可随意配置； |
| -g 组名     | 手工指定用户的初始组。一般以和用户名相同的组作为用户的初始组，在创建用户时会默认建立初始组。一旦手动指定，则系统将不会在创建此默认的初始组目录。 |
| -G 组名     | 指定用户的附加组。我们把用户加入其他组，一般都使用附加组；   |
| -s shell    | 手工指定用户的登录 [Shell](http://c.biancheng.net/shell/)，默认是 /bin/bash； |
| -e 曰期     | 指定用户的失效曰期，格式为 "YYYY-MM-DD"。也就是 /etc/shadow 文件的第八个字段； |
| -o          | 允许创建的用户的 UID 相同。例如，执行 "useradd -u 0 -o usertest" 命令建立用户 usertest，它的 UID 和 root 用户的 UID 相同，都是 0； |
| -m          | 建立用户时强制建立用户的家目录。在建立系统用户时，该选项是默认的； |
| -r          | 创建系统用户，也就是 UID 在 1~499 之间，供系统程序使用的用户。由于系统用户主要用于运行系统所需服务的权限配置，因此系统用户的创建默认不会创建主目录 |

> 系统已经规定了`useradd`命令很多默认值。在无特殊要求下，无需使用任何选项即可成功创建用户

```
[root@localhost ~]# useradd melody
```

> 此命令表示创建`melody`用户
>
> 此命令看起来很简单，但是事实上，他还会默认的帮你完成好几项操作



整个添加用户的过程如下：

1. 在`/etc/passwd`文件中写入一行与`lamp`用户相关的数据：

```
[root@localhost ~]# grep melody /etc/passwd
melody:x:1000:1000::/home/melody://bin/bash		
```

> 此处我的`UID`是从1000开始计算的

2. 在`/etc/shadow`中新添一行与`melody`用户密码有关的数据：

   ```
   [root@localhost ~]# grep melody /etc/shadow
   melody:!!:18755:0:99999:7:::
   ```

   > 此密码还没有设置，所以为!!，表示该用户没有密码不能正常登陆

3. 在`/etc/group`文件中创建一行与用户名一样的群组：

   ```
   [root@localhost ~]# grep melody /etc/group
   melody:x:1000:
   ```

   > 该群组为新建用户的初始组

4. 在`/etc/gshadow`文件中新增一行与新增群组相关的密码信息：

   ```
   [root@localhost ~]# grep melody /etc/gshadow
   melody:!::
   ```

5. 默认创建用户的主目录和邮箱

```
[root@localhost ~]#ll -d /home/lamp/
drwx------ 3 melody melody 4096 1月6 00:19 /home/lamp/
[root@localhost ~]#ll /var/spod/mail/lamp
-rw-rw---- 1 melody mail 0 1月6 00:19 /var/spool/mail/lamp
```

> 注意这两个文件的权限，都要让`melody`用户拥有拥有相应的权限。

6. 将`/etc/skel`目录中的配置文件复制到新用户的主目录中



下面使用选项添加一个用户：

```
[root@localhost ~]# useradd -u 1001 -g melody -G root -c "I'm melody " -d /home/melody -s /bin/bash
```



`useradd`命令在添加用户时参考的默认值文件主要有两个，分别是`/etc/default/add`和`/etc/login.def.s`





#### 2.	passwd

> `useradd`命令创建的用户并没有设定密码，因此无法登录，需要使用passwd命令修改了密码。



`passwd`的基本格式如下：

```
[root@localhost ~]# passwd [选项] 用户名
```



选项：

+ -S:查询用户密码的状态，也就是`/etc/shadow`文件中此用户。仅root用户可用

+ -l:暂时锁定用户，该选项会在`/etc/shadow`文件中指定用户的加密密码串前添加`!`，使密码失效。仅`root`用户可用。
+ -u:解锁用户，和`-l`选项相对应，也只能`root`用户使用。

- --stdin：可以将通过管道符输出的数据作为用户的密码。主要在批量添加用户时使用；
- -n 天数：设置该用户修改密码后，多长时间不能再次修改密码，也就是修改 /etc/shadow 文件中各行密码的第 4 个字段；
- -x 天数：设置该用户的密码有效期，对应 /etc/shadow 文件中各行密码的第 5 个字段；
- -w 天数：设置用户密码过期前的警告天数，对于 /etc/shadow 文件中各行密码的第 6 个字段；
- -i 日期：设置用户密码失效日期，对应 /etc/shadow 文件中各行密码的第 7 个字段。

> 一般都是`-S`，`-l`和`-u`用的比较多。和修改用户密码



实例1：

> 此处在`root`账户，和普通用户下使用`passwd`命令

```
[root@localhost ~]# passwd melody	//修改melody账户的密码


[root@localhost ~]# passwd -S melody	//查看melody账户的密码
lamp PS 2013-01-06 0 99999 7 -1 (Password set, SHA512 crypt.)


[melody@localhost ~]# passwd 		//普通用户仅能使用passwd命令修改自己的密码
```



#### 3.	usermod

前面的`useradd`添加错了用户信息，此处就可以使用`usermod`命令，修改用户的信息。

> 其实修改用户信息的方法不止使用`usermod`命令，还可以直接修改`/etc/passwd`,`/etc/shadow`，`/etc/group`，`/etc/gshadow`文件中的数据



`usermod`命令的基本格式如下：

```
[root@localhost ~]# usermod [选项] 用户名
```



选项：

+ `-c`用户说明：修改用户的描述信息`/etc/passwd`文件，用户信息的第5个字段
+ `-d`主目录：修改用户的主目录`/etc/passwd`文件的第6个字段
+ `-e`日期：修改用户的失效日期`/etc/shadow`文件中第8个字段
+ `-g`组名：修改用户的初始组`/etc/passwd`文件中第4个字段
+ `-G`组名：修改用户的附加组，就是把用户加入其他用户组，即修改`/etc/group`文件
+ `-u`UID：修改用户的UID，即修改`/etc/passwd`文件中第3个字段
+ `-l`用户名：修改用户的名称。
+ `-L`：临时锁定账户
+ `-U`：解锁(Unlock)账户。
+ `-s` shell：修改用户的登录`Shell`，默认是`/bin/shell`。

> `usermod`的命令选项和`useradd`命令选项及其相似，因为`usermod`就是来调整`useradd`的。



实例1：

把`melody`用户加入root组

```
[root@localhost ~]# usermod -G root melody
```



实例2：

修改用户的说明信息

```
[root@localhost ~]# usermod -c "this is melody's blog" melody
```



#### 4.	chage

>  除了`passwd -S`命令可以查看用户的密码信息外，还可以使用`chage`命令，它可以更加详细的用户密码信息，并且和`passwd`命令一样，提供了修改用户密码信息的功能。

`chage`命令的基本格式：

```
[root@localhost ~]# chage [选项] 用户名
```



选项：

+ `-l`：列出用户的详细密码状态
+ `-d`日期：修改`/etc/shadow`文件中指定用户密码信息的第3个字段，

- -d 日期：修改 /etc/shadow 文件中指定用户密码信息的第 3 个字段，也就是最后一次修改密码的日期，格式为 YYYY-MM-DD；
- -m 天数：修改密码最短保留的天数，也就是 /etc/shadow 文件中的第 4 个字段；
- -M 天数：修改密码的有效期，也就是 /etc/shadow 文件中的第 5 个字段；
- -W 天数：修改密码到期前的警告天数，也就是 /etc/shadow 文件中的第 6 个字段；
- -i 天数：修改密码过期后的宽限天数，也就是 /etc/shadow 文件中的第 7 个字段；
- -E 日期：修改账号失效日期，格式为 YYYY-MM-DD，也就是 /etc/shadow 文件中的第 8 个字段。



实例1：

> 简单查看用户的密码状态

```
[root@localhost ~]# chage -l lamp
Last password change:Jan 06, 2013
Password expires:never
Password inactive :never
Account expires :never
Minimum number of days between password change :0
Maximum number of days between password change :99999
Number of days of warning before password expires :7
```





实例2：

> 设定用户第一次登录必须设定密码

```
[root@localhost ~]# useradd jack	//新建用户
[root@localhost ~]# echo "jack" | passwd --stdin jack
							//设置密码
[root@localhost ~]# chage -d 0 jack			
				//通过chage命令设置此账号密码创建的日期为 1970 年 1 月 1 日（0 就表示这一天），这样用户登陆后就必须修改密码
```



#### 5.	userdel

> userdel命令很简单，就是删除用户的相关数据。此命令只能`root`用户才能用

`userdel`命令基本格式如下：

```
[root@localhost ~]# userdel -r 用户名
```

> `-r`选项表示删除用户的同时删除用户的家目录



其实使用此命令就相当于

删除`/etc/passwd`，`/etc/shadow`，`/etc/group`，`/etc/gshow`文件中关于目标用户的数据



#### 6.	id

使用`id`命令可查询用户的UID，GID，和附加组的信息。

基本格式如下：

```
[root@localhost ~]# id 用户名
```



实例1：

> 使用`id`命令来查看用户的信息

```
[root@localhost ~]# id melody
uid=1000(melody) gid=1000(melody) groups=1001(jack),0(root)
```



实例2：

> 查看当前用户的信息

```
[root@localhost ~]# id 
```



#### 7.	groups 

`groups`命令就像是上面的`id`命令一样，可以查看当前用户，加入的组的信息

基本格式：

```
[root@localhost ~]# groups 用户名
```





实例1：

> 使用`groups`命令查看用户的所属组

```
[root@localhost ~]# groups melody
melody : melody root	//可以看到用户加入了melody(初始组),root(附加组)
```



实例2：

> 使用`groups`命令查看当前用户的所属组

```
[root@localhost ~]# groups 
root
```



#### 8.	whoami

`whoami`命令和`who am i`命令是不一样的。

前者表示输出当前登录的有效用户。后者表示的是实际用户



所谓实际用户，指的是登陆 Linux 系统时所使用的用户，因此在整个登陆会话过程中，实际用户是不会发生变化的；而有效用户，指的是当前执行操作的用户，也就是说真正决定权限高低的用户，这个是能够利用 su 或者 sudo 命令进行任意切换的。



#### 9.	groupadd

添加用户组的命令是`groupadd`，命令格式如下：

```
[root@localhost ~]# groupadd [选项] 组名
```



选项：

+ `-g`GID：指定组ID 
+ `-r`：创建系统群组。



实例1：

> 使用groupadd命令创建新群组很简单

```
[root@localhost ~]# groupadd admin
[root@localhost ~]# grep admin /etc/group
group:x:1002:
```



#### 10.	groupmod 

`groupmod`命令用于修改用户组的相关信息，命令格式如下：

```
[root@localhost ~]# groupmod [选项] 组名
```

选项：

+ `-g`GID：修改组ID
+ `-n`新组名：修改组名



实例1：

> 使用`groupmod`修改组名

```
[root@localhost ~]# groupmod -n melody admin
[root@localhost ~]# grep melody /etc/group
melody:x:1002:
```



#### 11.	groupdel

使用`groupdel`命令删除用户组，基本格式如下：

```
[root@localhost ~]# groupdel 组名
```

> 同样的，其实删除组，就是删除`/etc/group`和`/etc/gshadow`中的数据



实例1：

> 使用groupdel命令删除用户组

```
[root@localhost ~]# groupdel melody
```



注意！！！：不能使用`groupsdel`命令随意删除群组，此命令只适用于那些“不说任何用户初始组的群组”，如果有群组还是某用户的初始组，则无法被删除。而且系统的组也不能删除



#### 12.	gpasswd

`gpasswd`命令，可以使用户加入和移除群组，也可以指定群组的管理员。代替root用户完成将用户加如或移除群组的操作



`gpasswd`基本格式如下：

```
[root@localhost ~]# gpasswd 选项 组名
```

选项：

| 选项         | 功能                                                         |
| ------------ | ------------------------------------------------------------ |
|              | 选项为空时，表示给群组设置密码，仅 root 用户可用。           |
| -A user1,... | 将群组的控制权交给 user1,... 等用户管理，也就是说，设置 user1,... 等用户为群组的管理员，仅 root 用户可用。 |
| -M user1,... | 将 user1,... 加入到此群组中，仅 root 用户可用。              |
| -r           | 移除群组的密码，仅 root 用户可用。                           |
| -R           | 让群组的密码失效，仅 root 用户可用。                         |
| -a user      | 将 user 用户加入到群组中。                                   |
| -d user      | 将 user 用户从群组中移除。                                   |



实例1：

> 使用`gpasswd -A`命令设定群组管理员

```
[root@localhost ~]# gpasswd -A admin group1
					//设定group群组管理员为admin 
```

> 设定了管理员后，此管理员用户就可以使用`gpasswd -a`命令了



实例2：

> 管理员账户使用`gpasswd -a`命令来新增群组用户

```
[admin@localhost ~]# gpasswd -a melody group1
```





#### 13.	newgrp

`newgrp`命令用作切换用户的有效组



有效组：要知道用户可以属于一个初始组，也可以属于多个附加组。既然用户属于这么多的组，那么用户创建文件后，默认生效的组身份是哪个呢。当然是初始组咯。



不过可以使用此处的`newgrp`命令来暂时的改变用户的有效组。



1. 首先，建立 3 个用户组 group1、group2 和 group3，命令如下：

   ```
   [root@localhost ~]# groupadd group1
   [root@localhost ~]# groupadd group2
   [root@localhost ~]# groupadd group3
   ```

2. 创建一个用户 user1，同时指定 user1 的初始组为 group1，附加组为 group2 和 group3，执行命令如下：

   ```
   [root@localhost ~]# useradd -g group1 -G group2,group3 user1
   \#由于指定了初始组，因此不会在创建 user1 默认群组
   [root@localhost ~]# more /etc/group | grep user1
   group2:x:501:user1
   group3:x:502:user1
   ```

3. 对用户 user1 设置密码，执行命令如下：

   ```
   [root@localhost ~]# passwd user1
   Changing password for user user1.
   New password:
   Retype new password:
   passwd: all authentication tokens updated successfully.
   ```

4. 切换至 user1 用户，通过 newgrp 切换用户组进行下列操作，读者可从中体会出 newgrp 命令的作用。

   ```
   \#切换至 user1 用户
   [root@localhost ~]# su - user1
   [root@localhost ~]# whoami
   user1
   \#使用 newgrp 命令一边切换 user1 的初始组，一边创建文件
   [root@localhost ~]# mkdir user1_doc
   [root@localhost ~]# newgrp group2
   [root@localhost ~]# mkdir user2_doc
   [root@localhost ~]# newgrp group3
   [root@localhost ~]# mkdir user3_doc
   \#查看各文件的详细信息
   [root@localhost ~]# ll
   total 12
   drwxr-xr-x 2 user1 group1 4096 Oct 24 01:18 user1_doc
   drwxr-xr-x 2 user1 group2 4096 Oct 24 01:18 user2_doc
   drwxr-xr-x 2 user1 group3 4096 Oct 24 01:19 user3_doc
   ```

   

具体的[看这里](http://c.biancheng.net/view/860.html)