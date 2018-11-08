>这种类型的设计模式属于创建型模式,使用多个简单的对象一步一步构建成一个复杂的对象,一个 Builder 类会一步一步构造最终的对象。该 Builder 类是独立于其他对象的。

![](http://ww1.sinaimg.cn/large/5f6e3e27ly1fx0tajw4g0j20sn0h340h.jpg)

举个例子：

小明想组装一个台式电脑，小明对电脑配置一窍不通，就直接跑到电脑城给装机老板说我要一台打游戏非常爽的电脑，麻烦你给装一下「配置什么的你给我推荐一下吧」，于是老板就让它的员工「小美」按小明的要求装了一个性能灰常牛 B 的电脑，1 个小时后电脑装好了，小明交钱拿电脑走人。不一会儿小张又来了，要一个满足平时写文章就可以的电脑，老板针对小张的要求给不同的装机配置。不同的人有不同的配置方案「但是装机流程是一样的」，这就是一个典型的建造者模式

1.首先，先有一个电脑类：
```php
<?php

namespace App\Builder;

class Computer
{
    private $cpu;
    private $hdd;
    private $mb;
    private $mem;
    ....
    ....
}
```

2.然后，电脑建造类接口：
```php
<?php

namespace App\Builder;

interface Builder
{
    public function createCpu(string $cpu);

    public function createHdd(string $hdd);

    public function createMb(string $mb);

    public function createMem(string $mem);

    public function createComputer();
}
```

3.然后，具体实现电脑建造类接口的类：
```php
<?php

namespace App\Builder;

class ConcreteBuilder implements Builder
{
    private $computer;

    public function __construct()
    {
        $this->computer = new Computer();
    }

    public function createCpu(string $cpu)
    {
        $this->computer->setCpu($cpu);
    }

    public function createHdd(string $hdd)
    {
        $this->computer->setHdd($hdd);
    }

    public function createMb(string $mb)
    {
        $this->computer->setMb($mb);
    }

    public function createMem(string $mem)
    {
        $this->computer->setMem($mem);
    }

    public function createComputer()
    {
        return $this->computer;
    }
}
```
4.最后，还需要一个指挥调用者：
```php
<?php

namespace App\Builder;

class Director
{
    private $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function buildCpu(string $cpu)
    {
        $this->builder->createCpu($cpu);
        return $this;
    }

    public function buildHdd(string $hdd)
    {
        $this->builder->createHdd($hdd);
        return $this;
    }

    public function buildMb(string $mb)
    {
        $this->builder->createMb($mb);
        return $this;
    }

    public function buildMem(string $mem)
    {
        $this->builder->createMem($mem);
        return $this;
    }
    
    public function createComputer(): Computer
    {
        return $this->builder->createComputer();
    }
}
```

5.实际调用方法：
```php
<?php

require "../include.php";

$builder = new \App\Builder\ConcreteBuilder();

$director = new \App\Builder\Director($builder);

$computer = $director->buildCpu("i7 8700k")
    ->buildHdd("Samsung 970")
    ->buildMb("Z370")
    ->buildMem("KingSD 16G")
    ->createComputer();

echo $computer;
```

有人说，本来几个方法就可以搞定的事情，使用设计模式之后居然多出来这么多，不过大家应该可以看出来，在这个案例里面，builder是可以很容易改变的，也就是解耦。

假如说现在需要组装一台手机，大家都知道，手机构造其实和电脑差不多，可以说现在的智能手机和电脑基本上一样了，虽然组成的元器件都差不多，都是cpu，内存，硬盘，主板，但是具体不一样，这时候就可以新建一个手机的builder用来创建手机。
