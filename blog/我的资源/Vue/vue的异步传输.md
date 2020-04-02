### 一， axios

​	首先导入axios的js文件，

​	vue通过axios来，进行异步传输

代码如下：

```
axios.get("http://192.168.1.114:8000/user/seller/")				//这个是get请求
			.then(function(response){
				if (response.status == 200){
					console.log(response.data.data)
				}
			})
		axios.post("http://192.168.1.114:8000/user/login/","username=loid002&password=loid002",).then(function(message){	//这个是post请求
			console.log(message.data.message)
		})
		
//请求连接后面跟回调函数
```

	#### 1.1 注意点

```vue
//mounted页面初始化方法
<script>
    var instance = axios.create({
			baseURL:'http://192.168.1.114:8000',
			timeout:1000,
		}); 		//把连接封装 到一个方法里面
    
new Vue({
    el:"#div1",
    data:{
        data1:"",
        datalist:[]
    },
    mounted(){
       instance.get("/user/seller/")
        .then(message =>{		//！！！ 这个地方之所以用箭头函数是为了下面的this指向的依然是vue对象而不是函数本身，不然会出bug
           this.tablelist = this.message.data.data	
           console.log(message)
       })
    }
})
</script>
```

