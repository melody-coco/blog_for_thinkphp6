#### 21题 
###### 两个乒乓球队进行比赛，各出三人。甲队为a,b,c三人，乙队为x,y,z三人。
######      已抽签决定比赛名单。有人向队员打听比赛的名单。a说他不和x比，c说他不和x,z比，

```
请编程序找出三队赛手的名单。
def ff():               
    for x in ['y','x','z']:
        print(x)
        for j in ['y','x','z']:
            if x!=j:
                for h in ['y','x','z']:
                    if h!=x and h!=j :
                        if x!='x' and h!= 'x' and h!='z':
                            print('a-->%s,b-->%s,c-->%s'%(x,j,h))
ff()
```
###### 这道题记住了,是用嵌套循环来做一个==条件配对==的


#### 26题:
#####         利用递归方法求5!。
###### 自己递归学的垃圾我就不说了
```
def ff(n):
    jj=n
    if(n==1):
        jj=1
    else:
        jj=ff(n-1)*jj
    return jj
print(ff(5))
```
####       27题
######       利用递归函数调用方式，将所输入的5个字符，以相反顺序打印出来。

```
def ff(s,l):
    if l==0:
        return print(s)
    print (s[l-1])
    ff(s,l-1)
jisuan=input('笨比')
l=len(jisuan)
ff(jisuan,l)
```
#### 28题
###### 有五个人，每个人依次比后面那个人大2岁，最后面那个人10岁，求最大的那个多大

```
def ff(n):
    if n==1:
        return 10
    return ff(n-1)+2
print('最大的是',ff(5))
```
##### ==利用递归的方法，递归分为回推和递推两个阶段。==
###### 要想知道第五个人岁数，需知道第四人的岁数，依次类推，推到第一人（10岁），再往回推。


#### 35题
###### 文本颜色设置

```
class bcolors:
    HEADER = '\033[95m'
    OKBLUE = '\033[94m'
    OKGREEN = '\033[92m'
    WARNING = '\033[93m'
    FAIL = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'
print(bcolors.WARNING + "警告的颜色字体?" + bcolors.ENDC)
```
### 37题
###### 对10个数进行排序。(选择排序法，)

```
def ff(l):
    f=10
    for x in range(f-1):
        min=x
        for d in range(x+1,f):
            if l[min]>l[d]:
                min=d
        l[x],l[min]=l[min],l[x]
    for y in range(f):
        print(l[y])
list_1=[]
for x in range(10):
    list_1.append(int(input('输入你要比较的十个数')))
print(list_1)
ff(list_1)
```
#### 38题
###### 求一个3*3矩阵主对角线元素之和。

```
def ff():
    i=[]
    sum=0
    for x in range(3):
        i.append([])
        for y in range(3):
            i[x].append(int(input('输入你想要得到的数')))
        sum+=i[x][x]
    print(sum)
ff()
```
#### 51题

##### 按位与，按位或，按位异或，按位取反
```
if __name__ == '__main__':
    a=151
    b=211
    c=a&b
    print('按位与c的值为',c)
    d=a|b
    print('按位或d的值为',d)
    e=a^b
    print('按位异或e的值为',e)
    f=~a
    print('按位取反f的值为',f)
```
###### 对数据的每个二进制位取反,即把1变为0,把0变为1 。~x 类似于 -x-1


#### 52题
###### 取一个整数a从右端开始的4〜7位。
###### (1)先使a右移4位。
###### (2)设置一个低4位全为1,其余全为0的数。可用~(~0<<4)
###### (3)将上面二者进行&运算。

```
u=int(input('输入哟个你想要的数'))
b=u>>4
print(~0<<4)
f=~(~0<<4)
print(u,b&f)
```

### 61题
###### 使用生成器打印出杨辉三角

```
def ff():
    list_1=[1]
    while len(list_1)<11:
        yield list_1
        list_1=[1]+[list_1[i]+list_1[i+1] for i in range(len(list_1)-1)]+[1]
n=0
o=[]
for x in ff():
    o.append(x)
    n+=1
    if n==10:
        break
for t in o:
    print(t)
```

#### 96题
###### 使用count函数查找字符(count函数返回的是查找到的字符的个数))

```
str_1=input('输入字符串')
find_1=input('输入查找的字符')
str_2=str_1.count(find_1,0,len(str_1))
print(str_2)
```
