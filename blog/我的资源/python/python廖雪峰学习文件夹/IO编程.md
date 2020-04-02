### 1，文件读写
###### 读文件
读文件可以直接写，不用写r(不过rb二进制读图片视频还是要)
但是写文件的话就得加'w'或者'a',加'a'最好
###### 要以读文件的模式打开一个文件对象，使用Python内置的open()函数，传入文件名和标示符：


```
>>> f = open('/Users/michael/test.txt', 'r')
```
###### 如果文件打开成功，接下来，调用read()方法可以一次读取文件的全部内容，Python把内容读到内存，用一个str对象表示：


```
>>> f.read()
'Hello, world!'
```
###### 最后一步是调用close()方法关闭文件。文件使用完毕后必须关闭，因为文件对象会占用操作系统的资源，并且操作系统同一时间能打开的文件数量也是有限的：


```
>>> f.close()
```
###### Python引入了with语句来自动帮我们调用close()方法：


```
with open('/path/to/file', 'r') as f:
    print(f.read())
这和前面的try ... finally是一样的，但是代码更佳简洁，并且不必调用f.close()方法。
```


###### 调用read()会一次性读取文件的全部内容，如果文件有10G，内存就爆了，所以，要保险起见，可以反复调用read(size)方法，每次最多读取size个字节的内容。另外，调用readline()可以每次读取一行内容，调用readlines()一次读取所有内容并按行返回list。因此，要根据需要决定怎么调用。

###### 如果文件很小，read()一次性读取最方便；如果不能确定文件大小，反复调用read(size)比较保险；如果是配置文件，调用readlines()最方便：


```
for line in f.readlines():
    print(line.strip()) # 把末尾的'\n'删掉
```
### file-like Object
###### 像open()函数返回的这种有个read()方法的对象，在Python中统称为file-like Object。除了file外，还可以是内存的字节流，网络流，自定义流等等。file-like Object不要求从特定类继承，只要写个read()方法就行。

###### StringIO就是在内存中创建的file-like Object，常用作临时缓冲。
##### 二进制文件
###### 前面讲的默认都是读取文本文件，并且是UTF-8编码的文本文件。要读取二进制文件，比如图片、视频等等，用'rb'模式打开文件即可：


```
>>> f = open('/Users/michael/test.jpg', 'rb')
>>> f.read()
b'\xff\xd8\xff\xe1\x00\x18Exif\x00\x00...' # 十六进制表示的字节
```

##### 字符编码
###### 要读取非UTF-8编码的文本文件，需要给open()函数传入encoding参数，例如，读取GBK编码的文件：


```
>>> f = open('/Users/michael/gbk.txt', 'r', encoding='gbk')
>>> f.read()
'测试'
```
###### 遇到有些编码不规范的文件，你可能会遇到UnicodeDecodeError，因为在文本文件中可能夹杂了一些非法编码的字符。遇到这种情况，open()函数还接收一个errors参数，表示如果遇到编码错误后如何处理。最简单的方式是直接忽略：


```
>>> f = open('/Users/michael/gbk.txt', 'r', encoding='gbk', errors='ignore')
```
##### 写文件
###### 写文件和读文件是一样的，唯一区别是调用open()函数时，传入标识符'w'或者'wb'表示写文本文件或写二进制文件：


```
>>> f = open('/Users/michael/test.txt', 'w')
>>> f.write('Hello, world!')
>>> f.close()
```
###### 写文件时是先放内春缓存起来，再用close结束缓存把数据写入磁盘所以还是用with语句来得保险：

```
with open('/Users/michael/test.txt', 'w') as f:
    f.write('Hello, world!')
```
### StringIO和BytesIO
##### StringIO
###### 很多时候，数据读写不一定是文件，也可以在内存中读写。

###### StringIO顾名思义就是在内存中读写str。

###### 要把str写入StringIO，我们需要先创建一个StringIO，然后，像文件一样写入即可：


```
>>> from io import StringIO
>>> f = StringIO()
>>> f.write('hello')
5
>>> f.write(' ')
1
>>> f.write('world!')
6
>>> print(f.getvalue())
hello world!
```

###### getvalue()方法用于获得写入后的str。
###### 要读取StringIO，可以用一个str初始化StringIO，然后，像读文件一样读取：


```
>>> from io import StringIO
>>> f = StringIO('Hello!\nHi!\nGoodbye!')
>>> while True:
...     s = f.readline()
...     if s == '':
...         break
...     print(s.strip())
...
Hello!
Hi!
Goodbye!
```
##### BytesIO
###### StringIO操作的只能是str，如果要操作二进制数据，就需要使用BytesIO。

###### BytesIO实现了在内存中读写bytes，我们创建一个BytesIO，然后写入一些bytes：


```
>>> from io import BytesIO
>>> f = BytesIO()
>>> f.write('中文'.encode('utf-8'))
6
>>> print(f.getvalue())
b'\xe4\xb8\xad\xe6\x96\x87'
```

###### 请注意，写入的不是str，而是经过UTF-8编码的bytes。

###### 和StringIO类似，可以用一个bytes初始化BytesIO，然后，像读文件一样读取：


```
>>> from io import BytesIO
>>> f = BytesIO(b'\xe4\xb8\xad\xe6\x96\x87')
>>> f.read()
b'\xe4\xb8\xad\xe6\x96\x87'
```
### 操作文件和目录
###### 打开Python交互式命令行，我们来看看如何使用os模块的基本功能：


```
>>> import os
>>> os.name # 操作系统类型
'posix'
```
###### 要获取详细的系统信息，可以调用uname()函数：


```
>>> os.uname()
posix.uname_result(sysname='Darwin', nodename='MichaelMacPro.local', release='14.3.0', version='Darwin Kernel Version 14.3.0: Mon Mar 23 11:59:05 PDT 2015; root:xnu-2782.20.48~5/RELEASE_X86_64', machine='x86_64')
```

###### 注意uname()函数在Windows上不提供，也就是说，os模块的某些函数是跟操作系统相关的。
##### 操作文件和目录
###### 操作文件和目录的函数一部分放在os模块中，一部分放在os.path模块中，这一点要注意一下。查看、创建和删除目录可以这么调用：


```
# 查看当前目录的绝对路径:
>>> os.path.abspath('.')
'/Users/michael'
# 在某个目录下创建一个新目录，首先把新目录的完整路径表示出来:
>>> os.path.join('/Users/michael', 'testdir')
'/Users/michael/testdir'
# 然后创建一个目录:
>>> os.mkdir('/Users/michael/testdir')
# 删掉一个目录:
>>> os.rmdir('/Users/michael/testdir')
```

###### 把两个路径合成一个时，不要直接拼字符串，而要通过os.path.join()函数，这样可以正确处理不同操作系统的路径分隔符
###### 同样的道理，要拆分路径时，也不要直接去拆字符串，而要通过os.path.split()函数，这样可以把一个路径拆分为两部分，后一部分总是最后级别的目录或文件名：


```
>>> os.path.split('/Users/michael/testdir/file.txt')
('/Users/michael/testdir', 'file.txt')
os.path.splitext()可以直接让你得到文件扩展名，很多时候非常方便：

>>> os.path.splitext('/path/to/file.txt')
('/path/to/file', '.txt')
```

###### 这些合并、拆分路径的函数并不要求目录和文件要真实存在，它们只对字符串进行操作。

###### 文件操作使用下面的函数。假定当前目录下有一个test.txt文件：


```
# 对文件重命名:
>>> os.rename('test.txt', 'test.py')
# 删掉文件:
>>> os.remove('test.py')
```
###### 最后看看如何利用Python的特性来过滤文件。比如我们要列出当前目录下的所有目录，只需要一行代码：


```
>>> [x for x in os.listdir('.') if os.path.isdir(x)]
['.lein', '.local', '.m2', '.npm', '.ssh', '.Trash', '.vim', 'Applications', 'Desktop', ...]
```

###### 要列出所有的.py文件，也只需一行代码：


```
>>> [x for x in os.listdir('.') if os.path.isfile(x) and os.path.splitext(x)[1]=='.py']
['apis.py', 'config.py', 'models.py', 'pymonitor.py', 'test_db.py', 'urls.py', 'wsgiapp.py']
```
##### 练习
###### 编写一个程序，能在当前目录以及当前目录的所有子目录下查找文件名包含指定字符串的文件，并打印出相对路径。

```
import os
def ss(str):
    a=[x for x in os.listdir('.') if os.path.isfile(x) and str in x ]
    for x in a:
        print(os.path.abspath(x))
    b=[os.path.abspath(x) for x in os.listdir('.') if os.path.isdir(x)]
    for x in b:
        a=[q for q in os.listdir('.') if os.path.isfile(os.path.join(x,q) and str in q)]
        for x in a:
            print(os.path.abspath(a))
print(ss(input('输入你要查找的文件')))
```
###### 序列化
###### 在程序运行的过程中，所有的变量都是在内存中，比如，定义一个dict：


```
d = dict(name='Bob', age=20, score=88)
```
###### 可以随时修改变量，比如把name改成'Bill'，但是一旦程序结束，变量所占用的内存就被操作系统全部回收。如果没有把修改后的'Bill'存储到磁盘上，下次重新运行程序，变量又被初始化为'Bob'。

###### 我们把变量从内存中变成可存储或传输的过程称之为序列化，在Python中叫pickling，在其他语言中也被称之为serialization，marshalling，flattening等等，都是一个意思。

###### 序列化之后，就可以把序列化后的内容写入磁盘，或者通过网络传输到别的机器上。

###### 反过来，把变量内容从序列化的对象重新读到内存里称之为反序列化，即unpickling。

```
>>> import pickle
>>> d = dict(name='Bob', age=20, score=88)
>>> pickle.dumps(d)
b'\x80\x03}q\x00(X\x03\x00\x00\x00ageq\x01K\x14X\x05\x00\x00\x00scoreq\x02KXX\x04\x00\x00\x00nameq\x03X\x03\x00\x00\x00Bobq\x04u.'
pickle.dumps()方法把任意对象序列化成一个bytes，然后，就可以把这个bytes写入文件。或者用另一个方法pickle.dump()直接把对象序列化后写入一个file-like Object：

>>> f = open('dump.txt', 'wb')
>>> pickle.dump(d, f)
>>> f.close()
```

###### 看看写入的dump.txt文件，一堆乱七八糟的内容，这些都是Python保存的对象内部信息。
###### 我们打开另一个Python命令行来反序列化刚才保存的对象：


```
>>> f = open('dump.txt', 'rb')
>>> d = pickle.load(f)
>>> f.close()
>>> d
{'age': 20, 'score': 88, 'name': 'Bob'}
```

###### 变量的内容又回来了！

###### 当然，这个变量和原来的变量是完全不相干的对象，它们只是内容相同而已。
##### JSON
###### 如果我们要在不同的编程语言之间传递对象，就必须把对象序列化为标准格式，比如XML，但更好的方法是序列化为JSON，因为JSON表示出来就是一个字符串，可以被所有语言读取，也可以方便地存储到磁盘或者通过网络传输。JSON不仅是标准格式，并且比XML更快，而且可以直接在Web页面中读取，非常方便。

```
>>> import json
>>> d = dict(name='Bob', age=20, score=88)
>>> json.dumps(d)
'{"age": 20, "score": 88, "name": "Bob"}'
```


```
>>> json_str = '{"age": 20, "score": 88, "name": "Bob"}'
>>> json.loads(json_str)
{'age': 20, 'score': 88, 'name': 'Bob'}
```
##### JSON进阶

```
import json

class Student(object):
    def __init__(self, name, age, score):
        self.name = name
        self.age = age
        self.score = score

s = Student('Bob', 20, 88)
print(json.dumps(s))
```

###### 运行代码，毫不留情地得到一个TypeError：


```
Traceback (most recent call last):
  ...
TypeError: <__main__.Student object at 0x10603cc50> is not JSON serializable
```
###### 可选参数default就是把任意一个对象变成一个可序列为JSON的对象，我们只需要为Student专门写一个转换函数，再把函数传进去即可：


```
def student2dict(std):
    return {
        'name': std.name,
        'age': std.age,
        'score': std.score
    }
```

###### 这样，Student实例首先被student2dict()函数转换成dict，然后再被顺利序列化为JSON：


```
>>> print(json.dumps(s, default=student2dict))
{"age": 20, "name": "Bob", "score": 88}
```
###### 不过，下次如果遇到一个Teacher类的实例，照样无法序列化为JSON。我们可以偷个懒，把任意class的实例变为dict：


```
print(json.dumps(s, default=lambda obj: obj.__dict__))
```
###### 因为通常class的实例都有一个__dict__属性，它就是一个dict，用来存储实例变量。也有少数例外，比如定义了__slots__的class。

###### 同样的道理，如果我们要把JSON反序列化为一个Student对象实例，loads()方法首先转换出一个dict对象，然后，我们传入的object_hook函数负责把dict转换为Student实例：


```
def dict2student(d):
    return Student(d['name'], d['age'], d['score'])
```

###### 运行结果如下：


```
>>> json_str = '{"age": 20, "score": 88, "name": "Bob"}'
>>> print(json.loads(json_str, object_hook=dict2student))
<__main__.Student object at 0x10cd3c190>
```

###### 打印出的是反序列化的Student实例对象。