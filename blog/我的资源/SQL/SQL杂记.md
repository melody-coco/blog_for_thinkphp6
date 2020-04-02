#### 1，进数据库
    mysql -uroot -p



#### 2.	复制表

复制旧表到新表中(ps.复制结构和数据，但是不复制索引，主键约束，外键约束，触发器)

```php
create table 新表 select * from 旧表;
```



#### 3.	复制表结构

复制旧表的表结构，到新表中。（只复制表结构，不复制表数据）

```
create table 新表 like 旧表;
```



#### 4.	数字作为表名

默认的mysql不用数字作为表名，如果要用数字作为表名的话。必须使用反引号``

```mysql
create table `115471`(
	id int(10) primary key auto_increment,
	name varchar(255),
	passwd varchar(255)
)
```



#### 5.	修改表名

```
alter table test_table rename to test_new_table;
```



修改数字表名：

```
alter table `115471` rename to test_new_table;
```



#### 6.	修改表字段

```
alter table test_table change 旧字段 新字段 varchar(255);
										//新字段必须加数据类型
```

