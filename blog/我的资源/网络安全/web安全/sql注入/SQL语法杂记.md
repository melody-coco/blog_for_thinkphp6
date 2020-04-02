<center>sql语法杂记</center>

#### 1.	运算符优先级



```
以下列表显示了操作符优先级的由低到高的顺序。排列在同一行的操作符具有相同的优先级。
:=
||, OR, XOR
&&, AND
NOT
BETWEEN, CASE, WHEN, THEN, ELSE
=, <=>, >=, >, <=, <, <>, !=, IS, LIKE, REGEXP, IN
|
&
<, >>
-, +
*, /, DIV, %, MOD
^
- (一元减号), ~ (一元比特反转)
!
BINARY, COLLATE
```

> 其中，貌似`^`的优先级比`!`高