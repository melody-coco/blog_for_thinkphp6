
#### 1,
由 SQL 查询程序获得的结果被存放在一个结果集中。

#### 2,
SQL不区分大小写



#### 3,	创建数据库和表

*CREATE DATABASE* - 创建新数据库

*ALTER DATABASE* - 修改数据库

*CREATE TABLE* - 创建新表					

*ALTER TABLE* - 变更（改变）数据库表

​		`alter table test drop column username;` 删除列

*DROP TABLE* - 删除表

*CREATE INDEX* - 创建索引（搜索键）

*DROP INDEX* - 删除索引

```mysql
mysql> create table test(
    -> id int(10) primary key auto_increment,
    -> number1 int(20) not null,
    -> number2 int(20) not null
    -> );					//创建表
```



| 数据类型                                                     | 描述                                                         |
| ------------------------------------------------------------ | ------------------------------------------------------------ |
| integer(size)<br/>int(size)<br/>smallint(size)<br/>tinyint(size) | 仅容纳整数。在括号内规定数字的最大位数。                     |
| decimal(size,d) numeric(size,d)                              | 容纳带有小数的数字。"size" 规定数字的最大位数。"d" 规定小数点右侧的最大位数。 |
| char(size)                                                   | 容纳固定长度的字符串（可容纳字母、数字以及特殊字符）。在括号中规定字符串的长度 |
| varchar(size)                                                | 容纳可变长度的字符串（可容纳字母、数字以及特殊的字符）。在括号中规定字符串的最大长度。 |
| date(yyyymmdd)                                               | 容纳日期。                                                   |





#### 4,	SQL 约束

约束用于限制加入表的数据的类型。

可以在创建表时规定约束（通过 CREATE TABLE 语句），或者在表创建之后也可以（通过 ALTER TABLE 语句）。

我们将主要探讨以下几种约束：

- NOT NULL	不为空
- UNIQUE     唯一性
- PRIMARY KEY     主键    拥有自动定义的 UNIQUE 约束
- FOREIGN KEY     外键
- CHECK                约束值(ps.例如 age>18)
- DEFAULT       默认值

#### 5,   UNIQE

​		约束

​	不同的数据库约束的写法不一样



​		Mysql：

```mysql
create table test(
	id primary key int(10) auto_increment,
    name varchar(20),
    Address varchar(255),
	City varchar(255),
    unique(id)
)
```



Oracle/Mssql/MS Access:

```mssql
create table test1(
id int not null UNIQUE,		//写在这
username varchar(255) not null,
city varchar(255)
)
```



给多个列进行约束，用下面的SQL语法：

​			ps.所有数据库都是一样

```mysql
CREATE TABLE Persons
(
Id int NOT NULL,
LastName varchar(255) NOT NULL,
FirstName varchar(255),
Address varchar(255),
City varchar(255),
CONSTRAINT uc_PersonID UNIQUE (Id,LastName)
)	//这里是固定格式，别问。问就语法
```





当表已被创建时，如需在 "Id_P" 列创建 UNIQUE 约束，请使用下列 SQL：

MySQL / SQL Server / Oracle / MS Access:

```mysql
ALTER TABLE Persons
ADD UNIQUE (Id_P)
```

如需命名 UNIQUE 约束，并定义多个列的 UNIQUE 约束，请使用下面的 SQL 语法：



MySQL / SQL Server / Oracle / MS Access:

```mysql
ALTER TABLE Persons
ADD CONSTRAINT uc_PersonID UNIQUE (Id_P,LastName)
```



撤销UNIQUE约束：

mysql:

```mysql
alter table test
drop username uc_PersonID
```



mssql/oracle/MS Access:

```mssql
alert table test
drop usernmae uc_PersonID
```

#### 6, primary key 主键

​	在此不对主键做过多描述，如有需求[点击这里](https://www.w3school.com.cn/sql/sql_primarykey.asp)



#### 7,	foreign key 外键

​	 在此不对逐渐做过多描述，如有需求[点击这里](https://www.w3school.com.cn/sql/sql_foreignkey.asp)

手动创建外键：

为testid创建外键，关联test3表的id字段

```sql
mysql> create table sf (
    -> id int(10) primary key,
    -> name varchar(255) not null,
    -> testid int(10),
    -> foreign key (testid) REFERENCES test3(id) );
```

添加主键约束：

```sql
ALTER TABLE test
ADD foreign key (test_id)
references Persons(id)
```



#### 8,check 约束

​		check 约束用于限制列中值的范围

​		

​		Mysql:

```mysql
create table test3(
id int not null primary key,
age int(10),
city varchar(255),
check (age>0)
)
```

​		

​		mssql/oracle/Ms Acess:

```mssql
create table test5(
id not null primary key,
age int(10) check (age>0)
city varchar(255),
)
```



​		为多个列进行约束：

```mssql
create table test1(
id not null primary key int(10),
age int(10),
city varchar(255),
CONSTRAINT chk_Person check(id>0 and city="beijing")
)
```



​		中途添加check(ps.所有数据库都一样这里):

```mysql
alter table test1
add check(age>0)
//下面的是全部的
alter table test2
add CONSTRAINT chk_Person check(age>0 and city="beijing")
```

​		

​		

​		撤销check:

​			mysql:

```mysql
alter table test1
drop check name
```

​			

​			mssqk/oracle/MS Access:

```mssql
alter table test
drop constraint name
```





	#### 9,	default

​		default  简单说就是设定数据的默认值。例如：

```mysql
My SQL / SQL Server / Oracle / MS Access:

create table test(
id int(10) primary key auto_increment,
name varchar(255) not null ,	
city varchar(255)	  //这个地方的vachar的长度就是defaul
)
```



修改表添加约束：

<center>mysql</center>
```mysql
alter table test
add city set default 'beijing'
```

​	

<center>mssql/oracle/MsAccess</center>
```mssql
alter table test
add column city default 'beijing'
```





撤销default约束:



<center>mssql

</center>

```mysql
alter table test
alter city drop default
```



<center>mssql/MS Access/oracle</center>
```mssql
alter table test
alter column city drop default 
```





#### 10,	index

​		create index用于创建索引。它可以在不读取整个表的情况下，索引使数据库应用程序可以**`更快`**的查找数据



​		用户无法看到索引，他们只能被用来加速查询/搜索

​		更行一个表索引比创建一个表的索引更花费时间，因为索引本身也需要更新



​		简单创建索引：

```mysql
create index indexName
on tableName (columnName)
```



​		创建一个唯一的索引：

​				ps.这意味着两条数据不能拥有相同的索引

```mysql
create unique index indexName
on tableName (columnName)	
//如果创建两个索引，则在括号后面加再culumn_name逗号隔开,
//如果想要降序索引，则在括号后面加DESV
```



#### 11	drop和delete的区别

drop主要用于删除结构

>  例如删除数据库：drop database XX，删除表 drop table XX。字段也是结构的一种，也可以使用drop了？对的，但是我们改变了表结构要先alter方法。例如，我们要删除student表上的age字段的信息，可以这样写：alter table student drop age



delete主要用于删除数据

> 举个例子，要删除 student表上名字为‘张三’的所有信息：delete from student where name=‘张三’。这种情况下用delete，由此可见delete常用于删除数据。





#### 11.	alter修改表



##### 1.	修改表字段

```mysql
alter table 表名 change 旧字段名 新字段名 varchar(255);	
										//新字段名后面必须跟着数据类型
```

##### 2.增加表字段

```mysql
alter tables test3
add createtime date;
```



##### 3.	修改表名

```
alter table test_table rename to test_new_table;
			旧表名					新表名
```



#### 4.	修改表字段

```
alter table test_table change 旧字段 新字段 varchar(255)
									//后面必须加数据类型
```

