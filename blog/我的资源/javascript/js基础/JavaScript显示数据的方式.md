### 1,使用windows.alert()弹出警告框(ps.就相当于alert())

### 2，使用document.write()方法将内容写到HTML文档中

### 3，使用innerHTML写入到HTML元素中

### 4，受用console.log()写入到浏览器的控制台中

### 5,confirm()，确认框
和alert的弹出警告框相似的`confirm`是弹出一个确认框
```
function my(){
	var oo = confirm("跳出一个警告框");
	if (oo==true){
		document.write("你选择了确定");
		}else{
		document.write("你选择了拒绝");
		}
}
```

### 6，`prompt()`提示输出框
和上面的`confirm`确认框的作用差不多
```
var oo = prompt("输入你的名字","momo");
	if(oo!=null && oo!=""){
	   document.write(oo+"你好啊");
	   }else{
	   alert("你必须写入你的名子");
	   }
```