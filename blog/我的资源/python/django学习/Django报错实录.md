#### 1,两个app路由问题
两个app，然后在telplete的html文件中有一个\<a href="/user/userlogin">跳转</a>

简单说就是配置路由，两个app的路由要分开，分配
```
from django.urls import include, path, re_path
from django.conf import settings
from django.conf.urls import static
from app1 import views
from app2 import views as views2  //注意这个地方，不是view,而是view2,下面的所有路由都是这样

urlpatterns = [
    path("", views2.userlogin.as_view(), name="userlogin")

]+static.static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)#配置图片地址
```
通过上面的把第二个的路由分开了过后，两者都可以正常的写路由


总的路由就分开配就行了

```
urlpatterns = [
    path('admins/', admin.site.urls),
    path('admin/', include("app1.urls")),
    path('user/', include("app2.urls"))
] + static.static(settings.MEDIA_URL, document_root=settings.MEDIA_ROOT)       # 这里是周杰说的上传文件回显的部分被我注释了

```

#### 2，后退的问题
有一个问题就是，我管理员登录`(post提交)`成功了过后然后进入了用户管理页面`(可以看到所有的用户)`，然后通过超链接a标签进入了添加用户界面，这时候的用户添加界面用的是传输方式是post，但是这是我不添加用户而是点击浏览器的后退键，这是会有一个页面弹出来，显示`确认重新添加表单`。问了周杰这个问题，

答案为：因为跳转的方式是post，post跳转的话需要提交表单，后退的话就像是重新请求那个路由但是又没提交表单，所以会弹出那个东西，

处理办法为：当post提交确认正确了之后重新写路由写成get


这里开始报出了bug确切就是使用了namespace过后再加上app_name过后

这里的话还是暂时没有解决等明早来解决

#### 3,创建超级管理员
```
python manage.py createsuperuser
```