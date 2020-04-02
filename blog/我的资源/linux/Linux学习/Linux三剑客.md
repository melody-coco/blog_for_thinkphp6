<center>Linux三剑客</center>
#### 1.	grep

`grep`命令全称为`global regular expressions print`，作用为查找文件内容



`grep` 能在一个或多个文件中，搜索某一特定的字符模式(也就是正则表达式)



`gref`支持的正则表达式如下表：

| 通配符 | 功能                                                |
| ------ | --------------------------------------------------- |
| c*     | 将匹配 0 个（即空白）或多个字符 c（c 为任一字符）。 |
| .      | 将匹配任何一个字符，且只能是一个字符。              |
| [xyz]  | 匹配方括号中的任意一个字符。                        |
| [^xyz] | 匹配除方括号中字符外的所有字符。                    |
| ^      | 锁定行的开头。                                      |
| $      | 锁定行的结尾。                                      |



`grep`命令是用来在每一个文件中搜索特定的模式，当使用`grep`时，包含指定字符模式的每一行内容，都会被打印到屏幕上，但是使用`grep`命令不会改变文件的内容。



`grep`命令的基本格式如下：

```shell
[root@localhost ~]# grep [选项] 模式 文件名
```



选项如下：

| 选项 | 含义                                                     |
| ---- | -------------------------------------------------------- |
| -c   | 仅列出文件中包含模式的行数。                             |
| -i   | 忽略模式中的字母大小写。                                 |
| -l   | 列出带有匹配行的文件名。                                 |
| -n   | 在每一行的最前面列出行号。                               |
| -v   | 列出没有匹配模式的行。                                   |
| -w   | 把表达式当做一个完整的单字符来搜寻，忽略那些部分匹配的行 |

> 如果是搜索多个文件，grep命令的搜索结果只显示文件中发现匹配模式的文件名；而搜索单个文件，grep命令的结果将显示每一个匹配的模式的行。



实例1：

> 搜索`test1.txt`文件里有melody的行

```
[root@localhost ~]# grep -n melody test1.txt
```

或者：

> 搜索`test1.txt`文件里有`melody`的人数

```shell
[root@localhost ~]# grep -c melody test1.txt
```

或者

>使用正则表达式来搜索

```shell
[root@localshot ~]# grep ^78 test1.txt
							//搜索test1.txt文件中，以78开头的行
```





#### 2.	sed

注意！：不论是`sed`还是`awk`，如果使用的时候没有指定文件名，程序则会需要用户输入数据，输入一行按回车，它就会运行一行，`Ctrl+D`键退出



> Vim采用的是交互式文本编辑模式，可以使用键盘命令来交互的插入，删除，替换文本中的数据。
>
> 但sed不同，sed采用的是流编辑模式，最明显的特点是，在sed处理数据之前，需要预先提供一组规则，sed会按照此规则来编辑数据

sed会根据脚本命令来处理文本文件中的数据，这些数据要么从命令行中输入，要么储存在一个文本文件中，此命令执行数据的顺序如下：

+ 每次仅读取一行内容；
+ 根据提供的规则命令匹配并修改数据，注意sed默认并不会直接修改源文件的数据，而是会将数据复制到缓冲区，修改也仅限于缓冲区中的数据；
+ 将执行结果输出

当一行的数据匹配完成后，他会继续读取下一行数据，并重复这个过程，直到将所有数据处理完毕



`sed`命令的基本格式如下：

```shell
[root@localhost ~]# sed [选项] '匹配规则 脚本命令' 文件名
```



选项：

| 选项            | 含义                                                         |
| --------------- | ------------------------------------------------------------ |
| -e 脚本命令     | 该选项会将其后跟的脚本命令添加到已有的命令中。               |
| -f 脚本命令文件 | 该选项会将其后文件中的脚本命令添加到已有的命令中。           |
| -n              | 默认情况下，sed 会在所有的脚本指定执行完毕后，会自动输出处理后的内容，而该选项会屏蔽启动输出，需使用 print 命令来完成输出。 |
| -i              | 此选项会直接修改源文件，要慎用。                             |





> 以下的全都称为脚本命令，但是都有不同的功效

##### s 替换

此命令的基本格式:

```shell
[address]s/pattern/repacement/flags
```

> 其中，address表示指定要操作的具体行，pattern指的是需要替换的内容,repacement指的是要替换的新内容。（ps.和vim的替换很相似）

> 最后再来说[address]是什么东西



此命令中常用的`flags`标记如表2所示。

| flags 标记 | 功能                                                         |
| ---------- | ------------------------------------------------------------ |
| n          | 1~512 之间的数字，表示指定要替换的字符串出现第几次时才进行替换，例如，一行中有 3 个 A，但用户只想替换第二个 A，这是就用到这个标记； |
| g          | 对数据中所有匹配到的内容进行替换，如果没有 g，则只会在第一次匹配成功时做替换操作。例如，一行数据中有 3 个 A，则只会替换第一个 A； |
| p          | 会打印与替换命令中指定的模式匹配的行。此标记通常与 -n 选项一起使用。 |
| w file     | 将缓冲区中的内容写到指定的 file 文件中；                     |
| &          | 用正则表达式匹配的内容进行替换；                             |
| \n         | 匹配第 n 个子串，该子串之前在 pattern 中用 \(\) 指定。       |
| \          | 转义（转义替换部分包含：&、\ 等）。                          |





实例：

> 通过以下的几个实例，来介绍sed的`s`替换脚本命令的具体用法

```shell
[root@localhost ~]# sed 's/test/exit/2' test1.txt
This is a test of the exit script.
This is the second test of the exit script.
//看到使用数字2 作为标记的结果就是，sed编辑器中只替换每行中第2次出现的匹配模式

			//如果要用新文件替换所有匹配的字符串，可以使用g标记
[root@localhost ~]# sed 's/test/exit/g' test1.txt
This is a exit of the exit script.
This is the second exit of the exit script.



//-n选项会禁止sed输出，但p标记会输出修改过的行，二者联用，就能只输出被替换命令修改过的行
[root@localhost ~]# cat test1.txt
this is a 
this are b
[root@localhost ~]# sed -n 's/is/no/p' test1.txt
this no a  



//w标记会将匹配后的结果保存到指定文件中
[root@localhost ~]# sed 's/is/no/p test2.txt' test1.txt
this no a 
[root@localhost ~]# cat test2.txt
this no a 



//在使用 s 脚本命令时，替换类似文件路径的字符串会比较麻烦，需要将路径中的正斜线进行转义
[root@localhost ~]# sed 's/\/bin\/bash/\/bin\/csh/' /etc/passwd
```





##### d 删除

此命令的基本格式为：

```shell
[address]d
```



如果需要删除文本中特定行，可以用`d`命令，它会删除指定行中的所有内容。

> 关于d的话，直接使用就好了



实例1：

> `d`指令的简单使用

```shell
[root@localhost ~]# sed '3d' test1.txt 	   //直接删除tes1.txt中第三行
[root@localhost ~]# sed '1,3d' test1.txt	//删除1,3行

		//或者，删除1，到3行的所有行
[root@localhost ~]# sed '/1/,/3/d' test1.txt	

		//又或者，删除3行，和后面的所有行
[root@localhost ~]# sed '3,$d' test1.txt
		
```





##### a,i	插入行

`a`和`i`，一起讲，是因为这两者极其相似。`i`命令表示在指定的行前面插入一行，`a`表示在指定的行后面插入一行

基本格式如下：

```shell
[address] a (或者i) \新的文本内容
```





实例1：

> 简单的使用`a`，`i`命令

```
[root@localhost ~]# sed '/a/a\this is new' test1.txt
this is a			//a命令插入一行在匹配"a"的行之后
this is new 
this is b


//使用i命令
[root@localhost ~]# sed '/a/i\
> this is the new' test1.txt
this is the new 
this is a 
this is b


又或者添加多行数据
[root@localhost ~]# sed '/a/i\
>this is one \
>this is two\
>this is three' test1.txt
this is one
this is two 
this is three
this is a
this is b
```





##### c	替换行

`c`命令。与`s`脚本命令不同的是，`s`脚本命令说白了就是`vim`一样的替换单词，而`c`命令用作与替换整行的内容



基本格式如下：

```
[address]c\用于替换的新文本
```



实例1：

> 简单的使用`c`命令，我觉得`c`也使用的不多

```shell
[root@localhost ~]# sed '/a/c\
>this is the newLine' test1.txt
this is the newLines
this is b
```







##### y	字符转换

`y`转换命令是唯一可以处理单个字符的`sed`脚本名4命令，基本格式如下：

```
[address]y/inchars/outchars
```

> 转换命令会对`inchars`和`outchars`值进行一对一的映射，也就是inchars的第一个字符会转化为outchars的第一个字符，以此类推。



实例1：

> `y`命令，简单的例子。注意`y`命令是一个全局命令，无法限定只在特定的地方使用

```
[root@localhost ~]# sed 'y/abc/def' test1.txt
this is d
this is e
```



##### p	打印命令

`p`命令表示搜索符合条件的行，并且输出该行的内容，基本格式为：

```shell
[address]p
```



实例1：

> 此处测试`-n`和`p`一起使用，和测试修改之前查看行

```shell
[root@localhost ~]# sed -n '/number 2/p' test1.txt
this is b			//此处禁止输出其他行，只输出匹配的行


	//此处测试功能，在修改之前输出一次内容
[root@localhost ~]# sed -n '/a/{
> p
>s/this/that/p
>}' test1.txt		//此种的话就会，在修改前执行一遍，修改后再执行一遍
```





##### w 写入文件

`w`命令用来将文本中指定行的内容写入文件中，基本格式如下：

```
[address]w filename
```

> 此处的filename表示文件名，绝对路径或相对路径都可以(但必须有写入的权限）





实例1：

> 简单的使用`w`命令。

```shell
[root@localhost ~]# sed -n '/a/w test2.txt' test1.txt
						//匹配带有a的行，并写入test2.txt文件
```





##### r 插入文件内容

`r`指令用于将一个独立文件的数据插入到，当前数据流的指定位置之后，基本格式为：

```
[address]r filename
```





实例1：

> 简单的使用`r`命令

新建一个文件test2.txt内容为(this is test2)，然后再原有的`test1.txt`基础上进行操作

```
[root@localhost ~]# sed '1r test2.txt' test1.txt
this is a 
this is test2
this is b


//或者可以使用$地址符，插入到数据流的末尾
[root@localhost ~]# sed '$r test2.txt' test1.txt
this is a
this is b
this is test2.txt
```





##### q退出sed

`q`命令的作用是：使`sed`命令在第一次匹配结束后，退出`sed`程序，不再对后续数据的处理。



实例1：

> 简单的使用`q`指令

```
[root@localhost ~]# sed '1q' test1.txt
this is a 					//执行了匹配第一行后q指令就会退出sed



//多行命令中使用q指令
[root@localhost ~]# sed '/b/{
>p						
>s/this/that/p
>q					//此多行命令作用为，匹配带b的行，并且输出一次后将
>}' test1.txt				//this换成that，然后再输出一次后退出
this is a
that is b
```





##### sed 脚本命令的寻址方式



对脚本命令来说，`address`用来标明该脚本命令作用到文本中的具体行



默认的话，`sed`命令会作用于文本数据的所有行。如果只想将命令作用于特定行或某些行，则必须写明`address`部分，表示的方法有以下两种：

+ 以数字形式指定区间。
+ 以文本模式指定区间。



以上的两种形式都可以使用如下这两种格式，分别是：

```
[address]脚本命令

或者

address {
	多个脚本命令
}
```

> 此处只会简单的说说这两种寻址方式，[详情点击](http://c.biancheng.net/view/4028.html)



+ 数字形式指定区间

基本格式：

```
n 命令					//此处的n表示的是任意数字
```



实例1：

```
[root@localhost ~]# sed -n '3d' test1.txt
```

> 此处通过数字的形式指定了区间，





+ 文本模式

基本格式：

```
/pattern/command
```

> 注意：必须使用斜杠将要指定的`pattern`封起来，sed命令才会生效



实例1：

> 简答使用文本模式的匹配，和正则表达式的匹配

```
[root@localhost ~]# sed -n '/a/s/this/that/p' test1.txt
that is a			//作用为匹配行内有a的行,并且将行内的this转换成that并且							//输出，其他的都不输出
			

//使用正则表达式
[root@localhost ~]# sed -n '/[ac]/s/this/that/p' test1.txt
that is a 			//作用大致和上面的一样，不过使用正则表达式，匹配的内容不							//止a，还有c
```





#### 3.	sed的高级操作

此处不写具体的高级操作，如有需求的话。[点击](http://www.beylze.com/news/30502.html)







#### 4.	awk

> 在此只介绍awk的基本用法，[详情](http://c.biancheng.net/view/4082.html)

除了使用`sed`命令，Linux系统中还有一个功能更加强大的文本数据处理工具。

`awk`

`awk`命令也是逐行扫描文件（从第一行到最后一行），寻找含有目标文本的行，如果匹配成功，则会再该行上执行用户想要的操作



`awk`基本格式为:

```
[root@localhost ~]# awk [选项] '脚本命令' 文件名
```



选项：

| 选项       | 含义                                                         |
| ---------- | ------------------------------------------------------------ |
| -F fs      | 指定以 fs 作为输入行的分隔符，awk 命令默认分隔符为空格或制表符。 |
| -f file    | 从脚本文件中读取 awk 脚本指令，以取代直接在命令行中输入指令。 |
| -v var=val | 在执行处理过程之前，设置一个变量 var，并给其设备初始值为 val。 |



`awk`的强大之处在于他的脚本命令，它由2部分组成，分别为匹配规则和执行命令，如下所示：

```shell
'匹配规则{执行命令}'
```

> 此处的匹配规则。和sed命令中的address部分作用相同，用来指定脚本命令可以作用到文本内容的具体行，可以使用字符串或者正则表达式。需要注意的是，整个脚本命令都是用单引号('')括起来的，而其中的执行命令部分需要大括号({})起来



实例1：

> 关于`awk`格式的简单实例

```
[root@localhost ~]# awk '/^$/print "空行"' test1.txt
```

> 此命令中，`/^$/`是一个正则表达式，匹配的是文本中的空白行，同时使用`print`命令输出"空行"，在此文本中，有多少的空白行，就会输出多少的“空行”





##### awk	使用数据字段变量

awk的主要特性之一是其处理文本文件中数据的能力，它会自动给一行中的每个元素分配一个变量。



默认情况下，`awk`会将如下变量分配给它再文本中发现的数据字段：

+ $0表示整个文本行。
+ $1表示文本行中的第1个数据字段
+ $2表示文本行中的第2个数据字段
+ $3表示文本行中的第3个数据字段
+ $n表示文本行中的第n个数据字段



在`awk`中，默认的字段分隔符是任意的空白字符（例如空格和制表符）。在文本行中，每个数据字段都是通过字段分隔符划分的。`awk`在读取一行文本时，会用预定义的字段分隔符划分每个数据字段。



实例1：

> 简单测试：数据字段变量

```
[root@localhost ~]# awk '{print "$3"}' test1.txt	
a					//此处只会显示第三个数据字段的值
b
```

> 使用`$3`，来表示每行文本的第三个数据字段





##### awk脚本命令使用多个命令

awk允许将多条命令组合成一个正常的程序。要在命令行上的程序脚本中使用多条命令，只要在命令之间放个分号即可。例如：

```
[root@localhost ~]# echo "I'm melody" | awk '{$2="rick";print $0}'
```





或者，也可以一次一行的输入程序脚本命令，例如：

```
[root@localhost ~]# awk '{
>$3="v"
>print $0
>}' test1.txt
```





##### awk从文件中读取程序

和`sed`一样，`awk`允许将脚本命令储存到文件中，然后再命令行中引用。

```
[root@localhost ~]# cat test2.txt
{print $3 " is cute"}
[root@localhost ~]# awk -Fi -f test2.txt test1.txt
		//此处的F后面的i，表示i为字段分隔符，-f表示引用test2.txt中的命令
```





##### BEGIN 关键字

`awk`中还可以指定脚本命令的运行时机。默认情况下，`awk`会从输入中读取一行文本，但有时需要在处理数据前运行一些命令。这就需要`BEGIN`关键字。



`BEGIN`会强制`awk`在读取数据前执行该关键字后指定的脚本命令，例如：

```
[root@localhost ~]# awk 'BEGIN{print "this is new day"}
>{print $0}' test1.txt
this is new day
this is a 
this is b
```





##### END关键字

和 BEGIN 关键字相对应，END 关键字允许我们指定一些脚本命令，awk 会在读完数据后执行它们，例如：

```
[root@localhost ~]# awk 'BEGIN {print "The data3 File Contents:"}
\> {print $0}
\> END {print "End of File"}' data3.txt
The data3 File Contents:
Line 1
Line 2
Line 3
End of File
```





#### 5.	awk的高级玩法

这个就不写了，[有需求自己去看](http://www.beylze.com/news/30504.html)