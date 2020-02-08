<?php


namespace App\Model\Work\Entity\Members\Member;


use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public static function next()
    {
    return new self(Uuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}