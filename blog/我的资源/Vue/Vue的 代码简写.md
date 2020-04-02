#### 1，Vue的元素绑定事件关键字

① v-on

简写为@，


元素绑定事件,
例如
```
    <button v-on:click="函数名">点击事件</button>   
    <button @click="函数名">点击事件</button>
    //还可以写其他的事件mouseup等
```

② v-if
    
判断元素是否显示

例如:
```

<div v-if="age > 18">       //在这种Vue的语法里""里面的值不一定就是string
    我成年了
</div>
<div v-else>
    我是未成年
</div>

<div v-if="ss">
    显示
</div>

data:{
    ss:true
}
```

③ v-for 

循环输出元素

例如：
```
<table>
    <tr v-for="x in tablelist">
        <td>{{ x.id }}</td>
        <td>{{ x.name }}</td>
        <td>{{ x.age }}</td>
    </tr>
</table>

data:{
    tablelist:[
    {
        id:1,
        name:"张",
        age:15
    }
    {
        id:2,
        name:"王",
        age:22
    }
    ]
}
```

④ v-model

元素和数据双向绑定

```
{{ form.name }}:
<input type="text" v-model="form.username"/>
<input type="text" v-model="form.password" />

data:{
    form:{
        username:"",
        password:""
    }
}
````

⑤ v-bind

简写:

绑定属性

```
<style>
    
</style>
<div v-bind:class="myClass">
显示
</div>
.pink{
    background-color:pink;
}
data:{
    myClass:"pink"
}
```

⑥ v-show

这个和v-if比较像，区别是v-show的话创建节点而不显示，v-if不创建