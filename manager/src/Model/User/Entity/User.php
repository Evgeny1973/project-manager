<?php

namespace App\Model\User\Entity;

class User
{
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

    public function __construct(Id $id, \DateTimeImmutable $date, Email $email, string $hash)
    {
        $this->id = $id;
        $this->date = $date;
        $this->email = $email;
        $this->passwordhash = $hash;
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
}