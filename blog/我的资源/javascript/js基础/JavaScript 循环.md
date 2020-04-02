#### 1,普通的for循环

```
for (var i = 0;i<10;i++){
    document.write(i)
}
```


#### 2,for/in循环

```
var i = [1,2,3,4,5]
for (x in i){
    document.write(i[x])这里for in 遍历的是脚标而不是实际的值
}
```

#### 3,while循环
while循环还是那个正常的while循环,do……while也是
```
var i = [1,2,3,4,6]
var y = 0
while(i[y]){
    document.write(i[y])
    y++
}
```

#### 4,JavaScript break和continue语句
这里break和continue和其他的是一样的