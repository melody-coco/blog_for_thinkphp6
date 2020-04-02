（URL跳转漏洞是指后台服务器在告知浏览器跳转时，未对客户端传入的重定向地址进行合法性验证，导致用户浏览器跳转到钓鱼页面的一种漏洞）


### 什么重定向(redirect)和跳转(forward)

简单说，重定向和跳转，都是客户端请求服务端，然后服务端响应而已，不过其中区别类似于：

*你到一个机关办事，一个是办事窗口的那个人很不客气地说，这个事你别找我，你找xxx窗口，然后你自己跑到xxx窗口，那个窗口的人直接给你办了；还有一个是窗口的人和你说，你等下，他自己跑去找另一个人沟通一番，然后跑回来给你办了。*

流程图如下：

![image](https://images2018.cnblogs.com/blog/1360356/201804/1360356-20180429160105708-1407751858.png)

#### ① 客户端跳转--重定向redirect

客户端向服务端发送请求，服务器返回一个“去访问其他链接”的响应，客户端根据此响应，第二次去访问服务器，客户端给出最终响应，所以总共有两次请求，地址栏会发生改变。

#### ② 服务端跳转--转发forward

客户端向服务器发送请求时，服务端发现当前资源给不出回应，服务器需要子啊内部请求另一个资源的跳转，然后给出响应，这属于1次请求，由于服务器跳转与否客户端并不知道，所以地址栏的URL并不会改变。

### 两者的区别

1，地址栏

转发：不会发生改变，，显示的依然是之前的地址。

重定向：会显示转向之后的地址

2，请求

转发：一次请求。

重定向：两次请求

3，数据

转发：对request对象的信息不会丢失，因此可以在多个页面的交互过程中实现请求数据的共享

重定向：request信息丢失

4，原理

请求转发为服务器内部跳转，只跳转一次，客户端接受结果，而不改变URL地址，而请求重定向则跳转两次，既将结果返回给客户端，又使客户端的URL地址改变，请求转发为内部跳转，页面请求的对象一直存在，请求重定向则会结束上个页面的请求。

这里用我自己的Django项目来具体讲解实例：
```
class userlogin(View):

    def get(self, request):
        return render(request, "u_userlogin.html", {"tt": "请登录"})

    def post(self, request):
        logout(request)
        name = request.POST.get("name", None)
        password = request.POST.get("password", None)

        if not name or not password:
            return HttpResponse("数据为空")
        user = authenticate(username=name, password=password)   //验证是否有该用户

        if user is not None:
            login(request, user)
            is_login = auth(request)
            if is_login:
                booklist = Book.objects.all()
                return render(request, "u_subscription.html", {"uu":  booklist}) 
                //这里是商城页面
```
上面代码中，登录成功了之后，登录成功了过后会直接取数据库的数据，然后用而数据库的数据渲染前端模板，

那么问题来了，如果是点击后退键 ==(ps.也就是js的BOM对象的window.history。back())==  。这样的话逻辑就是需要==重新提交表单==然后再跳转到商城页面。

那么如果是重定向喃？

##### 重定向
```
class re(View):#管理员登录

    def get(self, request):
        logout(request)
        print("确认已经输出到了get")
        return render(request, "login.html")


    def post(self, request):
        logout(request)
        name = request.POST.get("name", None)
        password = request.POST.get("password", None)

        if not name and not password:
            return HttpResponse("数据为空")
        user = authenticate(username=name, password=password)

        if user is not None:
            login(request, user)
            is_login, is_admin = auth(request)  //这里是验证是否登录，和权限
            if not is_admin:
                return render(request, "u_userlogin.html")#这个地方是普通用户登录
            print("post已经输出完了")
            userlist = User.objects.all()
            return redirect("showuser")     //这个地方是重定向到 showuser的路由
        else:
            return redirect("login")        
```

然后重定向后的路由(ps.为showuser)如下：
```
class showusers(View):   #展示所有的用户

    def get(self,request):
        is_login, is_admin = auth(request)  //这是引用本页面封装的函数确认登录
        print("已经输出到了这")
        print("is_login的值为：", is_login)
        if not is_login:
            return render(request, "login.html")
        if is_admin:
            userlist = User.objects.all()
            return render(request, "showuser.html", {"uu": userlist})
        return render(request, "login.html")        //用数据渲染前端模板
```

这里的话逻辑就是，登录验证成功了后，重定向到`showuser`函数的路由进入`showuser`，然后用`showuser`函数验证session情况后提取数据然后渲染到前端模板

这样后退的话，只要确认登录状态的话就可以直接提取数据渲染进模板了,==不会弹出重新提交表单的问题==

==一般可以不使用重定向，除非是需要提交数据的地方==

---

### URL跳转漏洞

此漏洞的话则是前端传入参数对应的URL地址，而后端没有进行筛选过滤就直接跳转

```
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<%
    String url = request.getParameter("url");
    // 客户端跳转
    response.sendRedirect(url);
    // META标签跳转:通过设置refresh进行跳转
    response.setHeader("Refresh","1;url="+url);
%>
```

这样的话进行跳转，例如`http://www.xxser.com/?url=http://www.baidu.com/`
这样的话就会直接跳转进百度(ps.一般是通过前面的链接，实际到的却是后面的链接来进行==钓鱼欺骗==)，