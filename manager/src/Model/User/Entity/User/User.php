<?php

namespace App\Model\User\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;

class User
{
    private const STATUS_WAIT = 'wait';
    private const STATUS_ACTIVE = 'active';
    private const STATUS_NEW = 'new';

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

    /**
     * @var Network[] | ArrayCollection
     */
    private $networks;

    public function __construct(Id $id, \DateTimeImmutable $date)
    {
        $this->id = $id;
        $this->date = $date;
        $this->status = self::STATUS_NEW;
        $this->networks = new ArrayCollection;
    }

    public function signUpByEmail(Email $email, string $hash, string $token): void
    {
        if (!$this->isNew()) {
            throw new \DomainException('Пользователь уже зарегистрирован.');
        }
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

    public function signUpByNetwork(string $network, string $identity): void
    {
        if (!$this->isNew()) {
            throw new \DomainException('Пользователь уже зарегистрирован.');
        }
        $this->attachNetwork($network, $identity);
        $this->status = self::STATUS_ACTIVE;
    }

    private function attachNetwork(string $network, string $identity): void
    {
        foreach ($this->networks as $existing) {
            if ($existing->isForNetwork() === $network) {
                throw new \DomainException('Сеть уже привязана.');
            }
        }
        $this->networks->add(new Network($this, $network, $identity));
    }
    
    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
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

    /**
     * @return Network[]
     */
    public function getNetworks(): array
    {
        return $this->networks->toArray();
    }

}