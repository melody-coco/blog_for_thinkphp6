#### 1，JSON实例:
```
{"shuju":[
    {"name":"jack","age":"18"},
    {"name":"mick","age":"20"},
    {"name":"bill","age":"19"}
]}
```
#### 2,JSON字符串转换为JavaScript对象
```
var text = '{"shuju":['+
    '{"name":"jack","age":"18"},'+
    '{"name":"mick","age":"20"},'+
    '{"name":"bill","age":"19"} ]}',
obj = JSON.parse(text);
document.write(obj.shuju.[0].name+" 现在"+obj.shuju.[0].age+"岁");
```

相关函数
函数|	描述
--|--
JSON.parse()|	用于将一个 JSON 字符串转换为 JavaScript 对象。
JSON.stringify()|	用于将 JavaScript 值转换为 JSON 字符串。




---
### 前端传json数据回后端
(ps.Java springmvc实现)
### 1.要完成JSON格式上传数据,首先呢我们要导入一个jackson的包，导在pom文件
```
 <dependency>
     <groupId>com.fasterxml.jackson.core</groupId>
     <artifactId>jackson-databind</artifactId> 
     <version>2.9.0</version>        
 </dependency>
 <dependency>            
     <groupId>com.fasterxml.jackson.core</groupId>
     <artifactId>jackson-core</artifactId>     
     <version>2.9.0</version>       
 </dependency>        
 <dependency>            
     <groupId>com.fasterxml.jackson.core</groupId> 
     <artifactId>jackson-annotations</artifactId>  
     <version>2.9.0</version>
</dependency>
```

### 2.index.jsp页面实例
#### 记住要先导入jquery导在webapp -> js
#### 然后再SpringMVC.xml里写入过滤静态资源
```
 <!--    哪些静态资源不拦截-->
    <mvc:resources mapping="/js/**" location="/js/"/>
```
```
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<html>
<head>
    <title>Title</title>
</head>

<script src="js/jquery.min.js"></script>

<script>
    // 页面加载，绑定单击事件
    $(function(){
        $("#btn").click(function(){
            alert("hello btn");
            // 发送ajax请求
            $.ajax({
                //编写Json格式，设置属性和值
                url:"test/testJson",
                contentType:"application/json;charset=UTF-8",//通过json格式传过去
                data:JSON.stringify({

                    "uname":$("[name=uname]").val(),
                    "pwd":$("[name=pwd]").val()

                }),
                dataType:"json",//通过json格式传过去
                type:"post",
                success:function (data) {
                    //data服务器响应的json的数据，进行解析
                    alert(data.uname);
                    alert(data.pwd);
                }
            });

        });
    });

</script>
<body>
    <form>
        用户名：<input type="text" name="uname"/>
        密码：<input type="text" name="pwd"/>
        <input type="button" id = "btn" value="登录">
    </form>

</body>
</html>
```
### 3.Controller的编写
**这里在JSON对象前加入了一个@ResponseBody用来反应json数据，还需要再传入的类之前加入@RequestBody 用来获取json数据**
```
@RequestMapping("/testJson")
    public @ResponseBody User testJson(@RequestBody User user){
        System.out.println("测试成功");
        return user;
    }
```

这样，当我们点击登录，就能获取到uname 和 pwd的值了，也就上传成功