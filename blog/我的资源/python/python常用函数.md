<center>python常用函数</center>



#### 1.	index()，find()



`index`和`find`都是str字符串类型的一个方法。



两个作用都是：检测字符串中是否包含子字符串。

两个函数的作用和使用方法都一样，区别只是index没有找到的话，会抛出异常。而find()会返回-1

此处就只写index的语法，find和其语法一模一样



语法：

```
str.index(str, beg=0, end=len(string))
```

参数：

+ str：指定检索的字符串
+ beg：开始的索引，默认为0
+ end：结束索引，默认为字符串长度



简单实例：

```
x = 'zxcvbnm';
print(x.index('c'))
```

输出：

```
2
```



> find方法和index都是一样的用法。此处就不写了