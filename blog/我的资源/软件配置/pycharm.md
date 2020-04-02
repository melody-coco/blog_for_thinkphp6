安装破解pycharm的问题就不说了。

这里将讲配置pycharm测试服务器的问题

Django开启测试服务器命令`python manage.py runserver`

#### 首先：

+ 在`pycharm`的`Setting`中选择`Language & Frameworks`中选择`Django`
+ 第一行`Django project root`是`Django`项目的目录路径
+ 第二行`setting`是项目的配置文件的路径
+ 还有第四个`manage.py script`是`python manage.py runserver` 中的`manage.py`文件的路径
+ 最后一个输入框`Folder pattern to trace files`中写`migrations`
+ 就动这四个，其他什么都不要动

#### 然后：

+ 在`pycharm`的右上角的运行服务器中

+ 第一行`host`选择`127.0.0.1`，端口填`8000`
+ 在`Envirronment variables`中，点输入框右边的小本本，全选小本本里面的东西，然后点击`OK`
+ 然后在`Python interpreter`中配置`python`解释器的路径
+ 然后在`Working directory`中配置项目的路径
+ 就动这四个其他什么都不要动