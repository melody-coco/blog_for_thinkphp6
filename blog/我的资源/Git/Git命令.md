<center>Git命令</center>
#### 1.	git init

> 此命令主要是：用作初始化一个Git仓库(工作区)，

基本格式：

在要创建的目录当中，使用以下命令来初始化一个Git仓库(工作区)

```
$ git init
```

> 此命令会出现一个`.git`文件，这时一个二进制文件不要动它。



#### 2.	git add 文件名

> 此命令主要是：把一个或多个文件，添加到暂存区(缓冲区)

> 必须在有`.git`的目录才能使用，换言之就是使用`git init`初始化后的目录才能使用

基本格式：

在工作的目录中创建`a`，`b`两个文件，使用以下命令把两个文件推送到Git的暂存区(缓冲区)：

```
$ git add a b
```



#### 3.	git commit -m "描述性文字"

> 此命令主要是：把缓冲区的数据提交到Git的版本库中

> 此命令必须加`-m`选项，否则的话，无法辨别文件

```
$ git commit -m "第一次提交的文件"
```



#### 4.	git status

> 此命令作用就是字面意思：查看当前的Git状态。

此命令很简单。甚至此命令还能提示其它的命令。

如果我们修改了仓库中的一个文件，但是我们不进行其他操作，此时使用`git status`命令查看：

```
$ git status
On branch master		//显示位于主分支
Changes not staged for commit:			//尚未暂存以备提交的变更：
  (use "git add <file>..." to update what will be committed)	//提示使用git add
  (use "git checkout -- <file>..." to discard changes in working directory)
												//提示使用git checkout 放弃修改
	modified:   a						//显示修改的文件为a

no changes added to commit (use "git add" and/or "git commit -a")
```

> 此处可以用`git diff a`命令，查看a文件的更改情况。



​	然后我们使用`git add a `命令把文件`a`放到缓冲区。然后使用`git status`命令查看：

```
$ git status 
On branch master
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)		//提示使用git reset 命令取消提交

	modified:   readme.txt
```



最后我们使用`git commit -m "第一次修改a"`命令，提交缓冲区的文件，然后使用`git status`命令查看：

```
$ git status
On branch master					//显示在主分支上
nothing to commit, working tree clean		//显示没有东西可提交，工作区很干净
```





#### 5.	git diff 文件名

> 此命令主要用于：查看本次修改改动的地方。常与`git status`合用。
>
> 相当于是版本库中对比工作区的文件，看工作区的文件新增了什么



查看并修改`a`文件：

```
[root@localhost ~]# cat a 
hellow word!

[root@localhost ~]# vim a
hellow world!
this is test
```

参数选项：

+ `HEAD -- a`：把版本库的文件和工作区的文件做对比



实例1：

> 使用`git diff`命令查看修改的地方:

```
$ git diff a
diff --git a/a b/a
index ce77205..ffe6804 100644
--- a/a
+++ b/a
@@ -1,2 +1,3 @@
 hellow world!
+this is test				//显示增加了一行内容
```

> 使用`git add a`命令，将文件添加到缓冲区了后，就不能再使用`git diff a`命令查看差异了



实例2：

> 对比工作区和版本库文件的区别

```
[root@localhsot ~]# git diff HEAD -- a
index 9ae7fac..d2bc460 100644
--- a/a
+++ b/a
@@ -1,3 +1,4 @@
 this is melody's first git
 hellow world!
 this is a new line
+this is 4					//新加上了最后一行
```





#### 6.	git log

> 此命令主要用于：查看提交的版本历史信息

`git log`命令，基本格式如下：

```
[root@localhost ~]# git log
commit 8adb7c830c118ebd2ee45a62ef26382eae6e6c27(HEAD -> master)
Author: melody <1154717286@qq.com>
Date:   Sun Feb 16 19:59:25 2020 +0800

    第一次测试git status

commit 33689022d668b5bfe2380ef10924bfa2c90b6018
Author: melody <1154717286@qq.com>
Date:   Sun Feb 16 18:40:23 2020 +0800

    这是新建a文件后的第一次修改

commit 07b9689e1b34d56b6e0304722d974fe7c9118adb
Author: melody <1154717286@qq.com>
Date:   Sun Feb 16 18:32:54 2020 +0800

    melody的第一次git文件提交
```

其中字段的详细信息如下

+ `commit`：`commit id(版本号)`，
+ `Author`：关于提交的用户信息。`name`，`mail`
+ `Date`：日期
+ `git commit -m ""`写入的描述性文字

> 上面`HEAD`指向的版本就是当前版本。
>
> 回退的话：上一版本就表示为`HEAD^`，上上个版本表示为`HEAD^^`。
>
> 上100个版本就显示为`HEAD~100`。历史版本信息，除了这种方法外还能使用版本号的方式显示



参数选项：

+ `--pretty=oneline`：此参数可以省略多于信息，简单的显示各版本信息



实例1：

> 查看提交和合并历史的命令

```
$ git log --graph --pretty=oneline --abbrev-commit
```





#### 7.	git reset

> 此命令是版本回退的命令，主要用于切换版本

`git reset`命令。基本格式：

```
[root@localhost ~]# git reset 
```

参数选项：

+ `-- hard 版本号`：适用于修改文件的版本，通过`git log`查看的版本号可以修改文件的版本

> 此处不只可以用版本号表示，也可以用`HEAD^`来表示

+ `HEAD 文件名`：撤销暂存区文件`a`修改。



实例1：

> 使用`git reset --hard 33689022d`

```
[root@localhost ~]# git reset --hard 33689022d			//版本号可以不写全，但不能只写两位导致无法自动补全

[root@localhost ~]# git reset --hard HEAD^			//切换到上次的版本
```

> 注意，切换到最新版本之前的版本后，`git log`无法再查到新版本的版本信息。如果要查的话只能用`git reflog`
>
> 但是，如果记得新版本的版本号的话，就可以不用`git reflog`命令查看



实例2：

> 使用`git reset HEAD a`命令来撤销暂存区中，文件a的修改

```
[root@localhost ~]# cat a			//查看文件a
this is 1
[root@localhost ~]# vim a			//修改文件a
this is 1
this is 2
[root@localhost ~]# git add a		//添加文件a到暂存区
[root@localhost ~]# git status 		//查看状态
On branch master
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)		//提示使用git reset 命令取消提交

	modified:   a			//可以看到文件a已经在暂存区中
	
[root@localhost ~]# git reset HEAD a	//把文件a从暂存区移除
[root@localhost ~]# git status			//查看状态
On branch master
nothing to commit, working tree clean
```





#### 8.	git reflog

> 查看命令历史

`git reflog`命令，基本格式：

```
[root@localhost ~]# git reflog
```



此命令与`git log`的区别为：如果把版本回退到最新版本之前的话，`git log`无法查看最新版本。





实例1：

> 使用`git reflog`命令，查看命令历史

```
[root@localhost ~]# git reflog
3368902 HEAD@{0}: reset: moving to 33689022d668b5bfe
8adb7c8 HEAD@{1}: reset: moving to 8adb7c8
3368902 HEAD@{2}: reset: moving to HEAD^
8adb7c8 HEAD@{3}: commit: 第一次测试git status
3368902 HEAD@{4}: commit: 这是新建a文件后的第一次修改
07b9689 HEAD@{5}: commit (initial): melody的第一次git文件提交
```



#### 9.	git checkout 

> 此命令用于：撤销对文件的修改。和切换当前的分支，也就是修改`HEAD`指针的指向

`git checkout`命令，基本格式：

```
$ git checkout -- 文件名
$ git checkout [-b] branch名
$ git checkout -b 本地branch名 远程库名/远程branch名						
								第三种格式主要是用作远程连接非master分支
```

格式选项：

+ `-- 文件名`：撤销对文件的修改。(ps.适用于修改还没有提交到暂存区)

+ `branch`名：切换到另一个分支。不止可以切换分支，还可以切换`commit`版本(其实还是自动创建一个分支)

  ​	1.`[-b]`参数：表示创建并切换分支



实例1：

> 使用`git checkout -- a`命令进行撤销对文件a的修改

```
[root@localhost ~]# cat a			//查看文件a
this is 1
[root@localhost ~]# vim a			//修改文件a
this is 1
this is 2
[root@localhost ~]# git status	//查看当前状态，可以看到当前a文件，修改了但未提交至暂存区
On branch master		
Changes not staged for commit:			
  (use "git add <file>..." to update what will be committed)	
  (use "git checkout -- <file>..." to discard changes in working directory)
												
	modified:   a						

no changes added to commit (use "git add" and/or "git commit -a")

[root@localhost ~]# git checkout -- a		//取消对文件a的修改
[root@localhost ~]# cat a					//查看文件a
this is 1
```

> `git checkout`其实是用版本库里的版本替换工作区的版本，无论工作区是修改还是删除，都可以“一键还原”。



实例2：

> 创建dev分支并切换

```
$ git checkout -b dev
切换到一个新分支 'dev'
```

> 此方式可以创建`dev`分支，并切换到`dev`分支。



实例3：

> 使用`git checkout -b 本地branch名 远程库名/远程branch名`命令。连接本地lpl分支和远程lpl分支

```
$ git clone git@github.com:melody-coco/githubtest.git				先复制项目
$ git branch 
*master											//默认的克隆只会克隆master分支
$ git checkout -b lpl origin/lpl					//创建远程lpl分支到本地。
$ git branch
*master
lpl
```

> 这样我们就能对`lpl`分支进行操作了。

> 注意：这里可能会遇见一个BUG：`There is no tracking information for the current branch.`。
>
> 这时候就必须建立远程连接了`git branch --set-upstream branch-name origin/branch-name`



#### 10.	git remote

> 上面的命令是简写，因为完整的比较长

>  此命令作用为：本地版本库和远程库的关联

可以关联多个远程库，例如`Github`和`Gitee`（码云）



基本格式如下：

```
[root@localhost ~]# git remote add origin git@github.com:melody-coco/clonetest.git
								   远程库名  使用git协议    GitHub账户名  GitHub项目名
								   
[root@localhost ~]# git remote [选项]		
```

第一种格式的字段含义如下：

+ `origin`：此字段为本地版本库为远程库取得名字，名字随意。不过默认叫`origin`。
+ `git@github.com`： 表示使用的是`Git`协议上传
+ `melody-coco`：此字段为关联得GitHub账户得用户名
+ `clonetest`：此字段为GitHub项目名，后面的`.git`必须加上去



第二种格式的参数如下：

+ `-v`： 详细显示远程版本库的信息
+ ` `：不加，简单查看远程版本库信息
+ `rm`：删除远程库。示例：`git remote rm origin`

实例1：

> 连接远程库

```
$ git remote add origin git@github.com:melody-coco/githubtest.git
```



实例2：

> 查看当前连接的数据库信息

```
$ git remote -v
origin  git@github.com:melody-coco/githubtest.git (fetch)
origin  git@github.com:melody-coco/githubtest.git (push)
```



#### 11.	git push

> 此命令的主要作用为把版本库提交到远程库中

`git push` 基本格式为：

```
[root@localhost ~]# git push [选项] 远程库名 分支
```

参数选项：

+ `-u`：参数通常是关联版本库和远程库后，第一次使用`push`，就要加此参数





实例1：

> 使用`git push`命令，

```
[root@localhost ~]# git push -u origin master
									//关联版本库和远程库后第一次使用push
									
[root@localhhost ~]# git push origin master			//往后正常使用git push
```





#### 12.	git pull

> 此命令多用于把远程库的内容更新到版本库中。

> 工作场景：只要远程库比版本库更新时。或者产生冲突时(冲突不懂去`Git概念`-->分支管理-->解决冲突)。
>
> ​				导致无法`git push`。此时就会要求使用`git pull`把远程库更新到版本库中。然后再进行操作

`git pull`命令，基本格式：

```
$ git pull 远程库名 分支名
```



实例1：

> 简单`git pull`一下

```
$ git pull origin master				//依据远程库更新本地库
```





#### 13.	git clone

> 此命令完整为`git clone git@github.com:melody-coco/clonetest.git`

此命令主要作用为克隆远程库到本地中，并且直接成为一个版本库。

使用此方式可以直接跳过添加远程库的步骤



此命令基本格式为：

```
[root@localhost ~]# git clone git@github.com:melody-coco/clonetest.git
							  	使用Git协议    GitHub用户		项目名
```



克隆命令和`git pull 远程库名 分支名`命令和区别为：

+ 克隆命令：可以不初始化版本库。从远程服务器克隆一个一模一样的版本库到本地,复制的是整个版本库
+ `git push`：获取远程库的最新版到本地版本库，需要初始化版本库，也需要添加远程库才能使用。



#### 14.	git branch

> 此命令主要是用于：管理分支，包括新增分支，查看分支，删除分支

`git branch`命令，基本格式为：

```
$ git branch [-d] 分支名
```

参数选项：

+ ` `:什么都不加，表示查看当前分支的情况，分支前边有`*`。表示当前所在分支
+ `-d`：后面接分支名，表示删除分支
+ `-D`：后面接分支名，表示强制删除
+ `分支名`：直接加分支名便是创建分支
+ `-f 分支名 commitID` ：强制分支回退(或切换)到目标`commitID`。实质就是强制移动分支指针



实例1

> 创建并查看新分支，然后删除

```
$ git branch						//查看所有分支
*master
$ git branch dev					//创建dev分支
$ git branch 						//查看所有分支
dev
*master					//要切换分支的话，使用git checkout
$ git branch -d dev					//删除dev分支
```



#### 15.	git merge

> 此命令主要用于：合并分支

`git merge`命令，基本格式：

```
$ git merge [参数选项] 分支名
```

参数选项：

+ `--no-ff`：强制不采用`fast-forwatd`模式
+ `--ff`：强制采用`fast-forward`模式
+ `-m`： 后面接双引号包裹的描述信息，就像是`git commit`的`-m`选项一样。
+ ` `： 不加参数，直接合并分支到当前分支。



实例1：

> 简单使用`git merge`合并分支

```
$ git checkout -b dev				//创建并切换到dev分支
省略……修改dev分支的其中一个文件并提交到版本库。

$ git checkout master				//切换到主分支
$ git merge dev					//合并dev分支到master分支上。主分支的内容此时就和dev分支相同
```



实例2：

> 简单使用`git merge --no--ff`命令。其实最好再加上`-m 描述信息`

```
$ git checkout -b dev				//创建dev分支
省略……修改dev分支的其中一个文件并提交到版本库。

$ gti checkout master
$ git merge --no-ff -m "不使用Fast-forward" dev			//强制不使用Fast-forward模式
```

> 至于什么是`Fast-forward`模式。和`git merge --no-ff`到底有什么用，
>
> 自己去`Git概念`-->`分支管理`-->`git merge --no-ff`看

> 此处清冽建立使用`git merge --no-ff`合并。而不是直接使用`merge`合并



#### 16.	git stash

> 保存(藏)工作现场。此命令什么作用自己去`Git概念`-->`分支管理`-->`git stash`看。



储存工作现场：

```
$ git stash [开发]
Saved working directory and index state WIP on dev: 44e40b9 add 开发
```

> 不加后面的`[开发]`，也可以。只是不便于辨认



查看工作现场列表：

```
$ git stash list
stash@{0}: WIP on master: 44e40b9 开发
```



恢复工作现场：

```
$ git stash apply	stash@{0}		//恢复工作现场
$ git stash pop	stash@{0}			//恢复后删除工作现场			相当于apply后drop
```



删除工作现场：

```
$ git stash drop stash@{0}			//删除工作现场
```



#### 17.	git cherry-pick

> 此命令用于：复制单次的修改到当前分支中。
>
> 使用场景：`master`分支出现了BUG，然后修复掉了。但是当前的工作分支，也有这个BUG，这时就可以用`git cherry-pick`复制单次的“修改”当前分支中



`git cherry-pick`命令，基本格式为

```
$ git cherry-pick <commit>		
```



实例1：

> 在主分支修复了BUG，这时候把BUG修改复制到`dev`

```
$ git check dev								//切换到dev分支
$ git cherry-pick 104ac12fec8c6b6c81		//在当前分支下进行复制“修改”
```



> 