# 适配器模式

适配器(Adapter)，咱们生活中的用到的电器插头，专业的叫法就是电源适配器，只不过咱们平时很少用适配器这个叫法, 有笔记本适配器、手机电源适配器、还有各种其它电子设备。之所以需要电源适配器是因为不同设备对电压和电流的要求不一样，但是标准市电都是220v，所以需要把高压电转换成需要的电压。

>这个模式有点像装饰模式，需要注意的一点适配器模式不是在设计时候添加的，而是解决正在运行的项目问题。比如说现在很多电脑的适配器都通用了，因为大家统一制定了一个标准，比如说type-c接口。但是以前的老设备就没办法了。

![适配器](https://segmentfault.com/img/remote/1460000013773250)

举个例子，现在的手机很多都采用了USB Type-c 接口,但是以前的手机是采用的 Micro USB 接口，但是使用转接头也可以用原来的Micro USB数据线。
假如我手中有Android数据线和iphone手机，我想用安卓数据线给iphone手机充电。此时：

```shell
初始角色：Android数据线
目标角色：iphone手机
适配器：数据线转换器
```

代码演示：

安卓数据线:

```php
class AndroidLine
{
    public function Acharge()
    {
        echo "Android数据线充电中...\n";
    }
}
```

iPhone手机：

```php
interface AbstractIphone
{
    public function Icharge();
}
```

数据线：

```php
class PhoneLineAdapter extends AndroidLine implements AbstractIphone
{
    public function Icharge()
    {
        echo "转换一下\n"；
        parent::Acharge();
    }
}
```

调用：

```php
$adapter = new PhoneLineAdapter();
$adapter->charge();
```
