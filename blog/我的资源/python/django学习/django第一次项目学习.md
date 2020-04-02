(本文大多的知识点基本来自)[自强学堂](https://www.ziqiangxuetang.com/django/django-queryset-advance.html)
###### 1，render(requests,'login.html')渲染跳转到html模板
###### 2,redirect('http://www.baidu.com')（跳转到其他页面）
###### 3，requests.POST.get('username')(post获取表单元素)


#### 1. QuerySet 创建对象的方法
链接https://www.ziqiangxuetang.com/django/django-queryset-api.html
            （获取数据库元素）
```
>>> from blog.models import Blog
>>> b = Blog(name='Beatles Blog', tagline='All the latest Beatles news.')
>>> b.save()
 
总之，一共有四种方法
# 方法 1
Author.objects.create(name="WeizhongTu", email="tuweizhong@163.com")
 
# 方法 2
twz = Author(name="WeizhongTu", email="tuweizhong@163.com")
twz.save()
 
# 方法 3
twz = Author()
twz.name="WeizhongTu"
twz.email="tuweizhong@163.com"
twz.save()
 
# 方法 4，首先尝试获取，不存在就创建，可以防止重复
Author.objects.get_or_create(name="WeizhongTu", email="tuweizhong@163.com")
# 返回值(object, True/False)
```

###### ==备注：前三种方法返回的都是对应的 object，最后一种方法返回的是一个元组，(object, True/False)，创建时返回 True, 已经存在时返回 False==


#### 2. 获取对象的方法（上一篇的部分代码）
```
Person.objects.all() # 查询所有
Person.objects.all()[:10] 切片操作，获取10个人，不支持负索引，切片可以节约内存，不支持负索引，后面有相应解决办法，第7条
Person.objects.get(name="WeizhongTu") # 名称为 WeizhongTu 的一条，多条会报错
 
get是用来获取一个对象的，如果需要获取满足条件的一些人，就要用到filter
Person.objects.filter(name="abc") # 等于Person.objects.filter(name__exact="abc") 名称严格等于 "abc" 的人
Person.objects.filter(name__iexact="abc") # 名称为 abc 但是不区分大小写，可以找到 ABC, Abc, aBC，这些都符合条件
 
Person.objects.filter(name__contains="abc") # 名称中包含 "abc"的人
Person.objects.filter(name__icontains="abc") #名称中包含 "abc"，且abc不区分大小写
 
Person.objects.filter(name__regex="^abc") # 正则表达式查询
Person.objects.filter(name__iregex="^abc")# 正则表达式不区分大小写
 
# filter是找出满足条件的，当然也有排除符合某条件的
Person.objects.exclude(name__contains="WZ") # 排除包含 WZ 的Person对象
Person.objects.filter(name__contains="abc").exclude(age=23) # 找出名称含有abc, 但是排除年龄是23岁的
```
#### 10. QuerySet 重复的问题，使用 .distinct() 去重

###### 一般的情况下，QuerySet 中不会出来重复的，重复是很罕见的，但是当跨越多张表进行检索后，结果并到一起，可能会出来重复的值（我最近就遇到过这样的问题）


```
qs1 = Pathway.objects.filter(label__name='x')
qs2 = Pathway.objects.filter(reaction__name='A + B >> C')
qs3 = Pathway.objects.filter(inputer__name='WeizhongTu')
 
# 合并到一起
qs = qs1 | qs2 | qs3
这个时候就有可能出现重复的
 
# 去重方法
qs = qs.distinct()
```
#### 9. QuerySet 不支持负索引


```
Person.objects.all()[:10] 切片操作，前10条
Person.objects.all()[-10:] 会报错！！！
 
# 1. 使用 reverse() 解决
Person.objects.all().reverse()[:2] # 最后两条
Person.objects.all().reverse()[0] # 最后一条
 
# 2. 使用 order_by，在栏目名（column name）前加一个负号
Author.objects.order_by('-id')[:20] # id最大的20条
```
#### 比如我们要获取作者的 name 和 qq


```
authors = Author.objects.values_list('name', 'qq')
```

#### Python choice() 函数


#### 聚合函数
annotate
求一个作者的所有文章的得分(score)平均值

```
form django.db.models import Count
zz = stu_class.objects.annotate(class_list=Count('stu'))
```

这里的annotate是通过外键来Avg(计数)查询所有的stu_class对应的stu表里面的数据
返回的话，会是一个dict，里面两个字段{'班级1'：20，'班级2'：'30'}

##### 而求和，求平均值的话：

```
Aticled
+----+---------+--------+-------+
| id | title   | author | score |
+----+---------+--------+-------+
|  1 | 测试    | loid   |    10 |
|  2 | 测试    | loid   |     3 |
|  3 | 测试233 | loid2  |    65 |
|  4 | 擦速度  | loid   |   641 |
|  5 | 阿达    | loid2  |     1 |
+----+---------+--------+-------+
Article.objects.values('author').annotate(avg_score=Avg('score'))
'SELECT `app1_article`.`author`, `app1_article`.`title`, AVG(`app1_article`.`score`) AS `avg_score2` FROM `app1_article` GROUP BY `app1_article`.`author`, `app1_article`.`title` ORDER BY NULL'
Articl对象，通过author(作者)来分组，并且用聚合函数求得一个作者的所有文章的平均值
这里的第一个values意思是group by
如果后面再加一个values的意思是和普通的values意思一样只取values函数里面的字段
```
##### 同样的
Article.objects.values('author', 'title').annotate(sum_score2=Sum('score')).query.__str__()
用聚合函数通过author分组(group by)，再用Sum求得所用的score的总值

#### select_related 优化一对一，多对一查询
    (ps.select_related的意思是查询相关的，)

```
data_list = stu.objects.all().order_by('stuname').select_related('stu_class')
#select_related前面不能加values取字段值
```
上文中的select_related('stu_class')是在获取stu对象时通过外键的的关系获取stu_class表，作用为

```
s1 = stu.object.all().select_related('stu_class')
s1.stu_class.class_name这一句语句可以直接的查询学生所在班级的名字
# 取值的时候：每个对象的通过外键建立的关系来取另一个表的字段值：
data_list[0].stu_class.class_name
```

(ps.如果不用的话也可以的不过反复的查询数据库很浪费内存)

### prefetch_related 优化一对多，多对多查询
###### 和 select_related 功能类似，但是实现不同。
###### select_related 是使用 SQL JOIN 一次性取出相关的内容。
###### prefetch_related 用于 一对多，多对多 的情况，这时 select_related 用不了，因为当前一条有好几条与之相关的内容。
###### prefetch_related是通过再执行一条额外的SQL语句，然后用 Python 把两次SQL查询的内容关联（joining)到一起
###### 我们来看个例子，查询文章的同时，查询文章对应的标签。“文章”与“标签”是多对多的关系。
==prefetch_related是通过再执行一条额外的SQL语句，然后用 Python 把两次SQL查询的内容关联（joining)到一起==
遍历查询的结果：
##### 不用 prefetch_related 时
```
In [9]: articles = Article.objects.all()[:3]
In [10]: for a in articles:
    ...:     print a.title, a.tags.all()
(0.000) SELECT "blog_article"."id", "blog_article"."title", "blog_article"."author_id", "blog_article"."content", "blog_article"."score" FROM "blog_article" LIMIT 3; args=()
(0.000) SELECT "blog_tag"."id", "blog_tag"."name" FROM "blog_tag" INNER JOIN "blog_article_tags" ON ("blog_tag"."id" = "blog_article_tags"."tag_id") WHERE "blog_article_tags"."article_id" = 1 LIMIT 21; args=(1,)
Django 教程_1 <QuerySet [<Tag: Django>]>
(0.000) SELECT "blog_tag"."id", "blog_tag"."name" FROM "blog_tag" INNER JOIN "blog_article_tags" ON ("blog_tag"."id" = "blog_article_tags"."tag_id") WHERE "blog_article_tags"."article_id" = 2 LIMIT 21; args=(2,)
Django 教程_2 <QuerySet [<Tag: Django>]>
(0.000) SELECT "blog_tag"."id", "blog_tag"."name" FROM "blog_tag" INNER JOIN "blog_article_tags" ON ("blog_tag"."id" = "blog_article_tags"."tag_id") WHERE "blog_article_tags"."article_id" = 3 LIMIT 21; args=(3,)
Django 教程_3 <QuerySet [<Tag: Django>]>
```

##### 用 prefetch_related 我们看一下是什么样子

```
In [11]: articles = Article.objects.all().prefetch_related('tags')[:3]
In [12]: for a in articles:
   ...:     print a.title, a.tags.all()
(0.000) SELECT "blog_article"."id", "blog_article"."title", "blog_article"."author_id", "blog_article"."content", "blog_article"."score" FROM "blog_article" LIMIT 3; args=()
(0.000) SELECT ("blog_article_tags"."article_id") AS "_prefetch_related_val_article_id", "blog_tag"."id", "blog_tag"."name" FROM "blog_tag" INNER JOIN "blog_article_tags" ON ("blog_tag"."id" = "blog_article_tags"."tag_id") WHERE "blog_article_tags"."article_id" IN (1, 2, 3); args=(1, 2, 3)
Django 教程_1 <QuerySet [<Tag: Django>]>
Django 教程_2 <QuerySet [<Tag: Django>]>
Django 教程_3 <QuerySet [<Tag: Django>]>
我们可以看到第二条 SQL 语句，一次性查出了所有相关的内容。
```
==select_related和prefetch_related都是差不多的都是查询相关的表，不过前者是外键，后者是多对多。使用的时候对手在对象的定义后面跟select_related('stu_class')或者prefetch_related('tag')==

==使用的时候更是差不多都是对象后面跟stu1.stu_class.class_name或者Article1.tags.all()区别是前者只有一个每个对象只有一个关联的外键，后者有多个关联的==

#### defer 排除不需要的字段
###### 这时候可以用 defer 来排除这些字段，比如我们在文章列表页，只需要文章的标题和作者，没有必要把文章的内容也获取出来（因为会转换成python对象，浪费内存）
Article.objects.all().defer('content')
#### only 仅选择需要的字段
和 defer 相反，only 
```
用于取出需要的字段，假如我们只需要查出 作者的名称
In [15]: Author.objects.all().only('name')
```
上面这种查询会无法避免的取出主键

Django 后台
python manage.py createsuperuser
#### 修改 admin.py 
###### 进入 blog 文件夹，修改 admin.py 文件（如果没有新建一个），内容如下


```
from django.contrib import admin
from .models import stu, stu_class, Article

admin.site.register(stu, stuadmin)
admin.site.register(stu_class)
admin.site.register(Article, articleadmin)
```
###### (ps.如果显示都是一样的名字说明魔术方法__str__()没有定义)
#### 在列表显示与字段相关的其它内容
###### 后台已经基本上做出来了，可是如果我们还需要显示一些其它的fields，如何做呢？

```
class articleadmin(admin.ModelAdmin):
    search_fields = ('title', 'score')这里的search_fields是更具后面的title和score搜索，
                                        会弹出一个搜索框

class stuadmin(admin.ModelAdmin):
    list_display = ('stuname', 'stu_class_id')表示显示stuname和stu_class_id两个字段
    list_filter = ('stu_class',)根据后面的字段属性进行筛选
    search_fields = ('stuname',)
```

关于form表单可以来一个标准的
在app的文件夹里兴建一个form.py文件

```
from django import forms
 
class AddForm(forms.Form):
    a = forms.IntegerField()
    b = forms.IntegerField()
    #这里貌似是不能写ForeiKey的
```
然后在views层里面

```
from .forms import AddForm
 
def index(request):
    if request.method == 'POST':# 当提交表单时
     
        form = AddForm(request.POST) # form 包含提交的数据
         
        if form.is_valid():# 如果提交的数据合法
            a = form.cleaned_data['stuname']#(ps.此处是以form对象返回stuname的值)
            b = form.cleaned_data['b']
            return HttpResponse(str(int(a) + int(b)))
     
    else:# 当正常访问时
        form = AddForm()
    return render(request, 'addforms.html', {'form': form})
```
###### 对应的模板文件 index.html


```
<form method='post'>
{% csrf_token %}
{{ form }}
<input type="submit" value="提交">
</form>
```
静态文件的配置
关于静态文件夹static，如果不想把他标准的放在APP的static目录下的话
模板使用静态文件时
```
<link rel="stylesheet" href="/static/commons.css">
```
而在setting中

```
STATIC_URL = '/static/'#这里的/static/表示的是上面模板中的前缀(两者要对齐)
STATICFILES_DIRS = (
    os.path.join(BASE_DIR, "sta"),#这个sta是在项目文件夹下，不是在app文件夹下
    '/var/www/static/',
)这里的sta表示app下的文件夹sta，而后面的表示静态文件的地址
这样我们就可以把静态文件放在 common_static 和 /var/www/static/中了，Django也能找到它们
```


###### 有时候有一些模板不是属于app的，比如 baidutongji.html, share.html等，
```
TEMPLATES = [
    {
        'BACKEND': 'django.template.backends.django.DjangoTemplates',
        'DIRS': [
            os.path.join(BASE_DIR,'templates').replace('\\', '/'),
            os.path.join(BASE_DIR,'templates2').replace('\\', '/'),
        ],
        'APP_DIRS': True,
]
```


#### STATIC_ROOT
```
STATIC_ROOT = os.path.join(BASE_DIR, 'collected_static')#创建collected_static文件夹，
                                                           #复制所有的静态文件进文件夹
STATIC_ROOT会将所有STATICFILES_DIRS中所有文件夹中的文件，
以及各app中static中的文件都复制过来
```
当然还是要运行python manage.py collectstatic(运行这个的话就会调用STATIC_ROOT创建)

#### 数据的批量导入

```
import os#导入os模块
import django#导入Django模块
os.environ.setdefault("DJANGO_SETTINGS_MODULE", "untitled2.settings") #这个地方的untitled2是项目名
django.setup() 使用setup函数
#一下是正文部分
def main():
    from app1.models import Xingxi
    kkp = []
    with open('kk.txt', 'r',  encoding='UTF-8') as f:
        for line in f:
            title, content = line.split('****')
            xinxi = Xingxi.objects.get_or_create(title=title,content=content)[0]
            kkp.append(xinxi)

    Xingxi.objects.bulk_create(kkp)
if __name__ == '__main__':
    main()
    print('导入完成')
```

#### 数据库的迁移
(这个东西很简单，至少对我学到的而言)
一般的话暂时只需要熟悉mysql语句中数据库迁移
以下都是在cmd中进行的命令

```
导出
mysqldump -uroot -p 数据库名字 > d:/python/创建的导出文件名.sql
```

```
导入
mysql -uroot -p 目标数据库名 < d:\python\创建的导出文件.sql
```

#### 缓存系统
(ps.在思维导图和其他笔记中有)




### session

###### Django完全支持也匿名会话，简单说就是使用跨网页之间可以进行通讯，比如显示用户名，用户是否已经发表评论。session框架让你存储和获取访问者的数据信息，这些信息保存在服务器上（默认是数据库中），以 cookies 的方式发送和获取一个包含 session ID的值，并不是用cookies传递数据本身。
##### session配置
###### 编辑setting.py配置

```
MIDDLEWARE_CLASSES确保其中包含以下内容
'django.contrib.sessions.middleware.SessionMiddleware',
INSTALLED_APPS 是包含
'django.contrib.sessions',
```

==(ps.这些都是pycharm默认的配置)==

```
ps.难点session是直接保存在缓存里的所以不用在前台获取斜面第一句这样写是不对的，
# 所以下面的requests.session['name']不用再前台获取key值，
# 直接使用requests.session.get['name']就可以了
(ps.这里是注销操作)
```
