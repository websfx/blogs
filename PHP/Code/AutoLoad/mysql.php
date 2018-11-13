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


