<?php

namespace App\Model\User\Entity\User;

class User
{
    private const STATUS_WAIT = 'wait';
    private const STATUS_ACTIVE = 'active';
    /**
     * @var Id
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @var Email
     */
    private $email;

    /**
     * @var string
     */
    private $passwordhash;

    /**
     * @var string | null
     */
    private $confirmToken;

    /**
     * @var string
     */
    private $status;

    public function __construct(Id $id, \DateTimeImmutable $date, Email $email, string $hash, string $token)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordhash = $hash;
        $this->confirmToken = $token;
        $this->status = self::STATUS_WAIT;
    }

    public function confirmSignUp(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('Пользователь уже подтверждён.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->confirmToken = null;
    }

    public function isWait(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    /**
     * @return string
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordhash;
    }

    /**
     * @return string|null
     */
    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }


}