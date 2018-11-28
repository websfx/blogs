## 1. 简介
Redis 发布订阅(pub/sub)是一种消息通信模式：发送者(pub)发送消息，订阅者(sub)接收消息。
下图展示了频道 channel1 ， 以及订阅这个频道的三个客户端 —— client2 、 client5 和 client1 之间的关系：
![pubsub1](http://upload-images.jianshu.io/upload_images/3571187-679a511c828e6966.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)

当有新消息通过 PUBLISH 命令发送给频道 channel1 时， 这个消息就会被发送给订阅它的三个客户端：

![pubsub2](http://upload-images.jianshu.io/upload_images/3571187-58fa9f79fc8c6a8d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/1240)
## 2. 实战
##### 1. 订阅端代码
```
<?php
$redis = new Redis();
$redis->connect('localhost', 6379);
$redis->subscribe(['order'], function ($redis, $chan, $msg) {
    var_dump($redis);
    var_dump($chan);
    var_dump($msg);
});
```
值得一提的是subscribe函数的第一个参数是一个数组，这意味着可以订阅多个发布端，回调函数里面有3个参数，第一个是redis实例，第二个是订阅的频道，第三个是订阅的消息内容，在命令下运行该文件就会进入等待发布端发布消息的阻塞状态！
##### 2. 发布端代码
```
<?php
$redis = new Redis();
$redis->connect('localhost', 6379);
$order = [
    'id' => 1,
    'name' => '小米6',
    'price' => 2499,
    'created_at' => '2017-07-14'
];
$redis->publish("order", json_encode($order));
```
在命令行下运行该代码，就会发现订阅端那边输出了消息：
```
class Redis#1 (1) {
  public $socket =>
  resource(5) of type (Redis Socket Buffer)
}
string(5) "order"
string(70) "{"id":1,"name":"\u5c0f\u7c736","price":2499,"created_at":"2017-07-14"}"
```
