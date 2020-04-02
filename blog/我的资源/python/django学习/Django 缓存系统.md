==简单说缓存系统讲得更多的是如何配置缓存而不是敲代码==
### 缓存系统工作原理：

###### 对于给定的网址，尝试从缓存中找到网址，如果页面在缓存中，直接返回缓存的页面，如果缓存中没有，一系列操作（比如查数据库）后，保存生成的页面内容到缓存系统以供下一次使用，然后返回生成的页面内容。
######  Django settings 中 cache 默认为

```
CACHE={
    'default': {
        'BACKEND': 'django.core.cache.backends.locmem.LocMemCache',
    }
}
也就是默认利用本地的内存来当缓存，速度很快。当然可能出来内存不够用的情况
```

##### 利用文件系统来缓存的配置：


```
CACHES = {
    'default': {
        'BACKEND': 'django.core.cache.backends.filebased.FileBasedCache',
        'LOCATION': '/var/tmp/django_cache',#这个是文件系统储存的位置
        'TIMEOUT': 600,
        'OPTIONS': {
            'MAX_ENTRIES': 1000
        }
    }
}
```

##### 利用数据库来缓存，利用命令创建相应的表：
python manage.py createcachetable cache_table_name


```
CACHES = {
    'default': {
        'BACKEND': 'django.core.cache.backends.db.DatabaseCache',
        'LOCATION': 'cache_table_name',
        'TIMEOUT': 600,
        'OPTIONS': {
            'MAX_ENTRIES': 2000
        }
    }
}
```
###### 当访问量非常大的时候，就会有很多次的数据库查询，肯定会造成访问速度变慢，服务器资源占用较多等问题。


```
from django.shortcuts import render
from django.views.decorators.cache import cache_page#这里导入了缓存模块
 
@cache_page(60 * 15) # 秒数，这里指缓存 15 分钟，不直接写900是为了提高可读性
def index(request):
    # 读取数据库等 并渲染到网页
    return render(request, 'index.html', {'queryset':queryset})
```
