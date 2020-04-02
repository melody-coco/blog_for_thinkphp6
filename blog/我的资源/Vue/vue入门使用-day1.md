### Vue 入门

#### 准备工作
+ 引入`Vue.js`
+ 测试代码
```javascript
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>标题</title>
		<script src="./js/vue.js"></script>
	</head>
	<body>
		<div id="app">
			{{ message }}
		</div>
		
		 <script>
			 new Vue({
				 el: "#app",
				 data: {
					 message: "helloworld",
				 }
			 });
		 </script>
	</body>
</html>
```


#### 几个主要的键
+ `el`, 用来指定Vue元素的范围
+ `data`, 用来定义属性
+ `methods`, 用来定义方法

#### 几个指令
+ `v-on` 绑定事件 (简写: `@xxx`)
	- `v-on:click` 绑定点击事件 (简写: `@click`)
	- `v-on:mouseover` 绑定鼠标mouseover事件 (简写: `@mouseover`)

+ `v-if` 条件语句, `v-if`里面的条件为 `true`的时候, 里面的元素才会被显示
+ `v-else` 这个都懂
+ `v-for` 循环语句

```html
dataList: [
	"姓名", "班级", "学号"
]
// 循环赋值(增强for)
<li v-for="item in dataList">
	{{ item }}
</li>

// 获取数组下标
<li v-for="(item, index) in dataList">
	{{index}} {{ item }}
</li>
```

+ `v-bind` 属性绑定(简写: `:xxx`, 比如`v-bind:class`等价于`:class`)

```html
.pink {
	background-color: pink;
}

<span :class="className">hahahaha</span>

new Vue({
	el: "#app",
	data: {
		className: "pink"
	}
);

```
+ `v-model` 双向数据绑定

```javascript
// 这时候输入的数据会赋值给 name 然后 {{name}}里面的name也会变化
{{name}}
<input type="text" v-model="name">
			
			
new Vue({
	el: "#app",
	data: {
		name: "默认数据"
	},
	methods: {
	
	}
);
```


#### 操作元素
+ 对`dataList`进行操作
```javascript
// 创建一个方法 addData()
methods: {
	addData() {
		// this 是代表当前对象
		// this.dataList 可以访问到Vue data里面的数据
		this.dataList.push("新增数据")
	}
}
```

---

（ps.上面的是周杰写的，下面是我自己添的）

==想要修改data中的数据的话必须用到this关键字，==

#### 通过双向绑定来控制form
```
//这种方法的话貌似是不需要写form的，直接写input

<input type="text" v-model="form.username" />
<input type="text" v-model="form.password"  />
<script>
    ……
    data:{
        form:{          //这里的绑定可以不写form可以写其他的，因为这里的form只是键
            username:"",
            passwoed:""
        }
    }
</script>
```

---

以下是day1实例（ps.可以不用看）
```
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<script src="vue.js"></script>
	</head>
<style>
        .pink{
            background-color: pink;
        }
    </style>
    <script src="vue.js"></script>
    <body>
        <div id="app">
                {{ message }}
                {{ aaa }}
                {{ ccc }}
                <button v-on:click="hellow()">点击</button>
                <button @click="hellow2">点击er</button>
                <button @click="ifc =!ifc">显示</button>
                <div v-if="ifc">
                    我被现实了
                </div>
                <br>
                <div v-if="age > 18">
                    我成年了
                </div>
                <div v-else>
                    我是未成年
                </div>
                <button @click="addData">增加</button>
                <button @click="subData">减少数据</button>
                <li v-for=" (x,index) in datalist">
                    {{ index }} :   {{ x }}
                    <br>
                </li>
                {{ Name1 }}
                <input type="text" v-model="Name1">  <!-- 这里的话，通过v-model绑定了属性Name1，这样的话Name1的值会被输入框的值替换 -->

                <input type="text" v-model="form.username">
                <input type="text" v-model="form.password">
                <button @click="login()">提交</button>

                <div>
                    <span :class="className">第一</span>
                    <span v-bind:class="className">第二</span>
                </div>
				<div>
					<table>
						<tr>
							<th>id</th>
							<th>姓名</th>
							<th>年纪</th>
						</tr>
						<tr v-for="x in tablelist">
							<th>{{ x.id }}</th>
							<th>{{ x.name }}</th>
							<th>{{ x.age }}</th>
						</tr>
					</table>
				</div>
        </div>
    </body>
    <script>
    new Vue({
        el:"#app",
        data: {
            message:"hellowword这是",
            aaa:"这是第二条消息",
            ccc:"<br>",
            ifc:true,
            age:20,
            datalist:["a","b","c","d","e","f"],
            Name1:"默认名",
            form:{
                username:"",
                password:""
            },
            className:"pink",
			tablelist:[
				{
					id:1,
					name:"张",
					age:13
				},
				{
					id:2,
					name:"里",
					age:22
				},
				{
					id:3,
					name:"网",
					age:36
				}
			]
        },
        methods:{
            hellow(){
                console.log("我的方法输出的内容")
            },
            hellow2(){
                console.log("我的输出2  @")
            },
            addData(){
                this.datalist.push("新的数据s")
            },
            subData(){
                this.datalist.pop()
            },
            login(){
                console.log(this.form)
            }
        }
    });
    </script>
</html>

```
