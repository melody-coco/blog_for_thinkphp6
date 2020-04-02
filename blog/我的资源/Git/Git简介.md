<center>Git简介</center>
### 一.	安装

> 此处不讲`Mac OS`的安装。有需求自己网上找

#### Linux安装

Linux安装的话，直接用`rpm`包安装就行了。

```
 //RedHat系
$ yum -y install git

  //Debian系
$ apt-get install git
```



#### windows安装

windows的话，安装需要[下载安装程序](https://git-scm.com/downloads)。然后按默认选项安装即可

安装完成后，在开始菜单里找到`Git -> Bash` 。蹦出一个类似于命令行窗口的东西，就说明Git安装成功

<img src="https://www.liaoxuefeng.com/files/attachments/919018718363424/0" alt="Windows安装Git" style="zoom:80%;" />

#### 安装后的初始化



下面配置`name`和`mail`。接下来还要配置`ssh`密钥。在`Git概念`-->远程仓库-->配置`SSH KEY`中。

```
$ git config --global user.name "Your Name"
$ git config --global user.email "email@example.com"
```

> 配置你自己的Name和Email。



### 二.	创建版本库

+ 找一个空目录(其实也可以不是空目录)，使用`git init`来创建Git仓库(`repository`)

+ 使用`git add 文件名`来，添加问价到缓冲区
+ 使用`git commit -m "描述语句"`来，把文件提交的仓库

