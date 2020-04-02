#### 1,创建cookie
document.cookie="name=jack";

cookie默认的是关闭页面的时候清除，但更多的是为cookie设置一个过期时间：

#### 2,为cookie设置过期时间
```
var day = new Date();新建一个时间对象
day.setTime(day.getTime()+24*60*60*1000);//设置一个以毫秒为单位的时间，这里的时间是24小时
var expires = "expires="+day.toGMTString();这里把时间转换成国际通用时间；
document.cookie="name=jack;"+expires;
```

#### 3，设置cookie的函数
```
function setcookie(cname,cvalue,exdays=1){
    var d = new Date();
    d.setTime(d.getTime()+(exdays*24*60*60*1000));
    var expires = "expires="+d.toGMTString();
    document.cookie=cname+"="+cvalue+";"+expires;
}
```
    
#### 4,获取cookie的函数
```
function getcookie(cname){
    var name = cname+"="; //cname是cookie里的键
    var lists = document.cookiesplit(";");//把所有的cookie装换成字符串装进变量lists中
    for (var i=0;i<lists.length;i++){//遍历整个数组
        var c = lists[i].trim();
        if(c.indexof(name)==0){return c.subtring(name.length,c.length)}//判断找到要求找到的cookie并且返回键对应的值
        
    }
    return "";
}
```

#### 5,检测cookie的函数
```
function checkcookie(){
    var username = getcookie("username");
    if(username!=null && username!=""){
        alert("欢迎你，"+username)
        
    }
    else{
        username = prompt("请输入你的名字");
        if(username!=null && username != ""){
            setcookie("username",username,1);
        }
    }
    
}
```

### <center>完整实例</center>
```
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>菜鸟教程(runoob.com)</title>
</head>
<head>
<script>
function setCookie(cname,cvalue,exdays){
	var d = new Date();
	d.setTime(d.getTime()+(exdays*24*60*60*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname+"="+cvalue+"; "+expires;
}
function getCookie(cname){
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i].trim();
		if (c.indexOf(name)==0) { return c.substring(name.length,c.length); }
	}
	return "";
}
function checkCookie(){
	var user=getCookie("username");
	if (user!=""){
		alert("欢迎 " + user + " 再次访问");
	}
	else {
		user = prompt("请输入你的名字:","");
  		if (user!="" && user!=null){
    		setCookie("username",user,30);
    	}
	}
}
</script>
</head>
	
<body onload="checkCookie()"></body>
	
</html>
```