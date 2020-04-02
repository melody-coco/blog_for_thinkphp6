(ps.一般是登录过滤用)xss

#### 1，表单调用javascript
通过表单属性的onsubmit可以调用
```
<script>
function hanshu(){
    k = document.forms.["myforms"]["name"].value  //切记这里的是forms不是form
    if(k<10){
        alert("数字必须小于10");
        return false;
    }
}
</script>
<form name="myforms" action="" method="post" onsubmit="return hanshu()"> //这里的onsubmit="return hanshu()"调用了hanshu函数
 <input type="text" name="name">
 <input type="submit" value="提交按钮">
</form>
```
这里的form中的`onsunmit`里面有一个retuen表示如果后面函数返回了false的话就不会执行form的提交

#### 2，javascript调用表单
##### 2.1，
上文中的`document.form["myforms"]["name"].value`就调用了myforms表单的值

##### 2.2，
也可以不使用form，直接用`input`标签，再通过getElementById()获取
```
<input id="jj" type="text">

<script>
g = document.getElementById("jj").value
</script>
```