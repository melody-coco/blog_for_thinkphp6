### 一，新增主要的键

	####  	1，computed

（ps.这个不是函数）

​	翻译为计算，主要用于一些前端的计算工作，

```vue
<body>
    <div id="div1">
    {{ test }}
    </div>
</body>
<script>
new Vue({
    el:"#div1",
    data:{
        number_1:"数据一"
    },
    computed:{
        test:function(){
            return this.number_1+55
        }
    }
})
</script>
```



#### 2，watch

​	侦听器

```vue
<div id="div2">
    {{ datatest }}
    <input type="text" v-model="value1" />
</div>
<script>
new Vue({
    el:"#div2",
    data:{
        datatest:"",
        value1:""
    },
    watch:{
        value1(shudu){
            console.log(shudu)  //shudu为value1的值
            this.datatest = this.watch
        }
    }
})
</script>
```

