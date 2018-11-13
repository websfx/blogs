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
     * @oneToMany(targetEntity="Comment")
     * @var
     */
    protected $comments;

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}