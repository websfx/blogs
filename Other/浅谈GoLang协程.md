### GoLang协程
学习golang也有一段时间了，这里讲一下自己对golang协程的使用理解，golang很多人都知道，毕竟有个好爹Google，提起golang和其它语言最大区别莫过于goroutine，
也就是go的协程，先来一个demo
```
package main

func say(s string) {
    for i := 0; i < 5; i++ {
        println(s)
    }
}

func main() {
    go say("Hello")
    go say("World")
}
```
go 启动协程的方式就是使用关键字 go，后面一般接一个函数或者类似下面的匿名函数的写法
```
go func() {
    for i := 0; i < 5; i++ {
        println(i)
    }
}()
```
当然如果你运行上面第一段代码，你会发现什么结果都没有，what？？？

这至少说明你代码写的没问题，当你使用go启动协程之后,这2个函数就被切换到协程里面执行了，但是这时候主线程结束了，这2个协程还没来得及执行就挂了！
聪明的小伙伴会想到，那我主线程先睡眠1s等一等？Yes, 在main代码块最后一行加入：
```
time.Sleep(time.Second*1) # 表示睡眠1s
```
你会发现可以打印出5个Hello 和 5个World，多次运行你会发现Hello 和 World 的顺序不是固定的，这进一步说明了一个问题，那就是多个协程是同时执行的
不过睡眠这种做法肯定是不靠谱的，go 自带一个WaitGroup可以解决这个问题, 代码如下:
```
package main

import (
	"sync"
)

var wg sync.WaitGroup

func say(s string) {
	for i := 0; i < 5; i++ {
		println(s)
	}
	wg.Done()
}

func main() {
	wg.Add(2)
	
	go say("Hello")
	go say("World")
	
	wg.Wait()
}

```
简单说明一下用法，var 是声明了一个全局变量 wg，类型是sync.WaitGroup，wg.add(2) 是说我有2个goroutine需要执行，
wg.Done 相当于 wg.Add(-1) 意思就是我这个协程执行完了。wg.Wait() 就是告诉主线程要等一下，等他们2个都执行完再退出。

举个例子，你有一个需求是从３个库取不同的数据汇总处理，同步代码的写法就是查３次库，但是这３次查询必须按顺序执行，大部分编程语言的代码执行顺序都是从上到下，假如一个
查询耗时１ｓ，３个查询就是３ｓ，但是使用协程你可以让这３个查询同时进行，也就是１ｓ就可以搞定（前提是数据库跟得上）。还有一个更有实际用途的例子就是用来写爬虫。

不过为了更好的使用协程，你可能还得了解一下管道 Chanel，go 里面的管道是协程之间通信的渠道，上面的例子里面我们是直接打印出来结果，假如现在的需求是把输出结果返回到主线程呢？
```
package main

import (
	"sync"
)

var wg sync.WaitGroup

func say(s string, c chan string) {
	for i := 0; i < 5; i++ {
		c <- s
	}
	wg.Done()
}

func main() {
	wg.Add(2)

	ch := make(chan string) // 实例化一个管道

	go say("Hello", ch)
	go say("World", ch)

	for {
		println(<-ch) //循环从管道取数据
	}

	wg.Wait()
}
```
简单说明一下，这里就是实例化了一个管道，go启动的协程同时向这个2个管道输出数据，主线程使用了一个for循环从管道里面取数据，其实就是一个生产者和消费者模式，和redis队列有点像

值得一说的是 World 和 Hello 进入管道的顺序是不固定的，可能大家实验的时候发现好像是固定的，那是因为电脑跑的太快了，你把循环数据放大，或者在里面加个睡眠再看看

但是这个程序是有bug的，在程序的运行的最后会输出这样的结果：
```
fatal error: all goroutines are asleep - deadlock! 
```
报错信息的提示意思是所有的协程都睡眠了，程序监测到死锁！为什么会这样呢？我是这样理解的，go的管道默认是阻塞的(假如你不设置缓存的话)，你那边放一个，我这头才能取一个，
如果你那边放了东西这边没人取，程序就会一直等下去，死锁了，同时，如果那边没人放东西，你这边取也取不到，也会发生死锁！

如何解决这个问题呢？标准的做法是主动关闭管道，或者你知道你应该什么时候关闭管道, 当然你结束程序管道自然也会关掉！针对上面的演示代码，可以这样写：
```
i := 1
for {
    str := <- ch
    println(str)

    if i >= 10{
        close(ch)
        break
    }
    i++
}

```
因为我们明确知道总共会输出10个单词，所以这里简单做了一个判断，大于10就关闭管道退出for循环，就不会报错了！下面是一个利用select从管道取数据的例子：
```
package main

import (
	"strconv"
	"fmt"
	"time"
)

func main() {
	ch1 := make(chan int)
	ch2 := make(chan string)
	go pump1(ch1)
	go pump2(ch2)
	go suck(ch1, ch2)
	time.Sleep(time.Duration(time.Second*30))
}

func pump1(ch chan int) {
	for i := 0; ; i++ {
		ch <- i * 2
		time.Sleep(time.Duration(time.Second))
	}
}

func pump2(ch chan string) {
	for i := 0; ; i++ {
		ch <- strconv.Itoa(i+5)
		time.Sleep(time.Duration(time.Second))
	}
}

func suck(ch1 chan int, ch2 chan string) {
	chRate := time.Tick(time.Duration(time.Second*5)) // 定时器
	for {
		select {
		case v := <-ch1:
			fmt.Printf("Received on channel 1: %d\n", v)
		case v := <-ch2:
			fmt.Printf("Received on channel 2: %s\n", v)
		case <-chRate:
			fmt.Printf("Log log...\n")
		}
	}
}

```
输出结果如下：
```
Received on channel 1: 0
Received on channel 2: 5
Received on channel 2: 6
Received on channel 1: 2
Received on channel 1: 4
Received on channel 2: 7
Received on channel 1: 6
Received on channel 2: 8
Received on channel 2: 9
Received on channel 1: 8
Log log...
Received on channel 2: 10
Received on channel 1: 10
Received on channel 1: 12
Received on channel 2: 11
Received on channel 2: 12
Received on channel 1: 14
```
这个程序建立了2个管道一个传输int，一个传输string，同时启动了3个协程，前2个协程非常简单，就是每隔1s向管道输出数据，第三个协程是不停的从管道取数据，
和之前的例子不一样的地方是，pump1 和 pump2是2个不同的管道，通过select可以实现在不同管道之间切换，哪个管道有数据就从哪个管道里面取数据，如果都没数据就等着，
还有一个定时器功能可以每隔一段时间向管道输出内容！

最后，值得一说的是，go 自带的web server性能非常强悍，主要就是因为使用了协程，对于每一个web请求，服务器都会新开一个go协程去处理，
一个服务器可以轻松同时开启上万个协程，好了，就说这么多，感兴趣的可以深入了解一下GoLang！