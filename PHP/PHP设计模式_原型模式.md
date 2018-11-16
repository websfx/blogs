>原型模式（Prototype Pattern）是用于创建重复的对象，同时又能保证性能。这种类型的设计模式属于创建型模式，它提供了一种创建对象的最佳方式。
 这种模式是实现了一个原型接口，该接口用于创建当前对象的克隆。当直接创建对象的代价比较大时，则采用这种模式。例如，一个对象需要在一个高代价的数据库操作之后被创建。我们可以缓存该对象，在下一个请求时返回它的克隆，在需要的时候更新数据库，以此来减少数据库调用。
----
### 1.JS原型
说起原型模式，估计很多人都想起来js里面的原型和原型链，虽然js不是一个面向对象的语言，但是通过原型链也能变相实现面向对象的继承特性。

大家应该知道，在js里面没有类(class)的概念（ES6开始有）,通常情况下为了new一个对象，我们需要定义一个函数，这个函数其实就是构造函数:
```js
function Person(name, age)
{
    this.name = name;
    this.age  = age;
    this.eat = function()
    {
        alert("I can eat!");  
    };
}

var p = new Person("对象", 20);
console.log(p.name, p.age);
```
当我们需要给这个p对象添加一些方法的时候，我们一般会这么写：
```js
Person.prototype.say = function(msg)
{
	console.log(msg);
}

p.say(1111);
```
这个 **prototype** 到底是什么呢？这个就是js对象的原型，一般我们这么写是为了公用方法，有些人为了图省事，直接给Object的原型加方法:
```js
Object.prototype.hello = function()
{
    alert("所有对象都是我的儿子，都会继承我的遗产！");
}

p.hello();
```
当然这种写法不提倡，即使要继承我们也要适当的继承，该继承的时候就继承！正确的做法如下, 实际上有很多种类似写法，我这里只展示一种：
```js
function Superman(power)
{
    this.power = power;
    this.fly = function ()
    {
        alert("I can fly!");
    }
}

Superman.prototype = new Person("对象", 20);

var s = new Superman(100);
s.fly();
s.name;
s.say();
```
我们可以通过把Superman的原型指向一个对象实现继承该对象的属性和方法，同时也继承该对象原型的属性和方法。真是饶人，JS这蹩脚的继承真是搞死人，还好typescript弥补了这些缺陷！

### 2.原型模式
刚才扯的有点远，如果大家对js不熟悉就略过吧，原型模式本质上是通过clone去复制一个对象，而不是从头开始new一个新的对象。为什么要折磨做呢？比如说类初始化需要消化非常多的资源，这个资源包括数据、硬件资源等，通过 new 产生一个对象需要非常繁琐的数据准备或访问权限。

大部分时候原型模式都是结合其它设计模式一起使用的，这里先简单展示一下在PHP里面clone的用法：
```php
<?php
namespace App\Prototype;
class Character
{
    public $id;

    public $name;

    public function __construct()
    {
        echo "一些初始化工作\n";
    }

    public function say()
    {
        echo "Say something!\n";
    }
}
```
上面是一个类，下面我们开始clone，我们先实例化一个对象，然后clone该对象，最后更改clone之后的对象，可以发现通过clone之后的对象和使用new的对象完全一样, 而且对原对象没有任何影响：
```php
<?php
include "../include.php";

$char = new \App\Prototype\Character();
$char->name = "原型";
$char->id = 1;

var_dump($char);

$clone = clone $char;
$clone->id = 2;
$clone->name = "克隆之后的对象";
$clone->say();

var_dump($clone);
var_dump($char);
```
说实话，平时使用到clone的场景真的不多，这里我就不多说了！
