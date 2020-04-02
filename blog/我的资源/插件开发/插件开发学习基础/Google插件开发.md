> 插件开发，一开始以为会很难，但是看起来难度系数不算太高，还可以应付，

> Google的插件开发主要是使用json来做的

1，首先在一个空文件夹中先新建一个文件夹manifest.json的json格式的文件，文件内容如下：
```
{
    "manifest_version":2,   //这个地方是关于浏览器版本的，必须为int
    "name":"插件标题",
    "version":"2.1",    //这里是自定义的浏览器插件版本
    "icons":{   //插件图标地址
        "16":"this.png",
        "48":"this.png",
        "128":"this.png"
    },
    "description":"这是关于插件的描述",
    "browser_action":{
        "default_popup":"htm.html", //这个地方是鼠标点击插件图标时的弹出的页面，是一个html
        "default_icon":"this.png"
    },
    "content_scripts":[     //内容脚本
    {
        "matches":["<all_urls>"],       //匹配的网站
        "js":["static/name.js"],    //引入js
        "css":["static/nam.css"],   //引入css
        "run_at":"document_end"          //在页面加载完成时进行修改，其他参数有document_start和document_idle
    }
    ]
}
```
js代码如下：
```
// var c = document.getElementsByTagName("p");
// c.innerhtml="这是一条数
console.log("这是数据")
var c = document.getElementsByTagName("a");
console.log("获取到的元素个数为"+c.length);
for(var v = 0;v<c.length;v++){
    console.log("这是x的数据为:"+v);
    c[v].innerHTML="插件修改的数据";
    // v.innerHTML="这是我的数据";
}
```

css代码如下：
```
div{
    outline-color:black;
    border: 1px red solid;
    /* background-color: black; */
}
p{
    font-size: 10px;
    color: brown;
}
```

htm.html代码如下：
```
<html>

    <head>

    </head>
    <meta name="keywords" charset="utf-8">
    <body>
        这是一条内容
    </body>
</html>
```
![image](D:/python/test%E6%8F%92%E4%BB%B6/test/%E8%B7%AF%E5%BE%84%E6%88%AA%E5%9B%BE.png)