<center>Linux文件系统管理，高级文件系统管理</center>
> 此文将Linux文件系统管理，Linux文件系统高级管理一起讲述。
>
> 此文大的分两个部分“Linux文件系统管理”，“Linux文件系统高级管理”
>
> `linux文件系统管理`细分为理论，相关文件，命令，实际操作。
>
> `Linux高级文件系统管理`则主要是：磁盘配额，逻辑卷，和磁盘阵列。的具体操作。其中所有的命令都放在`Linux文件系统管理`的命令中

### 一.	Linux文件系统管理



#### 1.	简单理论概念

##### 1.1.	硬盘的内部结构

> 硬盘是计算机的主要外部储存设备。计算机中的储存设备种类非常多，常见的有光盘，硬盘，U盘等，使用最多的还是硬盘。

简单说一下，硬盘从储存数据的介质上分，硬盘可分为机械硬盘，固态硬盘，机械硬盘采用磁性碟片来储存数据

###### 机械硬盘

<img src="http://c.biancheng.net/uploads/allimg/181012/2-1Q012154JE59.jpg" alt="机械硬盘长这样" style="zoom:67%;" />

> 机械硬盘和老式的留声机十分相似，但留声机只有一个磁头，机械硬盘是上下双磁头。也就是说，机械硬盘是上下面同时进行读取的，而且速度很快，所以机械硬盘在读取或写入数据时间，非常害怕晃动

**机械硬盘的逻辑结构**

机械硬盘的逻辑结构主要分为磁道，扇区和柱面，如下图：

<img src="http://c.biancheng.net/uploads/allimg/181012/2-1Q01215492WL.jpg" alt="磁道和扇区" style="zoom:67%;" />

磁道简单说就是：盘面上的同心圆，一个盘面上的磁道密度非常高，相邻磁道不是紧挨的。最外面的是0磁道。



扇区就是：上图中:每条磁道被扇骨分隔为若干弧段，每个户端就是一个扇区，扇区大小,大概为512Byte。扇区是磁盘储存的最小单位。



柱面就是：如果硬盘是多个盘面组成，每个盘面都被划分为数目相等的磁道，所有盘面都会从外向内进行磁道编号，最外侧为0磁道。具有相同编号的磁道回形成一个圆柱，这个圆柱就被称为磁盘的柱面。如下图

<img src="http://c.biancheng.net/uploads/allimg/181012/2-1Q012155002627.jpg" alt="柱面" style="zoom:67%;" />

> 硬盘的大小是使用"磁头数 x 柱面数 x 扇区数 x 每个扇区的大小"这样的公式来计算的。其中，磁头数（Heads）表示硬盘共有几个磁头，也可以理解为硬盘有几个盘面，然后乘以 2；柱面数（Cylinders）表示硬盘每面盘片有几条磁道；扇区数（Sectors）表示每条磁道上有几个扇区；每个扇区的大小一般是 512Byte。

还有硬盘的接口，不同的接口适用的机器不一样，[详情](http://c.biancheng.net/view/879.html)



##### 1.2	Linux常见文件系统

> 分区：新买来的硬盘，不分区的话，则只有一个分区，这样的话。调用一个文件则会查找整个磁盘，效率太低了。而且分区后安全性也有提到。



对硬盘进行格式化不只是清除了硬盘中的数据，还向硬盘中写入了文件系统。因为不同的操作系统，管理系统中文件的方式也不相同。因此为了使硬盘有效的存放当前系统中的文件数据，就需要将硬盘进行格式化，令其使用和操作系统一样的文件系统的格式。

> 现在windows10中文件系统用的是`FAT(32)`也就是`vfat`，Linux用的是`Ext2`（这里说的Ext2指的是Ext2系列，现在一般Linux用Ext4，我虚拟机用的是`xfs`）



像Linux，Linux的文件中`inode`保存文件的rw权限，所有者，创建时间等，还有对应block的编号。block中则包含着具体的信息。

> 像Linux这样的称为：索引式文件系统

###### Linux支持的常见的文件系统

像`windows`，Linux可以通过挂载的方式来使用Windows文件系统中的数据

| 文件系统 | 描 述                                                        |
| -------- | ------------------------------------------------------------ |
| Ext      | Linux 中最早的文件系统，由于在性能和兼容性上具有很多缺陷，现在已经很少使用 |
| Ext2     | 是 Ext 文件系统的升级版本，Red Hat Linux 7.2 版本以前的系统默认都是 Ext2 文件系统。于 1993 年发布，支持最大 16TB 的分区和最大 2TB 的文件（1TB=1024GB=1024x1024KB) |
| Ext3     | 是 Ext2 文件系统的升级版本，最大的区别就是带日志功能，以便在系统突然停止时提高文件系统的可靠性。支持最大 16TB 的分区和最大 2TB 的文件 |
| Ext4     | 是 Ext3 文件系统的升级版。Ext4 在性能、伸缩性和可靠性方面进行了大量改进。Ext4 的变化可以说是翻天覆地的，比如向下兼容 Ext3、最大 1EB 文件系统和 16TB 文件、无限数量子目录、Extents 连续数据块 概念、多块分配、延迟分配、持久预分配、快速 FSCK、日志校验、无日志模式、在线碎片整理、inode 增强、默认启用 barrier 等。它是 CentOS 6.3 的默认文件系统 |
| xfs      | 被业界称为最先进、最具有可升级性的文件系统技术，由 SGI 公司设计，目前最新的 CentOS 7 版本默认使用的就是此文件系统。 |
| swap     | swap 是 Linux 中用于交换分区的文件系统（类似于 Windows 中的虚拟内存)，当内存不够用时，使用交换分区暂时替代内存。一般大小为内存的 2 倍，但是不要超过 2GB。它是 Linux 的必需分区 |
| NFS      | NFS 是网络文件系统（Network File System）的缩写，是用来实现不同主机之间文件共享的一种网络服务，本地主机可以通过挂载的方式使用远程共享的资源 |
| iso9660  | 光盘的标准文件系统。Linux 要想使用光盘，必须支持 iso9660 文件系统 |
| fat      | 就是 Windows 下的 fatl6 文件系统，在 Linux 中识别为 fat      |
| vfat     | 就是 Windows 下的 fat32 文件系统，在 Linux 中识别为 vfat。支持最大 32GB 的分区和最大 4GB 的文件 |
| NTFS     | 就是 Windows 下的 NTFS 文件系统，不过 Linux 默认是不能识别 NTFS 文件系统的，如果需要识别，则需要重新编译内核才能支持。它比 fat32 文件系统更加安全，速度更快，支持最大 2TB 的分区和最大 64GB 的文件 |
| ufs      | Sun 公司的操作系统 Solaris 和 SunOS 所采用的文件系统         |
| proc     | Linux 中基于内存的虚拟文件系统，用来管理内存存储目录 /proc   |
| sysfs    | 和 proc —样，也是基于内存的虚拟文件系统，用来管理内存存储目录 /sysfs |
| tmpfs    | 也是一种基于内存的虚拟文件系统，不过也可以使用 swap 交换分区 |



##### 1.3	Linux识别硬盘设备及分区

linux系统初始化时，会根据 MBR 来识别硬盘设备。

MBR，全称 Master Boot Record，可译为硬盘主引导记录，占据硬盘 0 磁道的第一个扇区。MBR 中，包括用来载入操作系统的可执行代码，实际上，此可执行代码就是 MBR 中前 446 个字节的 boot loader 程序（引导加载程序），而在 boot loader 程序之后的 64 个（16&times;4）字节的空间，就是存储的分区表（Partition table）相关信息。如图下图 所示。

<img src="http://www.beylze.com/d/file/20190906/rkg2rnszef2.gif" alt="MBR" style="zoom: 80%;" />

在分区表（Partition table）中，主要存储的值息包括分区号（Partition id）、分区的起始磁柱和分区的磁柱数量。所以 Linux 操作系统在初始化时就可以根据分区表中以上 3 种信息来识别硬盘设备。其中，常见的分区号如下：

- 0x5（或 0xf）：可扩展分区（Extended partition）。
- 0x82：Linux 交换区（Swap partition）。
- 0x83：普通 Linux 分区（Linux partition）。
- 0x8e：Linux 逻辑卷管理分区（Linux LVM partition）。
- 0xfd：Linux 的 RAID 分区（Linux RAID auto partition）

由于 MBR 留给分区表的磁盘空间只有 64 个字节，而每个分区表的大小为 16 个字节，所以在一个硬盘上最多可以划分出 4 个主分区。如果想要在一个硬盘上划分出 4 个以上的分区时，可以通过在硬盘上先划分出一个可扩展分区的方法来增加额外的分区。

所以主分区和扩展分区加起来最多建立4个，扩展分区最多建立1个



##### 1.4	Linux虚拟内存与物理内存

我们都知道，直接从内存读写数据要比从硬盘读写数据快得多，因此更希望所有数据的读取和写入都在内存中完成，然而内存是有限的，这样就引出了物理内存与虚拟内存的概念。



物理内存就是系统硬件提供的内存大小，是真正的内存。相对于物理内存，在 [Linux](http://c.biancheng.net/linux_tutorial/) 下还有一个虚拟内存的概念，虚拟内存是为了满足物理内存的不足而提出的策略，它是利用磁盘空间虚拟出的一块逻辑内存。用作虚拟内存的磁盘空间被称为交换空间（又称 swap 空间）。



作为物理内存的扩展，Linux 会在物理内存不足时，使用交换分区的虚拟内存，更详细地说，就是内核会将暂时不用的内存块信息写到交换空间，这样一来，物理内存得到了释放，这块内存就可以用于其他目的，当需要用到原始的内容时，这些信息会被重新从交换空间读入物理内存。



Linux 的内存管理采取的是分页存取机制，为了保证物理内存能得到充分的利用，内核会在适当的时候将物理内存中不经常使用的数据块自动交换到虚拟内存中，而将经常使用的信息保留到物理内存。



要深入了解 Linux 内存运行机制，需要知道下面提到的几个方面：

- 首先，Linux 系统会不时地进行页面交换操作，以保持尽可能多的空闲物理内存，即使并没有什么事情需要内存，Linux 也会交换出暂时不用的内存页面，因为这样可以大大节省等待交换所需的时间。
- 其次，Linux 进行页面交换是有条件的，不是所有页面在不用时都交换到虚拟内存，Linux 内核根据“最近最经常使用”算法，仅仅将一些不经常使用的页面文件交换到虚拟内存。



有时我们会看到这么一个现象，Linux 物理内存还有很多，但是交换空间也使用了很多，其实这并不奇怪。例如，一个占用很大内存的进程运行时，需要耗费很多内存资源，此时就会有一些不常用页面文件被交换到虚拟内存中，但后来这个占用很多内存资源的进程结束并释放了很多内存时，刚才被交换出去的页面文件并不会自动交换进物理内存（除非有这个必要），那么此时系统物理内存就会空闲很多，同时交换空间也在被使用，就出现了刚才所说的现象了。

最后，交换空间的页面在使用时会首先被交换到物理内存，如果此时没有足够的物理内存来容纳这些页面，它们又会被马上交换出去，如此一来，虚拟内存中可能没有足够的空间来存储这些交换页面，最终会导致 Linux 出现假死机、服务异常等问题。Linux 虽然可以在一段时间内自行恢复，但是恢复后的系统己经基本不可用了。



因此，合理规划和设计 Linux 内存的使用是非常重要的，关于物理内存和交换空间的大小设置问题，取决于实际所用的硬盘大小，但大致遵循这样一个基本原则：

1. 如果内存较小（根据经验，物理内存小于 4GB），一般设置 swap 分区大小为内存的 2 倍；
2. 如果物理内存大于 4GB，而小于 16GB，可以设置 swap 分区大小等于物理内存；
3. 如果内存大小在 16GB 以上，可以设置 swap 为 0，但并不建议这么做，因为设置一定大小的 swap 分区是有一定作用的。

> 具体的创建`swap`分区的过程，我放在`实际操作`的`创建swap交换分区`中了。

















#### 2.	相关文件

##### 1.	/proc/sys/dev/cdrom/info

> 光驱的真正设备文件名目录，代表SCSI或SATA接口的光驱，
>
> 就是`/dev/cdrom`软连接指向的设备文件`/dev/sr0`文件的真正设备文件名。[详情](http://www.beylze.com/news/30566.html)



##### 2.	/etc/fstab

> 此文件设置Linux开机自动挂载硬件设备

> 此配置文件对所有用户可读，但只有`root`用户有权修改此文件。

首先查看一下文件内容：

```
[root@localhost ~]# less -Nm /etc/fstab
UUID=c2ca6f57-b15c-43ea-bca0-f239083d8bd2 / ext4 defaults 1 1
UUID=0b23d315-33a7-48a4-bd37-9248e5c44345 /boot ext4 defaults 1 2
UUID=4021be19-2751-4dd2-98cc-383368c39edb swap swap defaults 0 0
#只有这三个是真正的硬盘分区，下面的都是虚拟文件系统或交换分区
tmpfs /dev/shm tmpfs defaults 0 0
devpts /dev/pts devpts gid=5, mode=620 0 0
sysfs /sys sysfe defaults 0 0
proc /proc proc defaults 0 0
```

> tmpfs、devpts、sysfs 和 proc 这几行，它们分别是与共享内存、终端窗口、设备信息和内核参数相关联的特殊设备。

上面`fstab`文件内容中，每行数据都分为了6个字段，各自的含义分别为：

1. 用来挂载每个文件系统的分区设备文件名或`UUID`(用来指设备名)
2. 挂载点
3. 文件系统的类型
4. 各种挂载参数
5. 指定分区是否被`dumo`备份
6. 指定分区是否被`fsck`检测



###### /etc/fstab/文件各字段的含义

+ UUID

UUID即通用唯一标识符，作用为：当硬盘増加了新的分区，或者分区的顺序改变，或者内核升级后，仍然能够保证分区能够正确地加载，而不至于造成启动障碍。



可以使用`dumpe2fs`命令查看UUID：

```
[root@localhost ~]# dumpe2fs /dev/sdb5
dumpe2fs 1.41.12 (17-May-2010)
Filesystem volume name: test_label
Last mounted on: <not available>
Filesystem UUID: 63f238f0-a715-4821-8ed1-b3d18756a3ef
#UUID
```

另外，也可以通过查看每个硬盘UUID的链接文件名来确定UUID：

```
[root@localhost ~]# ls -l /dev/disk/by-uuid
Irwxrwxrwx. 1 root root 10 4 月 11 00:17 0b23d315-33a7-48a4-bd37-9248e5c44345
-> ../../sdal
Irwxrwxrwx. 1 root root 10 4 月 11 00:17 4021 be19-2751 -4dd2-98cc-383368c39edb
-> ../../sda2
```



+ 第二个字段为挂载点。

+ 第三个字段为文件系统，CentOS-7的默认文件系统应该是`xfs`
+ 第四个字段为挂载参数
+ 第五个字段为是否被`dump`备份，0代表不备份，1代表备份，2代表不定期备份
+ 第六个字段为指定分区是否被`fsck`检测，0代表不检测，其他数字代表检测的优先级，1的优先级比2高。所以先检测1的分区，再检测2的分区。一般都设1



###### 配置`/etc/fstab`文件

> 其实就是按照上面的格式直接配就好了

把`/dev/sdb5`和`/dev/sdb6`两个分区加入`/etc/fstab`文件中：

```
[root@localhost ~]# vim /etc/fstab
UUID=c2ca6f57-b15c-43ea-bca0-t239083d8bd2 ext4 defaults 1 1
UUID=0b23d315-33a7-48a4-bd37-9248e5c44345 I boot ext4 defaults 1 2
UUID=4021be19-2751-4dd2-98cc-383368c39edb swap swap defaults 0 0
tmpfs /dev/shm tmpfs defaults 0 0
devpts /dev/pts devpts gid=5, mode=620 0 0
sysfs /sys sysfs defaults 0 0
proc /proc proc defaults 0 0
/dev/sdb5 /disk5 ext4 defaults 1 2
/dev/sdb6 /disk6 ext4 defaults 1 2
```

> 这里并没有使用分区的UUID，而是直接写入设备文件名，也是可以的。不过，如果不写 UUID，就要注意，在修改了磁盘顺序后，/etc/fstab 文件也要相应的改变。



###### 修改`/etcfstab`文件出错导致Linux不能启动怎么办



首先我们先修改`/etc/fstab`其中一行数据

```
[root@localhost ~]# vi /etc/fstab
上面部分省略不写……
/dev/sdb /disk6 ext4 defaults 1 2
#故意把/dev/sdb6写成了 /dev/sdb
```

接下来重启，系统会报错。如下：

<img src="http://www.beylze.com/d/file/20190906/3utk5gpidgr.jpg" alt="重启报错" style="zoom: 80%;" />

系统提示输入密码，此处输入密码

接下来看到系统提示符，搞快把`/etc/fstab`文件修改回来

<img src="http://www.beylze.com/d/file/20190906/2lhslxpwksb.jpg" alt="系统提示符" style="zoom:80%;" />

此处修改`/etc/fstab`文件报错

原因是：没有写权限，此处把`/`分区重新挂载上读写短线就行了

```
[root@localhost ~]# mount -o remount,rw /
```



##### 3.	/proc/mdstat

> 此文件主要用于查看RAID保存的信息。

再查看一下 /proc/mdstat 文件，这个文件中也保存了 RAID 的相关信息。命令如下：

```
[root@localhost ~]# cat /proc/mdstat
Personalities：[raid6] [raid5] [raid4]
md0:active raid5 sdb9[4](S) sdb5[0] sdb8[3] sdb6[1]
\#RAID名 级别 组成RAID的分区，[数字]是此分区在RAID中的顺序
\#(S)代表备份分区
4206592 blocks super 1.2 level 5, 512k chunk, algorithm 2 [3/3] [UUU]
\#总block数 等级是5 区块大小 阵列算法 [组成设备数/正常设备数]
unused devices: <none>
```



##### 4./etc/mdadm.conf

> 此配置文件主要是：磁盘阵列RAID的`mdadm`配置文件
>
> 如果要启用RAID的话，必须创建这个配置文件。此文件默认是没有的

在 CentOS 6.x 中，mdadm 配置文件并不存在，需要手工建立。我们使用以下命令建立 /etc/mdadm.conf 配置文件：

```
[root@localhost ~]# echo Device /dev/sdb[5-8] >>/etc/mdadm.conf
\#建立/etc/mdadm.conf配置立件，并把组成RAID的分区的设备文件名写入
\#注意：如果有多个RAID，则要把所有组成RAID的设备都放入配置文件中；否则RAID设备重启后会丟失
\#比如组成RAID 10，就既要把分区的设备文件名放入此文件中，也翻组成RAID 0的RAID 1设备文件名放入
[root@localhost ~]# mdadm -Ds >>/etc/mdadm.conf
\#查询和扫描RAID信息，并追加进/etc/mdadm.conf文件
[root@localhost ~]# cat /etc/mdadm.conf
Device /dev/sdb5 /dev/sdb6 /dev/sdb7 /dev/sdb8
ARRAY /dev/md0 metadata: 1.2 spares=1 name=l(xalhost.localdomain:0 UUID=dd821fe5:8597b126:460a3afd:857c7989
\#查看文件内容
```



#### 3.	命令

##### 1.	df

> df命令用于显示Linux系统中各文件系统的硬盘使用情况

>  与整个文件系统有关的数据，都保存在超级块(`Super block`)中，df命令读取的数据针对整个文件系统，所以`df`命令主要是从各文件系统的`Super block`中读取数据

`df` 命令的基本格式为：

``` 
[root@localhost ~]# df [选项] [文件或目录名]
```

选项如下：

| 选项 | 作用                                                         |
| ---- | ------------------------------------------------------------ |
| -a   | 显示所有文件系统信息，包括系统特有的 /proc、/sysfs 等文件系统； |
| -m   | 以 MB 为单位显示容量；                                       |
| -k   | 以 KB 为单位显示容量，默认以 KB 为单位；                     |
| -h   | 使用人们习惯的 KB、MB 或 GB 等单位自行显示容量；             |
| -T   | 显示该分区的文件系统名称；                                   |
| -i   | 不用硬盘容量显示，而是以含有 inode 的数量来显示。            |

> 常用的-a,-h,-T以及，指定目录读取而不是整个Linux文件系统



实例1：

> 简单使用df命令

```
[root@localhost ~]# df 
#文件系统			总量		 已经使用  	未使用	  使用率  挂载目录
Filesystem      1K-blocks      Used Available Use% Mounted on
/dev/hdc2         9920624   3823112   5585444  41% /
/dev/hdc3         4956316    141376   4559108   4% /home
/dev/hdc1          101086     11126     84741  12% /boot
tmpfs              371332         0    371332   0% /dev/shm
省略一部分……


		//使用df命令查看，/etc目录所在分区的有关信息
[root@localhost ~]# df -h /etc
Filesystem            Size  Used Avail Use% Mounted on
/dev/hdc2             9.5G  3.7G  5.4G  41% /


		//使用-T选项显示分区的文件系统
[root@localhost ~]# df -aT
Filesystem    Type 1K-blocks    Used Available Use% Mounted on
/dev/hdc2     ext3   9920624 3823112   5585444  41% /
proc          proc         0       0         0   -  /proc
sysfs        sysfs         0       0         0   -  /sys
devpts      devpts         0       0         0   -  /dev/pts
/dev/hdc3     ext3   4956316  141376   4559108   4% /home
```



##### 2.	du

> du命令用于统计目录或文件所占的磁盘空间大小的命令

du命令的格式如下：

```
[root@localhost ~]# du [选项] [目录名]
```

选项：

- -a：显示每个子文件的磁盘占用量。默认只统计子目录的磁盘占用量
- -h：使用习惯单位显示磁盘占用量，如 KB、MB 或 GB 等；
- -s：统计总磁盘占用量，而不列出子目录和子文件的磁盘占用量



实例1：

> 使用`du`命令的`-a`选项，查看当前目录下所有子文件和子目录的占用

```
[root@localhost ~]# du
#统计当前目录的总磁盘占用量大小，同时会统计当前目录下所有子目录的磁盘占用量大小，不统计子文件
20 ./.gnupg
24 ./yum.bak
8 ./dtest
28 ./sh
188

			//使用-a命令查看
[root@localhost ~]# du -sh
188k
```



`du`命令和`df`命令的区别

有时我们会发现，使用 du 命令和 df 命令去统计分区的使用情况时，得到的数据是不一样的。那是因为df命令是从文件系统的角度考虑的，通过文件系统中未分配的空间来确定文件系统中已经分配的空间大小。也就是说，在使用 df 命令统计分区时，不仅要考虑文件占用的空间，还要统计被命令或程序占用的空间（最常见的就是文件已经删除，但是程序并没有释放空间）。

而 du 命令是面向文件的，只会计算文件或目录占用的磁盘空间。也就是说，df 命令统计的分区更准确，是真正的空闲空间。



##### 3.	mount

> Linux中所有硬件设备都必须挂载后才能使用，有些硬件设备（硬盘分区）系统启动时会自动挂载，而有些（光盘，U盘）则需要手动挂载。

> 挂载：将硬件设备的文件系统和Linux系统中的文件系统，通过指定目录(挂载点)进行关联。

`mount`命令的常用格式有以下三种：

```
[root@localhost ~]# mount [-l]
```

> 简单的使用`mount`命令，会显示出系统中已挂载的设备信息，使用`-l`选项，会额外显示出卷标名称

```
[root@localhost ~]# mount -a
```

> 自动检查`/etc/fstab`，文件中疏漏的设备文件，并进行自动挂载操作。



下面这个是最重要的用处：

```
[root@localhost ~]# mount [-t 系统类型] [-L 卷标名] [-o 特殊选项] [-n] 设备文件名 挂载点
```

各选项的含义分别为：

- -t 系统类型：指定欲挂载的文件系统类型。Linux 常见的支持类型有 EXT2、EXT3、EXT4、iso9660（光盘格式）、vfat、reiserfs 等。如果不指定具体类型，挂载时 Linux 会自动检测。
- -L 卷标名：除了使用设备文件名（例如 /dev/hdc6）之外，还可以利用文件系统的卷标名称进行挂载。
- -n：在默认情况下，系统会将实际挂载的情况实时写入 /etc/mtab 文件中，但在某些场景下（例如单人维护模式），为了避免出现问题，会刻意不写入，此时就需要使用这个选项；
- -o 特殊选项：可以指定挂载的额外选项，比如读写权限、同步/异步等，如果不指定，则使用默认值（defaults）。具体的特殊选项参见表 1；

> 其中`-o`选项的具体额外选项如下：

| 选项        | 功能                                                         |
| ----------- | ------------------------------------------------------------ |
| rw/ro       | 是否对挂载的文件系统拥有读写权限，rw 为默认值，表示拥有读写权限；ro 表示只读权限。 |
| async/sync  | 此文件系统是否使用同步写入（sync）或异步（async）的内存机制，默认为异步 async。 |
| dev/nodev   | 是否允许从该文件系统的 block 文件中提取数据，为了保证数据安装，默认是 nodev。 |
| auto/noauto | 是否允许此文件系统被以 mount -a 的方式进行自动挂载，默认是 auto。 |
| suid/nosuid | 设定文件系统是否拥有 SetUID 和 SetGID 权限，默认是拥有。     |
| exec/noexec | 设定在文件系统中是否允许执行可执行文件，默认是允许。         |
| user/nouser | 设定此文件系统是否允许让普通用户使用 mount 执行实现挂载，默认是不允许（nouser），仅有 root 可以。 |
| defaults    | 定义默认值，相当于 rw、suid、dev、exec、auto、nouser、async 这 7 个选项。 |
| remount     | 重新挂载已挂载的文件系统，一般用于指定修改特殊权限。         |



实例1：

> 使用`mount`命令查看已经挂载的文件系统，

```
[root@localhost ~]# mount
/dev/sda3 on / type ext4 (rw)  <--含义是，将 /dev/sda3 分区挂载到了 / 目录上，文件系统是 ext4，具有读写权限
proc on /proc type proc (rw)
sysfe on /sys type sysfs (rw)
/dev/sda1 on /boot type ext4 (rw)
```



实例2：

> 简单修改特殊权限，修改上例中的/boot目录。设置为`ro`只读权限。

```
[root@localhost ~]# mount -o remount ro /boot
[root@localhost ~]# cd /boot
[root@localhost boot]# touch a
-bash:touch:权限不够
```



实例3：

> 演示一下挂载

```
[root@localhost ~]# mkdir /mnt/disk1				//建立挂载目录
[root@localhost ~]# mount /dev/sdb1 /mnt/disk1		//挂载分区
```



##### 4.	umount 

> 硬盘分区是否需要卸载，取决于下一次是否需要使用，一般不对硬盘分区做卸载操作

`umount`命令，用于执行将设备从挂载点卸载的操作。基本格式如下：

```
[root@localhost ~]# umount 设备文件名或挂载点
```



此处注意，卸载命令后面可以加设备文件名，也可以加挂载点，不过只能二选一。如下：

```
[root@localhost ~]# umount /dev/sdb1 
[root@localhost ~]# umount /mnt/usb
```

> 假如，卸载的时候。挂载点和设备文件名都写上了。这样卸载第二次的话就会报错

```
[root@localhost ~]# umount /dev/cdrom /mnt/cdrom
```



> 注意：有时候卸载会出现下面的情况

```
[root@localhost ~]# cd /mnt/cdrom
[root@localhost ~]# umount /mnt/cdrom
umount: /mnt/cdrom: device is busy.
#报错，设备正忙
```

原因：因为此处进入了挂载点。所以执行`umount`卸载命令之前，用户必须退出挂载目录



##### 5.	fsck

> 此命令主要用于检测和修复文件系统。

> 此命令只能修复一些小的问题

`fsck`命令检查文件系统并尝试修复出现的错误。基本格式如下：

```
[root@localhost ~]# fsck [选项] 分区设备文件名
```

选项如下：

| 选项            | 功能                                                         |
| --------------- | ------------------------------------------------------------ |
| -a              | 自动修复文件系统，没有任何提示信息。                         |
| -r              | 采取互动的修复模式，在修改文件前会进行询问，让用户得以确认并决定处理方式。 |
| -A（大写）      | 按照 /etc/fstab 配置文件的内容，检查文件内罗列的全部文件系统。 |
| -t 文件系统类型 | 指定要检查的文件系统类型。                                   |
| -C（大写）      | 显示检查分区的进度条。                                       |
| -f              | 强制检测，一般 fsck 命令如果没有发现分区有问题，则是不会检测的。如果强制检测，那么不管是否发现问题，都会检测。 |
| -y              | 自动修复，和 -a 作用一致，不过有些文件系统只支持 -y。        |

> 此命令通常只有身为`root`用户且文件系统出现问题时才会使用，正常状态下使用`fsck`命令很可能会损坏系统。另外，如果怀疑已经格式化成功的硬盘有问题，也可以使用此命令来进行检查。
>
> ```
> 使用fsck命令修复文件系统是存在风险的，特别是当错误非常严重的时候。所以，如果受损的文件系统中包含非常有价值的数据时，一定要先备份。
> ```

使用`fsck`命令修复文件系统时，这个文件系统对应的磁盘分区一定要处于卸载状态。磁盘分区在挂载状态下进行修复有可能会损坏数据或硬盘。



实例1：

> 简单实例，使用`fsck`的`-r`选项，互动的修复模式

```
[root@localhost ~]# fsck /dev/sdb1
```

> ps.`fsck`命令在执行时，如果发现一些因为文件系统内部结构损坏导致的，没有文件系统依赖的文件或目录。会自动把找到的文件或目录放在`lost+found`目录中





##### 6.	dumpe2fs

> 此命令主要用于查看文件系统的详细信息

`dumpe2fs`命令的基本格式如下：

```
[root@localhost ~]# dumpe2fs [-h] 文件名
```

> `-h`选项的含义是：仅列出`superblock(超级块)`的信息。



实例1：

> 通过`df`命令找到根目录硬盘的文件名，然后使用`dumpe2fs`命令观察文件系统的详细信息

```
[root@localhost ~]# df      //此命令用于查看当前挂载的装置
Filesystem    1K-blocks      Used Available Use% Mounted on
/dev/hdc2       9920624   3822848   5585708  41% /
/dev/hdc3       4956316    141376   4559108   4% /home
/dev/hdc1        101086     11126     84741  12% /boot
tmpfs            371332         0    371332   0% /dev/shm

[root@localhost ~]# dumpe2fs /dev/hdc2
dumpe2fs 1.39 (29-May-2006)
Filesystem volume name:   /1             <==这个是文件系统的名称(Label)
Filesystem features:      has_journal ext_attr resize_inode dir_index
  filetype needs_recovery sparse_super large_file
Default mount options:    user_xattr acl <==默认挂载的参数
Filesystem state:         clean          <==这个文件系统是没问题的(clean)
Errors behavior:          Continue
Filesystem OS type:       Linux
Inode count:              2560864        <==inode的总数
Block count:              2560359        <==block的总数
Free blocks:              1524760        <==还有多少个 block 可用
Free inodes:              2411225        <==还有多少个 inode 可用
First block:              0
Block size:               4096           <==每个 block 的大小啦！
Filesystem created:       Fri Sep  5 01:49:20 2008
Last mount time:          Mon Sep 22 12:09:30 2008
Last write time:          Mon Sep 22 12:09:30 2008
Last checked:             Fri Sep  5 01:49:20 2008
First inode:              11
Inode size:               128            <==每个 inode 的大小
Journal inode:            8              <==底下这三个与下一小节有关
Journal backup:           inode blocks
Journal size:             128M

Group 0: (Blocks 0-32767) <==第一个 data group 内容, 包含 block 的启始/结束号码
  Primary superblock at 0, Group descriptors at 1-1  <==超级区块在 0 号 block
  Reserved GDT blocks at 2-626
  Block bitmap at 627 (+627), Inode bitmap at 628 (+628)
  Inode table at 629-1641 (+629)                     <==inode table 所在的 block
  0 free blocks, 32405 free inodes, 2 directories    <==所有 block 都用完了！
  Free blocks:
  Free inodes: 12-32416                              <==剩余未使用的 inode 号码
Group 1: (Blocks 32768-65535)
#由于数据量非常的庞大，这里省略了一部分输出信息
```

> 可以看到，使用 dumpe2fs 命令可以查询到非常多的信息，以上信息大致可分为 2 部分。前半部分显示的是超级块的信息，包括文件系统名称、已使用以及未使用的 inode 和 block 的数量、每个 block 和 inode 的大小，文件系统的挂载时间等。
>
> 另外，Linux 文件系统（EXT 系列）在格式化的时候，会分为多个区块群组（block group），每 个区块群组都有独立的 inode/block/superblock 系统。此命令输出结果的后半部分，就是每个区块群组的详细信息（如 Group0、Group1）。





##### 7.	fdisk

> 此命令主要用于给硬盘进行分区操作，或是查看系统分区情况
>
> 使用`fidsk`创建的分区表为MBR分区表，使用`parted`创建的分区表为GPT分区表

Linux中分区命令有`fdisk`和`parted`。`fdisk`更常用，但是`fdisk`不支持对2TB的分区，parted则支持2TB的分区。

`fdisk`命令的格式如下：

```
[root@localhost ~]# fdisk -l			//第一种应用方式查看系统分区信息
//列出系统分区
[root@localhost ~]# fdisk 设备名		 //第二种应用方式对硬盘进行分区
```



关于`fdisk -l`命令显示的数据，如下：

```
[root@localhost ~]# fdisk -l
#查询本机可以识别的硬盘和分区
Disk /dev/sda:32.2 GB, 32212254720 bytes
#硬盘文件名和硬盘大小
255 heads, 63 sectors/track, 3916 cylinders
#共255个磁头、63个扇区和3916个柱面
Units = cylinders of 16065 *512 = 8225280 bytes
#每个柱面的大小
Sector size (logical/physical): 512 bytes/512 bytes
#每个扇区的大小
I/O size (minimum/optimal): 512 bytes/512 bytes
Disk identifier: 0x0009e098
Device Boot Start End Blocks ld System				//此处开始为设备文件的分区情况表
/dev/sda1 * 1 26 204800 83 Linux
Partition 1 does not end on cylinder boundary.
#分区1没有占满硬盘
/dev/sda2 26 281 2048000 82 Linux swap / Solaris
Partition 2 does not end on cylinder boundary
#分区2没有占满硬盘
/dev/sda3 281 3917 29203456 83 Linux
#设备文件名启动分区 起始柱面 终止柱面容量 ID 系统

Disk /dev/sdb: 21.5 GB, 21474836480 bytes #第二个硬盘识别，这个硬盘的大小	     //此处为第二块设备
255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 * 512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes/512 bytes Disk identifier: 0x00000000
```

这里解释一下上面这些信息：上半部分为硬盘的整体状态信息，`/dev/sda1`硬盘的总大小是32.2GB，一共有3916个柱面，每个柱面由255个磁头读写数据，每个磁头管理 63 个扇区。每个柱面的大小是 8225280 Bytes，每个扇区的大小是 512 Bytes。



信息的下半部分是分区的信息，共7列，含义如下：

+ Device：分区的设备文件名
+ Boot：是否为启动引导分区，此处`/dev/sda1`为启动引导分区
+ Start：起始柱面，代表分区从哪里开始
+ End：终止柱面，代表分区从哪里结束
+ Blocks：分区的大小，单位是KB
+ id：分区内文件系统的ID，在`fdisk`命令中，可以使用“i”查看
+ System：分区内安装的系统是什么

如果分区并没有占满磁盘的话，就会提示“Partition 1 does not end on cyl inder boundary”。



上面使用`fdisk -l`命令查看的信息中，可以看到第二块硬盘`/dev/sdb`并没有分区，这里对第二块硬盘进行分区

```
[root@localhost ~]# fdisk /dev/sdb				//对/dev/sdb进行分区操作
Device contains neither a valid DOS partition table, nor Sun, SGI or OSF disklabel
Building a new DOS disklabel with disk identifier 0xed7e8bc7.
Changes will remain in memory only, until you decide to write them.
After that, of course, the previous content won't be recoverable.
Warning: invalid flag 0x0000 of partition table 4 will be corrected by w(rite)
WARNING: DOS-compatible mode is deprecated.it's strongly recommended to switch off the mode (command 'c') and change display units to sectors (command 'u').
Command (m for help):m
#交互界面的等待输入指令的位置，输入 m 得到帮助
Command action
#可用指令
a toggle a bootable flag
b edit bsd disklabel
c toggle the dos compatibility flag
d delete a partition
I list known partition types m print this menu
n add a new partition
o create a new empty DOS partition table
p print the partition table
q quit without saving changes
s create a new empty Sun disklabel
t change a partition's system id
u change display/entry units
v verity the partition table
w write table to disk and exit
x extra functionality (experts only)
```

> fdisk分区的话是交互式的分区。这里不对分区进行太多的介绍。不懂得话[B站链接3分25秒处开始](https://www.bilibili.com/video/av53304074?from=search&seid=3606839482973331677)

> 注意这里得分区命令是`fdisk /dev/sdb`，这是因为硬盘并没有分区，使用fdisk命令就是维克创建分区

在`fdisk`交互界面输入`m`可以获得帮助，帮助里列出了`fdisk`可以识别的交互命令，如下所示：

| 命令 | 说 明                                                        |
| ---- | ------------------------------------------------------------ |
| a    | 设置可引导标记                                               |
| b    | 编辑 bsd 磁盘标签                                            |
| c    | 设置 DOS 操作系统兼容标记                                    |
| d    | 删除一个分区                                                 |
| 1    | 显示已知的文件系统类型。82 为 Linux swap 分区，83 为 Linux 分区 |
| m    | 显示帮助菜单                                                 |
| n    | 新建分区                                                     |
| 0    | 建立空白 DOS 分区表                                          |
| P    | 显示分区列表                                                 |
| q    | 不保存退出                                                   |
| s    | 新建空白 SUN 磁盘标签                                        |
| t    | 改变一个分区的系统 ID                                        |
| u    | 改变显示记录单位                                             |
| V    | 验证分区表                                                   |
| w    | 保存退出                                                     |
| X    | 附加功能（仅专家）                                           |



##### 8.	partpprobe

> 使用了`fdisk`命令进行了分区操作之后。需要重启才能使分区表同步到内核
>
> 使用此命令就可以不重启，直接通知系统内核分区表的变化

基本格式如下：

```
[root@localhost ~]# partprobe			//一般就是这么直接使用
```



##### 9.	parted

> 使用`fidsk`创建的分区表为MBR分区表，使用`parted`创建的分区表为GPT分区表
>
> 此处只简单介绍`parted`命令,具体的去实际操作标签的`parted创建分区`中去看

`parted`命令的主要作用为：对高于2TB的硬盘进行分区。

`parted`命令是可以在命令行直接分区和格式化的，不过`parted`交互模式才用的更多，进入交互模式的格式如下：

```
[root@localhost ~]# parted 设备文件名
//进入交互模式
```



例如：

```
[root@localhost ~]# parted /dev/sdb
#打算继续划分/dev/sdb硬盘
GNU Parted 2.1
使用/dev/sdb
Welcome to GNU Parted! Type 'help' to view a list of commands.
(parted)   <--parted 的等待输入交互命令的位置，输入 help，可以看到在交互模式下支持的所有命令
```



`parted`的交互命令比较多，常见的命令如下表所示：

| parted交互命令                          | 说 明                                    |
| --------------------------------------- | ---------------------------------------- |
| check NUMBER                            | 做一次简单的文件系统检测                 |
| cp [FROM-DEVICE] FROM-NUMBER TO-NUMBER  | 复制文件系统到另一个分区                 |
| help [COMMAND]                          | 显示所有的命令帮助                       |
| mklabel,mktable LABEL-TYPE              | 创建新的磁盘卷标（分区表）               |
| mkfs NUMBER FS-TYPE                     | 在分区上建立文件系统                     |
| mkpart PART-TYPE [FS-TYPE] START END    | 创建一个分区                             |
| mkpartfs PART-TYPE FS-TYPE START END    | 创建分区，并建立文件系统                 |
| move NUMBER START END                   | 移动分区                                 |
| name NUMBER NAME                        | 给分区命名                               |
| print [devices\|free\|list,all\|NUMBER] | 显示分区表、活动设备、空闲空间、所有分区 |
| quit                                    | 退出                                     |
| rescue START END                        | 修复丢失的分区                           |
| resize NUMBER START END                 | 修改分区大小                             |
| rm NUMBER                               | 删除分区                                 |
| select DEVICE                           | 选择需要编辑的设备                       |
| set NUMBER FLAG STATE                   | 改变分区标记                             |
| toggle [NUMBER [FLAG]]                  | 切换分区表的状态                         |
| unit UNIT                               | 设置默认的单位                           |
| Version                                 | 显示版本                                 |



实例1：

> 简单讲一下查看`parted`分区信息中的东西

```
(parted) print
#进入print指令
Model: VMware, VMware Virtual S (scsi)
#硬盘参数，是虚拟机
Disk/dev/sdb: 21.5GB
#硬盘大小
Sector size (logical/physical): 512B/512B
#扇区大小
Partition Table: msdos
#分区表类型，是MBR分区表
Number Start End Size Type File system 标志
1 32.3kB 5379MB 5379MB primary
2 5379MB 21.5GB 16.1GB extended
5 5379MB 7534MB 2155MB logical ext4
6 7534MB 9689MB 2155MB logical ext4
#看到了我们使用fdisk命令创建的分区，其中1分区没被格式化；2分区是扩展分区，不能被格式化
```

使用 print 命令可以査看分区表信息，包括硬盘参数、硬盘大小、扇区大小、分区表类型和分区信息。分区信息共有 7 列，分别如下：

1. Number：分区号，比如，1号就代表 /dec/sdb1；
2. Start：分区起始位置。这里不再像 fdisk 那样用柱面表示，使用字节表示更加直观；
3. End：分区结束位置；
4. Size：分区大小；
5. Type：分区类型，有 primary、extended、logical 等类型；
6. Filesystem：文件系统类型；
7. 标志：分区的标记。



##### 10.	mkfs

> `mkfs`命令作用为：为分区写入文件系统

分区完成后，如果不格式化写入文件系统，则是不能正常使用的。这时就需要使用`mkfs`命令对硬盘分区进行格式化



`mkfs`命令格式如下：

```
[root@localhost ~]# mkfs [-t 文件系统格式] 分区设备文件名
```

> `-t`文件系统格式：用于指定格式化的文件系统，如ext3，ext4等。



首先，主分区，扩展分区，逻辑分区中。扩展分区不能被格式化，其他的分区都需要格式化后才能使用。



此处，格式化一个`/dev/sdb56`分区：

```
[root@localhost ~]# mkfs -t ext4 /dev/sdb6
mke2fs 1.41.12 (17-May-2010)
Filesystem label=  <--这里指的是卷标名，我们没有设置卷标
OS type：Linux
Block size=4096 (log=2) <--block 的大小配置为 4K
Fragment size=4096 (log=2)
Stride=0 blocks, Stripe width=0 blocks
131648 inodes, 526120 blocks <--由此配置决定的inode/block数量
26306 blocks (5.00%) reserved for the super user
First data block=0
Maximum filesystem blocks=541065216 17 block groups
32768 blocks per group, 32768 fragments per group
7744 inodes per group
Superblock backups stored on blocks:
32768, 98304, 163840, 229376, 294912
Writing inode tables: done
Creating journal (16384 blocks):done
Writing superblocks and filesystem accounting information:done
This filesystem will be automatically checked every 39 mounts or 180 days, whichever comes first. Use tune2fs -c or -i to override.
# 这样就创建起来所需要的 Ext4 文件系统了！简单明了！
```

> 虽然 mkfs 命令非常简单易用，但其不能调整分区的默认参数（比如块大小是 4096 Bytes），这些默认参数除非特殊清况，否则不需要调整。如果想要调整，就需要使用 mke2fs 命令重新格式化。



##### 11.	mke2fs

> 上面的`mkfs`命令为硬盘分区写入文件系统时，无法手动调整分区的默认参数（比如块大小是 4096 Bytes） 如果想要调整，就需要使用`mke2fs`命令

`mke2fs`命令的基本格式如下：

```
[root@localhost ~]# mke2fs [选项] 分区设备文件名
```

常用选项如下：

| 选项        | 功能                                                    |
| ----------- | ------------------------------------------------------- |
| -t 文件系统 | 指定格式化成哪个文件系统， 如 ext2、ext3、ext4；        |
| -b 字节     | 指定 block 的大小；                                     |
| -i 字节     | 指定"字节 inode "的比例，也就是多少字节分配一个 inode； |
| -j          | 建立带有 ext3 日志功能的文件系统；                      |
| -L 卷标名   | 给文件系统设置卷标名，就不使用 e2label 命令设定了；     |



为了更好的对比 mkfs 命令，这里我们依旧以格式化 /dev/sdb6 为例，不过，这次使用的是 mke2fs 命令，执行命令如下：

```
[root@localhost ~]# mke2fs -t ext4 -b 2048 /dev/sdb6
#格式化分区，并指定block的大小为2048 Bytes
mke2fe 1.41.12 (17-May-2010)
Filesystem label=
OS type：Linux
Block size=2048 (log=1)  <--block 的大小配置为 2K
Fragment size=2048 (log=1)
Stride=0 blocks, Stripe width=0 blocks 131560
inodes,1052240 blocks 52612 blocks (5.00%) reserved for the super user
First data block=0
Maximum filesystem blocks=538968064 65 block groups
16384 blocks per group, 16384 fragments per group
2024 inodes per group
Superblock backups stored on blocks:
16384, 49152, 81920, 114688, 147456, 409600, 442368, 802816
Writing inode tables: done
Creating journal (32768 blocks):done
Writing superblocks and filesystem accounting information:done
This filesystem will be automatically checked every 38 mounts or 180 days, whichever comes first. Use tune2fs -c or-i to override.
```

> 如果没有特殊需要，建议使用 mkfs 命令对硬盘分区进行格式化。



##### 12.	mkswap

> 此命令作用为：想要格式化swap分区时就得用此命令。而不是`mkfs`命令

`mkswap`命令，基本格式为：

```
[root@localhost ~]# mkswap 设备文件名
```



实例1：

> 简单的使用`mkswap`命令，格式化`swap`分区

```
[root@localhost ~]# mkswap /dev/sdb1
Setting up swapspace version 1, size = 522076 KiB
no label, UUID=c3351 dc3-f403-419a-9666-c24615e170fb
```



##### 13.	free

> `free`命令作用为：查看内存和`swap`分区的使用状况的



基本格式如下：

```
[root@localhost ~]# free
		total 	used 	free 	shared 	buffers 	cached
Mem: 	1030796 130792 	900004 		0 	15292 		55420
Swap: 	2047992   0 	2047992
```

free 命令主要是用来查看内存和 swap 分区的使用情况的，其中：

- total：是指总数；
- used：是指已经使用的；
- free：是指空闲的；
- shared：是指共享的；
- buffers：是指缓冲内存数；
- cached：是指缓存内存数，单位是KB；

+ available： 是指还可以被应用程序使用的物理内存大小。

> 我们需要解释一下 buffers（缓冲）和 cached（缓存）的区别。简单来讲，cached 是给读取数据时加速的，buffers 是给写入数据加速的。cached 是指把读取出来的数据保存在内存中，当再次读取时，不用读取硬盘而直接从内存中读取，加速了数据的读取过程；buffers 是指在写入数据时，先把分散的写入操作保存到内存中，当达到一定程度后再集中写入硬盘，减少了磁盘碎片和硬盘的反复寻道，加速了数据的写入过程。



##### 14.swapon

> `swapon`命令的作用为：开启swap`分区

当然，使用此命令的前提为：已经创建好了`swap`分区，并且已经格式化好了`swap`分区。



`swapon`基本格式：

```
[root@localhost ~]# swapon 分区设备文件名
```



实例1：

> 简单的开启(或者说使用)，一下`swap`分区

```
[root@localhost ~]# swapon /dev/sdb1
swap分区已加入，我们查看一下。
[root@localhost ~]#free
total used free shared buffers cached
Mem: 1030796 131264 899532 0 15520 55500
-/+ buffers/cache: 60244 970552
Swap: 2570064 0 2570064
```



##### 15.	swapoff

>`swapon`命令的作用为：关闭`swap`分区

当然，使用此命令的前提为：已经开启了`swap`交换分区。



`swapoff`基本格式：

```
[root@localhost ~]# swapon 分区设备文件名
```



实例2：

> 简单的关闭`swap`交换分区

```
[root@localhost ~]# swapoff /dev/sdb1
```



##### 16.	quotacheck

扫描文件系统并建立磁盘配额记录文件。

> 磁盘配额（Quota）就是通过分析整个文件系统中每个用户和群组拥有的文件总数和总容量，再将这些数据记录在文件系统中的最顶层目录中，然后在此记录文件中使用各个用户和群组的配额限制值去规范磁盘使用量的。

扫面文件系统(必须含有挂载参数`usrquota`和`grpquota`)，可以使用`quotacheck`命令，基本格式如下

```
[root@localhost ~]# quotacheck [-avugfM] 文件系统
```

选项如下：

| 选项       | 功能                                                         |
| ---------- | ------------------------------------------------------------ |
| -a         | 扫瞄所有在 /etc/mtab 中，含有 quota 支持的 filesystem，加上此参数后，后边的文件系统可以不写； |
| -u         | 针对使用者扫瞄文件与目录的使用情况，会创建 aquota.user       |
| -g         | 针对群组扫瞄文件与目录的使用情况，会创建 aquota.group        |
| -v         | 显示扫瞄的详细过程；                                         |
| -f         | 强制扫瞄文件系统，并写入新的 quota 记录文件                  |
| -M（大写） | 强制以读写的方式扫瞄文件系统，只有在特殊情况下才会使用。     |

> 在使用这些选项时，只需要一起下达`quotacheck -avug`即可。
>
> 至于 -f 和 -M 选项，是在文件系统以启动 quota 的情况下，还要重新扫描文件系统（担心有其他用户在使用 quota 中），才需要使用这两个选项。



例如，我们可以使用如下的命令，对整个系统中含有挂载参数（usrquota 和 grpquota）的文件系统进行扫描：

```
[root@localhost ~]# quotacheck -avug
quotacheck: Scanning /dev/hda3 [/home] quotacheck: Cannot stat old user quota
file: No such file or directory <--有找到文件系统，但尚未制作记录文件！
quotacheck: Cannot stat old group quota file: No such file or directory
quotacheck: Cannot stat old user quota file: No such file or directory
quotacheck: Cannot stat old group quota file: No such file or directory
done  <--上面三个错误只是说明记录文件尚未创建而已，可以忽略不理！
quotacheck: Checked 130 directories and 107 files <--实际搜寻结果
quotacheck: Old file not found.
quotacheck: Old file not found.
# 若运行这个命令却出现如下的错误信息，表示你没有任何文件系统有启动 quota 支持！
# quotacheck: Can't find filesystem to check or filesystem not mounted with quota option.

[root@localhost ~]# ll -d /home/a*
-rw------- 1 root root 8192 Mar  6 11:58 /home/aquota.group
-rw------- 1 root root 9216 Mar  6 11:58 /home/aquota.user
# 可以看到，扫描的同时，会创建两个记录文件，放在 /home 底下
```



##### 17.	quotaon

> 此命令的主要作用就是开启已经配置好的`Quota`服务。

`quotaon`命令的功能就是启动`Quota`服务，此命令的基本格式为：

```
[root@localhost ~]# quotaon [-avug]
[root@localhost ~]# quotaon [-vug] 文件系统名称
```

选项如下：

| 选项 | 功能                                                         |
| ---- | ------------------------------------------------------------ |
| -a   | 根据 /etc/mtab 文件中对文件系统的配置，启动相关的Quota服务，如果不使用 -a 选项，则此命令后面就需要明确写上特定的文件系统名称 |
| -u   | 针对用户启动 Quota（根据记录文件 aquota.user）               |
| -g   | 针对群组启动 Quota（根据记录文件 aquota.group）              |
| -v   | 显示启动服务过程的详细信息                                   |

> 注意：`quotaon -avug`命令只需要在第一次 Quota 服务时才需要进行，因为下次重新启动系统时，系统的 /etc/rc.d/rc.sysinit 初始化脚本会自动下达这个命令。



如果要同时启动对用户和群组的`Quota`服务，可以使用如下命令：

```
[root@localhost ~]# quotaon -avug
/dev/hda3 [/home]: group quotas turned on
/dev/hda3 [/home]: user quotas turned on
```



##### 18.	quotaoff

> 上面一点写了使用`quotaon`开启磁盘配额限制，此处使用`quotaoff`关闭磁盘配额限制

`quotaoff`命令的功能就是关闭磁盘配额限制，此命令的基本格式同`quotaon`类似。如下：

```
[root@localhost ~]# quotaoff [-avug]
[root@localhost ~]# quotaoff [-vug] 文件系统名称
```

选项如下：

| 选项 | 功能                                                         |
| ---- | ------------------------------------------------------------ |
| -a   | 根据 /etc/mtab 文件，关闭已启动的 Quota 服务，如果不使用 -a 选项，则此命令后面就需要明确写上特定的文件系统名称 |
| -u   | 关闭针对用户启动的 Quota 服务。                              |
| -g   | 关闭针对群组启动的 Quota 服务。                              |
| -v   | 显示服务过程的详细信息                                       |



此处使用`quotaoff`命令关闭所有已开启的`Quota`服务。

```
[root@localhost ~]# quotaoff -avug
```



> 如果只针对用户关闭`/var`启动的`Quota`支持，可以使用以下命令

```
[root@localhost ~]# quotaoff -uv /var
```



##### 19.	edquota

> 此命令用于修改用户（或群组）的磁盘配额限制

`edquota`，全写`edit quota`。用于修改用户和群组的配额限制参数，包括磁盘容量和文件个数限制、软限制和硬限制值、宽限时间，该命令的基本格式有以下 3 种

```
[root@localhost ~]# edquota [-u 用户名] [-g 群组名]
[root@localhost ~]# edquota -t
[root@localhost ~]# edquota -p 源用户名 -u 新用户名
```

常用选项如下：

| 选项      | 功能                                                         |
| --------- | ------------------------------------------------------------ |
| -u 用户名 | 进入配额的 Vi 编辑界面，修改针对用户的配置值；               |
| -g 群组名 | 进入配额的 Vi 编辑界面，修改针对群组的配置值；               |
| -t        | 修改配额参数中的宽限时间；                                   |
| -p        | 将源用户（或群组）的磁盘配额设置，复制给其他用户（或群组）。 |



例如，以用户 myquota 为例，通过如下命令配置此命令的 Quota：

```
[root@localhost ~]# edquota -u myquota
Disk quotas for user myquota (uid 710):Filesystem    blocks  soft   hard  inodes  soft  hard							/dev/hda3         80     0      0      10     0     0
```



> 关于字段的含义如下：

| 表头                     | 含义                                                         |
| ------------------------ | ------------------------------------------------------------ |
| 文件系统（filesystem）   | 说明该限制值是针对哪个文件系统（或分区）；                   |
| 磁盘容量（blocks）       | 此列的数值是 quota 自己算出来的，单位为 Kbytes，不要手动修改； |
| 磁盘容量的软限制（soft） | 当用户使用的磁盘空间超过此限制值，则用户在登陆时会收到警告信息，告知用户磁盘已满，单位为 KB； |
| 磁盘容量的硬限制（hard） | 要求用户使用的磁盘空间最大不能超过此限制值，单位为 KB；      |
| 文件数量（inodes）       | 同 blocks 一样，此项也是 quota自己计算出来的，无需手动修改； |
| 文件数量的软限制（soft） | 当用户拥有的文件数量超过此值，系统会发出警告信息；           |
| 文件数量的硬限制（hard） | 用户拥有的文件数量不能超过此值。                             |

> 注意，当 soft/hard 为 0 时，表示没有限制。另外，在 Vi（或 Vim）中修改配额值时，填写的数据无法保证同表头对齐，只要保证此行数据分为 7 个栏目即可。



实例1：

> 修改用户`myquota`的软限制值和硬限制值

```
[root@localhost ~]# edquota -u myquota
Disk quotas for user myquota (uid 710):
  Filesystem    blocks    soft    hard  inodes  soft  hard
  /dev/hda3         80  250000  300000      10     0     0
```



实例2：

> 修改群组`mygrp`的配额

```
[root@localhost ~]# edquota -g mygrp
Disk quotas for group mygrpquota (gid 713):
  Filesystem    blocks    soft     hard  inodes  soft  hard
  /dev/hda3        400  900000  1000000      50     0     0
```



实例3：

> 修改宽限天数。

```
[root@localhost ~]# edquota -t
Grace period before enforcing soft limits for users:
Time units may be: days, hours, minutes, or seconds
  Filesystem         Block grace period     Inode grace period
  /dev/hda3                14days                  7days
```



##### 20.	setquota

> 如果我们需要写脚本建立大量的用户，并给每个用户都自动进行磁盘配额，那么 edquota 命令就不能在脚本中使用了，因为这个命令的操作过程和 vi 类似，需要和管理员产生交互。
>
> 这种情况下就需要利用 setquota 命令进行设置，这个命令的好处是通过命令行设定配额，而不用和管理员交互设定。

`setquota`命令格式如下：

```
[root@localhost ~]# setquota -u 用户名 容量软限制 容量硬限制 个数软限制 个数硬限制 分区名
```



实例1：

> 我们建立用户 lamp4，并用 setquota 命令设定磁盘配额。

```
[root@localhost ~]# useradd lamp4
[root@localhost ~]# passwd lamp4
#建立用户
[root@localhost ~]# setquota -u lamp4 10000 20000 5 8/disk
#设定用户在/disk分区中的容量软限制为10MB，硬限制为20MB；文件个数软限制为5个，硬限制为8个
[root@localhost ~]# quota -uvs lamp4
Disk quotas for user Iamp4 (uid 503):
Filesystem blocks quota limit grace files quota limit grace
/dev/sdbl 0 10000 20000 0 5 8
#查看一下，配额生效了
```



##### 21.	quota

> quota命令主要用于在磁盘配额中，查询用户或群组的磁盘配额

quota 命令查询用户或用户组配额，基本格式如下：

```
[root@localhost ~]# quota [选项] [用户或组名]
```

选项：

- -u 用户名：查询用户配额；
- -g 组名：查询组配额；
- -v：显示详细信息；
- -s：以习惯单位显示容量大小，如M、G；

```
[root@localhost 〜]# quota -uvs lamp1
Disk quotas for user lamp1 (uid 500):
Filesystem blocks quota limit grace files quota limit grace	
/dev/sda3 	20 		0 	  0 		  6 	  0 	0
/dev/sdbl 	0 	   40000 50000  	  0 	  8 	10
#查看lamp1用户的配额值						//quota字段为软限制,limit字段为硬限制
[root@localhost ~]# quota -uvs lamp2
Disk quotas for user lamp2 (uid 501):
Filesystem blocks quota limit grace files quota limit grace
/dev/sda3  36752 	0 	  0    		 2672   0 	 0
/dev/sdbl 	 0 	   245M  293M 		  0 	  0 	0
#查看lamp2用户的配额值
```

> lamp 用户的配额值还不够大，所以没有换算成 MB 单位，但是 lamp2 用户已经换算了。在选项列当中多出了 grace 字段，这里是用来显示宽限时间的，我们现在还没有达到软限制，所以 grace 字段为空。



##### 22.	repquota

> `repquota`命令主要用于在磁盘配额中，查询整个文件系统的磁盘配额情况

repquota命令查询文件系统配额，基本格式如下：

```
[root@localhost ~]# repquota [选项] [分区名]
```

选项：

- -a：依据 /etc/mtab 文件查询配额。如果不加 -a 选项，就一定要加分区名；
- -u：查询用户配额；
- -g：查询组配额；
- -v：显示详细信息；
- -s：以习惯单位显示容量太小；

```
[root@localhost ~] # repquota -augvs
*** Report for user quotas on device /dev/sdbl
#用户配额信息
Block grace time: 8days; Inode grace time: 8days
Block limits File limits
User used soft hard grace used soft hard grace
root -- 13 0 	0 			2    0 	  0
lampl -- 0 40000 50000 		0 	 8 	  10
lamp2 -- 0 245M 293M 		0    0    0
lamp3 -- 0 245M 293M 		0    0    0
#用户的配额值
Statistics:
Total blocks: 7
Data blocks: 1
Entries: 4
Used average: 4.000000
*** Report for group quotas on device /dev/sdbl
#组配额信息
Block grace time: 7days; Inode grace time: 7days
Block limits File limits
Group used soft hard grace used soft hard grace
root -- 13  0     0 		2    0    0
brother--0 440M 489M 		0    0    0
#组的配额值
Statistics:
Total blocks: 7
Data blocks: 1
Entries: 2
Used average: 2.000000
```



##### 23.	pvcreate

> 使用`pvcreate`命令可以把`LVM`的分区，建立为物理卷

`pvcreate`命令基本格式如下：

```
[root@localhost ~]# pvcreate [设备文件名]
```

建立物理卷时，我们既可以把整块硬盘都建立成物理卷，也可以把某个分区建立成物理卷。如果要把整块硬盘都建立成物理卷的话，`pvcreate`后面直接跟设备文件名：

```
[root@localhost ~]# pvcreate /dev/sdb
```

当然，如果只是把分区建立成物理卷，那`pvcreate`后面直接跟分区名就好了：

```
[root@localhost ~]# pvcreate /dev/sdb5
Writing physical volume data to disk "/dev/sdb5" Physical volume "/dev/sdb5" successfully created
[root@localhost ~]# pvcreate /dev/sdb6
Writing physical volume data to disk "/dev/sdb6" Physical volume "/dev/sdb6" successfully created
[root@localhost ~]# pvcreate /dev/sdb7
Writing physical volume data to disk "/dev/sdb7" Physical volume 7dev/sdb7' successfully created
```



##### 24.	pvscan

> 使用`pvscan`命令，可以查看当前设备的物理卷。

其实查看物理卷的命令有两个。第一个是`pvscan`，用来查询系统中那些硬盘或分区是物理卷，命令如下

```
[root@localhost ~]# pvscan
PV /dev/sdb5 Ivm2 [1.01 GiB]
PV /dev/sdb6 Ivm2 [1.01 GiB]
PV /dev/sdb7 Ivm2 [1.01 GiB]
Total: 3 [3.03 GiB] /in no VG: 0 [0 ] / in no VG: 3 [3.03 GiB]
```

> 可以看到，在我们的系统中，/dev/sdb5~7 这三个分区是物理卷。最后一行的意思是：共有 3 个物理卷[大小]/使用了 0 个卷[大小]/空闲 3 个卷[大小]。



##### 25.	pvdisplay

> `pvdisplay`同样是查看物理卷的命令

`pvdisplay`命令可以看到更详细的物理卷状态，命令如下：

```
[root@localhost ~]# pvdisplay
"/dev/sdb5" is a new physical volume of "1.01 GiB"
—NEW Physical volume 一
PV Name /dev/sdb5
#PV名
VG Name
#属于的VG名，还没有分配，所以空白
PV Size 1.01 GiB
#PV 的大小
Allocatable NO
#是否已经分配
PE Size 0
#PE大小，因为还没有分配，所以PE大小也没有指定
Total PE 0
#PE总数
Free PE 0
#空闲 PE数
Allocated PE 0
#可分配的PE数
PV UUID CEsVz3-t0sD-e1w0-wkHZ-iaLq-06aV-xtQNTB
#PV的UUID
…其它两个PV省略…
```



##### 26.	pvremove

> `pvremone`命令用于卸载物理卷。
>
> 不过需要注意的是，卸载物理卷必须卷组`VG`已经卸载，卸载卷组`VG`必须逻辑卷`LV`已经卸载

如果不需要物理卷，则使用`pvremove`命令删除，命令如下：

```
[root@localhost ~]# pvremove /dev/sdb7
Labels on physical volume "/dev/sdb7" successfully wiped
```

> 在删除物理卷时，物理卷必须不属于任何卷组，也就是需要先将物理卷从卷组中删除，再删除物理卷。其实所有的删除就是把创建过程反过来，建立时不能少某个步骤，删除时也同样不能跳过某一步直接删除。



##### 27.	vgcreate

> 此命令的作用为：创建卷组`VG`，当然前提是已经创建好了物理卷

`vgcreate`命令，基本格式如下：

```
[root@localhost ~]# vgcreate [-s PE大小] 卷组名 物理卷名
```

> [-s PE 大小] 选项的含义是指定 PE 的大小，单位可以是 MB、GB、TB 等。如果不写，则默认 PE 大小是 4MB。这里的卷组名指的就是要创建的卷组的名称，而物理卷名则指的是希望添加到此卷组的所有硬盘区分或者整个硬盘。



实例1 

> 有2个物理卷`/dev/sdb5`和`/dev/sdb6`，我们把这两个物理卷为基础创建一个`scvg`卷组

```
[root@localhost ~]# vgcreate -s 8MB scvg /dev/sdb5 /dev/sdb6
Volume group "scvg" successfully created
我们把/dev/sdb和/dev/sdb6两个物理卷加入了卷组scvg，并指定了PE的大小是8MB
```



##### 28.	vgchange

> 此命令可用于：激活卷组`VG`。当然，前提是要有卷组。

`vgchange`命令的基本格式如下：

```
#激活卷组
[root@localhost ~]# vgchange -a y 卷组名
#停用卷组
[root@localhost ~]# vachange -a n 卷组名
```



实例1

> 使用`vgchange`命令，开启`scvg`卷组

```
[root@localhost ~]# vgchange -ay scvg			//开启卷组
[root@localhost ~]# vgchange -an scvg			//关闭卷组
```



##### 29.	vgscan

> vgscan 命令主要用于查看系统中是否有卷组

`vgscan`命令，基本格式如下：

```
[root@1ocalhost ~]# vgscan
```



实例1：

> 使用`vgscan`命令查看系统中是否有卷组

```
[root@1ocalhost ~]# vgscan
Reading all physical volumes. This may take a while...
Found volume group "scvg" using metadata type lvm2 #scvg卷组确实存在
```



##### 30.	vgdisplay

> vgdisplay 命令则用于查看卷组的详细状态。

`vgdisplay`命令，基本格式如下：

```
[root@localhost ~]# vgdisplay
```



实例1：

> 查看系统中卷组的详细状态

```
[root@localhost ~]# vgdisplay
---Volume group ---
VG Name scvg 卷组名
System ID
Format lvm2
Metadata Areas 2
Metadata Sequence No 1
VG Access read/write
#卷组访问状态
VG Status resizable
#卷组状态
MAX LV 0
#最大逻辑卷数
Cur LV 0
Open LV 0
Max PV 0
#最大物理卷数
Cur PV 2
#当前物理卷数
Act PV 2
VG Size 2.02 GiB
#卷组大小
PE Size 8.00 MiB
#PE大小
Total PE 258
#PE总数
Alloc PE / Size 0/0
#已用 PE 数量/大小
Free PE / Size 258 / 2.02GiB
#空闲PE数量/大小
VG UUID Fs0dPf-LV7H-0Ir3-rthA-3UxC-LX5c-FLFriJ
```



##### 31.	vgextend

> 此命令主要用于增加卷组容量，其实就是把新的物理卷加入卷组。当然前提是有卷组及物理卷，而且该物理卷不在其卷组内

`vgextend`命令，基本格式如下：

```
[root@localhost ~]# vgextend 卷组名 物理卷名
```



实例1：

> 使用`vgextend`命令，为`scvg`卷组增加新的物理卷`/dev/sdb7`

```
[root@localhost ~]# vgextend scvg /dev/sdb7
Volume group "scvg" successfully extended
#把/dev/sdb7物理卷也加入scvg卷组
[root@localhost ~]# vgdisplay
---Volume group ---
VG Name scvg
System ID
Format lvm2
Metadata Areas 3
Metadata Sequence No 2
VG Access read/write
VG Status resizable
MAX LV 0
Cur LV 0
Open LV 0
Max PV 0
Cur PV 3
Act PV 3
VG Size 3.02 GiB
#卷组容量增加
PE Size 8.00 MiB
Total PE 387
#PE 总数增加
Alloc PE / Size 0/0
Free PE / Size 387 / 3.02 GiB
VG UUID Fs0dPf-LV7H-0Ir3-rthA-3UxC-LX5c-FLFriJ
```



##### 32.	vgreduce

> 此命令主要用于减少卷组容量，其实就是在卷组中删除物理卷。当然已有的才能删除

`vgreduce`命令，基本格式：

```
[root@localhost ~]# vgreduce 卷组名 物理卷名
```



实例1：

> 使用`vgreduce`命令，删除`scvg`卷组中的`/dev/sdb7`物理卷

```
[root@localhost ~]# vgreduce scvg /dev/sdb7
Removed "/dev/sdb7" from volume group "scvg"
#在卷组中删除/dev/sdb7物理卷
[root@localhost ~]# vgreduce -a
#删除所有未使用的物理卷
```



##### 33.	vgremove

> 此命令主要用于删除卷组。当然，删除了逻辑卷之后才能删除卷组

`vgremove`命令，基本格式如下：

```
[root@localhost ~]# vgremove 卷组名
```



实例1：

> 使用`vgremove`命令，删除`scvg`卷组

```
[root@localhost ~]# vgremove scvg
Volume group "scvg" successfully removed
```



##### 34.	lvcreate 

> 此命令用于将卷组划分为逻辑卷。
>
> 可以把逻辑卷想象成分区，那么这个逻辑卷当然也需要被格式化和挂载。另外，逻辑卷也是可以动态调整大小的，而且数据不会丟失，也不用卸载逻辑卷。

我们现在已经建立了 3GB 大小的卷组 scvg，接下来需要在卷组中建立逻辑卷。命令格式如下：

```
[root@localhost ~]# lvcreate [选项] [-n 逻辑卷名] 卷组名
```

选项：

- -L 容量：指定逻辑卷大小，单位为 MB、GB、TB 等；
- -l 个数：按照 PE 个数指定逻辑卷大小，这个参数需要换算容量，太麻烦；
- -n 逻辑卷名：指定逻辑卷名；



实例1：

> 我们建立一个 1.5GB 大小的 lamplv 逻辑卷，命令如下：

```
[root@localhost ~]# lvcreate -L 1.5G -n lamplv scvg
Logical volume "lamplv" created
#在scvg卷组中建立一个1.5GB大小的lamplv逻辑卷
```

建立完逻辑卷，还要在格式化和挂载之后才能正常使用。格式化和挂载命令与操作普通分区时是一样的，不过需要注意的是，逻辑卷的设备文件名是"/dev/卷组名/逻辑卷名"，如逻辑卷 lamplv 的设备文件名就是"/dev/scvg/lamplv"。具体命令如下：

```
[root@localhost ~]# mkfs -t ext4 /dev/scvg/lamplv
\#格式化
[root@localhost ~]# mkdir /disklvm
[root@localhost ~]# mount /dev/scvg/lamplv /disklvm/
\#建立挂载点，并挂载
[root@localhost ~]# mount
…省略部分输出…
/dev/mapper/scvg-lamplv on /disklvm type ext4(rw)
\#已经挂载了
```

当然，如果需要开机后自动挂载，则要修改 /etc/fstab 文件。



##### 35.	lvscan

> 此命令用于查看系统中是否拥有逻辑卷

`lvscan`命令，基本格式如下：

```
[root@localhost ~]# lvscan
```



实例1：

> 查看当前系统中是否拥有逻辑卷

```
[root@localhost ~]# lvscan
ACTIVE '/dev/scvg/lamplv' [1.50 GiB] inherit
#能够看到激活的逻辑卷，大小是1.5GB
```



##### 36.	lvdisplay

> 此命令用于查看系统中逻辑卷的详细信息

`lvdisplay`命令，基本格式如下：

```
[root@localhost ~]# lvdisplay
```



实例1：

> 使用`lvdispaly`命令查看系统中逻辑卷`LV`的详细信息

```
[root@localhost ~]# lvdisplay
---Logical volume---
LV Path /dev/scvg/lamplv
逻辑卷的设备文件名
LV Name lamplv
#逻辑卷名
VG Name scvg
#所属的卷组名
LV UUID 2kyKmn-Nupd-CldB-8ngY-NsI3-b8hV-QeUuna
LV Write Access read/write
LV Creation host, time localhost, 2013-04-18 03:36:39 +0800
LV Status available
# open 1
LV Size 1.50 GiB
#逻辑卷大小
Current LE 192
Segments 2
Allocation inherit
Read ahead sectors auto
-currently set to 256
Block device 253:0
```



##### 37.	lvresize

> 此命令永固调整逻辑卷的大小。不过最好别减少逻辑卷的空间，这会导致逻辑卷中的文件丢失。
>
> 当然如果要增加逻辑卷大小的话，必须卷组中还有多余的空间

`lvresize`命令，基本格式如下：

```
[root@localhost ~]# lvresize [选项] 逻辑卷的设备文件名
```

选项：

- -L 容量：安装容量调整大小，单位为 KB、GB、TB 等。使用 + 増加空间，- 代表减少空间。如果直接写容量，则代表设定逻辑卷大小为指定大小；
- -l 个数：按照 PE 个数调整逻辑卷大小；



实例1：

> 使用`lvresize`命令调整系统中，逻辑卷`lamplv`大小

```
[roots localhost disklvm] # lvresize -L +1G /dev/scvg/lamplv
#增加lamplv逻辑卷的大小到2. 5GB，当然命令也可以这样写
[root@localhost disklvm]# lvresize -L 2.5G /dev/scvg/lamplv
					//使用命令lvdisplay，查看逻辑卷使用情况
[root@localhost disklvm]# lvdisplay
---Logical volume ---
LV Path /dev/scvg/lamplv
LV Name lamplv
VG Name scvg
LV UUID 2kyKmn-Nupd-CldB-8ngY-Ns13-b8hV-QeUuna
LV Write Access read/write
LV Creation host, time localhost, 2013-04-18 03:36:39 +0800 LV Status available
# open 1
LV Size 2.50 GiB
#大小改变了
Current LE 320
Segments 3
Allocation inherit
Read ahead sectors auto
-currently set to 256
Block device 253:0
```

> 已经修改好了逻辑卷`lamplv`的容量。



虽然这里已经修改好了逻辑卷`lamplv`的大小。但是有一个问题，`/dev/scvg/lamplv`分区大小却没有改变，还是1.5G。此处我们使用`df -h /disklvm`查看：

```
[root@localhost disklvm]# df -h /disklvm/			//这个目录是逻辑卷lamplv的挂载目录
文件系统 容量 已用 可用 已用% ％挂载点
/dev/mapper/scvg-lamplv 1.5G 35M 1.4G 3%/ disklvm
```



如果还想要让分区使用新的逻辑卷，则要使用下面的`resize2fs`命令来调整分区的大小。



##### 38.	resize2fs

> 此命令主要用于：当使用了`lvresize`命令调整了逻辑卷的大小后，使用此命令就可以调整逻辑卷对应的分区大小。

`resize2fs`命令，基本格式如下：

```
[root@localhost ~]# resize2fs [选项] [设备文件名] [调整的大小]
```

选项：

- -f：强制调整；
- 设备文件名：指定调整哪个分区的大小；
- 调整的大小：指定把分区调整到多大，要加 M、G 等单位。如果不加大小，则会使用整个分区；



实例1：

> 在上面的`lvresize`命令中，我们已经调整好了逻辑卷大小(增加了1G)。但是我们用`df`查看分区的时候，发现分区的大小并没有增加。
>
> 此处我们就用`resize2fs`命令来增加分区的大小。当然前提是逻辑卷的大小已经增加

```
[root@localhost ~]# resize2fs /dev/scvg/lamplv
resize2fs 1.41.12(17-May-2010)
Filesystem at /dev/scvg/lamplv is mounted on/ disklvm; on-line resizing required
old desc_blocks = 1, new_desc_blocks = 1
Performing an on-line resize of/dev/scvg/lamplv to 655360 (4k) blocks.
The filesystem on /dev/scvg/lamplv is now 655360 blocks long.
#已经调整了分区大小
[root@localhost ~]# df -h /disklvm/
文件系统 容量 已用 可用 已用% %挂载点
/dev/mapper/scvg-lamplv 2.5G 35M 2.4G 2% /disklvm
#分区大小已经是2.5GB 了
[root@localhost ~]# ls /disklvm/
lost+found testd testf
#而且数据并没有丟失
```

> 如果要减少逻辑卷的容量，则只需把增加步骤反过来再做一遍就可以了。不过我们并不推荐减少逻辑卷的容量，因为这有可能导致数据丟失。



##### 39.	lvremove

> 此命令主要用于卸载逻辑卷。
>
> 注意：删除了逻辑卷后，其中的数据会丢失。

`lvremove`命令的基本格式如下：

```
[root@localhost ~]#lvremove 逻辑卷的设备文件名
```



实例1

> 删除`lamplv`逻辑卷。当然删除之前要确认逻辑卷已经卸载

```
[root@localhost ~]# umount /dev/scvg/lamplv
[root@localhost ~]# Ivremove /dev/scvg/lamplv
Do you really want to remove active logical volume lamplv? [y/n]: n
#如果这里选择y，就会执行删除操作，逻辑卷内的所有数据都会被清空
Logical volume lamplv not removed
```



##### 40.	mdadm

> 此命令主要用于：在命令行中，创建RAID。RAID的操作几乎都是由此命令来完成。

建立 RAID 使用 mdadm 命令，命令格式如下：

[root@localhost ~]# mdadm [模式] [RAID设备文件名] [选项]

模式：

- Assemble：加入一个已经存在的阵列；
- Build：创建一个没有超级块的阵列；
- Create：创建一个阵列，每个设备都具有超级块；
- Manage：管理阵列，如添加设备和删除损坏设备；
- Misc：允许单独对阵列中的设备进行操作，如停止阵列；
- Follow or Monitor：监控RAID状态； Grow：改变RAID的容量或阵列中的数目；


选项：

- -s,-scan：扫描配置文件或/proc/mdstat文件，发现丟失的信息；
- -D,-detail：查看磁盘阵列详细信息；
- -C,-create：建立新的磁盘阵列，也就是调用 Create模式；
- -a,-auto=yes：采用标准格式建立磁阵列
- -n,-raicklevices=数字：使用几块硬盘或分区组成RAID
- -l,-level=级别：创建RAID的级别，可以是0,1,5
- -x,-spare-devices=数字：使用几块硬盘或分区组成备份设备
- -a,-add 设备文件名：在已经存在的RAID中加入设备
- -r,-remove 设备文件名名：在已经存在的RAID中移除设备
- -f,-fail设备文件名：把某个组成RAID的设备设置为错误状态
- -S,-stop：停止RAID设备
- -A,-assemble：按照配置文件加载RAID



实例1：

> 创建一个RAID5

```
[root@localhost ~]# mdadm -c /dev/md0 -a yes -l 5 -n 3 -x 1 /dev/sdb5 /dev/sdb6 /dev/sdb7 /dev/sdb8
```



实例2：

> 启动或停止RAID

```
[root@localhost ~]# mdadm -S /dev/md0
\#停止/dev/md0设备

[root@localhost ~]# mdadm -As /dev/md0			//启动/dev/md0
mdadm: /dev/md0 has been started with 3 drives and 1 spare.
[root@localhost ~]# mount /dev/md0 /raid/
#启动RAID后，记得挂载
```



实例3：

> 模拟分区出现故障

```
[root@localhost ~]# mdadm /dev/md0 --fail /dev/sda7
```



实例4：

> 移除错误分区

```
[root@localhost ~]# mdadm /dev/md0 -remove/dev/sdb7
mdadm: hot removed /dev/sdb7 from /dev/mdO
```



实例5：

> 添加新的备份分区

```
[root@localhost ~]# mdadm /dev/md0 -add /dev/sdb9
```





#### 4. 实际操作



##### 1.	挂载光盘

> Linux中，想要使用光盘。必须手动挂载到Linux系统中，才能使用。同样的不用的话必须卸载，才能取出。

将光盘放入光驱，并执行以下命令：

```
[root@localhost ~]# mkdir /mnt/cdrom					//建立挂载目录
[root@localhost ~]# mount -t iso9660 /dev/cdrom /mnt/cdrom		//使用mount进行挂载
[root@localhost ~]# mount 								//查看已挂载设备
省略一部分……
/dev/srO on /mnt/cdrom type iso9660 (ro)
#光盘已经挂载了，但是挂载的设备文件名是/dev/sr0			详情/proc/sys/dev/cdrom/info相关文件
```

> 光盘的系统是`iso960`，不过这个文件系统可以省略不写。系统会自动检测。



同样的，不用的话使用`umount`命令进行卸载。

```
[root@localhost ~]# umount /mnt/cdrom
```





##### 2.	挂载U盘

> 挂载U盘，和挂载光盘方式是一样的。只不过光盘的设备文件名是固定的(`/dev/sr0`或`/dev/cdrom`)。而U盘的设备文件名是插入U盘后系统自动分配的。

> 因为U盘使用的是硬盘的设备文件名，而在每台服务器上插入的硬盘和数量都是不以言的，所以U盘需要单独的检测与分配。以避免和硬件的设备文件名发生冲突。

U盘的设备文件名是系统自动分配的，只需要查找出来然后挂载就可以了。

使用`fdisk`命令，查找U盘的设备文件名。

```
[root@localhost ~]# fdisk -l
Disk /dev/sda: 21.5GB, 21474836480 bytes
#系统硬盘
省略部分输出
Disk/dev/sdb: 8022 MB, 8022654976 bytes
#这就是识别的U盘，大小为8GB
94 heads, 14 sectors/track, 11906 cylinders
Units = cylinders of 1316 * 512 = 673792 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk identifier: 0x00000000
Device Boot Start End Blocks Id System
/dev/sdb1 1 11907 7834608 b W95 FAT32
#系统给U盘分配的设备文件名
```

> 此处只简述：上面fdisk命令的每一陀都是不同的硬盘文件，里面有磁盘详细信息和该磁盘的分区信息



查询到了U盘的设备文件名，接下来创建挂载点。

```
[root@localhost ~]# mkdir /mnt/usb
```



接下来挂载命令如下：

```
[root@localhost ~]# mount -t vfat /dev/sdb1 /mnt/usb		//成功挂载
	//挂载U盘。因为是Windows分区，所以是vfat格式
[root@localhost ~]# cd /mnt/usb
[root@localhost ~]# ls				
//输出乱码
//之所以输出乱码，是因为编码格式不同
```



之所以出现乱码是因为U盘是Windows保存的数据，而Windows中的中文编码格式和Linux不一致。

```
[root@localhost ~]# mount -t vfat -o iochart=utf8 /dev/sdb1 /mnt/usb	
		//设定编码格式为UTF-8
```



> 查看一下我们Linux的编码格式
>
> ```
> [root@localhost ~]# echo $LANG
> zh_CN.UTF-8
> ```





##### 3.	使用`fdisk`创建分区

> 上面在命令标签的`fdisk`命令的介绍中，简单的记录了`fdisk`命令的作用。这里正式使用`fdisk`进行创建分区
>
> 使用`fidsk`创建的分区表为MBR分区表，使用`parted`创建的分区表为GPT分区表
>
> ①主分区：主要是用来启动操作系统的，它主要放的是操作系统的启动或引导程序，/boot分区最好放在主分区上；
> ②扩展分区是不能使用的，它只是做为逻辑分区的容器存在的，先创建一个扩展分区，在扩展分区之上创建逻辑分区；
> ③我们真正存放数据的是主分区和逻辑分区，大量数据都放在逻辑分区中。

这里实际建立一个主分区，看看是什么样子的。

```
[root@localhost ~]# fdisk /dev/sdb
省略部分输出
Command (m for help): p
#显示当前硬盘的分区列表
Disk /dev/sdb: 21.5 GB, 21474836480 bytes 255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 *512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk identifier: 0xb4b0720c
Device Boot Start End Blocks id System
#目前一个分区都没有
Command (m for help): n
#那么我们新建一个分区
Command action
#指定分区类型
e extended
#扩展分区
p primary partition (1-4)
#主分区
p
#这里选择p，建立一个主分区
Partition number (1-4): 1
#选择分区号，范围为1~4，这里选择1
First cylinder (1 -2610, default 1):
#分区的起始柱面，默认从1开始。因为要从硬盘头开始分区，所以直接回车
Using default value 1
#提示使用的是默认值1
Last cylinder, +cylinders or +size{K, M, G}(1-2610, default 2610): +5G
#指定硬盘大小。可以按照柱面指定(1-2610)。我们对柱面不熟悉，那么可以使用size{K, M, G}的方式指定硬盘大小。这里指定+5G，建立一个5GB大小的分区
Command (m for help):
#主分区就建立了，又回到了fdisk交互界面的提示符
Command (m for help): p
#查询一下新建立的分区
Disk /dev/sdb: 21.5GB, 21474836480 bytes
255 heads,63 sectors/track, 2610 cylinders
Units = cylinders of 16065 * 512 = 8225280 bytes
Sector size (logical/physical): 512 bytes 1512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk identifier: 0xb4b0720c
Device Boot Start End Blocks id System
/dev/sdb1 1 654 5253223+ 83 linux
#dev/sdb1已经建立了吧
```

总结：建立主分区的过程：`fdisk 硬盘名` --> `n(新建)` --> `p(建立分区)` --> `1(指定区号)` --> `回车(默认从柱面1开始建立分区)` --> `+5G(指定分区大小)`。这里我们的分区还没有`格式化`和`挂载`。还不能使用



下面进行建立一个扩展分区。(ps.主分区和扩展分区加起来最多建立4个，而扩展分区最多建立一个)

```
[root@localhost ~]# fdisk /dev/sdb
省略部分输出
Command (m for help): n
#新建立分区
Command action
e extended
p primary partition (1-4)
e
#这次建立扩展分区
Partition number (1-4): 2
#给扩展分区指定分区号2
First cylinder (655-2610, default 655):
#扩展分区的起始柱面。上节建立的主分区1已经占用了1~654个柱面，所以我们从655开始建立，注意：如果没有特殊要求，则不要跳开柱面建立分区，应该紧挨着建立分区
Using default value 655
提示使用的是默认值655
Last cylinder, +cylinders or +size{K, M, G} (655-2610, default 2610):
#这里把整块硬盘的剩余空间都建立为扩展分区
Using default value 2610
#提示使用的是默认值2610
```

这里把`/dev/sdb`硬盘的所有剩余空间都建立为扩展分区，也就是建立一个主分区，剩余空间都建立成扩展分区，在由扩展分区中建立逻辑分区。



扩展分区是不能被格式化和使用的，所以要在扩展分区内部建立逻辑分区。建立的过程如下

```
[root@localhost ~]# fdisk /dev/sdb
省略部分输出
Command (m for help): n
#建立新分区
Command action
l logical (5 or over)
#由于在前面章节中，扩展分区已经建立，所以这里变成了l(logic)
p primary partition (1-4)
l
#建立逻辑分区
First cylinder (655-2610, default 655):
#不用指定分区号，默认会从5开始分配，所以直接选择起始柱面
#注意：逻辑分区是在扩展分区内部再划分的，所以柱面是和扩展分区重叠的
Using default value 655
Last cylinder, +cylinders or +size{K, M, G} (655-2610, default 2610):+2G
#分配2GB大小
Command (m for help): n
#再建立一个逻辑分区
Command action
l logical (5 or over)
p primary partition (1-4)
l
First cylinder (917-2610, default 917):
Using default value 917
Last cylinder, +cylinders or +size{K, M, G} (917-2610, default 2610):+2G
Command (m for help): p
#查看一下已经建立的分区
Disk /dev/sdb: 21.5GB, 21474836480 bytes
255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 *512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes Disk identifier: 0xb4b0720c
Device Boot Start End Blocks id System
/dev/sdb1 1 654
5253223+ 83 Linux
#主分区
/dev/sdb2 655 2610 15711570
5 Extended
#扩展分区
/dev/sdb5 655 916
2104483+ 83 Linux
#逻辑分区 1
/dev/sdb6 917 1178
2104483+ 83 Linux
#逻辑分区2
Command (m for help): w
#保存并退出
The partition table has been altered!
Calling ioctl。to re-read partition table.
Syncing disks.
[root@localhost -]#
#退回到提示符界面
```

所有的分区建立过程中如果不保存退出是不会生效的，所以建立错了也没关系。使用`q`命令不保存退出即可。不过使用`w`命令的话，就会保存退出。有时因为分区表正忙，所以需要重新启动系统才能使新的分区表生效。

```
Command (m for help): w
#保存并退出
The partition table has been altered!
Calling ioctl() to re-read partition table.
WARNING: Re-reading the partition table failed with error 16:
Device or resource busy.
The kernel still uses the old table.
The new table will be used at the next reboot.
#要求重新启动，才能格式化
Syncing disks.								//看到了吗，必须重新启动
```

如果不想重新启动的话，则可以使用`partprobe`命令，此命令作用为让系统内核重新读取分区表信息。如下：

```
[root@localhost ~]# partprobe
```

> 如果这个命令不存在，则请安装 parted-2.1-18.el6.i686 这个软件包。partprobe 命令不是必需的，如果没有提示重启系统，则直接格式化即可。





##### 4.	使用`parted`创建分区

> 此处对应“命令”标签的`parted`命令



>  首先，说一下。接下来是已经使用`fdisk`命令创建好了`MMBR`分区表的硬盘。再使用`parted`命令创建`GPT`分区

首先，`parted`交互模式的命令如下

| parted交互命令                          | 说 明                                    |
| --------------------------------------- | ---------------------------------------- |
| check NUMBER                            | 做一次简单的文件系统检测                 |
| cp [FROM-DEVICE] FROM-NUMBER TO-NUMBER  | 复制文件系统到另一个分区                 |
| help [COMMAND]                          | 显示所有的命令帮助                       |
| mklabel,mktable LABEL-TYPE              | 创建新的磁盘卷标（分区表）               |
| mkfs NUMBER FS-TYPE                     | 在分区上建立文件系统                     |
| mkpart PART-TYPE [FS-TYPE] START END    | 创建一个分区                             |
| mkpartfs PART-TYPE FS-TYPE START END    | 创建分区，并建立文件系统                 |
| move NUMBER START END                   | 移动分区                                 |
| name NUMBER NAME                        | 给分区命名                               |
| print [devices\|free\|list,all\|NUMBER] | 显示分区表、活动设备、空闲空间、所有分区 |
| quit                                    | 退出                                     |
| rescue START END                        | 修复丢失的分区                           |
| resize NUMBER START END                 | 修改分区大小                             |
| rm NUMBER                               | 删除分区                                 |
| select DEVICE                           | 选择需要编辑的设备                       |
| set NUMBER FLAG STATE                   | 改变分区标记                             |
| toggle [NUMBER [FLAG]]                  | 切换分区表的状态                         |
| unit UNIT                               | 设置默认的单位                           |
| Version                                 | 显示版本                                 |



首先使用`parted`命令进入交互模式

```
[root@localhost ~]# parted /dev/sdb
```



1. 接下里查看分区表

```
(parted) print
#进入print指令
Model: VMware, VMware Virtual S (scsi)
#硬盘参数，是虚拟机
Disk/dev/sdb: 21.5GB
#硬盘大小
Sector size (logical/physical): 512B/512B
#扇区大小
Partition Table: msdos
#分区表类型，是MBR分区表
Number Start End Size Type File system 标志
1 32.3kB 5379MB 5379MB primary
2 5379MB 21.5GB 16.1GB extended
5 5379MB 7534MB 2155MB logical ext4
6 7534MB 9689MB 2155MB logical ext4
#看到了我们使用fdisk命令创建的分区，其中1分区没被格式化；2分区是扩展分区，不能被格式化
```

> 分区表中的信息怎么看，已经写在`命令`标签的`parted`命令中了



2. 接下来修改成GPT分区表

```
(partcd) mklabel gpt
#修改分区表命令
警告：正在使用/dev/sdb上的分区。由于/dev/sdb分区已经挂载，所以有警告。注意，如果强制修改，那么原有分区及数据会消失
忽略/Ignore/放弃/Cancel? ignore
#输入ignore忽略报错
警告：The existing disk label on /dev/sdb will be destroyed and all data on this disk will be lost. Do you want to continue?
是/Yes/否/No? yes
#输入 yes
警告：WARNING: the kernel failed to re-read the partition table on /dev/sdb (设 备或资源忙）.As a result, it may not reflect all of your changes until after reboot.
#下次重启后才能生效
(parted) print
#查看一下分区表
Model: VMware, VMware Virtual S (scsi)
Disk /dev/sdb: 21.5GB
Sector size (logical/physical): 512B/512B
Partition Table: gpt
#分区表已经变成 GPT
Number Start End Size File system Name 标志
#所有的分区都消失了								//此处需要重启
```

> 修改了分区表，如果这块硬盘上已经有分区了，那么原有分区和分区中的数据都会消失，而且需要重启系统才能生效。



>  另外，我们转换分区表的目的是支持大于 2TB 的分区，如果分区并没有大于 2TB，那么这一步是可以不执行的。也就是说MBP不支持大于2GB，而GPT支持大于2GB。
>
> 注意，一定要把 /etc/fstab 文件和原有分区中的内容删除才能重启，否则会报错。



3. 建立分区

   因为修改过了分区表，所以/dev/sdb硬盘中的所有数据都消失了，我们就可以重新对这块硬盘分区了。不过，在建立分区时，默认文件系统就只能是 ext2 了。命令如下：

```
(parted)mkpart
#输入创建分区命令，后面不要参数，全部靠交互
指定
分区名称？ []?disk1
#分区名称，这里命名为disk 1
文件系统系统？ [ext2]?
#文件系统类型，直接回车，使用默认文件系统ext2
起始点？ 1MB
#分区从1MB开始
结束点？5GB分区到5GB结束
#分区完成
(parted) print
#查看一下
Model: VMware, VMware Virtual S (scsi)
Disk/dev/sdb: 21.5GB
Sector size (logical/physical): 512B/512B Partition Table: gpt
Number Start End Size Rle system Name 标志
1 1049kB 5000MB 4999MB disk1
#分区1已经出现
```

> 注意，此处使用`print`查看的分区和第一次查看`MBR`分区表的分区时有些不一样了，少了`type`这个字段。多了`Name`字段。`type`字段用于标识主分区，扩展分区和逻辑分区的。不过这种标识只在 MBR 分区表中使用，现在已经变成了 GPT 分区表，所以就不再有 Type 类型了。



4. 建立文件系统

分区分完后，还需要进行格式化。如果使用 parted 交互命令格式化，则只能格式化成 ext2 文件系统。此处演示一下 parted 命令的格式化方法，格式化成 ext2 文件系统。命令如下：

```
(parted) mkfs
#格式化命令（很奇怪，也是mkfs，但是这只是parted的交互命令）
WARNING: you are attempting to use parted to operate on (mkfs) a file system.
parted's file system manipulation code is not as robust as what you'll find in
dedicated, file-system-specific packages like e2fsprogs. We recommend
you use parted only to manipulate partition tables, whenever possible.
Support for performing most operations on most types of file systems
will be removed in an upcoming release.
警告：The existing file system will be destroyed and all data on the partition will be lost. Do you want to continue?
是/Yes/否/No? yes
#警告你格式化丟失，没关系，已经丢失过了
分区编号？ 1
文件系统类型 [ext2]?
#指定文件系统类型，写别的也没用，直接回车
(parted) print #格式化完成，查看一下
Model: VMware, VMware Virtual S (scsi)
Disk/dev/sdb: 21,5GB
Sector size (logical/physical): 512B/512B
Partition Table: gpt
Number Start End Size File system Name标志
1 1049kB 5000MB 4999MB ext2 diski
#拥有了文件系统
```

> 如果要格式化成 ext4 文件系统，那么请 mkfs 命令帮忙吧（注意：不是 parted 交互命令中的 mkfs，而是系统命令 mkfs)。



5. 调整分区大小

parted 命令还有一大优势，就是可以调整分区的大小（在 Windows 中也可以实现，不过要么需要转换成动态磁盘，要么需要依赖第三方工具，如硬盘分区魔术师）。起始 [Linux](http://c.biancheng.net/linux_tutorial/) 中 LVM 和 RAID 是可以支持分区调整的，不过这两种方法也可以看成动态磁盘方法，使用 parted 命令调整分区更加简单。

>  注意，parted 调整已经挂载使用的分区时，是不会影响分区中的数据的，也就是说，数据不会丢失。但是一定要先卸载分区，再调整分区大小，否则数据是会出现问题的。另外，要调整大小的分区必须已经建立了文件系统（格式化），否则会报错。

```
(parted) resize
分区编号？ 1
#指定要修改的分区编号
起始点？ [1049kB]? 1MB
#分区起始位置
结束点？ [5000MB]? 6GB
分区结束位置
(parted) print
#查看一下
Model: VMware, VMware Virtual S (scsi)
Disk/dev/sdb: 21,5GB
Sector size (logical/physical): 512B/512B
Partition Table: gpt
Number Start End Size File system Name标志
1 1049kB 6000MB 5999MB ext2 diski
#分区大小改变
```



6. 删除分区

```
命令如下：
(parted) rm
#删除分区命令
分区编号？ 1
#指定分区编号
(parted) print
#查看一下
Model: VMware, VMware Virtual S (scsi)
Disk/dev/sdb: 21.5GB
Sector size (logical/physical): 512B/512B
Partition Table: gpt
Number Start End Size File system Name 标志 #分区消失
```

> 要注意的是，parted 中所有的操作都是立即生效的，没有保存生效的概念。这一点和 fdisk 交互命令明显不同，所以做的所有操作大家要加倍小心。





##### 5.	创建`swap`交换分区

> 关于什么是`swap`交换分区，详情在`简单理论概念`标签的`Linux虚拟内存与物理内存`中了。

我们在安装系统的时候已经建立了 swap 分区。swap 分区通常被称为交换分区，这是一块特殊的硬盘空间，即当实际内存不够用的时候，操作系统会从内存中取出一部分暂时不用的数据，放在交换分区中，从而为当前运行的程序腾出足够的内存空间。



也就是说，当内存不够用时，我们使用 swap 分区来临时顶替。这种“拆东墙，补西墙”的方式应用于几乎所有的操作系统中。



使用 swap 交换分区，显著的优点是，通过操作系统的调度，应用程序实际可以使用的内存空间将远远超过系统的物理内存。由于硬盘空间的价格远比 RAM 要低，因此这种方式无疑是经济实惠的。当然，频繁地读写硬盘，会显著降低操作系统的运行速率，这也是使用 swap 交换分区最大的限制。

```
相比较而言，Windows 不会为 swap 单独划分一个分区，而是使用分页文件实现相同的功能，在概念上，Windows 称其为虚拟内存，从某种意义上将，这个叫法更容易理解。因此，初学者将 swap 交换分区理解为虚拟内存是没有任何问题的
```

> swap分区大小的话。创建一个5G左右swap交换分区就差不多了



建立新的 swap 分区，只需要执行以下几个步骤。

1. 分区：不管是 fdisk 命令还是 parted 命令，都需要先区。
2. 格式化：格式化命令稍有不同，使用 mkswap 命令把分区格式化成 swap 分区。
3. 使用 swap 分区。



具体执行如下：

1. 建立swap分区

```
[root@localhost ~]# fdisk /dev/sdb
#以/dev/sdb分区为例
WARNING: DOS-compatible mode is deprecated.It's strongly recommended to switch off the mode (command 'c') and change display units to sectors (command 'u').
Command (m for help): n
#新建
Command action e extended p primary partition (1-4)
P
#主分区
Partition number (1-4): 1
#分区编号
First cylinder (1-2610, default 1):
#起始柱面
Using default value 1
Last cylinder, +cylinders or +size{K, M, G} (1-2610, default 2610): +500M
#大小
Command (m for help): p
#查看一下
Disk /dev/sdb: 21.5GB, 21474836480 bytes
255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 *512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes 1512 bytes
Disk identifier: OxOOOOOebd
Device Boot Start End Blocks Id System
/dev/sdb1 1 65 522081 83 Linux
#刚分配的分区ID是83，是Linux分区，我们在这里要分配swap分区
Command (m for help): t
#修改分区的系统ID
Selected partition 1
#只有一个分区，所以不用选择分区了
Hex code (type L to list codes): 82
#改为swap分区的ID
Changed system type of partition 1 to 82 (Linux swap / Solaris)
Command (m for help): p
#再查看一下
Disk /dev/sdb: 21.5 GB, 21474836480 bytes
255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 *512 = 8225280 bytes Sector size (logical/physical): 512 bytes / 512 bytes I/O size (minimum/optimal): 512 bytes 1512 bytes Disk identifier: OxOOOOOebd
Device Boot Start End Blocks Id System
/dev/sdb1 1 65 522081 82 Linux swap / Solaris
#修改过来了
Command (m for help): w
#记得保存退出
The partition table has been altered!
Calling ioctl() to re-read partition table.
Syncing disks.
```

> 仍以 /dev/sdb 分区作为实验对象。不过，如果分区使用 parted 命令转变为 GPT 分区表，则记得转换回 MBR 分区表，fdisk 命令才能识别，否则干脆新添加一块硬盘做实验。



2. 格式化

因为要格式化成`swap`分区，所以格式化命令是`mkswap`。如下：

```
[root@localhost ~]# mkswap /dev/sdb1
Setting up swapspace version 1, size = 522076 KiB
no label, UUID=c3351 dc3-f403-419a-9666-c24615e170fb
```



3. 开启`swap`分区

在使用 swap 分区之前，我们先来说说 free 命令。命令如下：

```
[root@localhost ~]#free
		total 	used 	free 	shared 	buffers 	cached
Mem: 	1030796 130792 	900004 		0 	15292 		55420
Swap: 	2047992   0 	2047992
```

free 命令主要是用来查看内存和 swap 分区的使用情况的，其中：

- total：是指总数；
- used：是指已经使用的；
- free：是指空闲的；
- shared：是指共享的；
- buffers：是指缓冲内存数；
- cached：是指缓存内存数，单位是KB；

+ available： 是指还可以被应用程序使用的物理内存大小。

> 我们需要解释一下 buffers（缓冲）和 cached（缓存）的区别。简单来讲，cached 是给读取数据时加速的，buffers 是给写入数据加速的。cached 是指把读取出来的数据保存在内存中，当再次读取时，不用读取硬盘而直接从内存中读取，加速了数据的读取过程；buffers 是指在写入数据时，先把分散的写入操作保存到内存中，当达到一定程度后再集中写入硬盘，减少了磁盘碎片和硬盘的反复寻道，加速了数据的写入过程。



我们已经看到，在加载进新的 swap 分区之前，swap 分区的大小是 2000MB，接下来只要加入 swap 分区就可以了，使用命令 swapon。命令格式如下：

```
[root@localhost ~]# swapon 分区设备文件名
```

例如：

```
[root@localhost ~]# swapon /dev/sdb1
swap分区已加入，我们查看一下。
[root@localhost ~]#free
total used free shared buffers cached
Mem: 1030796 131264 899532 0 15520 55500
-/+ buffers/cache: 60244 970552
Swap: 2570064 0 2570064
```

> swap 分区的大小变成了 2500MB，加载成功了。

如果要关闭新加入的 swap 分区，则也很简单，命令如下：

```
[root@localhost ~]# swapoff /dev/sdb1
```

如果想让 swap 分区开机之后自动挂载，就需要修改 /etc/fstab 文件，命令如下：

```
[root@localhost ~]#vi /etc/fstab
UUID=c2ca6f57-b15c-43ea-bca0-f239083d8bd2 / ext4 defaults 1 1
UUID=0b23d315-33a7-48a4-bd37-9248e5c443451 boot ext4 defaults 1 2
UUID=4021be19-2751-4dd2-98cc-383368c39edb swap swap defaults 0 0
tmpfs /dev/shm
tmpfs defaults 0 0
devpts /dev/pts
devpts gid=5, mode=620 0 0
sysfs /sys
sysfs defaults 0 0
proc /proc
proc defaults 0 0
/dev/sdb1 swap swap
defaults 0 0
#加入新swap分区的相关内容，这里直接使用分区的设备文件名，也可以使用UUID。
```





### 二.	Linux高级文件系统管理



#### 1.	磁盘配额

##### 1.	简单概念

磁盘配额（Quota）就是 [Linux](http://c.biancheng.net/linux_tutorial/) 系统中用来限制特定的普通用户或用户组在指定的分区上占用的磁盘空间或文件个数的。



在此概念中，有以下几个重点需要注意：

1. 磁盘配额限制的用户和用户组，只能是普通用户和用户组，也就是说超级用户 root 是不能做磁盘配额的；
2. 磁盘配额限制只能针对分区，而不能针对某个目录，换句话说，磁盘配额仅能针对文件系统进行限制，举个例子，如果你的 /dev/sda5 是挂载在 /home 底下，那么，在 /home 下的所有目录都会受到磁盘配额的限制；
3. 我们可以限制用户占用的磁盘容量大小（block），当然也能限制用户允许占用的文件个数（inode）。



磁盘配额想要正常使用，有以下几个前提条件：

1. 内核版本必须支持磁盘配额（ps.一般默认是支持磁盘配额的）。使用以下命令可以查看内核配置文件是否支持磁盘配额。

```
[root@localhost ~]# grep CONFIG_QUOTA /boot/corrfig-2.6.32-279.el6.i686
CONFIG_QUOTA=y
CONFIG_QUOTA_NETLINK_INTERFACE=y
# CONFIG_QUOTA_DEBUG is not set
CONFIG_QUOTA_TREE=y
CONFIG_QUOTACTL=y
```

> 可以看到，内核已经支持磁盘配额。如果内核不支持，就需要重新编译内核，加入 quota supper 功能。



2. 系统中必须安装了`QUOTA`工具。一般Linux中也是默认安装了此工具的。查看命令如下：

   ```
   [root@localhost ~]# rpm -qa | grep quota
   quota-3.17-16.el6.i686
   ```



3. 要支持磁盘配额的分区必须开启磁盘配额功能。这项功能可以手动开启，不再是默认开启的。



**磁盘配额中的常见概念**



*用户配额和组配额*

用户配额是针对用户的人的配额，组配额是针对整个用户组的配额。如果需要限制的用户数量不多，建议使用用户配额。如果需要限制的用户较多，建议使用组配额。



*磁盘容量限制和文件个数限制*

我们除了可以通过限制用户可用的`block`数量来限制用户可用的磁盘容量，也可以通过限制用户可用的`inode`数量来限制用户可以上传或新建的文件个数。



*软限制和硬限制*

软限制可以理解为警告限制，硬限制就是真正的限制了。例如软限制为100MB，硬限制为200MB。则用户使用的空间为100~200MB时，用户还可以继续上传和新建文件，但每次登陆时都会收到一条警告信息告诉用户磁盘将满。



*宽限时间*

如果用户的空间占用数处于软限制和硬限制之间，那么系统会在用户登录时警告用户磁盘将满，但是这个警告不会一直进行，而是有时间限制的。这个时间就是宽限时间，默认是7天。



> 如果到达宽限时间，用户的磁盘占用量还超过软限制，那么软限制就会升级为硬限制。
>
> 也就是说，如果软限制是 100MB，硬限制是 200MB，宽限时间是 7天，此时用户占用了 120MB,那么今后 7 天用户每次登录时都会出现磁盘将满的警告，如果用户置之不理，7 天后这个用户的硬限制就会变成 100MB，而不是 200MB 了。



##### 2.	磁盘配额前的准备



>  上面我们已经确定了我们当前操作系统内核是支持磁盘配额的。
>
> 接下来我们配置文件系统，使其也支持磁盘配额



由于 Quota 仅针对文件系统进行限制，因此我们有必要查一下，/home 是否是独立的文件系统，执行命令如下：

```
[root@localhost ~]# df -h /home
Filesystem     Size  Used Avail Use% Mounted on
/dev/hda3      4.8G  740M  3.8G  17% /home  <-- /home 确实是独立的！
```

> 此处的`/home`确实是独立的文件系统，所以可以进行磁盘配额的限制。但如果你使用的系统中`/home`不是独立的，则可能就要对根目录进行磁盘配额了。不过最好别这样做



另外，由于 VFAT 文件系统并不支持磁盘配额功能，因此，这里需要查看 /home 的文件系统，执行命令如下：

```
[root@localhost ~]# mount | grep home
/dev/hda3 on /home type ext3 (rw)				//也可以直接使用df -Th /home查看
```



接下来，如果想要获得文件系统的支持的话。还需要为执行的文件系统添加挂载参数，分别是`usrquota`(用户磁盘配额)和`grpquota`(用户组磁盘配额)。至于添加的方式有一下两种：

1. 如果只说想在本次启动中实验磁盘配额，那么只需要重新挂载的时候添加挂载参数就好了

```
[root@localhost ~]# mount -o remount,usrquota,grpquota /home
```

> 这种手动添加的方式，会在下次挂载的时候消失。

2. 如果想长久的使用磁盘配额。可以修改`/etc/fatab`文件，将挂载参数写入到配置文件中，

```
[root@localhost ~]# vim /etc/fstab
………………
/devhda3   /home  ext3   defaults,usrquota,grpquota  1 2
[root@localhost ~]# umount /home
[root@localhost ~]# mount -a
[root@localhost ~]# mount | grep home
/dev/hda3 on /home type ext3 (rw,usrquota,grpquota)
```

> 到此为止，我们的基本准备工作就做完了。



##### 3.	`quotacheck`建立磁盘配额记录文件

> 磁盘配额（Quota）就是通过分析整个文件系统中每个用户和群组拥有的文件总数和总容量，再将这些数据记录在文件系统中的最顶层目录中，然后在此记录文件中使用各个用户和群组的配额限制值去规范磁盘使用量的。



扫面文件系统(必须含有挂载参数`usrquota`和`grpquota`)，可以使用`quotacheck`命令，基本格式如下

```
[root@localhost ~]# quotacheck [-avugfM] 文件系统
```

选项如下：

| 选项       | 功能                                                         |
| ---------- | ------------------------------------------------------------ |
| -a         | 扫瞄所有在 /etc/mtab 中，含有 quota 支持的 filesystem，加上此参数后，后边的文件系统可以不写； |
| -u         | 针对使用者扫瞄文件与目录的使用情况，会创建 aquota.user       |
| -g         | 针对群组扫瞄文件与目录的使用情况，会创建 aquota.group        |
| -v         | 显示扫瞄的详细过程；                                         |
| -f         | 强制扫瞄文件系统，并写入新的 quota 记录文件                  |
| -M（大写） | 强制以读写的方式扫瞄文件系统，只有在特殊情况下才会使用。     |

> 在使用这些选项时，只需要一起下达`quotacheck -avug`即可。
>
> 至于 -f 和 -M 选项，是在文件系统以启动 quota 的情况下，还要重新扫描文件系统（担心有其他用户在使用 quota 中），才需要使用这两个选项。



例如，我们可以使用如下的命令，对整个系统中含有挂载参数（usrquota 和 grpquota）的文件系统进行扫描：

```
[root@localhost ~]# quotacheck -avug
quotacheck: Scanning /dev/hda3 [/home] quotacheck: Cannot stat old user quota
file: No such file or directory <--有找到文件系统，但尚未制作记录文件！
quotacheck: Cannot stat old group quota file: No such file or directory
quotacheck: Cannot stat old user quota file: No such file or directory
quotacheck: Cannot stat old group quota file: No such file or directory
done  <--上面三个错误只是说明记录文件尚未创建而已，可以忽略不理！
quotacheck: Checked 130 directories and 107 files <--实际搜寻结果
quotacheck: Old file not found.
quotacheck: Old file not found.
# 若运行这个命令却出现如下的错误信息，表示你没有任何文件系统有启动 quota 支持！
# quotacheck: Can't find filesystem to check or filesystem not mounted with quota option.

[root@localhost ~]# ll -d /home/a*
-rw------- 1 root root 8192 Mar  6 11:58 /home/aquota.group
-rw------- 1 root root 9216 Mar  6 11:58 /home/aquota.user
# 可以看到，扫描的同时，会创建两个记录文件，放在 /home 底下
```

> 注意：此命令不要反复的执行，因为若启动了`Quota`后还执行此命令。则会破坏原有的记录文件，同时残生一些错误信息。



还有没事别手贱去操作这两个文件。这两个文件不是拿来给人操作的，是系统要用的



##### 4.	`quotaon`开启磁盘配额限制

> 前面已经使用了`quotacheck`命令创建好了磁盘配额文件。此处就准备启动`Quota`了。
>
> 可以直接使用`quotaon`命令即可



`quotaon`命令的功能就是启动`Quota`服务，此命令的基本格式为：

```
[root@localhost ~]# quotaon [-avug]
[root@localhost ~]# quotaon [-vug] 文件系统名称
```

选项如下：

| 选项 | 功能                                                         |
| ---- | ------------------------------------------------------------ |
| -a   | 根据 /etc/mtab 文件中对文件系统的配置，启动相关的Quota服务，如果不使用 -a 选项，则此命令后面就需要明确写上特定的文件系统名称 |
| -u   | 针对用户启动 Quota（根据记录文件 aquota.user）               |
| -g   | 针对群组启动 Quota（根据记录文件 aquota.group）              |
| -v   | 显示启动服务过程的详细信息                                   |

> 注意：`quotaon -avug`命令只需要在第一次 Quota 服务时才需要进行，因为下次重新启动系统时，系统的 /etc/rc.d/rc.sysinit 初始化脚本会自动下达这个命令。



如果要同时启动对用户和群组的`Quota`服务，可以使用如下命令：

```
[root@localhost ~]# quotaon -avug
/dev/hda3 [/home]: group quotas turned on
/dev/hda3 [/home]: user quotas turned on
```



##### 5.	`quotaoff`关闭磁盘配额限制

> 上面一点写了使用`quotaon`开启磁盘配额限制，此处使用`quotaoff`关闭磁盘配额限制

`quotaoff`命令的功能就是关闭磁盘配额限制，此命令的基本格式同`quotaon`类似。如下：

```
[root@localhost ~]# quotaoff [-avug]
[root@localhost ~]# quotaoff [-vug] 文件系统名称
```

选项如下：

| 选项 | 功能                                                         |
| ---- | ------------------------------------------------------------ |
| -a   | 根据 /etc/mtab 文件，关闭已启动的 Quota 服务，如果不使用 -a 选项，则此命令后面就需要明确写上特定的文件系统名称 |
| -u   | 关闭针对用户启动的 Quota 服务。                              |
| -g   | 关闭针对群组启动的 Quota 服务。                              |
| -v   | 显示服务过程的详细信息                                       |



此处使用`quotaoff`命令关闭所有已开启的`Quota`服务。

```
[root@localhost ~]# quotaoff -avug
```



> 如果只针对用户关闭`/var`启动的`Quota`支持，可以使用以下命令

```
[root@localhost ~]# quotaoff -uv /var
```





##### 6.	`edquota`修改用户(群组)的磁盘配额

> 可以使用`edquota`命令来修改用户(群组)的磁盘配额限制

`edquota`，全写`edit quota`。用于修改用户和群组的配额限制参数，包括磁盘容量和文件个数限制、软限制和硬限制值、宽限时间，该命令的基本格式有以下 3 种

```
[root@localhost ~]# edquota [-u 用户名] [-g 群组名]
[root@localhost ~]# edquota -t
[root@localhost ~]# edquota -p 源用户名 -u 新用户名
```

常用选项如下：

| 选项      | 功能                                                         |
| --------- | ------------------------------------------------------------ |
| -u 用户名 | 进入配额的 Vi 编辑界面，修改针对用户的配置值；               |
| -g 群组名 | 进入配额的 Vi 编辑界面，修改针对群组的配置值；               |
| -t        | 修改配额参数中的宽限时间；                                   |
| -p        | 将源用户（或群组）的磁盘配额设置，复制给其他用户（或群组）。 |



例如，以用户 myquota 为例，通过如下命令配置此命令的 Quota：

```
[root@localhost ~]# edquota -u myquota
Disk quotas for user myquota (uid 710):Filesystem    blocks  soft   hard  inodes  soft  hard							/dev/hda3         80     0      0      10     0     0
```



> 关于字段的含义如下：

| 表头                     | 含义                                                         |
| ------------------------ | ------------------------------------------------------------ |
| 文件系统（filesystem）   | 说明该限制值是针对哪个文件系统（或分区）；                   |
| 磁盘容量（blocks）       | 此列的数值是 quota 自己算出来的，单位为 Kbytes，不要手动修改； |
| 磁盘容量的软限制（soft） | 当用户使用的磁盘空间超过此限制值，则用户在登陆时会收到警告信息，告知用户磁盘已满，单位为 KB； |
| 磁盘容量的硬限制（hard） | 要求用户使用的磁盘空间最大不能超过此限制值，单位为 KB；      |
| 文件数量（inodes）       | 同 blocks 一样，此项也是 quota自己计算出来的，无需手动修改； |
| 文件数量的软限制（soft） | 当用户拥有的文件数量超过此值，系统会发出警告信息；           |
| 文件数量的硬限制（hard） | 用户拥有的文件数量不能超过此值。                             |

> 注意，当 soft/hard 为 0 时，表示没有限制。另外，在 Vi（或 Vim）中修改配额值时，填写的数据无法保证同表头对齐，只要保证此行数据分为 7 个栏目即可。



实例1：

> 修改用户`myquota`的软限制值和硬限制值

```
[root@localhost ~]# edquota -u myquota
Disk quotas for user myquota (uid 710):
  Filesystem    blocks    soft    hard  inodes  soft  hard
  /dev/hda3         80  250000  300000      10     0     0
```



实例2：

> 修改群组`mygrp`的配额

```
[root@localhost ~]# edquota -g mygrp
Disk quotas for group mygrpquota (gid 713):
  Filesystem    blocks    soft     hard  inodes  soft  hard
  /dev/hda3        400  900000  1000000      50     0     0
```



实例3：

> 修改宽限天数。

```
[root@localhost ~]# edquota -t
Grace period before enforcing soft limits for users:
Time units may be: days, hours, minutes, or seconds
  Filesystem         Block grace period     Inode grace period
  /dev/hda3                14days                  7days
```



##### 7.	非交互式设置磁盘配额

> 如果我们需要写脚本建立大量的用户，并给每个用户都自动进行磁盘配额，那么 edquota 命令就不能在脚本中使用了，因为这个命令的操作过程和 vi 类似，需要和管理员产生交互。
>
> 这种情况下就需要利用 setquota 命令进行设置，这个命令的好处是通过命令行设定配额，而不用和管理员交互设定。

`setquota`命令格式如下：

```
[root@localhost ~]# setquota -u 用户名 容量软限制 容量硬限制 个数软限制 个数硬限制 分区名
```



实例1：

> 我们建立用户 lamp4，并用 setquota 命令设定磁盘配额。

```
[root@localhost ~]# useradd lamp4
[root@localhost ~]# passwd lamp4
#建立用户
[root@localhost ~]# setquota -u lamp4 10000 20000 5 8/disk
#设定用户在/disk分区中的容量软限制为10MB，硬限制为20MB；文件个数软限制为5个，硬限制为8个
[root@localhost ~]# quota -uvs lamp4
Disk quotas for user Iamp4 (uid 503):
Filesystem blocks quota limit grace files quota limit grace
/dev/sdbl 0 10000 20000 0 5 8
#查看一下，配额生效了
```



##### 8.	`quota`和`requota`命令查询磁盘配额



查询磁盘配额有两种方法：

+ 使用`quota`命令查询用户或用户组的配额
+ 使用`repquota`命令查询整个分区的配额情况



###### quota 命令查询用户或用户组配额

```
[root@localhost ~]# quota [选项] [用户或组名]
```

选项：

- -u 用户名：查询用户配额；
- -g 组名：查询组配额；
- -v：显示详细信息；
- -s：以习惯单位显示容量大小，如M、G；

```
[root@localhost 〜]# quota -uvs lamp1
Disk quotas for user lamp1 (uid 500):
Filesystem blocks quota limit grace files quota limit grace	
/dev/sda3 	20 		0 	  0 		  6 	  0 	0
/dev/sdbl 	0 	   40000 50000  	  0 	  8 	10
#查看lamp1用户的配额值						//quota字段为软限制,limit字段为硬限制
[root@localhost ~]# quota -uvs lamp2
Disk quotas for user lamp2 (uid 501):
Filesystem blocks quota limit grace files quota limit grace
/dev/sda3  36752 	0 	  0    		 2672   0 	 0
/dev/sdbl 	 0 	   245M  293M 		  0 	  0 	0
#查看lamp2用户的配额值
```

> lamp 用户的配额值还不够大，所以没有换算成 MB 单位，但是 lamp2 用户已经换算了。在选项列当中多出了 grace 字段，这里是用来显示宽限时间的，我们现在还没有达到软限制，所以 grace 字段为空。



###### repquota命令查询文件系统配额

```
[root@localhost ~]# repquota [选项] [分区名]
```

选项：

- -a：依据 /etc/mtab 文件查询配额。如果不加 -a 选项，就一定要加分区名；
- -u：查询用户配额；
- -g：查询组配额；
- -v：显示详细信息；
- -s：以习惯单位显示容量太小；

```
[root@localhost ~] # repquota -augvs
*** Report for user quotas on device /dev/sdbl
#用户配额信息
Block grace time: 8days; Inode grace time: 8days
Block limits File limits
User used soft hard grace used soft hard grace
root -- 13 0 	0 			2    0 	  0
lampl -- 0 40000 50000 		0 	 8 	  10
lamp2 -- 0 245M 293M 		0    0    0
lamp3 -- 0 245M 293M 		0    0    0
#用户的配额值
Statistics:
Total blocks: 7
Data blocks: 1
Entries: 4
Used average: 4.000000
*** Report for group quotas on device /dev/sdbl
#组配额信息
Block grace time: 7days; Inode grace time: 7days
Block limits File limits
Group used soft hard grace used soft hard grace
root -- 13  0     0 		2    0    0
brother--0 440M 489M 		0    0    0
#组的配额值
Statistics:
Total blocks: 7
Data blocks: 1
Entries: 2
Used average: 2.000000
```

> 如果想真实测试一下，磁盘配额是否生效的话。建议直接去新建文件，增加容量什么的。



#### 2.	LVM逻辑卷



##### 1.	LVM基础概念

> LVM 最大的好处就是可以随时调整分区的大小，分区中的现有数据不会丟失，并且不需要卸载分区、停止服务。

LVM 是 Logical Volume Manager 的简称，译为中文就是逻辑卷管理。它是 Linux 下对硬盘分区的一种管理机制。LVM 适合于管理大存储设备，并允许用户动态调整文件系统的大小。此外，LVM 的快照功能可以帮助我们快速备份数据。LVM 为我们提供了逻辑概念上的磁盘，使得文件系统不再关心底层物理磁盘的概念。

```
Linux LVM 允许我们在逻辑卷在线的状态下将其复制到另一设备上，此成功被称为快照功能。快照允许我们在复制的同时，保证运行关键任务的 Web 服务器或数据库服务继续工作。
```



LVM 是在硬盘分区之上建立一个逻辑层，这个逻辑层让多个硬盘或分区看起来像一块逻辑硬盘，然后将这块逻辑硬盘分成逻辑卷之后使用，从而大大提高了分区的灵活性。我们把真实的物理硬盘或分区称作物理卷（PV）；由多个物理卷组成一块大的逻辑硬盘，叫作卷组（VG）；将卷组划分成多个可以使用的分区，叫作逻辑卷（LV）。而在 LVM 中最小的存储单位不再是 block，而是物理扩展块（Physical Extend，PE）。我们通过下图看看这些概念之间的联系。

<img src="http://c.biancheng.net/uploads/allimg/181016/2-1Q0161050242Q.jpg" alt="LVM示意图" style="zoom:80%;" />

- 物理卷（Physical Volume，PV）：就是真正的物理硬盘或分区。
- 卷组（Volume Group，VG）：将多个物理卷合起来就组成了卷组。组成同一个卷组的物理卷可以是同一块硬盘的不同分区，也可以是不同硬盘上的不同分区。我们可以把卷组想象为一块逻辑硬盘。
- 逻辑卷（Logical Volume，LV）：卷组是一块逻辑硬盘，硬盘必须分区之后才能使用，我们把这个分区称作逻辑卷。逻辑卷可以被格式化和写入数据。我们可以把逻辑卷想象为分区。
- 物理扩展（Physical Extend，PE）：PE 是用来保存数据的最小单元，我们的数据实际上都是写入 PE 当中的。PE 的大小是可以配置的，默认是 4MB。





也就是说，我们在建立 LVM 的时候，需要按照以下步骤来进行：

1. 把物理硬盘分成分区，当然也可以是整块物理硬盘；
2. 把物理分区建立为物理卷（PV），也可以直接把整块硬盘都建立为物理卷。
3. 把物理卷整合为卷组（VG）。卷组就已经可以动态地调整大小了，可以把物理分区加入卷组，也可以把物理分区从卷组中删除。
4. 把卷组再划分为逻辑卷（LV），当然逻辑卷也是可以直接调整大小的。我们说逻辑卷可以想象为分区，所以也需要格式化和挂载。

> 注意：删除不用的逻辑卷时，必须按照上面的安装步骤反着做就好了。

##### 2.	`PV`物理卷

> 其实在创建`Linux`的时候分区就能修改问`LVM`分区的

###### 建立`LVM`分区

创建`PV`第一步就是：建立所需的物理分区，创建的方式还是使用`fdisk`命令。不过需要注意的是：这时候建立的分区就不说`Linux`分区，而是`LVM`的分区了。`LVM`的分区ID为`8e`。

使用以下命令创建三个`LVM`分区：

```
[root@localhost ~]# fdisk /dev/sdb
Disk /dev/sdb: 21.5 GB, 21474836480 bytes 255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 * 512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk identifier: 0x00000ebd
Device Boot Start End Blocks Id System
/dev/sdbl 1 65 522081 83 Linux
/dev/sdb2 66 2610 20442712+ 5 Extended
/dev/sdb5 66 197 1060258+ 83 Linux
/dev/sdb6 198 329 1060258+ 83 Linux
/dev/sdb7 330 461 1060258+ 83 Linux
#建立了/dev/sdb5 ~ 7三个分区
Command (m for help): t
Partition number (1-7): 5
Hex code (type L to list codes): 8e
Changed system type of partition 5 to 8e (Linux LVM)
#把/dev/sdb5的分区ID改为8e，其他两个分区照做，改好后，查询结果如下：
Command (m for help): p
Disk /dev/sdb: 21.5 GB, 21474836480 bytes 255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 * 512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes Disk identifier: 0x00000ebd
Device Boot Start End Blocks Id System
/dev/sdb1 1 65 52.2081 83 Linux
/dev/sdb2 66 2610 20442712+ 5 Extended
/dev/sdb5 66 197 1060258+ 8e Linux LVM
/dev/sdb6 198 329 1060258+ 8e Linux LVM
/dev/sdb7 330 461 1060258+ 8e Linux LVM #保存退出
[root@localhost ~]# partprobe #记得重新读取分区表，否则重启系统
```

> 此时已经建立好了，`LVM`的逻辑分区。接下来开始建立`PV`逻辑卷。



###### 建立物理卷

建立物理卷的命令`pvcreate`，格式如下：

```
[root@localhost ~]# pvcreate [设备文件名]
```

建立物理卷时，我们既可以把整块硬盘都建立成物理卷，也可以把某个分区建立成物理卷。如果要把整块硬盘都建立成物理卷的话，`pvcreate`后面直接跟设备文件名：

```
[root@localhost ~]# pvcreate /dev/sdb
```

当然，如果只是把分区建立成物理卷，那`pvcreate`后面直接跟分区名就好了：

```
[root@localhost ~]# pvcreate /dev/sdb5
Writing physical volume data to disk "/dev/sdb5" Physical volume "/dev/sdb5" successfully created
[root@localhost ~]# pvcreate /dev/sdb6
Writing physical volume data to disk "/dev/sdb6" Physical volume "/dev/sdb6" successfully created
[root@localhost ~]# pvcreate /dev/sdb7
Writing physical volume data to disk "/dev/sdb7" Physical volume 7dev/sdb7' successfully created
```



###### 查看物理卷

查看物理卷的命令有两个，一个是`pvscan`。命令如下：

```
[root@localhost ~]# pvscan
PV /dev/sdb5 Ivm2 [1.01 GiB]
PV /dev/sdb6 Ivm2 [1.01 GiB]
PV /dev/sdb7 Ivm2 [1.01 GiB]
Total: 3 [3.03 GiB] /in no VG: 0 [0 ] / in no VG: 3 [3.03 GiB]
```

> 可以看到，在我们的系统中，/dev/sdb5~7 这三个分区是物理卷。最后一行的意思是：共有 3 个物理卷[大小]/使用了 0 个卷[大小]/空闲 3 个卷[大小]。

第二个查询命令是`pvdisplay`，此命令可以看到更加详细的物理卷状态，如下：

```
[root@localhost ~]# pvdisplay
"/dev/sdb5" is a new physical volume of "1.01 GiB"
—NEW Physical volume 一
PV Name /dev/sdb5
#PV名
VG Name
#属于的VG名，还没有分配，所以空白
PV Size 1.01 GiB
#PV 的大小
Allocatable NO
#是否已经分配
PE Size 0
#PE大小，因为还没有分配，所以PE大小也没有指定
Total PE 0
#PE总数
Free PE 0
#空闲 PE数
Allocated PE 0
#可分配的PE数
PV UUID CEsVz3-t0sD-e1w0-wkHZ-iaLq-06aV-xtQNTB
#PV的UUID
…其它两个PV省略…
```



###### 删除物理卷

如果不需要物理卷，则使用`pvremove`命令删除，命令如下：

```
[root@localhost ~]# pvremove /dev/sdb7
Labels on physical volume "/dev/sdb7" successfully wiped
```

> 在删除物理卷时，物理卷必须不属于任何卷组，也就是需要先将物理卷从卷组中删除，再删除物理卷。其实所有的删除就是把创建过程反过来，建立时不能少某个步骤，删除时也同样不能跳过某一步直接删除。



##### 3.	`VG`卷组

> 上面已经创建好了逻辑卷，接下来创建卷组

可以把卷组想象成基本分区中的硬盘，是由多个物理卷组成的。卷组就已经可以动态地调整空间大小了，当卷组空间不足时，可以向卷组中添加新的物理卷。



###### 建立卷组

建立卷组使用的命令是`vgcreate`，具体的命令格式如下：

```
[root@localhost ~]# [-s PE] 卷组名 物理卷名
```

> [-s PE 大小] 选项的含义是指定 PE 的大小，单位可以是 MB、GB、TB 等。如果不写，则默认 PE 大小是 4MB。这里的卷组名指的就是要创建的卷组的名称，而物理卷名则指的是希望添加到此卷组的所有硬盘区分或者整个硬盘。



此时我们有三个卷组 /dev/sdb5~7，先把 /dev/sdb5 和 /dev/sdb6 加入卷组，留着 /dev/sdb7 一会实验调整卷组大小，命令如下：

```
[root@localhost ~]# vgcreate -s 8MB scvg /dev/sdb5 /dev/sdb6
Volume group "scvg" successfully created
我们把/dev/sdb和/dev/sdb6两个物理卷加入了卷组scvg，并指定了PE的大小是8MB
```



###### 激活卷组

卷组创建完毕了之后，可以通过 vschange 命令来激活卷组，而无法重启系统。



`vgchange`命令的基本格式如下：

```
#激活卷组
[root@localhost ~]# vgchange -a y 卷组名
#停用卷组
[root@localhost ~]# vachange -a n 卷组名
```

> 通过使用 vgchange 命令，我们可以激活 scvg 卷组。



###### 查看卷组

查看卷组的命令有两个，`vgscan`命令主要用户查看看系统中是否有卷组，`vgdisplay`主要用于查看卷组的详细状态。命令如下：

```
[root@1ocalhost ~]# vgscan
Reading all physical volumes. This may take a while...
Found volume group "scvg" using metadata type lvm2 #scvg卷组确实存在
[root@localhost ~]# vgdisplay
---Volume group ---
VG Name scvg 卷组名
System ID
Format lvm2
Metadata Areas 2
Metadata Sequence No 1
VG Access read/write
#卷组访问状态
VG Status resizable
#卷组状态
MAX LV 0
#最大逻辑卷数
Cur LV 0
Open LV 0
Max PV 0
#最大物理卷数
Cur PV 2
#当前物理卷数
Act PV 2
VG Size 2.02 GiB
#卷组大小
PE Size 8.00 MiB
#PE大小
Total PE 258
#PE总数
Alloc PE / Size 0/0
#已用 PE 数量/大小
Free PE / Size 258 / 2.02GiB
#空闲PE数量/大小
VG UUID Fs0dPf-LV7H-0Ir3-rthA-3UxC-LX5c-FLFriJ
```



###### 增加卷组容量

使用`vgextend`命令，怎加卷组容量。

`vgextend`命令，基本格式如下：

```
[root@localhost ~]# vgextend 卷组名 物理卷名
```



我们这里使用`vgextend`命令来把`/dev/sdb7`加入卷组。命令如下：

```
[root@localhost ~]# vgextend scvg /dev/sdb7
Volume group "scvg" successfully extended
#把/dev/sdb7物理卷也加入scvg卷组
[root@localhost ~]# vgdisplay
---Volume group ---
VG Name scvg
System ID
Format lvm2
Metadata Areas 3
Metadata Sequence No 2
VG Access read/write
VG Status resizable
MAX LV 0
Cur LV 0
Open LV 0
Max PV 0
Cur PV 3
Act PV 3
VG Size 3.02 GiB
#卷组容量增加
PE Size 8.00 MiB
Total PE 387
#PE 总数增加
Alloc PE / Size 0/0
Free PE / Size 387 / 3.02 GiB
VG UUID Fs0dPf-LV7H-0Ir3-rthA-3UxC-LX5c-FLFriJ
```



###### 减少卷组容量

> 我们可以使用`vgreduce`来减少卷组容量，准确说是在卷组中删除物理卷。

命令如下：

```
[root@localhost ~]# vgreduce scvg /dev/sdb7
Removed "/dev/sdb7" from volume group "scvg"
#在卷组中删除/dev/sdb7物理卷
[root@localhost ~]# vgreduce -a
#删除所有未使用的物理卷
```



###### 删除卷组

删除卷组的命令是`vgremove`。命令如下：

```
[root@localhost ~]# vgremove scvg
Volume group "scvg" successfully removed
```

> 当然只有删除了逻辑卷后，并且卷组不处于活跃状态，才能删除卷组





##### 4.	`LV`逻辑卷

> 我们可以把逻辑卷想象成分区，那么这个逻辑卷当然也需要被格式化和挂载。另外，逻辑卷也是可以动态调整大小的，而且数据不会丟失，也不用卸载逻辑卷。



###### 建立逻辑卷

`lvcreate`命令，用于创建逻辑卷。命令格式如下：

```
[root@localhost ~]# lvcreate [选项] [-n 逻辑卷名] 卷组名
```

选项：

- -L 容量：指定逻辑卷大小，单位为 MB、GB、TB 等；
- -l 个数：按照 PE 个数指定逻辑卷大小，这个参数需要换算容量，太麻烦；
- -n 逻辑卷名：指定逻辑卷名；



接下来我们来创建一个`1.5GB`的`lamplv`逻辑卷，命令如下：

```
[root@localhost ~]# lvcreate -L 1.5GB -n lamplv scvg
Logical volume "lamplv" created
#在scvg卷组中建立一个1.5GB大小的lamplv逻辑卷
```



建立完逻辑卷，还要在格式化和挂载之后才能正常使用。格式化和挂载命令与操作普通分区时是一样的，不过需要注意的是，逻辑卷的设备文件名是"/dev/卷组名/逻辑卷名"，如逻辑卷 lamplv 的设备文件名就是"/dev/scvg/lamplv"。具体命令如下：

```
[root@localhost ~]# mkfs -t ext4 /dev/scvg/lamplv
\#格式化
[root@localhost ~]# mkdir /disklvm
[root@localhost ~]# mount /dev/scvg/lamplv /disklvm/
\#建立挂载点，并挂载
[root@localhost ~]# mount
…省略部分输出…
/dev/mapper/scvg-lamplv on /disklvm type ext4(rw)
\#已经挂载了
```

当然，如果需要开机后自动挂载，则要修改 /etc/fstab 文件。



###### 查看逻辑卷

查看逻辑卷的命令同样有两个`lvscan`和`lvdisplay`，

`lvscan`可以查看系统中是否拥有逻辑卷

```
[root@localhost ~]# lvscan
ACTIVE '/dev/scvg/lamplv' [1.50 GiB] inherit
#能够看到激活的逻辑卷，大小是1.5GB
```



第二个命令 lvdisplay 可以看到逻辑卷的详细信息，命令如下：

```
[root@localhost ~]# lvdisplay
---Logical volume---
LV Path /dev/scvg/lamplv
逻辑卷的设备文件名
LV Name lamplv
#逻辑卷名
VG Name scvg
#所属的卷组名
LV UUID 2kyKmn-Nupd-CldB-8ngY-NsI3-b8hV-QeUuna
LV Write Access read/write
LV Creation host, time localhost, 2013-04-18 03:36:39 +0800
LV Status available
# open 1
LV Size 1.50 GiB
#逻辑卷大小
Current LE 192
Segments 2
Allocation inherit
Read ahead sectors auto
-currently set to 256
Block device 253:0
```



###### 调整逻辑卷大小

>  我们可以使用 lvresize 命令调整逻辑卷的大小，
>
> 不过我们一般不推荐减少逻辑卷的空间，因为这非常容易导致逻辑卷中的文件系统的数据丟失。所以，除非我们已经备份了逻辑卷中的数据，否则不要减少逻辑卷的空间



`lvresize`命令，基本格式如下：

```
[root@localhost ~]# lvresize [选项] 逻辑卷的设备文件名
```

选项：

- -L 容量：安装容量调整大小，单位为 KB、GB、TB 等。使用 + 増加空间，- 代表减少空间。如果直接写容量，则代表设定逻辑卷大小为指定大小；
- -l 个数：按照 PE 个数调整逻辑卷大小；



lamplv 逻辑卷的大小是 1.5GB，而 scvg 卷组中还有 1.5GB 的空闲空间，那么增加 lamplv 逻辑卷的大小到 2.5GB。命令如下：

```
[root@localhost disklvm]# lvresize -L 2.5G /dev/scvg/lamplv
Extending logical volume lamplv to 2.50 GiB Logical volume lamplv successfully resized
#增加lamplv逻辑卷的大小到2. 5GB，当然命令也可以这样写
[roots localhost disklvm] # lvresize -L +1G /dev/scvg/lamplv
[root@localhost disklvm]# lvdisplay
---Logical volume ---
LV Path /dev/scvg/lamplv
LV Name lamplv
VG Name scvg
LV UUID 2kyKmn-Nupd-CldB-8ngY-Ns13-b8hV-QeUuna
LV Write Access read/write
LV Creation host, time localhost, 2013-04-18 03:36:39 +0800 LV Status available
# open 1
LV Size 2.50 GiB
#大小改变了
Current LE 320
Segments 3
Allocation inherit
Read ahead sectors auto
-currently set to 256
Block device 253:0
```



逻辑卷的大小已经改变了，但是好像有如下一些问题：

```
[root@localhost disklvm]# df -h /disklvm/
文件系统 容量 已用 可用 已用% ％挂载点
/dev/mapper/scvg-lamplv 1.5G 35M 1.4G 3%/ disklvm
```

怎么 /disklvm 分区的大小还是 1.5GB 啊？刚刚只是逻辑卷的大小改变了，如果要让分区使用这个新逻辑卷，则还要使用 resize2fs 命令来调整分区的大小。不过这里就体现出了 LVM 的优势：我们不需要卸载分区，直接就能调整分区的大小。



resize2fs命令的格式如下：

```
[root@localhost ~]# resize2fs [选项] [设备文件名] [调整的大小]
```

选项：

- -f：强制调整；
- 设备文件名：指定调整哪个分区的大小；
- 调整的大小：指定把分区调整到多大，要加 M、G 等单位。如果不加大小，则会使用整个分区；

我们已经把逻辑卷调整到 2.5GB，这时就需要把整个逻辑卷都加入 /disklvm 分区中，命令如下：

```
[root@localhost ~]# resize2fs /dev/scvg/lamplv
resize2fs 1.41.12(17-May-2010)
Filesystem at /dev/scvg/lamplv is mounted on/ disklvm; on-line resizing required
old desc_blocks = 1, new_desc_blocks = 1
Performing an on-line resize of/dev/scvg/lamplv to 655360 (4k) blocks.
The filesystem on /dev/scvg/lamplv is now 655360 blocks long.
\#已经调整了分区大小
[root@localhost ~]# df -h /disklvm/
文件系统 容量 已用 可用 已用% %挂载点
/dev/mapper/scvg-lamplv 2.5G 35M 2.4G 2% /disklvm
\#分区大小已经是2.5GB 了
[root@localhost ~]# ls /disklvm/
lost+found testd testf
\#而且数据并没有丟失
```

如果要减少逻辑卷的容量，则只需把增加步骤反过来再做一遍就可以了。不过我们并不推荐减少逻辑卷的容量，因为这有可能导致数据丟失。



###### 删除逻辑卷

删除了逻辑卷，其中的数据就会丟失，所以要确定你真的需要删除这个逻辑卷。命令格式如下：

```
[root@localhost ~]#lvremove 逻辑卷的设备文件名
```

我们删除 lamplv 逻辑卷，记得在删除时要先卸载。 命令如下：

```
[root@localhost ~]# umount /dev/scvg/lamplv
[root@localhost ~]# Ivremove /dev/scvg/lamplv
Do you really want to remove active logical volume lamplv? [y/n]: n
\#如果这里选择y，就会执行删除操作，逻辑卷内的所有数据都会被清空
Logical volume lamplv not removed
```





###### LVM逻辑卷的管理与删除

> 此处主要讲LVM的删除

> 要删除一个LVM，步骤如下

1.要删除一个逻辑卷，就必须先将这个逻辑卷从系统中卸载掉。例如，使用 umount 命令卸载挂载在 /disklvm 目录上的逻辑卷，执行命令如下：

```
[root@localhost ~]# umount /disklvm
```



2. 现在，就可使用 lvremove 命令移除设备文件 /dev/scvg/lamplv 所对应的逻辑卷了。在系统提示处输入 【y】 确认要移除 lamplv 逻辑卷，执行命令如下所示：

   ```
   [root@localhost ~]# lvremove /dev/scvg/lamplv
   Do you really want to remove active logical volume "lamplv"? [y/n]:y
   Logical volume "lamplv" successfully removed
   ```



3. 接下来， 可以使用 vgremove 命令删除 scvg 卷组，执行命令如下：

   ```
   [root@localhost ~]# vgchange -an scvg
   [root@localhost ~]# vgremove scvg
   Volume group "scvg" successfully removed
   ```

   

   4.注意，一些 [linux](http://www.beylze.com/linuxjiaocheng/) 教程认为在删除了卷组之后就算完成了全部所需的操作，但是最好还是要移除所有分区上的物理卷的卷标。因此，最好使用 pvremove 命令同时移除 /dev/sdb5、 /dev/sdb6 和 /dev/sdb7 这 3 个分区上的物理卷的卷标，执行命令如下：

   ```
   [root@localhost ~]# pvremove /dev/sdb5 /dev/sdb6 /dev/sdb7
   Labels on physical volume "/dev/sdb5" successfully wiped
   Labels on physical volume "/dev/sdb6" successfully wiped
   Labels on physical votume "/dev/sdb7" successfuily wiped
   ```

   > 完成了以上操作之后，我们不但删除了逻辑卷和卷组，而且还释放了物理卷所使用的所有磁盘空间，即将这些磁盘空间归还给了 Linux 系统。



#### 3.RAID磁盘阵列

> RAID（Redundant Arrays of Inexpensive Disks，磁盘阵列），翻译过来就是廉价的、具有冗余功能的磁盘阵列。其原理是通过软件或硬件将多块较小的分区组合成一个容量较大的磁盘组。这个较大的磁盘组读写性能更好，更重要的是具有数据冗余功能。



##### 1.	基本概念

那什么是数据冗余呢？从字面上理解，冗余就是多余的、重复的。在磁盘阵列中，冗余是指由多块硬盘组成一个磁盘组，在这个磁盘组中，数据存储在多块硬盘的不同地方，这样即使某块硬盘出现问题，数据也不会丟失，也就是磁盘数据具有了保护功能。

读者也可以这样理解，RAID 用于在多个硬盘上分散存储数据，并且能够&ldquo;恰当&rdquo;地重复存储数据，从而保证其中某块硬盘发生故障后，不至于影响整个系统的运转。RAID 将几块独立的硬盘组合在一起，形成一个逻辑上的 RAID 硬盘，这块&ldquo;硬盘&rdquo;在外界（用户、LVM 等）看来，和真实的硬盘一样，没有任何区别。

RAID 的组成可以是几块硬盘，所以我们在讲解原理时使用硬盘举例，但是大家要知道不同的分区也可以组成 RAID。

RAID 根据组合方式的不同，有多种设计解决方案，以下介绍几种常见的 RAID 方案（RAID级别）



###### **RAID0**

RAID 0 也叫 Stripe 或 Striping（带区卷），是 RAID 级别中存储性能最好的一个。RAID 0 最好由相同容量的两块或两块以上的硬盘组成。如果组成 RAID 0 的两块硬盘大小不一致，则会影响 RAID 0 的性能。



这种模式下会先把硬盘分隔出大小相等的区块，当有数据需要写入硬盘时，会把数据也切割成相同大小的区块，然后分别写入各块硬盘。这样就相当于把一个文件分成几个部分同时向不同的硬盘中写入，数据的读/写速度当然就会非常快。

从理论上讲，由几块硬盘组成 RAID 0，比如由 3 块硬盘组成 RAID 0，数据的写入速度就是同样的数据向一块硬盘中写入速度的3倍。我们画一张 RAID 0 的示意图，如下图所示。

<img src="http://www.beylze.com/d/file/20190907/whsife3qibq.jpg" alt="RAID0示意图" style="zoom:80%;" />

解释一下这张示意图。我们准备了 3 块硬盘组成了 RAID 0，每块硬盘都划分了相等的区块。当有数据要写入 RAID 0 时，首先把数据按照区块大小进行分割，然后再把数据依次写入不同的硬盘。每块硬盘负责的数据写入量都是整体数据的 1/3，当然写入时间也只有原始时间的 1/3。所以，从理论上讲，由几块硬盘组成 RAID 0，数据的写入速度就是数据只写入一块硬盘速度的几倍。

RAID 0 的优点如下：

- 通过把多块硬盘合并成一块大的逻辑硬盘，实现了数据跨硬盘存储。
- 通过把数据分割成等大小的区块，分别存入不同的硬盘，加快了数据的读写速度。数据的读/写性能是几种 RAID 中最好的。
- 多块硬盘合并成 RAID 0，几块小硬盘组成了更大容量的硬盘，而且没有容量损失。RAID 0 的总容量就是几块硬盘的容量之和。


RAID 0 有一个明显的缺点，那就是没有数据冗余功能，RAID 0 中的任何一块硬盘损坏，RAID 0 中所有的数据都将丟失。也就是说，由几块硬盘组成 RAID 0，数据的损毁概率就是只写入一块硬盘的几倍。

我们刚刚说了，组成 RAID 0 的硬盘的大小最好都是一样的。那有人说我只有两块不一样大小的硬盘，难道就不能组成 RAID 0 吗？

答案是可以的。假设有两块硬盘，一块大小是 100GB，另一块大小是 200GB。由这两块硬盘组成 RAID 0，那么当最初的 200G 数据写入时，是分别存放在两块硬盘当中的；但是当数据大于 200GB 之后，第一块硬盘就写满了，以后的数据就只能写入第二块硬盘中，读/写性能也就随之下降了。

一般不建议企业用户使用 RAID 0，因为数据损毁的概率更高。如果对数据的读/写性能要求非常高，但对数据安全要求不高时，RAID 0 就非常合适了。





###### **RAID1**

> RAID 1也叫 Mirror 或 Mirroring（镜像卷），由两块硬盘组成。两块硬盘的大小最好一致，否则总容量以容量小的那块硬盘为主。RAID 1 就具备了数据冗余功能，因为这种模式是把同一份数据同时写入两块硬盘。

<img src="http://www.beylze.com/d/file/20190907/dsd5zrussuq.jpg" alt="RAID1示意图" style="zoom:80%;" />

RAID 1 具有了数据冗余功能，但是硬盘的容量却减少了 50%，因为两块硬盘当中保存的数据是一样的，所以两块硬盘际上只保存了一块硬盘那么多的数据，这也是我们把 RAID 1 称作镜像卷的原因。

RAID 1 的优点如下：

- 具备了数据冗余功能，任何一块硬盘出现故障，数据都不会丟失。
- 数据的读取性能虽然不如RAID 0，但是比单一硬盘要好，因为数据有两份备份在不同的硬盘上，当多个进程读取同一数据时，RAID会自动分配读取进程。


RAID 1 的缺点也同样明显：

- RAID 1 的容量只有两块硬盘容量的 50%，因为每块硬盘中保存的数据都一样。
- 数据写入性能较差，因为相同的数据会写入两块硬盘当中，相当于写入数据的总容量变大了。虽然 CPU 的速度足够快，但是负责数据写入的芯片只有一个。





###### RAID10和RAID01

>我们发现，RAID 0 虽然数据读/写性能非常好，但是没有数据冗余功能；而 RAID 1 虽然具有了数据冗余功能，但是数据写入速度实在是太慢了（尤其是软 RAID）。

下面得讲解没懂的话，建议去网上看一下`RAID10`和`RAID01`的区别

>  那么，我们能不能把 RAID 0 和 RAID 1 组合起来使用？当然可以，这样我们就即拥有了 RAID 0 的性能，又拥有了 RAID 1 的数据冗余功能。

我们先用两块硬盘组成 RAID 1，再用两块硬盘组成另一个 RAID 1，最后把这两个 RAID 1组成 RAID 0，这种 RAID 方法称作 RAID 10。那先组成 RAID 0，再组成 RAID 1 的方法我们作 RAID 01。我们通过示意图 3 来看看 RAID 10。

<img src="http://www.beylze.com/d/file/20190907/rdukpeuag2o.jpg" alt="RAID10示意图" style="zoom:80%;" />

我们把硬盘 1 和硬盘 2 组成了第一个 RAID 1，把硬盘 3 和硬盘 4 组成了第二个 RAID 1，这两个 RAID 1组成了 RAID 0。因为先组成 RAID 1，再组成 RAID 0，所以这个 RAID 是 RAID 10。

当有数据写入时，首先写入的是 RAID 0（RAID 0 后组成，所以数据先写入），所以数据 1 和数据 3 写入了第一个 RAID 1，而数据 2 和数据 4 写入了第二个 RAID 1。当数据 1 和数据 3 写入第一个 RAID 1 时，

因为写入的是 RAID 1，所以在硬盘 1 和硬盘 2 中各写入了一份。数据 2 和数据 4 也一样。

这样的组成方式，既有了 RAID 0 的性能优点，也有了 RAID 1 的数据冗余优点。但是大家要注意，虽然我们有了 4 块硬盘，但是由于 RAID 1 的缺点，所以真正的容量只有 4 块硬盘的 50%，另外的一半是用来备份的。





###### **RAID5**

RAID 5 最少需要由 3 块硬盘组成，当然硬盘的容量也应当一致。当组成 RAID 5 时，同样需要把硬盘分隔成大小相同的区块。当有数据写入时，数据也被划分成等大小的区块，然后循环向 RAID 5 中写入。



每次循环写入数据的过程中，在其中一块硬盘中加入一个奇偶校验值（Parity），这个奇偶校验值的内容是这次循环写入时其他硬盘数据的备份。当有一块硬盘损坏时，采用这个奇偶校验值进行数据恢复。通过示意图来看看 RAID 5 的存储过程，如图 4 所示。

<img src="http://www.beylze.com/d/file/20190907/wos4l0d5zaz.jpg" alt="RAID5示意图" style="zoom:80%;" />

在这张示意图中，我们使用三块硬盘组成了 RAID 5。当有数据循环写入时，每次循环都会写入一个奇偶校验值（Parity），并且每次奇偶校验值都会写入不同的硬盘。这个奇偶校验值就是其他两块硬盘中的数据经过换算之后产生的。因为每次奇偶校验值都会写入不同的硬盘，所以任何一块硬盘损坏之后，都可以依赖其他两块硬盘中保存的数据恢复这块损坏的硬盘中的数据。

需要注意的是，每次数据循环写入时，都会有一块硬盘用来保存奇偶校验值，所以在 RAID 5 中可以使用的总容量是硬盘总数减去一块的容量之和。

比如，在这张示意图中，由三块硬盘组成了 RAID 5，但是真正可用的容量是两块硬盘的容量之和，也就是说，越多的硬盘组成 RAID 5，损失的容量占比越小，因为不管由多少块硬盘组成 RAID 5，奇偶校验值加起来只占用一块硬盘。而且还要注意，RAID 5 不管是由几块硬盘组成的，只有损坏一块硬盘的情况才能恢复数据，因为奇偶校验值加起来只占用了一块硬盘，如果损坏的硬盘超过一块，那么数据就不能再恢复了。

RAID 5 的优点如下：

- 因为奇偶校验值的存在，RAID 5 具有了数据冗余功能。
- 硬盘容量损失比 RAID 1 小，而且组成 RAID 5 的硬盘数量越多，容量损失占比越小。
- RAID 5的数据读/写性能要比 RAID 1 更好，但是在数据写入性能上比 RAID 0 差。


RAID 5 的缺点如下：

- 不管由多少块硬盘组成 RAID 5，只支持一块硬盘损坏之后的数据恢复。
- RAID 5 的实际容量是组成 RAID 5 的硬盘总数减去一块的容量之和。也就是有一块硬盘用来保存奇偶校验值，但不能保存数据。


从总体上来说，RAID 5 更像 RAID 0 和 RAID 1 的折中，性能比 RAID 1 好，但是不如 RAID 0；数据冗余比 RAID 0 好，而且不像 RAID 1 那样浪费了 50% 的硬盘容量。



###### 软`RAID`和硬`RAID`

我们要想在服务器上实现 RAID，可以采用磁盘阵列卡（RAID 卡）来组成 RAID，也就是硬 RAID。RAID 卡上有专门的芯片负责 RAID 任务，因此性能要好得多，而且不占用系统性能，缺点是 RAID 卡比较昂贵。

如果我们既不想花钱又想使用 RAID，那就只能使用软 RAID 了。软 RAID 是指通过软件实现 RAID 功能，没有多余的费用，但是更加耗费服务器系统性能，而数据的写入速度比硬 RAID 慢。





##### 2.使用图形化界面来配置RAID

此处不说图形化设置RAID。[自己看](http://www.beylze.com/news/30594.html)

其实就是配置分区得时候选择RAID分区，然后配置了几个RAID分区过后，设置RAID设备选项。到RAID设备选项去设置具体要使用哪种RAID方案



##### 3.	`mdadm`命令来配置`RAID`

> 建立三个 2GB 大小的分区，构建 RAID 5。不过我们多建立了一个 2GB 大小的分区，这个分区用作备份分区。
>
> 备份分区的作用是什么呢？ RAID 最大的好处就是具有数据冗余功能，当有一块硬盘或分区损坏时，数据不会丟失，只要插入新的硬盘或分区，依赖其他分区就会主动重建损坏的硬盘或分区中的数据。不过这仍然需要关闭服务器，手工插拔硬盘。
>
> 如果在组成 RAID 的时候就加入了备份硬盘或备份分区，那么当硬盘或分区损坏时，RAID 会自动用备份硬盘或备份分区代替损坏的硬盘或分区，然后立即重建数据，而不需要人为手工参与。这样就避免了服务器停机和人为手工参与，非常方便，唯一的问题就是需要多余的硬盘或分区作为备份设备。



也就是说，我们在这个实验中需要 4 个 2GB 大小的分区，其中 3 个组成 RAID 5，1 个作为备份分区。建立分区的过程这里不再详细解释，建立完分区之后，可以使用 fdisk -l 命令査看。命令如下：

```
[root@localhost ~]#fdisk -l
...省略部分输出...
Disk /dev/sdb: 21.5 GB, 21474836480 bytes 255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 * 512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk identifier: 0xba384969
Device Boot Start End Blocks ld System
/dev/sdb1 1 2610 20964793+ 5 Extended
/dev/sdb5 1 262 2104452 83 linux
/dev/sdb6 263 524 2104483+ 83 Linux
/dev/sdb7 525 786 2104483+ 83 Linux
/dev/sdb8 787 1048 2104483+ 83 Linux
```

> 我们建立了 /dev/sdb5、/dev/sdb6、/dev/sdb7 和 /dev/sdb8 共 4 个 2GB 大小的分区。



###### 使用mdadm命令创建RAID5

建立RAID5需要使用`mdadm`命令，基本格式如下：

```
[root@localhost ~]# mdadm [模式] [RAID设备文件名] [选项]
```

模式：

- Assemble：加入一个已经存在的阵列；
- Build：创建一个没有超级块的阵列；
- Create：创建一个阵列，每个设备都具有超级块；
- Manage：管理阵列，如添加设备和删除损坏设备；
- Misc：允许单独对阵列中的设备进行操作，如停止阵列；
- Follow or Monitor：监控RAID状态； Grow：改变RAID的容量或阵列中的数目；



选项：

- -s,-scan：扫描配置文件或/proc/mdstat文件，发现丟失的信息；
- -D,-detail：查看磁盘阵列详细信息；
- -C,-create：建立新的磁盘阵列，也就是调用 Create模式；
- -a,-auto=yes：采用标准格式建立磁阵列
- -n,-raicklevices=数字：使用几块硬盘或分区组成RAID
- -l,-level=级别：创建RAID的级别，可以是0,1,5
- -x,-spare-devices=数字：使用几块硬盘或分区组成备份设备
- -a,-add 设备文件名：在已经存在的RAID中加入设备
- -r,-remove 设备文件名名：在已经存在的RAID中移除设备
- -f,-fail设备文件名：把某个组成RAID的设备设置为错误状态
- -S,-stop：停止RAID设备
- -A,-assemble：按照配置文件加载RAID



使用以下命令来创建RAID5：

```
[root@localhost ~]# mdadm -c /dev/md0 -a yes -l 5 -n 3 -x 1 /dev/sdb5 /dev/sdb6 /dev/sdb7 /dev/sdb8
```

> 其中，/dev/md0 是第一个 RAID 设备的设备文件名，如果还有 RAID 设备，则可以使用 /dev/md[0~9] 来代表。

我们建立了一个 RAID 5，使用了三个分区，并建立了一个备份分区。先查看一下新建立的 /dev/md0，命令如下：

```
[root@localhost ~]# mdadm -D /dev/md0
/dev/md0:
#设备文件名
Version : 1.2
Creation Time : Tue Apr 23 23:13:48 2013
#创建时间
Raid Level : raid5
#RAID 级别
Array Size : 4206592 (4.01 GiB 4.31 GB) +RAID #总容量
Used Dev Size : 2103296 (2.01 GiB 2.15 GB)
#每个分区的容量
Raid Devices : 3
#组成 RAID 的设备数
Total Devices : 4
#总设备数
Persistence : Superblock is persistent
Update Time : Tue Apr 23 23:14:52 2013 State : clean
Active Devices : 3
#激活的设备数
Working Devices : 4
#可用的设备数
Failed Devices : 0
#错误的设备数
Spare Devices : 1
#备份设备数
Layout : left-symmetric
Chunk Size : 512K
Name : localhost.localdomain:0 (local to host localhost.localdomain) UOID : 15026b78:126a4930:89d8cf54:5bcb7e95 Events : 18
Number Major Minor RaidDevice State
0 8 21 0 active sync /dev/sdb5
1 8 22 1 active sync /dev/sdb6
4 8 23 2 active sync /dev/sdb7
#三个激活的分区
3 8 24 - spare /dev/sdb8
#备份分区
```



再查看一下 /proc/mdstat 文件，这个文件中也保存了 RAID 的相关信息。命令如下：

```
[root@localhost ~]# cat /proc/mdstat
Personalities：[raid6] [raid5] [raid4]
md0:active raid5 sdb9[4](S) sdb5[0] sdb8[3] sdb6[1]
\#RAID名 级别 组成RAID的分区，[数字]是此分区在RAID中的顺序
\#(S)代表备份分区
4206592 blocks super 1.2 level 5, 512k chunk, algorithm 2 [3/3] [UUU]
\#总block数 等级是5 区块大小 阵列算法 [组成设备数/正常设备数]
unused devices: <none>
```



###### 格式化与挂载

RAID 5 已经创建，但是要想正常使用，也需要格式化和挂载。格式化命令如下：

```
[root@localhost ~]# mkfs -t ext4 /dev/md0
```

挂载命令如下：

```
[root@localhost ~]# mkdir /raid
\#建立挂载点
[root@localhost ~]# mount /dev/md0 /raid/
\#挂载/dev/md0
[root@localhost ~]# mount
&hellip;省略部分输出&hellip;
/dev/md0 on /raid type ext4(rw)
\#查看一下，已经正常挂载
```



###### 生成`mdadm`配置文件

在 CentOS 6.x 中，mdadm 配置文件并不存在，需要手工建立。我们使用以下命令建立 /etc/mdadm.conf 配置文件：

```
[root@localhost ~]# echo Device /dev/sdb[5-8] >>/etc/mdadm.conf
\#建立/etc/mdadm.conf配置立件，并把组成RAID的分区的设备文件名写入
\#注意：如果有多个RAID，则要把所有组成RAID的设备都放入配置文件中；否则RAID设备重启后会丟失
\#比如组成RAID 10，就既要把分区的设备文件名放入此文件中，也翻组成RAID 0的RAID 1设备文件名放入
[root@localhost ~]# mdadm -Ds >>/etc/mdadm.conf
\#查询和扫描RAID信息，并追加进/etc/mdadm.conf文件
[root@localhost ~]# cat /etc/mdadm.conf
Device /dev/sdb5 /dev/sdb6 /dev/sdb7 /dev/sdb8
ARRAY /dev/md0 metadata: 1.2 spares=1 name=l(xalhost.localdomain:0 UUID=dd821fe5:8597b126:460a3afd:857c7989
\#查看文件内容
```



###### 设置开机后自动挂载

自动挂载也要修改 /etc/fstab 配置文件，命令如下：

```
[root@localhost ~]# vi /etc/fstab
/dev/mdO /raid ext4 defaults 12
\#加入此行
```

>  如果要重新启动，则一定要在这一步完成之后再进行，否则会报错。



###### 启动或停止RAID 

RAID 设备生效后，不用手工启动或停止。但是，如果需要卸载 RAID 设备，就必须手工停止 RAID。这里我们学习一下启动和停止 RAID 的方法。先看看停止命令：

```
[root@localhost ~]# mdadm -S /dev/md0
\#停止/dev/md0设备
```



当然，如果要删除 RAID，则要非常小心，要把所有和 RAID 相关的内容全部删除，才能保证系统不报错。需要进行的步骤如下：

```
[root@localhost ~]# umount /dev/md0		//卸载分区
\#卸载RAID
[root@localhost ~】# vi /etc/fstab		//修改开机挂载目录
/dev/md0 /raid ext4 defaults 12
\#删除此行
[root@localhost ~]# mdadm -S /dev/md0		//停用RAID5(/dev/md0)
mdadm: stopped /dev/md0
\#停止RAID
[root@localhost ~]# vi /etc/mdadm.conf		//修改mdadm配置文件
ARRAY /dev/md0 metadata: 1.2 spares=1 name=localhost.localdomain:0 UUID=dd821fe5:8597b126:460a3afd:857c7989
\#删除或者注释此行
```

如果仅仅是停止，而不是删除，就没有这么麻烦了，只需先下载，再停止即可。那停止完成之后，怎么再启动呢？启动 RAID 的命令如下：

```
[root@localhost ~]# mdadm -As /dev/md0
mdadm: /dev/md0 has been started with 3 drives and 1 spare.
\#启动/dev/md0
[root@localhost ~]# mount /dev/md0 /raid/
\#启动RAID后，记得挂载
```



###### 模拟分区出现故障

我们的 RAID 虽然配置完成了，但是它真的生效了吗？我们模拟磁盘报错，看看备份分区是否会自动代替错误分区。mdadm 命令有一个选项 -f，这个选项的作用就是把一块硬盘或分区变成错误状态，用来模拟 RAID 报错。命令如下：

```
[root@localhost ~]# mdadm /dev/md0 --fail /dev/sda7
\#模拟/dev/sdb7分区报错
[root@1ocalhost ~】# mdadm -D /dev/mdO 
...省略部分输出...
Active Devices : 2
Working Devices : 3
Failed Devices : 1
\#1个设备报错了
Spare Devices : 1
...省略部分输出...
Number Major Minor RaidDevice State
0 8 21 0 active sync /dev/sdb5
1 8 22 1 active sync /dev/sdb6
3 8 24 2 spare rebuilding /dev/sdb8
\#/dev/sdb8分区正在准备修复
4 8 23 - faulty spare /dev/sdb7
\#/dev/sdb7已经报错了
```

要想看到上面的效果，査看时要快一点，否则修复就可能完成了。因为有备份分区的存在，所以分区损坏了，是不用管理员手工的。如果修复完成，再查看，就会出现下面的情况：

```
[root@localhost ~]# mdadm /dev/mdO
Number Major Minor RaidDevice State
0 8 21 0 active sync /dev/sdb5
1 8 22 1 active sync /dev/sdb6
3 8 24 2 active sync /dev/sdb8
4 8 23 - faulty spare /dev/sdb7
```

> 备份分区/dev/sdb8已经被激活，但是 /dev/sdb7分区失效。



###### 移除错误分区

既然分区已经报错了，我们就把 /dev/sdb7 分区从 RAID 中删除。如果这是硬盘，就可以进行更换硬盘的处理了。

移除命令如下：

```
[root@localhost ~]# mdadm /dev/md0 -remove/dev/sdb7
mdadm: hot removed /dev/sdb7 from /dev/mdO
```



###### 添加新的备份分区

既然分区已经报错，那么我们还需要加入一个新的备份分区，以备下次硬盘或分区出现问题。既然要加入新的备份分区，当然还需要再划分出一个 2GB 大小的分区出来，命令如下：

```
[root@localhost ~]#fdisk -l
Disk /dev/sdb: 21.5 GB, 21474836480 bytes
255 heads, 63 sectors/track, 2610 cylinders
Units = cylinders of 16065 *512 = 8225280 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes 1512 bytes
Disk identifier: 0x151a68a9
Device Boot Start End Blocks Id System
/dev/sdb1 1 2610 20964793+ 5 Extended
/dev/sdb5 1 262 2104452 83 Linux
/dev/sdb6 263 524 2104483+ 83 Linux
/dev/sdb7 525 786 2104483+ 83 Linux
/dev/sdb8 787 1048 2104483+ 83 Linux
/dev/sdb9 1049 1310 2104483+ 83 Linux
```

我们新建了 /dev/sdb9 分区，然后把它加入 /dev/md0 作为备份分区，命令如下：

```
[root@localhost ~]# mdadm /dev/md0 -add /dev/sdb9
mdadm: added /dev/sdb9
\#把/dev/sdb9加入/dev/md0
[root@localhost ~]# mdadm -D /dev/md0
...省略部分输出...
Number Major Minor RaidDevice State
0 8 21 0 active sync /dev/sdb5
1 8 22 1 active sync /dev/sdb6
3 8 24 2 active sync /dev/sdb8
4 8 25 - spare /dev/sdb9
\#查看一下，/dev/sdb9已经变成了备份分区
```

