###简介
堆（英语：heap)是计算机科学中一类特殊的数据结构的统称。堆通常是一个可以被看做一棵树的数组对象。堆总是满足下列性质：
堆中某个节点的值总是不大于或不小于其父节点的值；堆总是一棵完全二叉树。
将根节点最大的堆叫做最大堆或大根堆，根节点最小的堆叫做最小堆或小根堆。常见的堆有二叉堆、斐波那契堆等。（以上内容网上摘取，是不是看了之后一脸懵逼？还是看看代码吧）
###1.类摘要
```
abstract SplHeap implements Iterator , Countable {
	/* 方法 */
	public __construct ( void )
	abstract protected int compare ( mixed $value1 , mixed $value2 )
	public int count ( void )
	public mixed current ( void )
	public mixed extract ( void )
	public void insert ( mixed $value )
	public bool isEmpty ( void )
	public mixed key ( void )
	public void next ( void )
	public void recoverFromCorruption ( void )
	public void rewind ( void )
	public mixed top ( void )
	public bool valid ( void )
}
```
从这个类的定义可以看出来，这是一个抽象类，但是只有一个抽象实现需要方法compare，啥意思呢？文档的定义是： Compare elements in order to place them correctly in the heap while sifting up.翻译过来就是比较元素，在筛选时候正确的放置其位置，问题来了，和谁比呢？

###2.实例
```
<?php

namespace SPL;

class SPLHeap extends \SplHeap
{
    protected function compare($value1, $value2)
    {
        return $value1 > $value2 ? -1 : 1;
    }
}

$hp = new SPLHeap();
$hp->insert(1);
$hp->insert(9);
$hp->insert(7);
$hp->insert(7);
$hp->insert(5);
$hp->insert(11);
$hp->insert(55);
$hp->insert(55);
$hp->insert(20);

$hp->rewind();
foreach ($hp as $value) {
    echo $value . "\n";
}
```
运行结果:从小到大排序输出 1,5,7,9....
从上述例子可以发现compare函数的主要作用就是提供一个排序规则，通过返回一个大于0或者小于0的数来排序，其他方法和链表差不多！
PHP SPL里面还有一个SplMinHeap和SplMaxHeap,即最小堆和最大堆，它们其实都是继承的SplHeap，方法基本上也一样！
