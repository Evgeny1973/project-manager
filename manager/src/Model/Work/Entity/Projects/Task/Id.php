<?php


namespace App\Model\Work\Entity\Projects\Task;


use Webmozart\Assert\Assert;

class Id
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value;
    }


}