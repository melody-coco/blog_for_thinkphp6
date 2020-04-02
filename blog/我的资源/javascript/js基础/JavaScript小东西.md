#### 1，
```
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>菜鸟教程(runoob.com)</title>
</head>
<body>

<p id="p1">你的名字</p>
<p id="p2">Hello World!</p>
	<button type="button" onclick="hanshu()">按钮</button>
<script>
var x = document.getElementById("p1");
	x.style.fontFamily="Arial";
	x.style.fontSize="larger";
	var y = ["red","blue","green"];
	function han(){
	var i=0;
		function k(){
			var x = y[i];
			console.log("y的值为"+y);
			i+=1;
			if(i==3){
			   i=0;
			   }
			console.log("x的值为"+x);
			
			return x;
		}
		return k;
	}
	var z= han();
	function hanshu(){
		console.log("开始执行");
	x.style.color=z();
	}
</script>
<p>以上段落通过脚本修改。</p>

</body>
</html>
```