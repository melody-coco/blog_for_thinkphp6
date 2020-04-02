<center>Kali更新源</center>





### 1. 	kali源相关



#### 1.	打开源的文件

```
root@kali:~# vim /etc/apt/sources.list
```





#### 2.	添加源

\#kali官方源

deb http://http.kali.org/kali kali-rolling main non-free contrib

deb-src http://http.kali.org/kali kali-rolling main non-free contrib

\#中科大的源

deb http://mirrors.ustc.edu.cn/kali kali-rolling main non-free contrib

deb-src http://mirrors.ustc.edu.cn/kali kali-rolling main non-free contrib

\#浙江大学源

deb http://mirrors.zju.edu.cn/kali kali-rolling main non-free contrib

deb-src http://mirrors.zju.edu.cn/kali kali-rolling main non-free contrib





#### 3.	更新源

更新源，生成缓存

```
root@kali:~# apt-get update
```





#### 4.	更新软件包

```
root@kali:~# apt-get upgrade
```





#### 5.	更新系统

```
root@kali:~# apt-get dist-upgrade
```

​	



#### 6.	自动卸载不需要的软件包

apt-get autoremove

自动清除软件包

apt-get autoclean





### 2.	kali中文乱码



#### 1.	简单解决乱码





使用以下命令即可完美解决中文乱码：

```
sudo apt-get install ttf-wqy-zenhei
```

> 当然，前提是换一个国内源









### 3.	kali安装输入法

……

这个的坑确实多

此处使用的是农夫发放下来的光盘镜像。

应该是kali2019.4版本的。文件名`kali-linux-2019.4-gnome-amd64.iso`



##### 1.	卸载不必要软件包

`apt-get remove libqtcore4 libqtgui4 fcitx*`





##### 2.	导入密钥

> 因为我们要安装搜狗输入法的话，需要使用`ubounto`的源。所以需要使用密钥才能使用`ubounto`的源。

`apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 3B4FE6ACC0B21F32`





##### 3.	安装源

> 源的路径`/etc/apt/sources.list`

该文件放入如下：

```
deb http://mirrors.aliyun.com/ubuntu/ bionic main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ bionic-security main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ bionic-updates main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ bionic-proposed main restricted universe multiverse
deb http://mirrors.aliyun.com/ubuntu/ bionic-backports main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ bionic main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ bionic-security main restricted universe multiverse
deb-src http://mirrors.aliyun.com/ubuntu/ bionic-updates main restricted universe
```





##### 4.	更新ubount源



`apt-get update`





##### 5.	安装依赖

```
apt-get install fcitx-libs fcitx-libs-qt fcitx-bin fcitx-data fcitx-modules fcitx-module-dbus fcitx-module-kimpanel fcitx-module-lua fcitx-module-x11 fcitx fcitx-tools fcitx-ui-classic fcitx-config-gtk2 libopencc2 libqtwebkit4
```





##### 6.	切换至rolling

切换到rolling源

```
deb http://http.kali.org/kali kali-rolling main non-free contrib
```





#### 7.	更新rolling源



`apt-get clean`清处一下，以前的环境

`apt-get update`更新源包



##### 8.	强制更新

`apt-get install -f `

> apt-get -f install 是修复损坏的软件包，尝试卸载出错的包，重新安装正确版本的。
>
>
> 此命令为修复依赖关系(depends)的命令,就是假如你的系统上有某个package不满足依赖条件,这个命令就会自动修复,
> 安装那个package依赖的package。(自动修复损坏的软件包，尝试卸载出错的包)！

##### 9.	重启即可



### 4.	为kali设置代理



有两个方法为kali设置代理，此处不详讲。只做简要描述

> 我测试过

以下方法都是在`VirtualBox`中使用，VMware的话应该同理。

不过以下方法都需要重启几次虚拟机才能使用







##### 1.	设置转发

此处如果使用VirtualBox的话，可能得重启两次才能启用





> 为宿主机开启代理，并且选项设置里面，设置本地代理。允许局域网连接。不要密码，端口设置默认1080
>
> 并且系统代理模式和代理规则全部设置为全局



然后将kali设置为桥接模式。

> 此处如果使用VirtualBox的话，可能得重启两次才能启用





然后kali的设置代理里面，设置手动模式，并且ip填宿主机的内网ip。端口填，在宿主机ShadowsocksR设置的本地代理的端口



然后重启两次，即可使用上代理









##### 2.	kali走宿主机流量



这一点很简单，主要是把kali网络设置为NAT，

然后宿主机的系统代理模式和代理规则全部设置为全局。



这样的话，kali就会走宿主机的流量了





不过这个的话可能会出问题。