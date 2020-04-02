==SQL 是用于访问和处理数据库的标准的计算机语言。==



#### 一，简单用法

##### 1.0 select

&emsp;select 列名 from 表名
```
select * from UserList  //*表示全部
select firstName,lastName from Userlist 
//返回的只有所有数据的firstName和lastName
```
##### 1.1 distinct
​	 表示同样的重复值只取一个

​	`		select DISTINCT username from userlist`

​	有两个张三的话也只会返回一个张三

##### 1.2 where

​	where子句用于规定选择的标准，这样

​	

| 操作符  | 描述                |
| ------- | ------------------- |
| =d      | 等于                |
| <>      | 不等于(ps.相当于!=) |
| >       | 大于                |
| <       | 小于                |
| >=      | 大于等于            |
| <=      | 小于等于            |
| between | 在某个范围内        |
| like    | 搜索某种模式        |

​	例如:

​	`select * from userlist where age > 18`



##### 1.3 and 和 or

 	and 和 or 就不用说了吧。

​	 例子:

```mysql
SELECT * FROM Persons WHERE (FirstName='Thomas' OR FirstName='William')AND LastName='Carter'
```



##### 1.4 order by (ps.降序desc)

​	<u>根据指定的列对结果集进行排序</u>

​	例如：

​	`select * from userlist order by username,id`

​	降序的话用`desc`关键字

​	例如：

​	`select * from userlist order by 1 desc` 

​					`1`表示第一个列



##### 1.5 insert

​	**insert into 语句用于向表格中插入新的行**

​	用法：

​		insert into 表名 values (值1，值2，……)  `要传id值`

​		或者：

​		insert into 表名(列1，列2……) values(值1，值2，……)



##### 1.6 update

​	用法：

​	`update 表名 set 列名 = 新值,列名 = 新值 where 列名 = 某值 `



##### 1.7 delete

​	用法：

​	`delete from 表名 where 列名  = 值`

​	删除所有行(ps.不删除表)：

​	`delete from 表名` 

​	

