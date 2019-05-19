## 前言
在做PHP开发的过程中，大部分我们都在和http协议打交道，在ISO模型里面，http属于应用层协议，它底层会用到TCP协议。http协议非常简单，它是一个文本协议，一个请求对应一个响应，客户端发起一个请求，服务端响应这个请求。http是一个一问一答的对话，每次请求都得重新建立对话（这里暂不讨论Keep-Alive），如果你想通过一个请求进行多次对话，那就是长链接通信，必须使用TCP或者UDP协议。

互联网运行的基石是建立在一些协议上的，目前而言主要是TCP/IP协议族，大部分协议都是公开开放的，电脑遵循这些协议我们才能通信，当然也有一些私有协议，私有协议只有自己知道如何去解析，相当来说更安全，比如QQ所用的协议就是自己定义的。在ISO模型里面，咱们常用的有http、ftp、ssh、dns等，但是不常用的数不胜数，发明一个协议不难，难的是如何设计的更好用，而且大家都喜欢用。

## Socket
Socket并不是一个协议，本质上说Socket是对 TCP/IP 协议的封装，它是一组接口，在设计模式中，Socket 其实就是一个门面（facade）模式，它把复杂的 TCP/IP 协议族隐藏在 Socket 接口后面，对用户来说，一组简单的接口就是全部，让 Socket 去组织数据，以符合指定的协议。

下图展示了Socket在ISO模型里面大概位置：

![](http://ww1.sinaimg.cn/large/5f6e3e27ly1g372hly7xkj20f20d8js4.jpg)


## PHP Socket
虽然PHP的强项是处理文本，一般用来写网页和http接口，但是官方依然提供了Socket扩展，编译PHP时在配置中添加--enable-sockets 配置项来启用，如果使用apt或yum安装，默认情况下都是启用的。

[官方文档](https://www.php.net/manual/zh/book.sockets.php)里面列出了大概40个函数，但是常用的也就那几个，跟着文档，咱们一起来学学如何使用，首先声明一下，本人对Socket编程并不熟悉，如有错误的地方，希望大家指出来。

咱们先看一幅图，关于TCP客户端和服务端之间的通信过程，它和咱们平时写http接口的时候差异很大，我们需要做更多的工作。

![](http://ww1.sinaimg.cn/large/5f6e3e27ly1g371bhib22j20da0dn0t2.jpg)


### 1.服务端代码
```php
<?php
set_time_limit(0);

$ip = '127.0.0.1';
$port = 8888;

$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

socket_bind($sock, $ip, $port);
socket_listen($sock, 4);

echo "Server Started, Listen On $ip:$port\n";

$accept = socket_accept($sock);

socket_write($accept, "Hello World!\n", 8192);

$buf = socket_read($accept, 8192);

echo "Receive Msg： " . $buf . "\n";

socket_close($sock);
```
简单说一下,为便于演示，所以省略了所有的错误处理代码，可以看到分为create、bind、listen、accept、write\read、close这几步，看上去非常简单！具体参数大家可以看一下文档！在服务端启动之后，当收到一个请求之后，我们首先返回了一个```Hello World\n```,然后又读取了8192个字节的数据，打印出来！最后关闭链接。

由于这里，咱还没有写客户端，所以暂时使用curl访问一下，运行效果如下：

===>服务端：

![](http://ww1.sinaimg.cn/large/5f6e3e27ly1g373ivwa2ej20ls06274r.jpg)

===>客户端：

![](http://ww1.sinaimg.cn/large/5f6e3e27ly1g373k4ahoij20hw03cwem.jpg)

从这个例子里面我们可以看出来，curl发出是一个标准的http请求，实际上它的每一行后面是有\n的，在http协议里面，这几行文本其实是头（header）,但是在这个例子里面，对于我们来说，它就是一段文本而已，服务端只是把它的内容打印出来了,并没有去按照http协议去解析。虽然我们返回了```Hello World！\n```，但是这也并没有按照http协议的格式去做，缺少响应头。我只能说curl比较强大，如果使用浏览器访问的话会失败，提示```127.0.0.1 sent an invalid response```。


