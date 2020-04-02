<center>Linux具体命令</center>
#### 1.	cd

全称为`change directory`用作切换工作目录

cd命令的基本格式如下：

```shell
[root@localhost ~]# cd [相对路径或绝对路径]
```

除此之外，cd命令后面还可以跟一些特殊符号，表达固定的定义

| 特殊符号 | 作用                       |
| -------- | -------------------------- |
| ~        | 代表当前用户的主目录       |
| ~用户名  | 表示切换至指定用户的主目录 |
| -        | 代表上次所在的目录         |
| .        | 代表当前目录               |
| ..       | 代表上级目录               |

关于`~`其实你认真发现的话就可以看到。

```shell
[root$localhost ~]# cd -
//这里可以看到有一个~这个表示的就是用户的主目录，表示我现在就在用户的主目录
//~表示主目录
```

`cd -`就代表回退，退到上次所在的目录

`cd ..`代表退回上级目录。（ps.注意`cd-`和`cd ..`的区别）



#### 2.	pwd

pwd命令，全称(`print working directory`)，功能是显示用户当前所处的工作目录，该命令的基本格式为：

```shell
[root@localhost ~]# pwd
/root						//表示当前目录为/root目录
[root@localhost ~]# whoami
root						//表示当前用户为root用户
```

注意`[root@localhost ~]# cd -`中的`~`表示的是当前为主目录，但是此处的显示只能显示路径中的最后一个目录





#### 3.	ls命令

ls命令，`list`的缩写，是最常见的目录操作命令，其主要功能是显示当前目录下的内容。		格式如下：

```shell
[root@localhost ~]ls [选项]目录名称
```



以下是ls命令常用的选项和各自的功能：

| 选项                                      | 功能                                                         |
| ----------------------------------------- | ------------------------------------------------------------ |
| -a                                        | 显示全部的文件，包括隐藏文件（开头为 . 的文件）也一起罗列出来，这是最常用的选项之一。 |
| -A                                        | 显示全部的文件，连同隐藏文件，但不包括 . 与 .. 这两个目录。  |
| -d                                        | 仅列出目录本身，而不是列出目录内的文件数据。                 |
| -f                                        | ls 默认会以文件名排序，使用 -f 选项会直接列出结果，而不进行排序。 |
| -F                                        | 在文件或目录名后加上文件类型的指示符号，例如，* 代表可运行文件，/ 代表目录，= 代表 [socket](http://c.biancheng.net/socket/) 文件，\| 代表 FIFO 文件。 |
| -h                                        | 以人们易读的方式显示文件或目录大小，如 1KB、234MB、2GB 等。  |
| -i                                        | 显示 inode 节点信息。                                        |
| -l                                        | 使用长格式列出文件和目录信息。                               |
| -n                                        | 以 UID 和 GID 分别代替文件用户名和群组名显示出来。           |
| -r                                        | 将排序结果反向输出，比如，若原本文件名由小到大，反向则为由大到小。 |
| -R                                        | 连同子目录内容一起列出来，等於将该目录下的所有文件都显示出来。 |
| -S                                        | 以文件容量大小排序，而不是以文件名排序。                     |
| -t                                        | 以时间排序，而不是以文件名排序。                             |
| --color=never --color=always --color=auto | never 表示不依据文件特性给予颜色显示。 always 表示显示颜色，ls 默认采用这种方式。 auto 表示让系统自行依据配置来判断是否给予颜色。 |
| --full-time                               | 以完整时间模式 （包含年、月、日、时、分）输出                |
| --time={atime,ctime}                      | 输出 access 时间或改变权限属性时间（ctime），而不是内容变更时间。 |



实例1：

```shell
[root@localhost ~]# ls -al ~
total 156
drwxr-x---  4 root root  4096 Sep 24 00:07 .
drwxr-xr-x 23 root root  4096 Sep 22 12:09 ..
-rw-------  1 root root  1474 Sep  4 18:27 anaconda-ks.cfg
-rw-------  1 root root   955 Sep 24 00:08 .bash_history
-rw-r--r--  1 root root    24 Jan  6  2007 .bash_logout
-rw-r--r--  1 root root   191 Jan  6  2007 .bash_profile
-rw-r--r--  1 root root   176 Jan  6  2007 .bashrc
drwx------  3 root root  4096 Sep  5 10:37 .gconf
-rw-r--r--  1 root root 42304 Sep  4 18:26 install.log
-rw-r--r--  1 root root  5661 Sep  4 18:25 install.log.syslog
```

此处没有隐藏文件，隐藏文件是以`.`开头的。Linux中的隐藏文件都是重要的系统文件才会被隐藏

上面代码中的`ls -l`命令显示了文件的详细信息，这七项的含义分别是：

1.第一列：规定了不同用户对文件所拥有的权限。

2.第二列：引用计数，文件的引用计数代表该文件的硬链接个数，而目录的引用计数代表该目录有多少个子目录

3.第三列：所有者，也就是这个文件属于哪个用户。默认的所有者是文件的建立用户

4.第四列：所属组，默认所属组是文件建立用户的有效组，一般情况下就是建立用户所在的组

5.第五列：大小，默认单位是字节。可以通过`-h`选项自适应显示。自适应换单位

6.第六列：文件修改时间，文件状态修改时间或文件数据修改时间都会更改这个时间，注意这个时间不是文件的创建时间。

7.第七列：文件名或目录名



实例2：

如果想要看某个目录的详细信息，例如：

```shell
[root@localhost ~]# ls -l /root
-rw-------.1 root root 1207 1 月 14 18:18 anaconda-ks.cfg
```



此`ls`命令会显示目录下的内容，而不会显示这个目录本身的详细信息。如果想显示目录本身的信息，就必须加如"-d"选项。

```shell
[root@localhost ~]# ls -ld /root
dr-xr-x---.2 root root 4096 Jna 20 12:30 /root/
```



另一个命令`ll`。此命令其实说白了就是`ls -l`



上面以及说过`-h`选项了



#### 4.	mkdir

`mkdir`，全称`make directories`

mkdir命令的基本格式为：

```shell
[root@localhost ~]# mkdir [-mp]目录名
```

+ -m选项用于手动配置所创建的目录权限，而不再使用默认权限。
+ -p选项递归创建所有目录，以创建/hoem/test/demo为例，在默认情况下，你需要一层一层创建各个目录，而使用-p选项，则系统会自动帮你创建/home,/home/test和/home/test/demo目录



`-p`选项

```
[root@localhost ~]# mkdir test1              //当前目录下创建tset1

[root@localhost ~]# mkdir -p test1/test2/test3
	//此处递归的在当前目录下创建test1目录里面包含test2,test2包含test3
	
！！！注意
[root@localhost ~]# mkdir -p /test1/test2/test3
//此句的命令和上面这句不同，此句是在根目录下创建test1，test1包含test2，test2包含test3
```



`-m`选项

```
[root@localhost ~]# mkdir -m 711 test
```

创建一个权限值为`711`的目录。权限值为设定访问权限

(ps.没有`-m`选项的话默认权限值为755)  



#### 5.	rmdir

rmdir,全称`remove empty directories`，移除空目录

基本格式为：

```shell
[root@localhost ~]# rmdir [-p]目录名					//移除空目录
```

ps.rmdir只能删除空目录。删除非空目录会报错，



`-p`选项

-p选项用于递归的删除空目录，（就像mkdir的递归创建一样）

```shell
[root@localhost ~]# rmdir -p test1/test2/test3
//删除当前目录下的test1/其中包含test2，test2包含test3
   //此方式是从最低一层的目录开始删除，一层一层的删除直到test1，不为空就报错
	
    //如果，此处不加-p选项的话。只会删除最底层的目录
```



此命令比较“笨”，所以不常用。后续学到rm的时候。更多用rm





#### 6.	touch

`touch`命令用作创建文件。

```shell
[root@localhost ~]# touch test
```



如果当前目录已经有了`touch`要创建的文件，则会修改文件的访问时间。



`touch`还有一个功能就是更改文件的**时间参数**



Linux系统中，每个文件主要拥有3个时间参数，分别是文件的访问时间，数据修改时间和状态修改时间：

+ 访问时间(Access time,简称`atime`)，只要文件的内容被读取，访问的时间就会刷新。例如使用`cat`命令查看文件时，就会改变文件的访问时间
+ 数据修改时间(Modify time,简称`mtime`)，当文件的内容数据发生改变时，此文件的数据修改时间就会发生改变。
+ 状态改变时间(Change time,简称`ctime`)，当文件的状态发生改变，就会相应的改变这个时间。比如说，如果文件的权限或属性发生改变，此时间就会发生改变



`touch`命令的基本格式如下：

```shell
[root@localhost ~]# touch [选项] 文件名
```

选项：

+ -a：只修改文件的访问时间；		（ps.修改为当前时间）
+ -c：仅修改文件的时间参数，(3个时间参数都改变)，如果文件不存在则不修改

+ -d：后面跟欲修订的时间，而不用当前的时间，即把文件的mtime和atime都改为指定时间
+ -m：只修改文件的mtime时间。
+ -t：后面可以跟欲修订的时间，不用当前时间，时间书写格式为`YYMMDDHHMM`



实例1：

创建文件：

```shell
[root@localhost ~]# touch test
```



实例2：

不用选项修改文件的访问时间

```
[root@localhost ~]# ll --time=atime test		
//查看文件的访问时间						
 -rw-r--r-- 1 root root 0 Sep 25 21:23 bols   //ll命令，ls节说过了 
 
[root@localhost ~]# touch test			//实例1已经创建了test文件

[root@localhost ~]# ll --time=atime test
-rw-r--r-- 1 root root 0 May 15 16:36 bols	

						//touch命令，文件存在则会修改文件的访问时间
```



实例3：

修改文件的atime和ctime

```shell
[root@localhost ~]# touch -d "2015-02-03" test
[root@localhost ~]# ll test; ll --time=atime test; ll --time=ctime test
-rw-r--r-- 1 root root 0 May 4 2017 bols
-rw-r--r-- 1 root root 0 May 4 2017 bols
-rw-r--r-- 1 root root 0 Sep 25 21:40 bols
#ctime不会变为设定时间，但会变为当前服务器时间
```





#### 7.	ln建立 软/硬链接

**是L不是i**

具体的区别，和ext4文件系统已经在  ../linux理论中讲了，这里只讲In的用法

```shell
[root@localhost ~]# ln [选项] 源文件 目标文件
```

选项：

+ -s：建立软连接，默认为硬链接
+ -f：强制建立，如果目标文件已经存在，则删除目标文件后重新建立链接文件





硬链接：

```shell
[root@localhost ~]# touch test					//创建test文件
[root@localhost ~]# echo 111 >> test			//test文件写入111
[root@localhost ~]# ln test /home/test1
									//创建硬链接到/home/test1中
[root@localhost ~]# cd /home/test1				//进入/home目录
[root@localhost home]# cat test1				//查看test1文件
111							//test1文件内容为111
```



软链接：

```shell
[root@localhost ~]# touch test2
[root@localhost ~]# echo 222 >> test2
[root@localhost ~]# ln /root/test2 /home/test2
[root@localhost ~]# cd /home
[root@localhost ~]# cat test2
222
```

##### 注意：

+ 硬链接不能链接目录
+ 硬链接不能跨文件系统（分区）建立，因为在不同的文件系统中，inode号是重新计算的
+ 软连接在命令行创建的时候，必须写绝对路径。硬链接才可以用相对路径
+ 一般软连接用的比较的多





#### 8.	cp

`cp`命令，主要用于复制文件和目录。同时借助某些选项，还可以复制整个目录，已经对比两文件的新旧而给予升级等功能



cp命令基本格式如下：

```shell
[root@localhost ~]# cp [选项] 源文件 目标文件
```

选项：

+ -a：相当于-d，-p，-r选项的集合。
+ -d：如果源文件为软连接(对硬链接无效)，则复制出的目录也为软连接;否则的话复制的为软连接指向的源文件
+ -i：询问，如果目标文件已经建立，则会询问是否覆盖；
+ -l：把目标文件创建为源文件的硬链接，而不是复制源文件。（写绝对路径）
+ -s：把目标文件创建为源文件的软连接，而不是复制源文件。（写绝对路径）
+ -p：复制后目标文件保留源文件的属性（包括所有者，权限和时间）
+ -r：递归复制，用于复制目录
+ -u：若目标文件比源文件有差异，则使用该选项可以更新目标文件，此选项可用于对文件的升级和备用



这里不做过多演示，自己下来慢慢试



#### 9.	rm

rm，全称`remove`。删除命令

此命令的基本格式为：

```shell
[root@lcalhost ~]# rm [选项] 文件或目录
```

选项：

+ -f：强制删除，和-i选项相反，使用-f，系统将不会再发出询问，而是直接删除目标文件和目录
+ -i：询问删除，和-f相反，在删除文件或目录前，系统会给出提示信息，使用-i可以有效的防止不小心，删除有用的文件或目录。
+ -r：递归删除，主要用于删除目录，可删除指定目录以及包含的所有内容，包括子目录和文件。

默认的`rm`指令是自带的`-i`的。



删除目录如果不加`-f`选项的话，会反复的问很多次





#### 10.	mv

mv命令，全称`move`。

该命令的基本格式如下：

```shell
[root@localhost ~]# rm [选项] 源文件 目标文件
```

选项：

+ -f：强制覆盖，如果目标文件以及存在，则不询问，直接强制覆盖
+ -i：交互移动，如果目标文件以及存在，则询问用户是否覆盖
+ -n：如果目标文件已经存在，则不会覆盖移动，也不会询问用户
+ -u：如果目标文件已存在，但两者相比源文件更新，则更新目标文件



此处只简单的说一下改名的实例：

如果源文件和目标文件在同一文件夹，则mv命令会编程和改名：

```shell
[root@localhost ~]# mv test test1		
把test改名为test1
```





#### 11.	通配符



##### 命令自动补全

Shell (Bash) 提供了一种“命令行自动补全”的动能，在输入文件名的时候，只需要输入改文件名的前几个字符，然后按Tab键，Shell就可以自动将文件名补全。

```shell
[root@localhost ~]# cd /etc
[root@localhost ~]# cd fs <---按一次Tab键
```

当按下`Tab`键，你会发现Shell自动将"fs"补全为"fatab"，这是因为当前/etc目录中只有fstab是以"fs"开头的，因此Shell可以确定这里想要输入的文件名称为fstab。



如果当前目录中含有多个以指定字符（或字符串）开头的文件或目录，Shell就不能成功辨认了，不过连按两次“Tab”可以列出以输出字符串开头的文件或目录



命令行也可以这样用，输入"ca"，连按两次空格，就可以看出所有"ca"开头的命令

```shell
[root@localhost ~]# ca<---连按两次tab	,列出命令
[root@localhost ~]# ca <--留个空格,再连按两次Tab,列出ca开头的文件或目录
```



##### 通配符

和`sql`中的适配符相似

| 符号 | 作用                                                         |
| ---- | ------------------------------------------------------------ |
| *    | 匹配任意数量的字符。                                         |
| ?    | 匹配任意一个字符。                                           |
| []   | 匹配括号内的任意一个字符，甚至 [] 中还可以包含用 -（短横线）连接的字符或数字，表示一定范围内的字符或数字。 |



实例如下：

```
[root@localhost ~]# ls -l [abc]?[def]
	//列出所有以a或b或c开头，以d或e或f结尾的，字符长度为3的文件或目录
```



#### 12.	alias

使用`alias`命令来为命令增添一个别名，例如：

```
[root@localhost ~]# alias rm		//查看别名 rm
alias rm='rm -i'		//打印出别名rm的详细的命令
```



删除别名：

```shell
[root@localhost ~]# unalias rm			//使用unalias删除别名
[root@localhost ~]# rm test	//删除了别名后，rm就会直接删除，不在询问
```



添加别名：

```shell
[root@localhost ~]# alias rm='rm -i'		//添加别名
```





#### 13.	export

使用`export`命令来显示或者设置全局变量。

这里只说设置：

```shell
[root@localhost ~]# WORDKEY=/home/admin/test1	//设置一个路径环境
[root@localhost ~]# cd $WORDKEY    		//进入环境指定的路径
		
[root@localhost test1]# su admin		//切换普通用户
[admin@localhost ~]# cd $WORDKEY	//此处进不去,因为上面的环境只是临时的，切换了用户后，就不管用了。想要管用的话就得使用export命令
[admin@localhost ~]# su root
[root@localhost ~]# export WORDKEY

				//使用了export命令后，设置的WORDKEY就是全局变量了
```





#### 14.	which

which,用于查找。





实例1 ：

使用`which`查找`ls`命令的绝对路径

```shell
[root@localhost ~]# which rm	//使用which命令查看ls命令的绝对路径
 /bin/rm
```



#### 15.	env

`env`命令，作用是查看`Linux`系统中所有的环境变量。执行命令如下：

```
[root@localhost ~]# env
ORBIT_SOCKETDIR=/tmp/orbit-root
HOSTNAME=livecd.centos
GIO_LAUNCHED_DESKTOP_FILE_PID=2065
TERM=xterm
SHELL=/bin/bash
......
```





#### 16.	tar



##### tar命令做打包操作



当`tar`命令做打包操作时，基本格式为：

```shell
[root@localhost ~]# tar [选项] 源文件或目录
```



选项如下：

| 选项    | 含义                                                         |
| ------- | ------------------------------------------------------------ |
| -c      | 将多个文件或目录进行打包。                                   |
| -A      | 追加 tar 文件到归档文件。                                    |
| -f 包名 | 指定包的文件名。包的扩展名是用来给管理员识别格式的，所以一定要正确指定扩展名； |
| -v      | 显示打包文件过程；                                           |

`-cvf`是习惯用法



实例1：

```
[root@localhost ~]# tar -cvf test.tar test/
test/							//将test目录打包成 test.tar包
test/test3
test/test2
test/test1
[root@localhost ~]# tar -cvf test1.tar test/ test2.cfg 
									//使用tar打包多个文件或目录
```



实例2：

使用`gzip`命令压缩包

```shell
[root@localhost ~]# gzip test.tar   //使用gzip命令压缩之前的test.tar包
[root@localhost ~]# ll -d test.tar.gz
-rw-r--r-- 1 root root 176 6月 18 01:06 test.tar.gz
```





##### tar命令做解打包操作

tar命令做解打包操作，的基本格式如下：

```shell
[root@localhost ~]# tar [选项] 目标包
```



选项，如下：

| 选项    | 含义                                                       |
| ------- | ---------------------------------------------------------- |
| -x      | 对 tar 包做解打包操作。                                    |
| -f      | 指定要解压的 tar 包的包名。                                |
| -v      | 显示解打包的具体过程。                                     |
| -t      | 只查看 tar 包中有哪些文件或目录，不对 tar 包做解打包操作。 |
| -C 目录 | 指定解打包位置。                                           |

其实解包和打包相比只是将`-cvf`命令换成`-xvf`命令而已





实例1：

使用`-xvf`命令解打包，并且使用`-C`命令指定解包位置。

```shell
[root@localhost ~]# tar -xvf test.tar -C /root/admin	
						//解文件包test.tar到/root/admin目录下
```



实例2：

使用`-tvf`命令，不解包，只是查看包的内容。

```
[root@localhost ~]# tar -tvf test.tar
drwxr-xr-x root/root 0 2016-06-17 21:09 test/
-rw-r-r- root/root 0 2016-06-17 17:51 test/test3
-rw-r-r- root/root 0 2016-06-17 17:51 test/test2
-rw-r-r- root/root 0 2016-06-17 17:51 test/test1
```



##### tar命令做打包压缩操作

> 上面的只是进行tar打包操作，还没有进行压缩,(ps.有一个进行了的)。

> 打包和压缩看起来很麻烦，需要分开坐，其实可以使用`tar`命令一起做的



使用`tar`命令同时进行打包压缩操作 ，其基本格式如下：

```shell
[root@localhost ~]# tar [选项] 压缩包名 源文件或目录
```



此处的常用选项有两个：

+ `-z`：压缩与解压缩“.tar.gz”格式
+ `-j`：压缩与解压缩“.tar.gz2”格式



实例1：

> 压缩为“.tar.gz”格式的文件或目录

```shell
[root@localhost ~]# tar -zcvf test.tar.gz test/
#将当前目录下的test目录，打包成gz格式的压缩包test.tar.gz
```



> 解压缩“.tar.gz”格式的文件

```shell
[root@localhost ~]# tar -zxvf test.tar.gz -C /home/admin
		//解压缩test.tar.gz格式的压缩包到/home/admin目录下
```

前面讲的选项“-C”和“-t”在这里同样适用



> 想要压缩和解压缩bzip2格式。只需要把上面命令的z换成j就行了





#### 17.	zip

使用`zip`命令来对文件进行压缩操作，此`zip`命令类似于`Windows`系统种的`winzip`压缩程序。



基本格式，如下：

```shell
[root@localhost ~]# zip [选项] 压缩包名 源文件或目录
```

> 注意，zip命令需要手工指定压缩后的压缩包名



常用选项：

| 选项      | 含义                                                         |
| --------- | ------------------------------------------------------------ |
| -r        | 递归压缩目录，及将制定目录下的所有文件以及子目录全部压缩。   |
| -m        | 将文件压缩之后，删除原始文件，相当于把文件移到压缩文件中。   |
| -v        | 显示详细的压缩过程信息。                                     |
| -q        | 在压缩的时候不显示命令的执行过程。                           |
| -压缩级别 | 压缩级别是从 1~9 的数字，-1 代表压缩速度更快，-9 代表压缩效果更好。 |
| -u        | 更新压缩文件，即往压缩文件中添加新文件。                     |





实例1：

> 使用zip命令进行多个文件的打包操作

```shell
[root@localhost ~]# zip test.zip test1 test2 test3
[root@localhost ~]# ll test.zip
-rw-r--r-- 1 root root 935 6月 1716:00 test.zip
```



实例2：

>  对目录进行打包操作

```shell
[root@localhost ~]# zip -r test.zip test/
			//对test目录进行打包操作
```





#### 18.	unzip

`unzip`命令用于 解压`zip`命令压缩的压缩包

基本格式，如下：

```
[root@localhost ~]# unzip [选项] 压缩包名
```

> 选项

| 选项        | 含义                                                         |
| ----------- | ------------------------------------------------------------ |
| -d 目录名   | 将压缩文件解压到指定目录下。                                 |
| -n          | 解压时并不覆盖已经存在的文件。                               |
| -o          | 解压时覆盖已经存在的文件，并且无需用户确认。                 |
| -v          | 查看压缩文件的详细信息，包括压缩文件中包含的文件大小、文件名以及压缩比等，但并不做解压操作。 |
| -t          | 测试压缩文件有无损坏，但并不解压。                           |
| -x 文件列表 | 解压文件，但不包含文件列表中指定的文件。                     |



实例1：

> 使用unzip的-d选项命令。压压缩包，并放在指定目录

```shell
[root@localhost ~]# unzip -d /home/admin test.zip
```





#### 19.	gzip

`gzip`命令，Linux种经常用来压缩和解压的命令，通过此命令进行压缩压缩包，其扩展名通常为`gz`。

> gzip命令只能用来压缩文件，不能压缩目录，即便指定了目录，也只能压缩目录内的所有文件



基本格式，如下：

```shell
[root@localhost ~]# gzip [选项] 源文件
```

> 选项如下

| 选项  | 含义                                                         |
| ----- | ------------------------------------------------------------ |
| -c    | 将压缩数据输出到标准输出中，并保留源文件。                   |
| -d    | 对压缩文件进行解压缩。                                       |
| -r    | 递归压缩指定目录下以及子目录下的所有文件。                   |
| -v    | 对于每个压缩和解压缩的文件，显示相应的文件名和压缩比。       |
| -l    | 对每一个压缩文件，显示以下字段：压缩文件的大小；未压缩文件的大小；压缩比；未压缩文件的名称。 |
| -数字 | 用于指定压缩等级，-1 压缩等级最低，压缩比最差；-9 压缩比最高。默认压缩比是 -6。 |



实例1：

> 使用gzip命令进行压缩

```shell
[root@localhost ~]# gzip test.log
[root@localhost ~]# ls
test1 	test2 	test.log.gz		//gzip命令压缩文件，不会保留源文件
```



实例2：

> 使用gzip命令压缩，并保留源文件

```shell
[root@localhost ~]# gzip -c test.log >> test.log.gz
				//此种方法的gzip命令，压缩的操作，会保留源文件
```



实例3：

> 实例3就不写了，简单说就是如果压缩的是目录，哪怕加上-r命令。也只会压缩源目录中的所有的文件而已，（ps.还是保留在源文件夹内）

`gzip`命令不会打包目录，而是把目录下的子文件分别进行压缩





#### 20.	gunzip

`gunzip`解压缩命令，用作解压`.gz`格式的压缩包

基本格式，为：

```shell
[root@localhost ~]# gunzip [选项] 文件
```



> 选项

| 选项 | 含义                                               |
| ---- | -------------------------------------------------- |
| -r   | 递归处理，解压缩指定目录下以及子目录下的所有文件。 |
| -c   | 把解压缩后的文件输出到标准输出设备。               |
| -f   | 强制解压缩文件，不理会文件是否已存在等情况。       |
| -l   | 列出压缩文件内容。                                 |
| -v   | 显示命令执行过程。                                 |
| -t   | 测试压缩文件是否正常，但不对其做解压缩操作。       |



实例1：

> 简单实例，直接解压缩

```shell
[root@localhost ~]# gunzip test.tar.gz
		//还可以使用gzip -d命令来解压缩
[root@localhost ~]# gzip -d test.tar.gz
```



实例2：

> 使用gunzip -r命令来解压缩，目录下的所有压缩包

```
[root@localhost ~]# gunzip -r test/
```

> 可以使用zcat命令，不解压缩的情况下进行查看文本文件中的内容





#### 21.	bzip2

`bzip2`命令同`gzip`命令类似，只能对文件进行压缩(或解压缩)。对于目录，`bzip2`连`-r`选项都没有

> ps. 	bzip2压缩的更好，gzip压缩的更快



基本格式，如下：

```shell
[root@localhost ~]# bzip2 [选项] 源文件
```



选项：

| 选项  | 含义                                                         |
| ----- | ------------------------------------------------------------ |
| -d    | 执行解压缩，此时该选项后的源文件应为标记有 .bz2 后缀的压缩包文件。 |
| -k    | bzip2 在压缩或解压缩任务完成后，会删除原始文件，若要保留原始文件，可使用此选项。 |
| -f    | bzip2 在压缩或解压缩时，若输出文件与现有文件同名，默认不会覆盖现有文件，若使用此选项，则会强制覆盖现有文件。 |
| -t    | 测试压缩包文件的完整性。                                     |
| -v    | 压缩或解压缩文件时，显示详细信息。                           |
| -数字 | 这个参数和 gzip 命令的作用一样，用于指定压缩等级，-1 压缩等级最低，压缩比最差；-9 压缩比最高 |

> 注意，bzip2压根没有-r选项。根本不支持压缩目录



实例1：

> 简单的使用bzip2命令压缩文件

```shell
[root@localhost ~]# bzip2 test2				//直接进行打包文件

[root@localhost ~]# bzip2 -k test2		//不删除源文件的压缩操作
```





#### 22.	bunzip2

`bunzip2`命令，用于对`bzip2`格式的压缩包进行解压

> bunzip2命令解压目录的话，只会解压目录下的所有文件



`buzip2`命令的基本格式，为：

```shell
[root@localhost ~]# bunzip2 [选项] 源文件
```



选项：

| 选项 | 含义                                                         |
| ---- | ------------------------------------------------------------ |
| -k   | 解压缩后，默认会删除原来的压缩文件。若要保留压缩文件，需使用此参数。 |
| -f   | 解压缩时，若输出的文件与现有文件同名时，默认不会覆盖现有的文件。若要覆盖，可使用此选项。 |
| -v   | 显示命令执行过程。                                           |
| -L   | 列出压缩文件内容。                                           |



实例1：

> 直接使用bunzip2命令进行解压

```
[root@localhost ~]# bunzip2 test.bz2	//直接使用bunzip2命令进行解压

								//也可以使用bzip2 -d命令进行解压
[root@localhost ~]# bzip2 -d test.bz2	
```



> 和gzip一样,bzip2”格式的压缩的纯文本也可以不解压直接看，使用命令为bzcat





#### 23.	cat

`cat`全称`concatenate`(连续)。

基本格式如下：

```shell
[root@localhost ~]#cat [选项] 文件名
或者
[root@localhost ~]# cat 文件1 文件2 > 文件3
```



> 选项

| 选项 | 含义                                                     |
| ---- | -------------------------------------------------------- |
| -A   | 相当于 -vET 选项的整合，用于列出所有隐藏符号；           |
| -E   | 列出每行结尾的回车符 $；                                 |
| -n   | 对输出的所有行进行编号；                                 |
| -b   | 同 -n 不同，此选项表示只对非空行进行编号。               |
| -T   | 把 Tab 键 ^I 显示出来；                                  |
| -V   | 列出特殊字符；                                           |
| -s   | 当遇到有连续 2 行以上的空白行时，就替换为 1 行的空白行。 |

> 主要用的，我看也就-A 和-n



实例1 ：

> 使用cat -n命令来带编号查看

```
[root@localhost ~]# cat -n test1
1 # Kickstart file automatically generated by anaconda.
2
3
4 #version=DEVEL
5 install
```

可以看到，此时查看的文本都是带上了编号的

> -A 命令的话就不说了





实例2 ： 

> 使用cat >输出重定向的方式来查看。

```shell
[root@localhost ~]# cat test1 test2 > test3 
[root@localhost ~]# cat test3
test1的内容
test2的内容
```



#### 24.	more

`more`命令用作查看内容较大的文本

> 使用方法和cat类似



选项：

| 选项 | 含义                                                     |
| ---- | -------------------------------------------------------- |
| -f   | 计算行数时，以实际的行数，而不是自动换行过后的行数。     |
| -p   | 不以卷动的方式显示每一页，而是先清除屏幕后再显示内容。   |
| -c   | 跟 -p 选项相似，不同的是先显示内容再清除其他旧资料。     |
| -s   | 当遇到有连续两行以上的空白行时，就替换为一行的空白行。   |
| -u   | 不显示下引号（根据环境变量 TERM 指定的终端而有所不同）。 |
| +n   | 从第 n 行开始显示文件内容，n 代表数字。                  |
| -n   | 一次显示的行数，n 代表数字。                             |





`more`命令的执行会打开一个交互界面，所以有一些交互的命令需要了解

| 交互指令            | 功能                                                       |
| ------------------- | ---------------------------------------------------------- |
| h 或 ？             | 显示 more 命令交互命令帮助。                               |
| q 或 Q              | 退出 more。                                                |
| v                   | 在当前行启动一个编辑器。                                   |
| :f                  | 显示当前文件的文件名和行号。                               |
| !<命令> 或 :!<命令> | 在子[Shell](http://c.biancheng.net/shell/)中执行指定命令。 |
| 回车键              | 向下移动一行。                                             |
| 空格键              | 向下移动一页。                                             |
| Ctrl+l              | 刷新屏幕。                                                 |
| =                   | 显示当前行的行号。                                         |
| '                   | 转到上一次搜索开始的地方。                                 |
| Ctrf+f              | 向下滚动一页。                                             |
| .                   | 重复上次输入的命令。                                       |
| / 字符串            | 搜索指定的字符串。                                         |
| d                   | 向下移动半页。                                             |
| b                   | 向上移动一页。                                             |

> 一般就`q`，`v`，`:f`，`回车键`，`空格键`，`=`，`/搜索`，`d`，`b`用的比较多





实例1： 

> 简单的使用more命令

```
[root@localhost ~]# more test1.txt
# Kickstart file automatically generated by anaconda.
#version=DEVEL
install
cdrom
…省略部分内容…
--More--(69%)
#在此处执行交互命令即可
```





实例2 ：

> 显示文件`test1.txt`的内容，每十行显示一屏，同时清除屏幕

```
[root@localhost ~]# more -c 10 test1.txt
```







#### 25.	head

`head`命令也是用作查看文本的，不过可以指定显示文件前若干行。



格式如下：

```shell
[root@localhost ~]#	head [选项] 文件名
```



选项如下：

| 选项 | 含义                                                         |
| ---- | ------------------------------------------------------------ |
| -n K | 这里的 K 表示行数，该选项用来显示文件前 K 行的内容；如果使用 "-K" 作为参数，则表示除了文件最后 K 行外，显示剩余的全部内容。 |
| -c K | 这里的 K 表示字节数，该选项用来显示文件前 K 个字节的内容；如果使用 "-K"，则表示除了文件最后 K 字节的内容，显示剩余全部内容。 |
| -v   | 显示文件名；                                                 |



实例1：

> 简单的使用head 

```shell
[root@localhost ~]# head test1.txt
```

如不设置显示的具体行数的话，默认是10行 



实例2：

> 使用-n 和-c选项来设定显示文件显示的内容

```shell
[root@localhost ~]# head -n 10 test1.txt
也可以直接写
[root@localhost ~]# hdead -10 test1.txt

使用-c指令
[root@localhost ~]# head -c 10 test1.txt
[root@localhost ~]# head -c -10 test1.txt
		//此处最后一行指令作用为：显示除了最后10个字节之外的全部内容
```







#### 26.	less

`less`，作用和`more`十分类似。不过`less`更加的强大，支持的功能更多

> 建议以后长内容的更多用`less`和`more`



基本格式：

```shell
[root@localhost ~]# less [选项] 文件名
```



选项如下：

| 选项            | 选项含义                                               |
| --------------- | ------------------------------------------------------ |
| -N              | 显示每行的行号。                                       |
| -S              | 行过长时将超出部分舍弃。                               |
| -e              | 当文件显示结束后，自动离开。                           |
| -g              | 只标志最后搜索到的关键同。                             |
| -Q              | 不使用警告音。                                         |
| -i              | 忽略搜索时的大小写。                                   |
| -m              | 显示类似 more 命令的百分比。                           |
| -f              | 强迫打开特殊文件，比如外围设备代号、目录和二进制文件。 |
| -s              | 显示连续空行为一行。                                   |
| -b <缓冲区大小> | 设置缓冲区的大小。                                     |
| -o <文件名>     | 将 less 输出的内容保存到指定文件中。                   |
| -x <数字>       | 将【Tab】键显示为规定的数字空格。                      |

> 用的多的一般就`-N`，`-m`，



使用`less`的时候和`more`一样，也会进入交互界面，以下是一些常用的交互指令。

| 交互指令   | 功能                                   |
| ---------- | -------------------------------------- |
| /字符串    | 向下搜索“字符串”的功能。               |
| ?字符串    | 向上搜索“字符串”的功能。               |
| n          | 重复*前一个搜索（与 / 成 ? 有关）。    |
| N          | 反向重复前一个搜索（与 / 或 ? 有关）。 |
| b          | 向上移动一页。                         |
| d          | 向下移动半页。                         |
| h 或 H     | 显示帮助界面。                         |
| q 或 Q     | 退出 less 命令。                       |
| y          | 向上移动一行。                         |
| 空格键     | 向下移动一页。                         |
| 回车键     | 向下移动一行。                         |
| 【PgDn】键 | 向下移动一页。                         |
| 【PgUp】键 | 向上移动一页。                         |
| Ctrl+f     | 向下移动一页。                         |
| Ctrl+b     | 向上移动一页。                         |
| Ctrl+d     | 向下移动一页。                         |
| Ctrl+u     | 向上移动半页。                         |
| j          | 向下移动一行。                         |
| k          | 向上移动一行。                         |
| G          | 移动至最后一行。                       |
| g          | 移动到第一行。                         |
| ZZ         | 退出 less 命令。                       |
| v          | 使用配置的编辑器编辑当前文件。         |
| [          | 移动到本文档的上一个节点。             |
| ]          | 移动到本文档的下一个节点。             |
| p          | 移动到同级的上一个节点。               |
| u          | 向上移动半页。                         |

> 相当于more和vim的以下指令混合到了一起





实例1：

> 简单的使用less命令

```
[root@localhost ~]# less -Nm test1.txt
```

> 交互指令的话就不试了，有需要自己试





#### 27.	tail

`tail`命令用于查看文件末尾的数据，和`head`正好相反。



基本格式如下：

```shell
[root@localhost ~]# tail [选项] 文件名
```



| 选项 | 含义                                                         |
| ---- | ------------------------------------------------------------ |
| -n K | 这里的 K 指的是行数，该选项表示输出最后 K 行，在此基础上，如果使用 -n +K，则表示从文件的第 K 行开始输出。 |
| -c K | 这里的 K 指的是字节数，该选项表示输出文件最后 K 个字节的内容，在此基础上，使用 -c +K 则表示从文件第 K 个字节开始输出。 |
| -f   | 输出文件变化后新增加的数据。                                 |

> `-f`命令可用于监听文件新增的内容



实例1：

> 使用tail的`-n`和`-c`命令，查看文件

```
[root@localhost ~]# tail -n 10 test1			//查看文件最后十行内容
[root@localhost ~]# tail -c 10 test1 	//查看文件最后十个字节的内容
```



实例2：

> 使用`tail`的`-f`监听功能

```
[root@localhost ~]# tail -f test1.txt
fdsa
fdsa
fdsa
fsda
fdsa
//此时光标并不会退出文件	，而是一直监听在文件的结尾处
```



此时的话需要新开一个终端。

```
[root@localhost ~]# echo 111 >> test1.txt	//使用echo往文件中追加数据
```



那么在原始监听的终端中，会看到如下的信息：

```
[root@localhost ~]# tail -f test1.txt
fdsa
fdsa
fdsa
fsda
fdsa
111
```



#### 28.	重定向

关于文本处理，还有一个重定向的问题，不过我把它放在`Linux`理论中了



#### 29.	groups

使用`groups`命令，可以查看当前登录账户的所属组有哪些。实例：

```
[jack@localhost ~]# groups
jack root		//可以看到当前账户jack，加入的组有jack初始组和root附加组
```





#### 30.	source

> 此命令好像是用来保存的，修改的设置的

类似于在`kali`，里面使用的`sync`命令：将内存中的数据写入硬盘中

例如，在`Linux杂项/Linux踩过的坑中/设置系统中文英文的问题`中

修改了`/etc/profile`文件后就需要使用`source`命令保存一下。

```
[root@localhost ~]# source /etc/profile			//修改了过后就用此命令保存
```



#### 31.dd

> dd 命令，用指定大小的块拷贝一个文件，并在拷贝的同时进行指定的转换。

##### 参数注释：

1. if=文件名：输入文件名，缺省为标准输入。即指定源文件。< if=input file >
2. of=文件名：输出文件名，缺省为标准输出。即指定目的文件。< of=output file >
3. ibs=bytes：一次读入bytes个字节，即指定一个块大小为bytes个字节。
   obs=bytes：一次输出bytes个字节，即指定一个块大小为bytes个字节。
   bs=bytes：同时设置读入/输出的块大小为bytes个字节。
4. cbs=bytes：一次转换bytes个字节，即指定转换缓冲区大小。
5. skip=blocks：从输入文件开头跳过blocks个块后再开始复制。
6. seek=blocks：从输出文件开头跳过blocks个块后再开始复制。
   注意：通常只用当输出文件是磁盘或磁带时才有效，即备份到磁盘或磁带时才有效。
7. count=blocks：仅拷贝blocks个块，块大小等于ibs指定的字节数。
8. conv=conversion：用指定的参数转换文件。

- - ascii：转换ebcdic为ascii
  - ebcdic：转换ascii为ebcdic
  - ibm：转换ascii为alternate ebcdic
  - block：把每一行转换为长度为cbs，不足部分用空格填充
  - unblock：使每一行的长度都为cbs，不足部分用空格填充
  - lcase：把大写字符转换为小写字符
  - ucase：把小写字符转换为大写字符
  - swab：交换输入的每对字节
  - noerror：出错时不停止
  - notrunc：不截短输出文件
  - sync：将每个输入块填充到ibs个字节，不足部分用空（NUL）字符补齐。



实例1：

> 在 dd 命令中，if 用于指定输入项，这里我们用 /dev/zero 作为输入项，会不停地向目标文件中写 0；of 用于指定输出项，这里用 /disk/testfilef 作为目标文件；bs 指定每次复制 1MB 数据；count 指定复制 60 次。

```
[lamp1@localhost disk]$ dd if=/dev/zero of=/disk/tesffile bs=1M count=60
#建立tesffile文件，指定文件大小为60MB
```



#### 32.	lastb

> 此命令和`last`，`lastlog`命令比较相同。

> 不过此命令，不是用来查看用户的最近登录信息。而是查看最近用户的错误登录信息

`lastb`基本格式：

```
[root@localhost ~]# lastb
```

> 此命令的使用方法，就是直接使用`lastb`。



#### 33.	chkconfig

> 此命令主要是：用于设定Linux系统中的自启动服务，也可用于查看系统中所有的所有服务

`chkconfig`命令，基本格式为：

```
[root@localhost ~]# chkconfig [选项] 服务名
[root@localhost ~]# chkconfig --list
[root@localhost ~]# chkconfig 
```

> 详细的使用方法在`Linux系统服务及日志管理`文件-->Linux系统管理部分-->命令-->chkconfig，中



#### 34.	setup

> 此命令会强势的开启一个图形化界面。用来配置X，打印设置，时区设置，系统服务，网络配置，配置，防火墙配置，验证配置，鼠标配置。

`setup`命令，基本格式为：

```
[root@localhsot ~]# setup
```

> 此命令直接使用就好了



#### 35.	file

> 此命令主要用于判断文件的类别





#### 36.	runlevel

> 查看当前系统的运行级别。





#### 37.	init

> 切换Linux的运行级别



#### 38.	find

> 此命令用于在目录中查找对应的目标文件或目录



简单使用：

```
在/home目录下查找以.txt结尾的文件名
find /home -name "*.txt"

同上，但忽略大小写
find /home -iname "*.txt"

当前目录及子目录下查找所有以.txt和.pdf结尾的文件
find . -name "*.txt" -o -name "*.pdf"
```









#### 39.	wget

> 此命令一般用来直接从网络上下载资源



#### 40.	curl

> 此命令可以直接请求服务器。和上面的区别是上面的`wget`主要是用于下载资源

此命令主要用于请求服务器。相当于简单的爬虫`curl www.baidu.com`



#### 41.	history



此命令用于查看，历史命令



注意，Linux中使用过Linux命令，即会生成一个`.bash_history`文件来保存执行命令的历史记录

语法

```
history(选项)(参数)
```

选项：

+ -c：清空当前历史命令；

+ -a：将历史命令缓冲区中命令写入历史命令文件中； 

+ -r：将历史命令文件中的命令读入当前历史命令缓冲区；

+ -w：将当前历史命令缓冲区命令写入历史命令文件中。

