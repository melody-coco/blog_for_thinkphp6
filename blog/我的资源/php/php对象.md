<center>类和对象</center>
#### 1,	基本概念



##### class

以`class`关键字开始，后面跟着类名，在后面跟着花括号，

一个类有属于自己的常量，变量(属性)以及函数(方法)。

```php
<?php
	class test{
		public $name = 'jack';
		
		public function show(){
			echo $this->name;
		}
	}
?>
```



##### new

创建一个类的实例(对象)，必须使用`new`关键字。

```php
<?php
	class test{
		public $name = 'jack';
	}
	$test1 = new test();
	echo test1->name;
?>
```



##### extends

PHP中继承使用`extends`关键字，，并且PHP不支持多继承，如果父类定义了`final`关键字，则父类方法无法被覆盖。

```php
<?php
	class newTest extends test{
		public $tt = 'the new';
	}
	$student1 = new newTest();
	echo #student->name
?>
```



##### ::class

PHP中使用`::class`来进行类名的基尔希。使用`ClassName::class`返回一个字符串，包含了类ClasssName的完全限定名称。这对使用了命名空间的类尤其有用。

```php
<?php
	namespace NS{
		class test{
			
		}
		echo test::class;
	}
?>				//这里会输出NS\test
```





#### 2.	属性

属性初始化的时候只能为常量

类的变量成员叫做“属性” 或者“字段”

属性声明由关键字`public`，`protected`，`provate`开头

在类的**成员方法**中，可以使用->(对象运算符)：`$this->name`（这里的name是属性名）这种方式来访问非静态属性。静态属性则是用`::`(双冒号）:`self::$name`（这里的name为静态属性）





#### 3.	类常量

**类常量的访问和静态属性是一样的**

把在类中始终保持不变的值定义为常量。在定义和使用常量涩时候不需要使用`$`符号

常量的值必须是一个定制，不能说类变量，数学运算的结果等。

接口中也可以定义变量。



#### 4，	类的自动加载

想要了解，自己去网上看看





#### 5.	构造函数与析构函数



​	构造函数

​	PHP中，具有构造函数的类会在每次创建新对象时先调用此方法。

```php
<?php
	class test{
        function __construct($new){
            echo  "这是在构造函数中$new"
    }
    
    class test1 extends test{
        function __construct(){
            parent::__construc();
            echo "这子类的构造函数"
        }
    }
    $test = new test("test");//这里会输出"这是在构造函数中test"
    $test1 = new test1();	//这里会输出"这子类的构造函数"
}
?>
```



析构函数		`__destruct`

PHP中的析构函数会在某个对象的所有引用都被删除或者当期做对象被显式销毁时执行。

```php
<?php
class MyDestructableClass {
   function __construct() {
       print "In constructor\n";
       $this->name = "MyDestructableClass";
   }

   function __destruct() {
       print "Destroying " . $this->name . "\n";
   }
}

$obj = new MyDestructableClass();
?>
```





#### 6.	访问控制



属性或方法的访问控制，是通过在前面添加`public`，`protected`,`prvate` 分别为 公开，受保护(只能子类和自身方法访问)，私有(只能自身访问)



属性声明：

```php
<?php
	class test{
		public $name = 'jack';	//成员方法，子类，外部都能访问
		protected $sex = 'man';	//成员方法和子类都能调用
		private $age = 11;		//只能类的成员方法调用
	}
?>
```



方法声明：

```php
<?php
	class test{
    
    	//此方法外部，方法子类，成员方法能访问
		public function test1(){
            echo "这个是公共方法";
        }
    	//此方法子类，成员方法能访问
    	protected function test2(){
            echo "这个是protected方法";
        }
    	//此方法自能类的成员方法才能调用
    	private function test3(){
            echo "这个是provete方法";
        }
    
    
	}
?>
```





#### 7.	对象继承

PHP中继承关键字`extends`

```php
<?php
	class test{
    
        public $name = '你的名字';
        public function show(){
            echo $this->name;
    }
    
    class test2 extends{
 
    }
    
    $test = new test();
    echo $test->show;
}
?>
```





#### 8.	范围解析操作`::`

范围解析操作符`::`作用为，访问静态成员，类常量，，还可以用于覆盖类中的属性和方法



`::`用于访问静态变量，类变量，详情去看`后期静态绑定`





#### 9.	Static（静态）



此关键字用于声明类的属性或者方法为静态，静态的话就可以不实例化对象，直接访问类。

```php
<?php
	class test {
		public static $name = "jack";
		
		public static function show(){
			echo $this->name;
		}
	}
	
	echo test::show();
?>
```



#### 10.	抽象类abstract 

​		

​			抽象类的关键字`abstract`

定义为抽象的类不能被实例化。任何一个类，如果它里面至少一个方法被声明为抽象的。那么这个类就必须被声明为抽象类。被定义为抽象的方法只是声明了其调用方法，不能定义其具体的功能实现。



继承一个抽象类，字类必须定义父类中手游的抽象方法，访问控制必须和父类中一样(或者更为宽松)，



实例如下：

```php
<?php
	abstract class models{
		abstract public function show(){};
		abstract public function set($number){};
    
    	public function showMy(){
            echo "此方法不为抽象方法，"
        } 
	}
	
	class test extends models{
		public $list = array();
	
		public function show(){
			echo "输出内容如下";
		}
		
		public function set($number){
			$this->list[$number] = "输入类容如下";
		}
	}
?>
```





#### 11.	对象接口



​	使用接口(nterface)，可以指定某个类必须实现哪些方法，但不需要定义这些方法的具体内容。



接口定义通过关键字`interface`来定义，就像定义一个标准的类一样，但其中定义的方法都是空的



接口中定义的所有方法都必须是共有，这是接口的特性。可以在接口中定义一个构造方法，

接口之间也可以继承，通过`extends`

```php
<?php
interface a
{
    public function foo();
}

interface b extends a
{
    public function baz(Baz $baz);
}

// 正确写法
class c implements b
{
    public function foo()
    {
    }

    public function baz(Baz $baz)
    {
    }
}
?>
```



#### 12.	trait



PHP中一种**代码复用**的方法,`trait`

因为`php`是单继承的语言，所以通过`trait`来对单一继承进行补充



```
<?php
	trait show{
	
        public function showAll(){
            echo "trait继承的第一个方法";
        }
        
        public function showThis(){
        	echo "trait继承的第二个方法";
        }
	}
	
	class test {
		use show;
	}
?>
```





​	1.**优先级**

从基类继承的成员会被 trait 插入的成员所覆盖。优先顺序是来自当前类的成员覆盖了 trait 的方法，而 trait 则覆盖了被继承的方法。





​	2.可以用多个`trait`

```php
<?php
trait Hello {
    public function sayHello() {
        echo 'Hello ';
    }
}

trait World {
    public function sayWorld() {
        echo 'World';
    }
}

class MyHelloWorld {
    use Hello, World;
    public function sayExclamationMark() {
        echo '!';
    }
}

$o = new MyHelloWorld();
$o->sayHello();
$o->sayWorld();
$o->sayExclamationMark();
?>
```



3.`trait`冲突

如果两个`trait`插入了两个同名犯法，会产生一个报错



4.修改方法的访问控制。

```php
class MyClass1 {
    use HelloWorld { sayHello as protected; }
}
```



5.由`trait`组成`trait`



6.`trait`的抽象成员

​	`trait`支持在里面写入抽象方法

```php
<?php
	trait Hello {
        public function sayHelloWorld() {
            echo 'Hello'.$this->getWorld();
    	}
    abstract public function getWorld();
}			//use此trait的类也必须写trait中的抽象方法
?>
```



7. ​	`Trait`的静态成员

   ```php
   <?php
   trait Counter {
       public function inc() {
           static $c = 0;
           $c = $c + 1;
           echo "$c\n";
       }
   }
   
   class C1 {
       use Counter;
   }
   
   class C2 {
       use Counter;
   }
   
   $o = new C1(); $o->inc(); // echo 1
   $p = new C2(); $p->inc(); // echo 1
   ?>
   ```



9. ​	`Trait`属性



​	`Trait`可以定义属性

```php
<?php
trait PropertiesTrait {
    public $x = 1;
}

class PropertiesExample {
    use PropertiesTrait;
}

$example = new PropertiesExample;
$example->x;
?>
```

[详情见](https://www.php.net/manual/zh/language.oop5.traits.php)





#### 13.	匿名类

说白了，就是和匿名方法很像的玩意，

这里不做过多刨析

```php
<?php
	var_dump(new class{
		public $test = "测试内容";
	})
?>
```





#### 14.	重载

`java`中的重载是提供多个重名的方法，各个方法的参数个数和参数不同来进行重载

PHP中的重载，是指动态的“创建”类属性和方法。通过魔术方法来是实现



**属性重载[ ¶](https://www.php.net/manual/zh/language.oop5.overloading.php#language.oop5.overloading.members)**

public __set ( string `$name` , [mixed](https://www.php.net/manual/zh/language.pseudo-types.php#language.types.mixed) `$value` ) : void

public __get ( string `$name` ) : [mixed](https://www.php.net/manual/zh/language.pseudo-types.php#language.types.mixed)

public __isset ( string `$name` ) : bool

public __unset ( string `$name` ) : void

在给不可访问属性赋值时，[__set()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.set) 会被调用。

读取不可访问属性的值时，[__get()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.get) 会被调用。

当对不可访问属性调用 [isset()](https://www.php.net/manual/zh/function.isset.php) 或 [empty()](https://www.php.net/manual/zh/function.empty.php) 时，[__isset()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.isset) 会被调用。

当对不可访问属性调用 [unset()](https://www.php.net/manual/zh/function.unset.php) 时，[__unset()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.unset) 会被调用。



属性重载如下：

```php
<?php
class PropertyTest {
     /**  被重载的数据保存在此  */
    private $data = array();

 
     /**  重载不能被用在已经定义的属性  */
    public $declared = 1;

     /**  只有从类外部访问这个属性时，重载才会发生 */
    private $hidden = 2;

    public function __set($name, $value) 
    {
        echo "Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }

    public function __get($name) 
    {
        echo "Getting '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**  PHP 5.1.0之后版本 */
    public function __isset($name) 
    {
        echo "Is '$name' set?\n";
        return isset($this->data[$name]);
    }

    /**  PHP 5.1.0之后版本 */
    public function __unset($name) 
    {
        echo "Unsetting '$name'\n";
        unset($this->data[$name]);
    }

    /**  非魔术方法  */
    public function getHidden() 
    {
        return $this->hidden;
    }
}


echo "<pre>\n";

$obj = new PropertyTest;

$obj->a = 1;
echo $obj->a . "\n\n";

var_dump(isset($obj->a));
unset($obj->a);
var_dump(isset($obj->a));
echo "\n";

echo $obj->declared . "\n\n";

echo "Let's experiment with the private property named 'hidden':\n";
echo "Privates are visible inside the class, so __get() not used...\n";
echo $obj->getHidden() . "\n";
echo "Privates not visible outside of class, so __get() is used...\n";
echo $obj->hidden . "\n";
?>
```



**方法重载[ ¶](https://www.php.net/manual/zh/language.oop5.overloading.php#language.oop5.overloading.methods)**

public __call ( string `$name` , array `$arguments` ) : [mixed](https://www.php.net/manual/zh/language.pseudo-types.php#language.types.mixed)

public static __callStatic ( string `$name` , array `$arguments` ) : [mixed](https://www.php.net/manual/zh/language.pseudo-types.php#language.types.mixed)

在对象中调用一个不可访问方法时，[__call()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.call) 会被调用。

在静态上下文中调用一个不可访问方法时，[__callStatic()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.callstatic) 会被调用。





方法重载如下：

```php
<?php
class MethodTest 
{
    public function __call($name, $arguments) 
    {
        // 注意: $name 的值区分大小写
        echo "Calling object method '$name' "
             . implode(', ', $arguments). "\n";
    }

    /**  PHP 5.3.0之后版本  */
    public static function __callStatic($name, $arguments) 
    {
        // 注意: $name 的值区分大小写
        echo "Calling static method '$name' "
             . implode(', ', $arguments). "\n";
    }
}

$obj = new MethodTest;
$obj->runTest('in object context');

MethodTest::runTest('in static context');  // PHP 5.3.0之后版本
?>
```



#### 15.	遍历对象

使用`foreach`对象来进行遍历。默认情况下，所有的可见属性都将用于被遍历

实例如下：

```php
<?php
class MyClass
{
    public $var1 = 'value 1';
    public $var2 = 'value 2';
    public $var3 = 'value 3';

    protected $protected = 'protected var';
    private   $private   = 'private var';

    function iterateVisible() {
       echo "MyClass::iterateVisible:\n";
       foreach($this as $key => $value) {
           print "$key => $value\n";
       }
    }
}

$class = new MyClass();

foreach($class as $key => $value) {
    print "$key => $value\n";
}
echo "\n";


$class->iterateVisible();

?>
	//输出如下
var1 => value 1
var2 => value 2
var3 => value 3

MyClass::iterateVisible:
var1 => value 1
var2 => value 2
var3 => value 3
protected => protected var
private => private var
```



#### 16.	魔术方法

[__construct()](https://www.php.net/manual/zh/language.oop5.decon.php#object.construct)， [__destruct()](https://www.php.net/manual/zh/language.oop5.decon.php#object.destruct)， [__call()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.call)， [__callStatic()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.callstatic)， [__get()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.get)， [__set()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.set)， [__isset()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.isset)， [__unset()](https://www.php.net/manual/zh/language.oop5.overloading.php#object.unset)， [__sleep()](https://www.php.net/manual/zh/language.oop5.magic.php#object.sleep)， [__wakeup()](https://www.php.net/manual/zh/language.oop5.magic.php#object.wakeup)， [__toString()](https://www.php.net/manual/zh/language.oop5.magic.php#object.tostring)， [__invoke()](https://www.php.net/manual/zh/language.oop5.magic.php#object.invoke)， [__set_state()](https://www.php.net/manual/zh/language.oop5.magic.php#object.set-state)， [__clone()](https://www.php.net/manual/zh/language.oop5.cloning.php#object.clone) 和 [__debugInfo()](https://www.php.net/manual/zh/language.oop5.magic.php#object.debuginfo) 等方法在 PHP 中被称为魔术方法（Magic methods）。在命名自己的类方法时不能使用这些方法名，除非是想使用其魔术功能。



一些用于重载的方法在上例中已经被提到，这里就不说了



`__sleep()`和`__wakeup()`

前者是序列化`(selialize)`的时候，之前调用，调用的返回值再被序列化。

后者是反序列化`(unserialize)`的时候，之前调用。例如重新简例数据库连接，或者其他操作



`__toString()`

当类被当做字符串的时候被调用。

```php
<?php
// Declare a simple class
class TestClass
{
    public $foo;

    public function __construct($foo) 
    {
        $this->foo = $foo;
    }

    public function __toString() {
        return $this->foo;
    }
}

$class = new TestClass('Hello');
echo $class;
?>
```



`__invoke()`

当把类当做函数来调用是，此方法会被调用



#### 17.	Final关键字

如果父类中的方法被声明为`final`，则子类无法覆盖该方法。如果一个类被声明为`final`，则不能被继承



#### 18.	对象复制

这里不做过多描述

有需要[自己看](https://www.php.net/manual/zh/language.oop5.cloning.php)



#### 19.	对象比较

当使用比较运算符(==)比较两个对象变量时，比较的原则是：如果两个变量的属性和属性值都相等，而且两个对象是同一个类的实例，那么这两个对象变量相等。



而如果使用权等运算(===)，这两个对象变量一定要指向某一个类的同一个实例（即童话一个对象）

[没懂得话](https://www.php.net/manual/zh/language.oop5.object-comparison.php)



#### 20.	参数类型约束

PHP 类型约束，函数的参数可以指定必须为对象，接口数组等。	在传参的小括号里标明参数的类型

​	实例如下：

```php
<?php
//如下面的类
class MyClass
{
    /**
     * 测试函数
     * 第一个参数必须为 OtherClass 类的一个对象
     */
    public function test(OtherClass $otherclass) {
        echo $otherclass->var;
    }


    /**
     * 另一个测试函数
     * 第一个参数必须为数组 
     */
    public function test_array(array $input_array) {
        print_r($input_array);
    }
}

    /**
     * 第一个参数必须为递归类型
     */
    public function test_interface(Traversable $iterator) {
        echo get_class($iterator);
    }
    
    /**
     * 第一个参数必须为回调类型
     */
    public function test_callable(callable $callback, $data) {
        call_user_func($callback, $data);
    }
}

// OtherClass 类定义
class OtherClass {
    public $var = 'Hello World';
}
?>
```



#### 21.	后期静态绑定



`slef::`的限制

```php
<?php
class A {
    public static function who() {
        echo __CLASS__;			//输出的为类名
    }
    public static function test() {
        self::who();			//slef为自身
    }
}

class B extends A {
    public static function who() {
        echo __CLASS__;
    }
}

B::test();
?>
```



简单的说，这里后期静态绑定就是(`self::`,`parent::`,`static`)

他们都是调用的静态方法,而不是伪变量`$this`



#### 22.	对象和引用

简单说就是 对象的赋值 是通过引用传递 。实质上两个变量都只是一个标识符而已。 



#### 23.	序列化

所有的PHP里面的值都可以使用函数`serialize()`来返回一个包含字节流的字符串来表示。`unserialize`函数能够重新把字符串便会PHP原来的值。



序列化一个对象将会保存对象的所有变量，但是不会保存对象的方法，只会保存类的名字。



PHP序列化的注意事项：

1. 序列化和反序列化的PHP页面必须都有要序列化的对象的类的定义。



示例如下：

```php
<?php
// classa.inc:
  
  class A {
      public $one = 1;
    
      public function show_one() {
          echo $this->one;
      }
  }
  
// page1.php:

  include("classa.inc");
  
  $a = new A;
  $s = serialize($a);
  // 把变量$s保存起来以便文件page2.php能够读到
  file_put_contents('store', $s);

// page2.php:
  
  // 要正确了解序列化，必须包含下面一个文件
  include("classa.inc");

  $s = file_get_contents('store');
  $a = unserialize($s);

  // 现在可以使用对象$a里面的函数 show_one()
  $a->show_one();
?>
```

