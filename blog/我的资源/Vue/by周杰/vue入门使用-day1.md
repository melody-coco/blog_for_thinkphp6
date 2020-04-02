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
