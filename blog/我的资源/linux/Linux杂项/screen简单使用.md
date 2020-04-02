| -c file                         | 使用配置文件file，而不使用默认的$HOME/.screenrc              |
| :------------------------------ | :----------------------------------------------------------- |
| -d\|-D [pid.tty.host]           | 不开启新的screen会话，而是断开其他正在运行的screen会话       |
| -h num                          | 指定历史回滚缓冲区大小为num行                                |
| -list\|-ls                      | 列出现有screen会话，格式为pid.tty.host                       |
| -d -m                           | 启动一个开始就处于断开模式的会话                             |
| -r sessionowner/ [pid.tty.host] | 重新连接一个断开的会话。多用户模式下连接到其他用户screen会话需要指定sessionowner，需要setuid-root权限 |
| -S sessionname                  | 创建screen会话时为会话指定一个名字                           |
| -v                              | 显示screen版本信息                                           |
| -wipe [match]                   | 同-list，但删掉那些无法连接的会话                            |

> 后面接完整的screen_id。不只是数字