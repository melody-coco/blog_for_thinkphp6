简单说，很简单的东西，

t基本就是通过

```js
chrome.notifications,create(op,function(i)		       {console.log(i)})
```

其中op是json格式的数据

```json
var op = {
	type: "basic",
	iconUrl: chrome.extension.getURL("ggp.png"),
	title: "",
	message: ""
}
```



完整实例如下：

```javascript
var options = {
	type: "basic",
	iconUrl: chrome.extension.getURL("ggp.png"),
	title: "",
	message: ""
}

chrome.runtime.onMessage.addListener(function(message,send,response){
	if (message == "create"){
		options.title = "这是来自张某人给你送的新年祝福";
		options.message = "新年好啊,新年好啊";
		chrome.notifications.create(options,function(i){console.log("i的值为"+i)})	//这里是回调函数，返回值
		
	}
})
```

