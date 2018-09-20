<?php

namespace Code;

require_once 'Node.php';

define('LH', +1);
define('EH', 0);
define('RH', -1);

class Tree
{
    /**
     * @var Node
     */
    public $root = null;

    /**
     * 插入
     * @param $key
     * @param $data
     */
    public function insert($key, $data)
    {
        $node = new Node($key, $data);

        if ($this->root == null) {
            $this->root = $node;
        } else {
            $current = $this->root;
            $parent  = null;
            while (true) {
                $parent = $current;
                // 如果数字比当前节点小，则存左边
                if ($key < $current->key) {
                    $current = $current->leftNode;
                    if ($current == null) {
                        $parent->leftNode = $node;
                        return;
                    }
                } else {
                    $current = $current->rightNode;
                    if ($current == null) {
                        $parent->rightNode = $node;
                        return;
                    }
                }
            }
        }
    }

    /**
     * 查找
     * @param $key
     * @return Node|null
     */
    public function find($key)
    {
        $current = $this->root;
        while ($key != $current->key) {
            if ($key > $current->key) {
                $current = $current->rightNode;
            } else {
                $current = $current->leftNode;
            }
            if ($current == null) {
                return null;
            }
        }

        return $current;
    }

    /**
     * 求树的最值
     */
    public function mVal(): array
    {
        $minNode = null;
        $maxNode = null;

        $current = $this->root;
        while ($current != null) {
            $maxNode = $current;
            $current = $current->rightNode;
        }

        $current = $this->root;
        while ($current != null) {
            $minNode = $current;
            $current = $current->leftNode;
        }

        return ['minNode' => $minNode, 'maxNode' => $maxNode];
    }

    /**
     * 反转二叉树
     * @param Node $root
     * @return null
     */
    public function inverse($root)
    {
        if ($root == null) {
            return null;
        }
        $tmp = $root->leftNode;

        $root->leftNode  = $this->inverse($root->rightNode);
        $root->rightNode = $this->inverse($tmp);

        return $root;
    }

    /**
     * 前序遍历算法
     * @param $node
     */
    public function preOrderTraverse($node)
    {
        if ($node == null) {
            return;
        }
        echo $node->key . '--->' . $node->data . "\n";
        $this->preOrderTraverse($node->leftNode);
        $this->preOrderTraverse($node->rightNode);
    }

    /**
     * 对以p为根的二叉排序树作右旋处理
     * 处理之后p指向新的树根节点，即旋转处理之前的左子树的树节点
     * @param $p Node
     */
    public function RRotate(Node &$p)
    {
        $l = $p->leftNode;

        $p->leftNode = $l->rightNode;

        $l->rightNode = $p;

        $p = $l;
    }

    /**
     * 对以p为根的二叉排序树作左旋处理
     * 处理之后p指向新的树根节点，即旋转处理之前的右子树的树节点
     * @param $p Node
     */
    public function LRotate(Node &$p)
    {
        $r = $p->rightNode;

        $p->rightNode = $r->leftNode;

        $r->leftNode = $p;

        $p = $r;
    }

    /**
     * 左平衡旋转
     * @param $root Node
     */
    public function leftBalance(Node &$root)
    {
        $l = $root->leftNode;

        switch ($l->bf) {
            case EH:
                $l->bf    = RH;
                $root->bf = LH;
                self::RRotate($root);
                break;
            case LH:
                $root->bf = $l->bf = EH;
                self::RRotate($root);
                break;
            case RH:
                $lr = $l->rightNode;
                switch ($lr->bf) {
                    case LH:
                        $root->bf = RH;
                        $l->bf    = EH;
                        break;
                    case EH:
                        $root->bf = $l->bf = EH;
                        break;
                    case RH:
                        $root->bf = EH;
                        $l->bf    = LH;
                        break;
                }
                $lr->bf = EH;
                self::LRotate($root->leftNode);
                self::RRotate($root);
        }
    }

    /**
     * 右平衡旋转
     * @param $root Node
     */
    public function rightBalance(Node &$root)
    {
        $r = $root->rightNode;

        switch ($r->bf) {
            case RH:
                $root->bf = $r->bf = EH;
                self::LRotate($root);
                break;
            case EH:
                $root->bf = RH;
                $r->bf    = LH;
                self::LRotate($root);
                break;
            case LH:
                $rl = $r->leftNode;
                switch ($rl->bf) {
                    case EH:
                        $root->bf = $r->bf = EH;
                        break;
                    case RH:
                        $root->bf = LH;
                        $rl->bf   = EH;
                        break;
                    case LH:
                        $root->bf = EH;
                        $r->bf    = RH;
                        break;
                }
                $rl->bf = EH;
                self::RRotate($root->rightNode);
                self::LRotate($root);
                break;
        }
    }

    /**
     * 平衡二叉树插入
     * @param Node $root
     * @param int $key
     * @param string $data
     * @param bool $taller
     * @return bool
     */
    public function insertAvl(&$root, int $key, string $data, bool &$taller = false)
    {
        if (!$root) {
            $root           = new Node($key, $data);
            $root->leftNode = $root->rightNode = null;
            $root->bf       = EH;
            $taller         = true;
            return true;
        } else {
            if ($key == $root->key) {
                $taller = false;
                return false;
            }

            if ($key < $root->key) {
                //在左子树中搜索
                if (!self::insertAvl($root->leftNode, $key, $data, $taller)) {
                    return false;
                }
                if ($taller) {
                    switch ($root->bf) { //检查树的平衡度
                        case LH:
                            self::leftBalance($root);
                            $taller = false;
                            break;
                        case EH:
                            $root->bf = LH;
                            $taller   = true;
                            break;
                        case RH:
                            $root->bf = EH;
                            $taller   = false;
                            break;
                    }
                }
            } else {
                //在右子树中搜索
                if (!self::insertAvl($root->rightNode, $key, $data, $taller)) {
                    return false;
                }
                if ($taller) {
                    switch ($root->bf) { //检查树的平衡度
                        case LH:
                            $root->bf = EH;
                            $taller   = false;
                            break;
                        case EH:
                            $root->bf = RH;
                            $taller   = true;
                            break;
                        case RH:
                            self::rightBalance($root);
                            $taller = false;
                            break;
                    }
                }
            }
        }

        return true;
    }
}


$tree = new Tree();
//$tree->insert(3, 'AbC');
//$tree->insert(2, 'Jack');
//$tree->insert(1, 'Baby');
//$tree->insert(4, 'Luck');
//$tree->insert(5, 'Ketty');
//$tree->insert(6, 'LA');
//$tree->insert(7, 'Buck');
//$tree->insert(10, 'Jun');
//$tree->insert(9, 'Hello');
//$tree->insert(8, 'Name');
$tree->insertAvl($root, 3, 'AbC');
$tree->insertAvl($root, 2, 'Jack');
$tree->insertAvl($root, 1, 'Baby');
$tree->insertAvl($root, 4, 'Luck');
$tree->insertAvl($root, 5, 'Ketty');
$tree->insertAvl($root, 6, 'LA');
$tree->insertAvl($root, 7, 'Buck');
$tree->insertAvl($root, 10, 'Jun');
$tree->insertAvl($root, 9, 'Hello');
$tree->insertAvl($root, 8, 'Name');

//$res  = $tree->find(16);
//$mVal = $tree->mVal();
//var_dump($res);
//var_dump($mVal);
//
//$tree->inverse($tree->root);
var_dump($tree);

//$tree->preOrderTraverse($tree->root);
