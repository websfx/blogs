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
     * 这里通过注释设置了需要映射的实体和对应的字段
     * @ManyToOne(targetEntity="Product", inversedBy="comments")
     * @JoinColumn(name="product_id", referencedColumnName="id")
     * @var Product
     */
    private $product;

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return self
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}
