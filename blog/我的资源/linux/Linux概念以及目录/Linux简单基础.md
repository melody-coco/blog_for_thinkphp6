<center>简单知识点</center>
#### 1.	环境变量

LInux中的环境变量默认为大写



<center>Linux系统中重要的10个环境变量</center>
| 环境变量名称 | 作用                                                         |
| ------------ | ------------------------------------------------------------ |
| HOME         | 用户的主目录（也称家目录）                                   |
| SHELL        | 用户使用的 [Shell](http://c.biancheng.net/shell/) 解释器名称 |
| PATH         | 定义命令行解释器搜索用户执行命令的路径                       |
| EDITOR       | 用户默认的文本解释器                                         |
| RANDOM       | 生成一个随机数字                                             |
| LANG         | 系统语言、语系名称                                           |
| HISTSIZE     | 输出的历史命令记录条数                                       |
| HISTFILESIZE | 保存的历史命令记录条数                                       |
| PS1          | Bash解释器的提示符                                           |
| MAIL         | 邮件保存路径                                                 |



环境变量由`变量名`和用户或系统定义的`变量`值两部分组成

```shell
[root@localhost ~]# WORDKEY=/root/test1	//设定临时环境变量WORDKEY
				    [↑变量名]   [↑变量值]
```



上面这种只是临时的环境变量，要设定全局变量得使用`export`命令定义