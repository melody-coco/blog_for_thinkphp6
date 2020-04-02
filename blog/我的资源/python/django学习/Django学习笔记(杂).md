###### 一次http请求
![image](C:/Users/11547/Desktop/121.png)




###### 创建项目(ps,写在cmd)
```
代码:django-admin startproject mysite(ps.mysite是项目名)
```
###### 创建应用
```
python manage.py start app1(ps.app1是项目名)
```
###### 启动web服务器

```
runserver
```
1. urls.py
1. 网址入口，关联到对应的views.py中的一个函数（或者generic类），访问网址就对应一个函数。
1. 
1. views.py
1. 处理用户发出的请求，从urls.py中对应过来, 通过渲染templates中的网页可以将显示内容，比如登陆后的用户名，用户请求的数据，输出到网页。
1. 
1. models.py
1. 与数据库操作相关，存入或读取数据时用到这个，当然用不到数据库的时候 你可以不使用。
1. 
1. forms.py
1. 表单，用户在浏览器上输入数据提交，对数据的验证工作以及输入框的生成等工作，当然你也可以不使用。
1. 
1. templates 文件夹
1. 
1. views.py 中的函数渲染templates中的Html模板，得到动态内容的网页，当然可以用缓存来提高速度。
1. 
1. admin.py
1. 后台，可以用很少量的代码就拥有一个强大的后台。
1. 
1. settings.py
1. Django 的设置，配置文件，比如 DEBUG 的开关，静态文件的位置等。

##### 1，创建project
##### 2，配置路径
######     （1）模板路径
```
TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [os.path.join(BASE_DIR, 'templates')]
        ,
        'APP_DIRS': True,
        'OPTIONS': {
            'context_processors': [
                'django.template.context_processors.debug',
                'django.template.context_processors.request',
                'django.contrib.auth.context_processors.auth',
                'django.contrib.messages.context_processors.messages',
            ],
        },
    },
]
```
###### （2）静态文件配置
![image](C:/Users/11547/Desktop/1.png)

###### （3）额外配置

```
MIDDLEWARE = [
    'django.middleware.security.SecurityMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
    'django.middleware.common.CommonMiddleware',
    #'django.middleware.csrf.CsrfViewMiddleware',
    'django.contrib.auth.middleware.AuthenticationMiddleware',
    'django.contrib.messages.middleware.MessageMiddleware',
    'django.middleware.clickjacking.XFrameOptionsMiddleware',
]
```
在python manage.py shell里面
这是extra给字段取别名的sql语句

```
stu.objects.all().extra(select={'jio':'stuname'}).query.__str__()
这里的query表示整体返回的是一个查询语句加上__str__()再把它打印出来
这一句的效果就是sql语句而并不是返回的数据库stu的对象
'SELECT (stuname) AS `jio`, `app1_stu`.`id`, `app1_stu`.`stuname`,`app1_stu`.`stu_class` FROM `app1_stu`'
```
###### #### 而关于defer
请注意，的输出query是无效的SQL,因为“Django从未实际插入参数：他会查询和参数分别发送到数据库适配器，后者执行适当的操作”

```
In [47]: Tag.objects.all().extra(select={'tag_name': 'name'}).query.__str__()
Out[47]: u'SELECT (name) AS "tag_name", "blog_tag"."id", "blog_tag"."name" FROM "blog_tag"'
我们发现查询的时候弄了两次 (name) AS "tag_name" 和 "blog_tag"."name"
如果我们只想其中一个能用，可以用 defer 排除掉原来的 name （后面有讲）
In [49]: Tag.objects.all().extra(select={'tag_name': 'name'}).defer('name').query.__str__()
Out[49]: u'SELECT (name) AS "tag_name", "blog_tag"."id" FROM "blog_tag"'
```
#### 一对一表
```
class teacher(models.Model):
    teachername = models.CharField(max_length=255)
    teacher_class=models.ForeignKey('stu_class', on_delete='models.CASCADE')#一对一
    def __str__(self):      上面这个地方使用Foreikgney
        return self.teachername


class stu_class(models.Model):
    class_name=models.CharField(max_length=255)
    def __str__(self):
        return  self.class_name
```
#### 更加高效的在views里面区分post，get方法
#### from django.views.generic import View #通过继承views来区分method

```
在views里面
class Zengjia(View):

    def get(self, requests):
        return render(requests, 'set.html', {'uu': '还请你添加数据'})

    def post(self, requests):
        nama = requests.POST.get('name')
        pwd = requests.POST.get('name')
        return render(requests,'set.html',{'uu':[name,pwd]})
```

```
在urls中
from django.urls import path, include, re_path
from app1 import views

urlpatterns = [
    re_path(r'^zengjia/$', views.Zengjia.as_view()),#这个地方是关于下面周杰给我演示的通过继承view来分类
]
```
