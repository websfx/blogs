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
这些类和方法节省了开发中查库的操作时间，但本质上还是拼SQL，只不过调用的时候看起来更面向对象，已经非常方便了，但是ORM的功能还要比这个多一点，能够方便的处理表与表的之间的关系。

### 2.Doctrine
Doctrine是symfony框架默认ORM，下面我就简单介绍一下PHP重量级ORM doctrine，官网连接: https://www.doctrine-project.org/ 

1.安装

一.按照官方的教程，最好的方式是使用composer:
```json
{
    "require": {
        "doctrine/orm": "^2.6.2",
        "symfony/yaml": "2.*"
    }
}
```
二.在项目根目录创建一个bootstrap.php文件：

```php
<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'dbname' => 'blog',
    'user' => 'root',
    'password' => '123456',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
    'charset' => 'utf8',
);
// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);
```
这里面有一些需要注意的地方，$idDevMode 配置是否开发模式.

$config按照官方说法现在推荐使用 Annotation 也就说注解的方式配置，还支持xml和yaml，yaml这种方式已经被deprecated了，还有需要把src替换成你自己项目的目录，在本例中，是app。

下面还有数据库连接配置，官方给的案例是使用了sqlite了，这里改成了MySQL。

三.配置命令行工具

同样在项目根目录新建一个 cli-config.php 文件：
```php
<?php
// cli-config.php
require_once "bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
```
这样就可以使用命令行工具执行一些操作，比如说生成数据表，更新数据表

四.使用Annotation创建数据表

先来一个简单的数据库实体，在app目录下创建一个 Product.php 文件，这个文件其实可以理解为是model，即数据库模型文件！内容如下：
```php
<?php
namespace App;
/**
 * @Entity @Table(name="products",options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * Class Product
 * @package App
 */
class Product
{
    /**
     * @ID @Column(type="integer") @GenerateDValue
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @return int
     */
    ......more code
}
```
后面的setter和getter这里省略了，如果有人对 **annotation** 这种注解方法比较熟悉的话应该可以看懂。

首先在类的注释上，使用了@Entity表明这是一个数据库实体。@Table指定了表名，@ID表明的是主键，@Column表明是数据表字段，使用type声明了类型！

然后使用命令```vendor/bin/doctrine orm:schema-tool:update --force --dump-sql```就可以生成数据表：
```shell
 The following SQL statements will be executed:

     CREATE TABLE products (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB;

 Updating database schema...

     1 query was executed
                                                                                                      
 [OK] Database schema updated successfully!  
```
可以看到，使用这种方式，完全不用担心数据库问题，无论是mysql还是sql server，或者oracle，都没问题，一键迁移，ORM抹平了数据库之间的差异！

五.持久化数据到数据表

上面的步骤搞定了数据库创建的问题，下面来介绍一下如何插入数据到数据表，为了方便，这里我直接写在index.php里面：
```php
<?php
require "vendor/autoload.php";
require "bootstrap.php";

$product = new \App\Product();
$product->setName("ORM的应用");

$entityManager->persist($product);
$entityManager->flush();

echo "Created Product Success with ID: ".$product->getId();
var_dump($product);
```
可以看出来这是一个完全OOP的写法，是先实例化一个数据表实体，然后通过setter去设置去属性，最后调用persist和flush持久化数据库里面。

六.查询数据

使用ORM查询数据也很简单,：
```php
<?php
//查询所有
$productRepository = $entityManager->getRepository('\App\Product');
$products = $productRepository->findAll();

foreach ($products as $product) {
    var_dump($product);
    var_dump($product->getName());
}

//查询单个
$id = 3;
$product = $entityManager->find('Product', $id);
if ($product === null) {
    echo "No product found.\n";
    exit(1);
}
var_dump($product);
```
如果想对数据进行修改也很简单，比如在上面的例子里面，我们查询出id为3的数据，现在我们想修改这条数据:
```php
<?php
$product->setName("ORM更新数据");
$entityManager->flush();
```
我们只需调用这个对象的setter方法，然后flush即可，也是OOP的操作方式！

七.表与表之间的关系

数据表和数据表之间的关系总体来说可以分为下面几种：1对1，1对多，多对多，在doctrine里面有细分为下面几种：
![](http://ww1.sinaimg.cn/large/5f6e3e27ly1fx6n9nprvzj208n09raab.jpg)

划分的有点复杂和难理解，这里我就简单介绍其中一种：oneToMany，即1对多关系，这个其实很常见，比如说一个产品可以有多个评论。

首先，先定义一下评论表comment, 基本上和product差不多：
```php
<?php
namespace App;
/**
 * @Entity @Table(name="comments",options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 * Class Product
 * @package App
 */
class Comment
{
    /**
     * @ID @Column(type="integer") @GenerateDValue
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $content;
    
    .......more code
}
``` 

接下来，我们就需要对product 和 comment 做一些改动，建立关联关系！






