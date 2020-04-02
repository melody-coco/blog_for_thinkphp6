### 相关配置
#### (ps.有什么不懂得可以在我的插件`test-tabs`中查看)

```json
{
    "manifest_version": 2,
    "name": "day3-02插件开发-tabs",
    "version": "1.1",
    "description": "这是第三天的描述",
    "browser_action": {
        "default_title": "这是popup",
        "default_popup": "popup.html"
    },
    "background": {
        "scripts": ["js/bg.js"]
    },
    "permissions": [
        "<all_urls>",
        "tabs"
    ]
}
```



### `chrome.tabs.*`  [官方文档](<https://developer.chrome.com/extensions/tabs>)

> 可以用来对标签页进行 创建/修改/移动/注入脚本等操作



### 部分常用方法说明

+ `chrome.tabs.create(object createProperties, function callback)`

  > 创建标签页

  + `createProperties` 类型: 对象
    - `index`, 类型: 整型. 指定标签页顺序位置.
    - `url`, 类型: 字符串.指定标签页的url地址
    - `active`, 类型: 布尔. 指定当前标签页是否是选中状态

+ `chrome.tabs.query(object queryInfo, function callback)`
+ 实例如下

```
chrome.tabs.create({
            index:0,    //该参数的作用为创建新的页面时，新页面出现的索引，这里是在最前面创建
            active:false,   //该参数的含义是是否选中，新页面创建时不切换到这个标签页面来
            url:"https://www.baidu.com"
        })
```

  > 查询标签页

  - `queryInfo `类型: 对象
    - `active`. 类型: 布尔. 标签页状态
    - `title`. 类型: 字符串. 标签页标题
    - `url`. 类型: 字符串. 标签页url链接
  - `callback(tabs)`
    - `tabs` 类型: 数组.返回符合查询条件的tab结果集.

+ `chrome.tabs.update(integer tabId, object updateProperties, function callback)`
+ 实例如下
```
chrome.tabs.query({
            url:"https://www.baidu.com/"    //地址，查询的地址
        }, function(tabs){
            console.log(tabs)
        })
```

  > 更新指定标签页状态

  - `tabId` 类型: 整型. 指定一个具体的标签页id.
  - `updateProperties` 类型: 对象
    - `url`
    - `active`

+ `chrome.tabs.executeScript(integer tabId, object details, function callback)`
+ 实例如下
```
chrome.tabs.update(460,{        //该参数作用是id，更新的标签的id，更新为百度
            url:"https://www.baidu.com/"
        })
```

  > 注入 js 代码

  - `tabId` 指定一个标签页id
  - `details` 类型: 对象
    - `code` 注入的js代码
    - `file` 注入的js文件
    - `allFrames` 类型: 布尔 是否注入到所有框架
    - `runAt` 何时注入. `document_end`/`document_start`/`document_idle`

+ `chrome.tabs.insertCSS(integer tabId, object details, function callback)`

  > 注入 css 代码

  - `tabId` 指定一个标签页id
  - `details` 类型: 对象
    - `code` 注入的css代码
    - `file` 注入的css文件
    - `allFrames` 类型: 布尔 是否注入到所有框架
    - `runAt` 何时注入. `document_end`/`document_start`/`document_idle
+ 实例如下
```
chrome.tabs.query({
            active:true            //查询当前的标签
        },function(tabs){
            var x = tabs[0].id;
            alert(x)
            chrome.tabs.insertCSS(x,{   //id为先前所有查询到的标签,然后进行插入css
                
                file:"static/css.css"
            })
        })
```
