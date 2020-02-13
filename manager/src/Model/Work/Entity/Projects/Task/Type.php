<?php


namespace App\Model\Work\Entity\Projects\Task;


use Webmozart\Assert\Assert;

class Type
{
    public const NONE = 'none';
    public const ERROR = 'error';
    public const FEATURE = 'feature';
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::NONE,
            self::ERROR,
            self::FEATURE,
        ]);
        $this->name = $name;
    }

    public function isEqual(self $other): bool
    {
        return $this->getName() === $other>getName();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}