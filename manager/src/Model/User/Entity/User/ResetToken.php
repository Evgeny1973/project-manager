<?php


namespace App\Model\User\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class ResetToken
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $token;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
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

    /**
     * @internal for postload callback
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->token);
    }
}