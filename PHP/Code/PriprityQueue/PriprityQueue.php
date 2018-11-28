<?php

class MyQueue extends SplPriorityQueue
{
    public function compare($priority1, $priority2)
    {
        if ($priority1->age === $priority2->age) {
            return 0;
        }
        return $priority1->age < $priority2->age ? -1 : 1;
    }
}

class Person
{

    public $age;

    public function __construct($age)
    {
        $this->age = $age;
    }
}

$queue = new MyQueue();

$queue->insert("A", new Person(2));
$queue->insert("B", new Person(17));
$queue->insert("C", new Person(4));
$queue->insert("D", new Person(10));
$queue->insert("E", new Person(1));

//获取优先级最高的元素
echo $queue->top() . "\n";

//按照优先级从大到小遍历所有元素
while ($queue->valid()) {
    echo $queue->current() . "\n";
    $queue->next();
}
