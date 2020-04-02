<center>SQL的一些无聊的函数函数</center>
### 一，基本概念

​		在SQL中，基本的函数类型,种类有若干种。函数的基本类型是：

			+ Aggregate函数（合计函数）
			+ Scalar函数



#### 1.1	聚合函数(aggregate)

​												aggregate functios

​		Aggregate 函数的操作面向一系列的值，并返回一个单一的值

​		

​		聚合函数使用的话经常和`group by`   一起使用



一些常用的聚合函数如下

| functions                                                    | description                      |
| ------------------------------------------------------------ | -------------------------------- |
| [AVG(column)](https://www.w3school.com.cn/sql/sql_func_avg.asp) | 返回某列的平均值                 |
| [COUNT(column)](https://www.w3school.com.cn/sql/sql_func_count.asp) | 返回某列的行数（不包括 NULL 值） |
| [COUNT(*)](https://www.w3school.com.cn/sql/sql_func_count_ast.asp) | 返回被选行数                     |
| FIRST(column)                                                | 返回在指定的域中第一个记录的值   |
| LAST(column)                                                 | 返回在指定的域中最后一个记录的值 |
| [MAX(column)](https://www.w3school.com.cn/sql/sql_func_max.asp) | 返回某列的最高值                 |
| [SUM(column)](https://www.w3school.com.cn/sql/sql_func_sum.asp) | 返回某列的总和                   |



#### 1.2	标量函数(Scalar)

​											scalar funcitons	标量函数

​	Scalar 函数的操作面向某一个单一的值，并返回基于输入的一个单一的值



| 函数     (c为column)    | 描述                                   |
| ----------------------- | -------------------------------------- |
| ucase(c)                | 将某个域换为大写                       |
| lcase(c)                | 将某个域换为小写                       |
| MID(c,start[,end])      | 从某个文本域提取字符串                 |
| length(c)               | 返回某个文本域的长度                   |
| now()                   | 返回当前的系统日期                     |
| left(c,number_of_char)  | 返回某个被请求的文本域的左侧部分       |
| right(c,number_of_char) | 返回某个被请求的文本域的右侧部分       |
| round                   | 对某个数值域进行指定小数位数的四舍五入 |
| INSTR(c,char)           | 返回在某个文本域中指定字符的位置       |

​		

### 二，函数

​	

	#### 1.1	avg()

​		avg函数返回数值列的平均值，null值不包括在计算内

​		语法：

```mysql
select avg(age) from studentList
	//这个实例就不用演示了吧
```

​	

#### 1.2	count()

​		count()函数用于返回匹配指定条件的行数

​		语法:

```mysql
select count(name) from studentList
```

​		也可以：

```mysql
select count(*) from studentList;	//返回所有记录数
```

​		也适用于distinct(取反):

```mysql
select count(distinct name) from studentList;
	//这里我发现返回的是和name一样的 数量的 值
```



​		又比如：

```mysql
select count(name) from studentList where age>18;
```



#### 1.3	first()

​		first()函数返回指定字段的第一个记录的值（也就是说返回的是第一条数据）

​		语法：

```mysql
select first(*) from test;		//输出查询到的第一条数据
			//mysql用不了这个，只能用limit
```



#### 1.4	last()

​		last()函数返回指定的字段中最后一个记录的值

​		语法：

```mysql
select last(*) from test;	//返回搜索到的最后一条数据
		//奴能哦用于Mysql
```

​	

#### 1.5	max()

​		max函数返回一列中的最大值，(ps.null不会被计算)

​		语法：

```mysql
select max(name) from sutdentList;
		//字符串的话就是比较首字母的ASCII码
```



#### 1.6	min()

​		min()函数用于返回一列中的最小值，(ps.null不会被计算)

​		语法：

```mysql
select min(name) from test;
		//字符串的话就是比较首字母的ASCII码
```



#### 1.7	sum()

​		sum()函数返回数值列的总数(总额)

​		语法：

```mysql
select sum(number)	from test; //返回得是所有int数据的和
		//字符串的话会计算所有字符串中的数字和。没有的话返回0
```



#### 1.8	group by

​		group by 语句用于结合聚合函数，根据一个或多个列对结果集进行分组

语法：

```mysql
select name, sum(price) from test order by name;
		//一般都是通过搜索的字段取order by分组
```



#### 1.9	having 子句

​		在SQL中增加having子句的原因是，where关键字无法和聚合函数一起使用



​			实例：

		O_Id	OrderDate	OrderPrice	Customer
​			1			2008/12/29			1000			Bush
​			2			2008/11/23			1600			Carter
​			3			2008/10/05			700				Bush
​			4			2008/09/28			300				Bush
​			5			2008/08/06			2000			Adams
​			6			2008/07/21			100				Carter



​	现在我们希望查找订单总金额少于2000的客户

​			语句如下：

```

```



#### 2.0	ucase()

​		ucase函数把字段的值转换为大写

​		语法：

```mysql
select ucase(name) from testlist;//查询到的数据转为大写
```



#### 2.1	lcase()

​		lcase()函数把字段的值转换为小写。

​		语法：

```mysql
select lcase(name) from testlist;//查询到的数据转为小写
```



#### 2.11	mid()	

​	新增的函数

​	mid()函数截取 查询到的数据的长度（limit截取返回数据的条数，mid截取返回数据的所有数据的长度）

​		语法：

```mysql
select mid(column_Name,start,length) from tableName;
		//返回所有查询到的数据的文本长度
```







#### 2.2	len()

​			Mysql中是length()

​			len()函数返回文本字段中值的长度

​			语法：

```mysql
select len(name) from test;
```



#### 2.3	round()函数

​		round()函数用于把数值字段舍入为指定的小数位数

​		简单说就是，规定返回的浮点数的小数长度

​		语法：

```mysql
select round(height,0) from test;
		//返回test表中所有height数据(ps.返回的都0个小数点)
```



#### 2.4	format()

​		format函数用于规定返回数据的格式，（格式化）

​		语法：

```mysql
select format(column_name,format) from table_name;
```



​		实例：

```mysql
select name,age,format(now(),'YYYY-MM-DD') as day from test_Table;
```

