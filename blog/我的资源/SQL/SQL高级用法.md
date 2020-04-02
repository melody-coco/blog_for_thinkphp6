<center>稍微高级的用法</center>
（ps.Mysql关键字不区分大小写）



### 一 ，小知识点

#### 1.1	top 子句

​	top 子句用于规定要返回的记录条数

​	(ps.并非所有的数据库系统都支持TOP 子句)

​	mysql用不了top

​	

​	SQL server的语法：

```
select top number|percent column_name(s) from table_name	
```

​	Mysql语法：

```
select column_name(s) from table_name limit number

例子：
select * from app1_admin  limit 3,1;
```



​	Oracle语法：

```
SELECT column_name(s)
FROM table_name
WHERE ROWNUM <= number

例子：

SELECT *
FROM Persons
WHERE ROWNUM <= 5
```



​	SQL  TOP 实例

​		从表的上面选取两条数据

​		`select top 2 * from 表名`

​	

​	SQL TOP PERCENT 实例

​		从表的上面选取50%的记录 

​		`select top 50 percent * from 表名`



#### 1.2	like

​	LIKE 操作符用于在 WHERE 子句中搜索列中的指定模式。

​	

​	简单用法如下：

```mysql
select * from table_name where username like jj;
```

​	

​	like一般会搭配通配符使用：

```
select * from userlist where username like "k%"
```

​	上面是查询所有的名字里以k开头的数据



#### 1.3	通配符



| 通配符                   | 描述                       |
| ------------------------ | -------------------------- |
| %                        | 代替一个或多个字符         |
| _（ps.下划线）           | 仅代替一个字符             |
| [charlist]               | 字符列中的任何单一字节     |
| [^charlist]或[!charlist] | 不在字符列中的任何单一字节 |

​		（ps.[charlist]这种不能用于mysql）

​	使用%通配符：

​		例一：

```
select * from userlist where username like "Me%";
//查询所有username以Me开头的数据
```

​		例二：

```
select * from userlsit where username like "%lo%";
//查询所有username中包含lo的数据
```

​	

​	使用_通配符:

```
select * from userlist where username like "_elody";
//查询所有数据usernname中第一个字符后是elody的数据
```

​		

​	使用[charlist]和[!charlist]：

```
select * from userlist where username like "[dabf]%"
//查询所有数据，username中以d，a，b，f开头的数据
select * from userlist where username like "[!fc]%";
//查询所有数据，username中不是以f或c开头的数据
```



#### 1.4	in

​	IN 操作符允许我们在 WHERE 子句中规定多个值。

​	

​	语法:

```
select * from userlist where username in ("lisa","melody");
//查询所有的数据,username为lisa或者melody的数据
```

​	

#### 1.5	between……and

​	between……and操作符在where子句中使用，作用是选取介于两个值之间的数据范围(ps.数值，文本，日期)



​	语法：

```
select * from userlist where username between "a" and "z";
//查询所有的数据，username介于a和z之间的数据
```

​	例如：

| username | password |
| -------- | -------- |
| admin    | admin    |
| a        | a        |
| c        | c        |
| t        | t        |

```mysql
select * from userlit where username between "admin" and "c";
//这里返回的数据为在数据库中在admin和c之间的数据，不包括c
```

​	结果为admin,a

​	(ps.不同的数据库对 BETWEEN...AND 操作符的处理方式是有差异的。某些数据库会列出介于 "admin" 和 "c" 之间的人，但不包括 "admin" 和 "c" ；某些数据库会列出介于 "admin" 和 "c" 之间并包括 "admin" 和 "c" 的人；而另一些数据库会列出介于 "admin" 和 "c" 之间的人，包括 "admin" ，但不包括 "c" 。)。

​	mysql会返回包括admin和c,

​	**mysql。between英文单词文本的时候只会识别首字母来between，就相当于between "a“ and "z"**

​	

​	如果要选between范围之外的，使用NOT操作符。

```
select * from userlist where username not between "a" and "z";
//返回的数据为a到z范围之外的数据
```



#### 1.6	Alias

​	通过使用SQL，可以为列名称和表名称指定别名(Alias)

​	

表的SQL Alias语法：

```
select username from userlist as studentlist;
```



列的SQL Alias语法：

```mysql
select username as name from userlist;
```



表的SQL别名好处是可以写的短一点：

```mysql
select user.username,user.password,book.user_id from auth_user as user right join app1_subscribe as book on user.id=book.user_id;
```



列的好处是，返回的可以显示的是别名：

```mysql
select id as a,book_id as b, user_id as c from app1_subscribe;
```

返回的结果如下：

| a    | b    | c    |
| ---- | ---- | ---- |
| 1    | 1    | 4    |
| 2    | 2    | 4    |
| 3    | 1    | 4    |
| 4    | 2    | 4    |





#### 1.7	 Join

​	内连接（ps.通过外键查询）

​	通过引用两个表，从两个表中获取数据：

​	表一：

​	|||

| id   | book_id | user_id |
| ---- | ------- | ------- |
| 1    | 1       | 4       |
| 2    | 2       | 4       |
| 3    | 1       | 4       |
| 4    | 2       | 5       |
| 5    | 1       | 3       |

表二：



| id   | username | password |
| ---- | -------- | -------- |
| 1    | admin    | admin    |
| 2    | admins   | admins   |
| 3    | root     | root     |
| 4    | wwe      | wwe      |

`select auth_user.username,auth_user.password,app1_subscribe.user_id from auth_user,app1_subscribe where auth_user.id=app1_subscribe.user_id`  

结果为：

|||

| username | password | user_id |
| -------- | -------- | ------- |
| root     | root     | 3       |
| wwe      | wwe      | 4       |
| wwe      | wwe      | 4       |
| wwe      | wwe      | 4       |
| wwe      | wwe      | 4       |



这里我查询两个表，返回的数据整合为结果集，并且按照书的他们的外键



查询到的所有结果返回成一个结果集，两个表如果其中一个表没加条件的话，就会乱。如果两个表都没加条件就会乱的一匹

`join`的作用大致也是这样

```mysql
select auth_user.username,auth_user.password,app1_subscribe.user_id from auth_user inner join app1_subscribe on auth_user.id=app1_subscribe.user_id
```





- JOIN: 如果表中有至少一个匹配，则返回行

- <a id="left_joiin"></a>  LEFT JOIN: 即使右表中没有匹配，也从左表返回所有的行


  ​	ps.从左表(join的左边)中返回所有的行，即使在右表中没有匹配的行

- <div id="right_join">RIGHT JOIN: 即使左表中没有匹配，也从右表返回所有的行

  ​	ps.从右表(join的右边)中返回所有行，即使在右表中没有匹配的行</div>

- FULL JOIN: 只要其中一个表中存在匹配，就返回行



#### 1.8	inner join

​	inner join和join是相同的就像上面的实例一样我用的不是join 而是inner join 

​	

#### 1.9	[left  join](#left_joiin)

​		上面的`join`中有讲

​		还是在这讲一下

​		借用join中的两个表输出下面:

```mysql
select user.username,user.password,book.user_id from auth_user as user left join app1_subscribe as book on user.id=book.user_id;
```

返回的结果和上面`join`中的结果不同(ps.查的都是同样的两张表)：

| username | passoword | user_id |
| -------- | --------- | ------- |
| root     | root      | 3       |
| wwe      | wwe       | 4       |
| wwe      | wwe       | 4       |
| wwe      | wwe       | 4       |
| a        | a         | NULL    |
| c        | c         | NULL    |
| z        | z         | NULL    |

除了查到的结果外，还返会了左表中所有的数据



#### 1.11	Right join

​		在上面的`join`中有，自己去看



#### 1.12	Full join

​		只要其中某个表存在匹配，FULL JOIN关键字就会返回行

```mysql
select user.username,user.password,book.user_id from auth_user as user fulljoin app1_subscribe as book on user.id=book.user_id;

```

​		返回的是：所有行，如果左表中的行，在右表中没有匹配，或者右表的行在左表没有匹配，同样会全部列出

​		ps. Mysql不能用full join，只能以下面的方式进行类似的操作：

```mysql
mysql> select * from t1 left join t2 on t1.id = t2.id
    -> union 
    -> select * from t1 right join t2 on t1.id = t2.id;
```

​	

#### 1.13	Union

​	Union操作符用于合并两个或多个SELECT语句的结果集

​	注意！	Union 两边的select语句必须拥有相同数量的列，

```mysql
SELECT column_name(s) FROM table_name1 UNION
SELECT column_name(s) FROM table_name2
```

​		

​		Union all和Union的区别：

​		两者的区别为，Union如果union前后的数据是有一样的时候，只会返回一个（也就是distinct的取唯一值）

​		Union all的话则会返回所有的数据



#### 1.14	select ino

​				ps.	Mysql用不了`select into`只能用`create table newtable(select* from oldtable)`

把旧表的数据全部装入新表

```mysql
SELECT * INTO new_table_name [IN externaldatabase] 
FROM old_tablename
```



也可以把旧表中的其中一列装入新表：

```mysql
select username,password into newtable from oldtable;
```



select into 带where 子句：

```mysql
select username,password into newtable from oldtable where age>30;	//查询所有的age大于30 的名字，密码
```

​	

select into 被连接的表：

```mysql
select username,password,bookname into newtable from
usertable join booklist on bookman_id=user_id;
```



#### 1.15	Drop

​		删除索引不同的数据库语法不一样，详情点[这里](https://www.w3school.com.cn/sql/sql_drop.asp)



​		删除操作：

```mysql
//删除表
drop table tableName
//删除数据库
drop database database_Name
```



​		删除表的数据，不删除表本身：

```mysql
truncate table tableName
```



#### 1.16	alter

​				ps.有些数据库不支持这个

​	alter table语句用于在已有的表中添加，修改列

​	

​	添加列：

```mysql
alter table tableName
add columnName datatype
```

​	删除列：

```mysql
alter table table_name
drop column columnName
```

​	修改列：

```mysql
alter table tableNzme
alter column column_Name datatype
```





#### 1.17	aotu increment

​				ps.自动递增

不同的数据库支持不通的自动递增的关键字，详情点[这里](https://www.w3school.com.cn/sql/sql_autoincrement.asp)





#### 1.18	view

​		视图类似于一个真实的表，视图中的字段来自一个或者多个数据库中真实的表中的字段，我们可以向视图添加SQL函数，where以及join语句

​		简单说，就像是一个虚表。由实表table中的数据填充而来，也会因为table中的数据改变而改变。

​		作用为，不让用户的到真实的数据，不让用户直接访问数据库

​		视图只能通过查询表的数据来建立

​		create view:

```mysql
create view viewName as
select * from tableName		//后面加的就是正常的查询语句
```

​		

​		查询view :

```mysql
select * from viewName;		//就像正常的查询一样
						//这只是在mysql中，其他没试过
```



​		删除view:

```mysql
drop view viewName
```



​	修改视图：

```mysql
create or replace view viewName as
select name from test3;		//这里修改表到只有一个字段
```





#### 1.19	date

​		这里不对处理时间的函数做描述，详情点击[这里](https://www.w3school.com.cn/sql/sql_dates.asp)



#### 1.20	null 和 is not null

​		这个东西很简单就是空啊，

​		当字段没有设定`not null`时，数据可以为null (空)。
​	

​		而`is not null`则是一般用于`where`子句，例如：

```mysql
select * from test where city is not null;
```



#### 1.21	isnull()函数

​			多的不说，详情点击[这里](https://www.w3school.com.cn/sql/sql_isnull.asp)

​			简单说，就是当数据为空时，使用`isnull()`函数来，替换`null`（ps.一般用来代替null）

​			语法:	

​						mysql语法如下（其他的自己找）:

```mysql
select username,password,ifnull(last_login,'无') from user;
```

​	

#### 1.22	数据类型datatype

​		不同的数据库有不同的数据类型，这里不作描述，详情点击[这里](https://www.w3school.com.cn/sql/sql_datatypes.asp)



#### 1.23	RDBMS，SQL服务器

​		详情点击[这里](https://www.w3school.com.cn/sql/sql_server.asp)或者取网上看，这里不做论述

#### 1.24	distinct

此函数的作用为：对返回的结果集进行去重



简单实例：

```
select distinct table_schema from information_schema.tables;
```



注意，只有`distinct`后面跟的字段，数据完全相同才会去重。

​	例如：

```
select distinct id,name from user;
					#只有id和name都一样的数据才会进行去重
```

