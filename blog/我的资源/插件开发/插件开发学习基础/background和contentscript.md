#### 1，首先在manifest页面添加，如下：
```
"content_script":[
    {
    "matches":["all_urls"],
    "js":["static/test.js"],
    "css":["static/test.css"],
    "all_frames":true;
    "run_at":"document_end"
}
],
"background":{
    "script":["static/background.js"]
},
"permissions":[
    "contextMenus"
]
```

> contentscript和background通信的问题

#### 2,contentscript页面如下：
```
var x = document.getElementsByTagName("title")[0].innerText
console.log(x)
chrome.runtime.sendMessage(x,function(result){      //通过这个函数的话，就可以传数据到后台background
    console.log("这里是回调函数");
    console.log("通过background返回的数据为："+result);
})
```

#### 3，background页面如下：
```
//message是传过来的内容
//sender是发送者，
//sendResponse是回调的方法，把数据回调去发给 发送者
chrome.runtime.onMessage.addListener(function(message,sender,serndResponse){
    console.log("前台传过来的数据为"+message);
    console.log("sender的数据为:"+sender);
    serndResponse("我已经接收到数据了,,,,写这段话的是后台background")
})
```

---
### 实现右键翻译
直接贴在background
```
chrome.contextMenus.create({
    id:"rooty",
    contexts:["selection"],
    type:"normal",
    title:"翻译数据分割线",
    onclick:function(info){
        var text = info.selectionText;
        // alert(text);
        http("http://fanyi.youdao.com/translate?&doctype=json&type=AUTO&i="+text,function(data){
        // var c =data["translateResult"][0][0]["tgt"];
        var c = JSON.parse(data);
        alert("翻译为"+c["translateResult"][0][0]["tgt"]);
        })
    }
})

function http(url, callback) {      //函数用来进行ajax请求
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            callback(xhr.responseText);
        }
    }
    xhr.send();
}
```