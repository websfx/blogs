>工厂方法模式是简单工厂模式的仅一步深化， 在工厂方法模式中，我们不再提供一个统一的工厂类来创建所有的对象，而是针对不同的对象提供不同的工厂。也就是说每个对象都有一个与之对应的工厂。

---
在代码里面，就是刚才的 LogFactory 类变成一个接口：
```php
<?php

namespace App\FactoryMethod;

interface LogFactory
{
    public function getLogFactory();
}
```
然后我们分部新建两个类去实现这个接口：

```php
<?php

namespace App\FactoryMethod;

class FileLogFactory implements LogFactory
{
    public function getLog()
    {
        return new FileLog();
    }
}
```
```php
<?php

namespace App\FactoryMethod;

class MongoLogFactory implements LogFactory
{
    public function getLog()
    {
        return new MongoLog();
    }
}
```
然后我们可以这么使用：

```php
<?php

require "../include.php";

$fileLogFactory = new \App\FactoryMethod\FileLogFactory();
$fileLog = $fileLogFactory->getLog();
$fileLog->log("something");
```

可以看到，在工厂方法模式里面每一个对象都有一个工厂类, 而且工厂方法模式让一个类的实例化延迟到其子类，更灵活！虽然看上去更复杂一点，但是设计模式要解决的其实是代码的课维护性和扩展性问题！

还有一种模式叫作抽象工厂模式，更复杂，更难理解，这里简单说一下：
>抽象工厂模式是工厂方法的仅一步深化，在这个模式中的工厂类不单单可以创建一个对象，而是可以创建一组对象。Provide an interface for creating families of related or dependent objects without specifying their concrete classes。 为创建一组相关或相互依赖的对象提供一个接口，而且无需指定它们的具体类。
    
需要注意一点，这种模式强调的是对象之间有依赖关系。举个例子，假如有一个工厂生产联想笔记本，但是这个工厂不仅仅生产笔记本，同时还会生产相关配件，比如说联想鼠标，联想键盘，每生产一个联想笔记本，就得对应生产一套联想键盘鼠标！