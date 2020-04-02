## 类和实例
######     面向对象最重要的概念就是类（Class）和实例（Instance），==必须牢记类是抽象的模板，比如Student类，而实例是根据类创建出来的一个个具体的“对象”，每个对象都拥有相同的方法，但各自的数据可能不同。==

###### 仍以Student类为例，在Python中，定义类是通过class关键字：


```
class Student(object):
    pass
```
###### 定义好了Student类，就可以根据Student类创建出Student的实例，创建实例是通过类名+()实现的：


```
>>> bart = Student()
>>> bart
<__main__.Student object at 0x10a67a590>
>>> Student
<class '__main__.Student'>
```
###### 可以自由地给一个实例变量绑定属性，比如，给实例bart绑定一个name属性：


```
>>> bart.name = 'Bart Simpson'
>>> bart.name
'Bart Simpson'
```

###### 由于类可以起到模板的作用，因此，可以在创建实例的时候，把一些我们认为必须绑定的属性强制填写进去。通过定义一个特殊的__init__方法，在创建实例的时候，就把name，score等属性绑上去：


```
class Student(object):

    def __init__(self, name, score):
        self.name = name
        self.score = score
```

######  ==注意：特殊方法“__init__”前后分别有两个下划线！！！==
###### 注意到__init__方法的第一个参数永远是self，表示创建的实例本身，因此，在__init__方法内部，就可以把各种属性绑定到self，因为self就指向创建的实例本身。

###### 有了__init__方法，在创建实例的时候，就不能传入空的参数了，必须传入与__init__方法匹配的参数，但self不需要传，Python解释器自己会把实例变量传进去：


```
>>> bart = Student('Bart Simpson', 59)
>>> bart.name
'Bart Simpson'
>>> bart.score
59
```

###### 和普通的函数相比，在类中定义的函数只有一点不同，就是第一个参数永远是实例变量self
###### 从新给对象的参数复制的话可以这样

```
blue.score=19
```
## 数据封装
###### 面向对象编程的一个重要特点就是数据封装。在上面的Student类中，每个实例就拥有各自的name和score这些数据。我们可以通过函数来访问这些数据，比如打印一个学生的成绩：


```
>>> def print_score(std):
...     print('%s: %s' % (std.name, std.score))
...
>>> print_score(bart)
Bart Simpson: 59
```

###### 但是，既然Student实例本身就拥有这些数据，要访问这些数据，就没有必要从外面的函数去访问，可以直接在Student类的内部定义访问数据的函数，这样，就把“数据”给封装起来了。这些封装数据的函数是和Student类本身是关联起来的，我们称之为类的方法：


```
class Student(object):

    def __init__(self, name, score):
        self.name = name
        self.score = score

    def print_score(self):
        print('%s: %s' % (self.name, self.score))
```

###### 要定义一个方法，除了第一个参数是self外，其他和普通函数一样。要调用一个方法，只需要在实例变量上直接调用，除了self不用传递，其他参数正常传入：


```
>>> bart.print_score()
Bart Simpson: 59
```

###### 这样一来，我们从外部看Student类，就只需要知道，创建实例需要给出name和score，而如何打印，都是在Student类的内部定义的，这些数据和逻辑被“封装”起来了，调用很容易，但却不用知道内部实现的细节。



###### 封装的另一个好处是可以给Student类增加新的方法，比如get_grade：


```
class Student(object):
    ...

    def get_grade(self):
        if self.score >= 90:
            return 'A'
        elif self.score >= 60:
            return 'B'
        else:
            return 'C'
```

###### 同样的，get_grade方法可以直接在实例变量上调用，不需要知道内部实现细节：

```
class Student(object):
    def __init__(self, name, score):
        self.name = name
        self.score = score

    def get_grade(self):
        if self.score >= 90:
            return 'A'
        elif self.score >= 60:
            return 'B'
        else:
            return 'C'
lisa = Student('Lisa', 99)
bart = Student('Bart', 59)
print(lisa.name, lisa.get_grade())
print(bart.name, bart.get_grade())
```

---

### 类和实例
###### 面向对象最重要的概念就是类（Class）和实例（Instance），必须牢记类是抽象的模板，比如Student类，而实例是根据类创建出来的一个个具体的“对象”，每个对象都拥有相同的方法，但各自的数据可能不同。

###### 仍以Student类为例，在Python中，定义类是通过class关键字：


```
class Student(object):
    pass
```
###### 定义好了Student类，就可以根据Student类创建出Student的实例，创建实例是通过类名+()实现的：


```
>>> bart = Student()
>>> bart
<__main__.Student object at 0x10a67a590>
>>> Student
<class '__main__.Student'>
```
###### 可以自由地给一个实例变量绑定属性，比如，给实例bart绑定一个name属性：


```
>>> bart.name = 'Bart Simpson'
>>> bart.name
'Bart Simpson'
```

###### 由于类可以起到模板的作用，因此，可以在创建实例的时候，把一些我们认为必须绑定的属性强制填写进去。通过定义一个特殊的__init__方法，在创建实例的时候，就把name，score等属性绑上去：


```
class Student(object):

    def __init__(self, name, score):
        self.name = name
        self.score = score
```

######  注意：特殊方法“__init__”前后分别有两个下划线！！！
### 访问限制

```
class Student(object):#这几行主要说了关于给实例的属性改为私有属性
    def __init__(self,name,fen):
        self.__name=name
        self.__fen=fen
    def get__name(self):#获取私有的姓名
        return self.__name
    def get__fen(self):#获取私有的分数
        return self.__fen
    def set__fen(self,fen):#修改私有的分数
        if 0<=fen<=100:
            self__fen=fen
            print(self__fen)
        else :
            return 'sorry'
name=input('姓名')
fen=int(input('分数'))
sam=Student(name,fen)
houfen=int(input('输入你要修改的分数拒绝输入0'))
print(sam.get__name())
print(sam.set__fen(houfen))
#print(sam.name)这里不注释掉的话会报错，报错没有name这个属性
# print(sam.fen)
```
### 继承
###### 在OOP程序设计中，当我们定义一个class的时候，可以从某个现有的class继承，新的class称为子类（Subclass），而被继承的class称为基类、父类或超类（Base class、Super class）。

###### 比如，我们已经编写了一个名为Animal的class，有一个run()方法可以直接打印：


```
class Animal(object):
    def run(self):
        print('Animal is running...')
```

###### 当我们需要编写Dog和Cat类时，就可以直接从Animal类继承：


```
class Dog(Animal):
    pass

class Cat(Animal):
    pass
```
###### 继承有什么好处？最大的好处是子类获得了父类的全部功能。由于Animial实现了run()方法，因此，Dog和Cat作为它的子类，什么事也没干，就自动拥有了run()方法：

```
dog = Dog()
dog.run()

cat = Cat()
cat.run()
运行结果如下：

Animal is running...
Animal is running...
```
###### 继承的第二个好处需要我们对代码做一点改进。你看到了，无论是Dog还是Cat，它们run()的时候，显示的都是Animal is running...，符合逻辑的做法是分别显示Dog is running...和Cat is running...，因此，对Dog和Cat类改进如下：


```
class Dog(Animal):

    def run(self):
        print('Dog is running...')

class Cat(Animal):

    def run(self):
        print('Cat is running...')
再次运行，结果如下：

Dog is running...
Cat is running...
```
### 多态
#### 子类可以传入父类作为参数的函数 来作参数

```
a = list() # a是list类型
b = Animal() # b是Animal类型
c = Dog() # c是Dog类型
```

###### 判断一个变量是否是某个类型可以用isinstance()判断：


```
>>> isinstance(a, list)
True
>>> isinstance(b, Animal)
True
>>> isinstance(c, Dog)
True
```

###### 看来a、b、c确实对应着list、Animal、Dog这3种类型。

###### 但是等等，试试：




```
>>> isinstance(c, Animal)


True
```

###### 看来c不仅仅是Dog，c还是Animal！

###### 不过仔细想想，这是有道理的，因为Dog是从Animal继承下来的，当我们创建了一个Dog的实例c时，我们认为c的数据类型是Dog没错，但c同时也是Animal也没错，Dog本来就是Animal的一种！
###### 要理解多态的好处，我们还需要再编写一个函数，这个函数接受一个Animal类型的变量：


```
def run_twice(animal):
    animal.run()
    animal.run()
```

###### 当我们传入Animal的实例时，run_twice()就打印出：


```
>>> run_twice(Animal())
Animal is running...
Animal is running...
```

###### 当我们传入Dog的实例时，run_twice()就打印出：


```
>>> run_twice(Dog())
Dog is running...
Dog is running...
```

###### 当我们传入Cat的实例时，run_twice()就打印出：


```
>>> run_twice(Cat())
Cat is running...
Cat is running...
```

###### 看上去没啥意思，但是仔细想想，现在，如果我们再定义一个Tortoise类型，也从Animal派生：


```
class Tortoise(Animal):
    def run(self):
        print('Tortoise is running slowly...')
```

###### 当我们调用run_twice()时，传入Tortoise的实例：


```
>>> run_twice(Tortoise())
Tortoise is running slowly...
Tortoise is running slowly...
```

###### 你会发现，新增一个Animal的子类，不必对run_twice()做任何修改，实际上，任何依赖Animal作为参数的函数或者方法都可以不加修改地正常运行，原因就在于多态。
###### 多态的好处就是，当我们需要传入Dog、Cat、Tortoise……时，我们只需要接收Animal类型就可以了，因为Dog、Cat、Tortoise……都是Animal类型，然后，按照Animal类型进行操作即可。由于Animal类型有run()方法，因此，传入的任意类型，只要是Animal类或者子类，就会自动调用实际类型的run()方法，这就是多态的意思：

###### 对于一个变量，我们只需要知道它是Animal类型，无需确切地知道它的子类型，就可以放心地调用run()方法，而具体调用的run()方法是作用在Animal、Dog、Cat还是Tortoise对象上，由运行时该对象的确切类型决定，这就是多态真正的威力：调用方只管调用，不管细节，而当我们新增一种Animal的子类时，只要确保run()方法编写正确，不用管原来的代码是如何调用的。这就是著名的“开闭”原则：

###### 对扩展开放：允许新增Animal子类；

###### 对修改封闭：不需要修改依赖Animal类型的run_twice()等函数。
### getattr()、setattr()以及hasattr()，我们可以直接操作一个对象的状态：


```
>>> class MyObject(object):
...     def __init__(self):
...         self.x = 9
...     def power(self):
...         return self.x * self.x
...
>>> obj = MyObject()
```

###### 紧接着，可以测试该对象的属性：


```
>>> hasattr(obj, 'x') # 有属性'x'吗？
True
>>> obj.x
9
>>> hasattr(obj, 'y') # 有属性'y'吗？
False
>>> setattr(obj, 'y', 19) # 设置一个属性'y'
>>> hasattr(obj, 'y') # 有属性'y'吗？
True
>>> getattr(obj, 'y') # 获取属性'y'
19
>>> obj.y # 获取属性'y'
19
```

###### 如果试图获取不存在的属性，会抛出AttributeError的错误：


```
>>> getattr(obj, 'z') # 获取属性'z'
Traceback (most recent call last):
  File "<stdin>", line 1, in <module>
AttributeError: 'MyObject' object has no attribute 'z'
可以传入一个default参数，如果属性不存在，就返回默认值：

>>> getattr(obj, 'z', 404) # 获取属性'z'，如果不存在，返回默认值404
404
也可以获得对象的方法：

>>> hasattr(obj, 'power') # 有属性'power'吗？
True
>>> getattr(obj, 'power') # 获取属性'power'
<bound method MyObject.power of <__main__.MyObject object at 0x10077a6a0>>
>>> fn = getattr(obj, 'power') # 获取属性'power'并赋值到变量fn
>>> fn # fn指向obj.power
<bound method MyObject.power of <__main__.MyObject object at 0x10077a6a0>>
>>> fn() # 调用fn()与调用obj.power()是一样的
81
```
### 类属性与实例属性
##### …………省略