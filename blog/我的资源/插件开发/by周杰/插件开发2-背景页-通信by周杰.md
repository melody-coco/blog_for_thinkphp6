### 基本配置

```json
{
    "manifest_version": 2,
    "name": "day2插件开发",
    "version": "1.1",
    "description": "这是第二天的描述",
    "content_scripts": [
        {
            "matches": ["<all_urls>"],
            "js": ["js/content.js"],
            "all_frames": true
        }
    ],
    "browser_action": {
        "default_title": "这是popup",
        "default_popup": "popup.html"
    },
    "background": {
        "scripts": ["js/background.js"]
    }
}
```



### 字段说明

+ `background` 背景页配置(**背景页**的作用类似一个后台进程)
  - `scripts` 类型: 数组, 写入背景页文件, 可以是js, 也可以是html(html里面可以引入多个js文件)



### content_script.js 与 background.js通信

+ `js/content_script.js`

```javascript
// 发送消息给 background.js
// 第一个参数, 发送到背景页的数据
// 第二个参数, 后端回传的数据, 匿名函数
chrome.runtime.sendMessage(message, function(result) {
    .....
})
```

+ `js/background.js`

+ ```javascript
  // message 传过来的消息
  // sender 是谁传过来的
  // sendResponse 回传数据给来源页
  chrome.runtime.onMessage.addListener(function(message, sender, sendResponse) {
      console.log(message);
  	// sender 内包含一些信息,其中包含 tab页的数据信息.
      console.log(sender);
      // 回传数据给 数据来源页
      sendResponse("我接收到数据啦    ————来自于bg.js")
  })
  ```



> 配套拓展代码 day2.zip