
==保存数据==
#### 1，在background.js中
```
var setting = JSON.parse(localStorage.getItem(setting)) || {
    open:true
}       //这个是获取的缓存中的数据setting

var savesetting = function(){
    localStorage.setItem("setting",json.stringify(setting))
}       //这个是设置缓存setItem的setting方法
```

保存数据到缓存的话，只能保存（键值对）字符串，不能存对象

#### 2,在popup.js中
```
var BGPage = chrome.extension.getBackgroundPage();      //这个作用是获取background的所有的变量，赋值为BGPage
var setting = BGPage.setting;       //这里使用了background的变量setting

BGPage.savesetting()            //这里使用了background.js的savesetting函数
```