###简介
SPL是用于解决典型问题(standard problems)的一组接口与类的集合，包括数据结构、迭代器、接口、异常等。链表是一种物理存储单元上非连续、非顺序的存储结构，数据元素的逻辑顺序是通过链表中的指针链接次序实现的。链表由一系列结点（链表中每一个元素称为结点）组成，结点可以在运行时动态生成。每个结点包括两个部分：一个是存储数据元素的数据域，另一个是存储下一个结点地址的指针域。 相比于线性表顺序结构，操作复杂。由于不必须按顺序存储，链表在插入的时候可以达到O(1)的复杂度，比另一种线性表顺序表快得多，但是查找一个节点或者访问特定编号的节点则需要O(n)的时间，而线性表和顺序表相应的时间复杂度分别是O(logn)和O(1)。
双向链表在PHP SPL里面有2种实现，一种是栈，特性是FIFO（first input first output），先进先出，就像咱排队上地铁一样，排在前面的先上地铁；还有一种是队列。特性是LIFO（last input first output），后进先出，这个看上去有点不合常理，在日常生活中的例子就是往箱子里面放东西，你肯定要把后面放进去的东西先拿出来才能拿最底下的东西。在SPL里面，全部提供了实现，这个比你自己实现效率高多了。
###1.类摘要
```
SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
	/* 方法 */
	public __construct ( void )
	public void add ( mixed $index , mixed $newval ) #添加一个元素
	public mixed bottom ( void ) 
	public int count ( void ) 
	public mixed current ( void ) # 返回当前指针指向的元素
	public int getIteratorMode ( void ) # 返回迭代模式
	public bool isEmpty ( void )
	public mixed key ( void )
	public void next ( void ) # 移动指针到下一个元素
	public bool offsetExists ( mixed $index )
	public mixed offsetGet ( mixed $index )
	public void offsetSet ( mixed $index , mixed $newval )
	public void offsetUnset ( mixed $index )
	public mixed pop ( void ) # 弹出一个元素，从队列头出列
	public void prev ( void )
	public void push ( mixed $value ) # 增加一个元素，从队列头入列
	public void rewind ( void ) # 初始化队列
	public string serialize ( void )
	public void setIteratorMode ( int $mode ) # 设置迭代模式，栈或者队列
	public mixed shift ( void ) # 弹出一个元素，从队列尾出列
	public mixed top ( void )
	public void unserialize ( string $serialized )
	public void unshift ( mixed $value ) # 增加一个元素，从队列尾入列
	public bool valid ( void )
}
```
###2.实例
```
<?php

$dll = new SplDoublyLinkedList();
# 添加元素
$dll->add(0, 'a');
$dll->add(1, 'b');
$dll->add(2, 'c');
$dll->add(3, 'd');
# 遍历链表，这个迭代模式有4种,源码里面定义的内容
#        const IT_MODE_LIFO = 2;  后进先出，其实就是栈
#        const IT_MODE_FIFO = 0;  先进先出，其实就是队列
#        const IT_MODE_DELETE = 1; 删除元素
#        const IT_MODE_KEEP = 0; 保持原来的顺序
$dll->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
for ($dll->rewind(); $dll->valid(); $dll->next()) {
    var_dump($dll->current()) . "\n";
}
```
###3.总结
平时写业务代码很少用到这些东西，不过很多PHP框架其实都用到这些了，一些库的底层也用到了，毕竟数据结构都是通用的，了解一下还是不错滴