### 1.什么是ORM？
>对象关系映射（Object Relational Mapping，简称ORM）模式是一种为了解决面向对象与关系数据库存在的互不匹配的现象的技术。简单的说，ORM是通过使用描述对象和数据库之间映射的元数据，将程序中的对象自动持久化到关系数据库中。

ORM并不是PHP独有的东西，只要和数据库打交道的语言都可以使用ORM，常见的ORM有: 比如Java Web三大框架里面Hibernate，还有Doctrine(PHP重量级的ORM) ，Eloquent（laravel框架默认ORM，也可以单独使用）。

ORM是完全采用面向对象的思想去操作数据库，不用去拼SQL，对于复杂的SQL，ORM也支持直接运行原生SQL，使用ORM的利弊咱放到后面说，咱先回顾一下平时咱们都是怎么操作数据库？举个例子，现在有一个库blog，一张表article，大部分的时候都是这是方式：新建MySQL连接，然后执行数据库操作，需要手写SQL：
```php
<?php
$connect = mysqli_connect("localhost", "root", "123456", "blog", "3306") or die("数据库连接失败！");
$connect->set_charset("utf8");

$id = 1;
$sql = "SELECT * FROM article WHERE id = $id";
$query = mysqli_query($connect, $sql);
if (!$query) {
    die("数据库查询失败!");
}

$assoc = $query->fetch_assoc();
var_dump($assoc);
```
当然上面的写法也有缺点，有一种更好的方式是使用PDO，扩展性更强，而且可以使用预处理防止SQL注入:
```php
<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=blog", "root", "123456");
} catch (PDOException $exception) {
    echo "Connect Failed" . $exception->getMessage();
}
$pdo->exec("set names utf8");

$id      = 1;
$prepare = $pdo->prepare("SELECT * FROM article WHERE id = ?");
$prepare->execute(array($id));
while ($row = $prepare->fetch()) {
    var_dump($row);
}
```

不过实际开发中，大家都是使用一些封装好的类和方法，比如laravel框架里面称之为查询构造器，我们可以使用这样方法去查询数据库：
```php
<?php
$users = DB::table('users')->get();

$price = DB::table('orders')->where('finalized', 1)->avg('price');

$users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

$orders = DB::table('orders')
                ->select('department', DB::raw('SUM(price) as total_sales'))
                ->groupBy('department')
                ->havingRaw('SUM(price) > 2500')
                ->get();
```
这些类和方法大量节省了开发中拼SQL的时间，已经非常方便了。但是这和ORM还差一点，ORM还有一个强大的地方是可以处理表和表之间的关系，举个例子，还有一张表 comment 是文章的评论，它和 article 表是一个多对1的关系，
很多ORM可以实现查询article的时候自动查询出对应评论的功能，并不需要你手动join或者再做其它操作。

### 2.Doctrine
Doctrine是symfony框架默认ORM，下面我就简单介绍一下PHP重量级ORM doctrine，有多重呢？重到让你感觉不是在写PHP, 官网连接: https://www.doctrine-project.org/ 

1.安装
按照官方的教程，最好的方式是使用composer:
```json
{
    "require": {
        "doctrine/orm": "^2.6.2",
        "symfony/yaml": "2.*"
    }
}
```

