### 简介
SplFixedArray，字面意思就是固定大小的数组，意思就是在定义的时候就要确定大小，有点C语言基础的人估计都知道在C语言里面数组的大小是固定的，而PHP则随意很多，代价就是性能，所以这个数组比那个性能高很多，这里有一组数据：
> 
On a PHP 5.4 64 bits linux server, I found SplFixedArray to be always faster than array().
* small data (1,000):
    * write: SplFixedArray is 15 % faster
    * read:  SplFixedArray is  5 % faster
* larger data (512,000):
    * write: SplFixedArray is 33 % faster
    * read:  SplFixedArray is 10 % faster


### 1.类摘要
```
SplFixedArray implements Iterator , ArrayAccess , Countable {
	/* 方法 */
	public __construct ([ int $size = 0 ] )
	public int count ( void )
	public mixed current ( void )
	public static SplFixedArray fromArray ( array $array [, bool $save_indexes = true ] )
	public int getSize ( void )
	public int key ( void )
	public void next ( void )
	public bool offsetExists ( int $index )
	public mixed offsetGet ( int $index )
	public void offsetSet ( int $index , mixed $newval )
	public void offsetUnset ( int $index )
	public void rewind ( void )
	public int setSize ( int $size )
	public array toArray ( void )
	public bool valid ( void )
	public void __wakeup ( void )
}
```
### 2.实例
```
<?php

namespace SPL;

$fixArr    = new \SplFixedArray(10);
$fixArr[0] = 1;
$fixArr[1] = 2;
$fixArr[2] = 3;

foreach ($fixArr as $value) {
    echo $value . "\n";
}
```
从使用上说，fixed 数组和普通数组大部分没有区别，最大的问题就在于你必须先确定数组大小！某些情况下还是挺有用，能够提升性能！