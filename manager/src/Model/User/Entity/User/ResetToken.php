<?php


namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class ResetToken
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var \DateTimeImmutable
     */
    private $expiries;

    public function __construct(string $token, \DateTimeImmutable $expiries)
    {
        Assert::NotEmpty($token);
        $this->token = $token;
        $this->expiries = $expiries;
    }

    public function isExpiriesTo(\DateTimeImmutable $date): bool
    {
        return $this->expiries <= $date;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}