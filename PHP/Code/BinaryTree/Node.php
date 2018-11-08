<?php
namespace Code;

class Node
{
    public $key;

    public $data;

    public $bf; //平衡因子

    public $leftNode;

    public $rightNode;

    public function __construct($key, $data)
    {
        $this->key  = $key;
        $this->data = $data;
    }

    public function __toString()
    {
        return $this->key . '--->' . $this->data;
    }
}
