<?php
require "vendor/autoload.php";
require "bootstrap.php";

$product = new \App\Product();

$product->setName("ORM的应用");

$entityManager->persist($product);

$entityManager->flush();

echo "Created Product Success with ID: ".$product->getId();

var_dump($product);


$productRepository = $entityManager->getRepository('\App\Product');
$products = $productRepository->findAll();

//foreach ($products as $product) {
//    var_dump($product);
//    var_dump($product->getName());
//}

//查询单个
$id = 3;
$product = $entityManager->find('\App\Product', $id);
if ($product === null) {
    echo "No product found.\n";
    exit(1);
}

$product->setName("ORM更新数据");
$entityManager->flush();

var_dump($product);
