<?php

namespace App\Model\User\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user_users", uniqueConstraints={
 * @ORM\UniqueConstraint(columns={"email"}),
 * @ORM\UniqueConstraint(columns={"reset_token_token"})
 * })
 */
class User
{
    private const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';
    private const STATUS_NEW = 'new';

    /**
     * @var Id
     * @ORM\Column(type="user_user_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @var Email
     * @ORM\Column(type="user_user_email", nullable=true)
     */
    private $email;

    /**
     * @var string | null
     * @ORM\Column(type="string", nullable=true, name="password_hash")
     */
    private $passwordHash;

    /**
     * @var string | null
     * @ORM\Column(type="string", nullable=true, name="confirm_token")
     */
    private $confirmToken;

    /**
     * @var Email | null
     * @ORM\Column(type="user_user_email", name="new_email", nullable=true)
     */
    private $newEmail;

    /**
     * @var string | null
     * @ORM\Column(type="string", name="new_email_token", nullable=true)
     */
    private $newEmailToken;

    /**
     * @var ResetToken | null
     * @ORM\Embedded(class="ResetToken", columnPrefix="reset_token_")
     */
    private $resetToken;

    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private $status;

    /**
     * @var Role
     * @ORM\Column(type="user_user_role")
     */
    private $role;

    /**
     * @var Network[] | ArrayCollection
     * @ORM\OneToMany(targetEntity="Network", mappedBy="user", orphanRemoval=true, cascade={"persist"})
     */
    private $networks;

    private function __construct(Id $id, \DateTimeImmutable $date)
    {
        $this->id = $id;
        $this->date = $date;
        $this->role = Role::user();
        $this->networks = new ArrayCollection;
    }

    public static function signUpByEmail(Id $id, \DateTimeImmutable $date, Email $email, string $hash, string $token): self
    {
        $user = new self($id, $date);
        $user->email = $email;
        $user->passwordHash = $hash;
        $user->confirmToken = $token;
        $user->status = self::STATUS_WAIT;
        return $user;
    }

    public static function signUpByNetwork(Id $id, \DateTimeImmutable $date, string $network, string $identity): self
    {
        $user = new self($id, $date);
        $user->attachNetwork($network, $identity);
        $user->status = self::STATUS_ACTIVE;
        return $user;
    }

    public function confirmSignUp(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('Пользователь уже подтверждён.');
        }
        $this->status = self::STATUS_ACTIVE;
        $this->confirmToken = null;
    }

    public function requestPasswordReset(ResetToken $token, \DateTimeImmutable $date): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('Пользователь не активирован.');
        }
        if (!$this->email) {
            throw new \DomainException('Email не задан.');
        }
        if ($this->resetToken && !$this->resetToken->isExpiriesTo($date)) {
            throw new \DomainException('Сброс пароля уже запрошен.');
        }
        $this->resetToken = $token;
    }

    public function passwordReset(\DateTimeImmutable $date, string $hash): void
    {
        if (!$this->resetToken) {
            throw new \DomainException('Сброс пароля не запрошен.');
        }
        if ($this->resetToken->isExpiriesTo($date)) {
            throw new \DomainException('Токен сброса пароля просрочен.');
        }
    }

    private function attachNetwork(string $network, string $identity): void
    {
        foreach ($this->networks as $existing) {
            if ($existing->isForNetwork($network) === $network) {
                throw new \DomainException('Сеть уже привязана.');
            }
        }
        $this->networks->add(new Network($this, $network, $identity));
    }

    public function changeRole(Role $role): void
    {
        if ($this->role->isEqual($role)) {
            throw new \DomainException('Эта роль уже задана.');
        }
        $this->role = $role;
    }

    public function requestEmailChanging(Email $email, string $token): void
    {
        if (!$this->isActive()) {
            throw new \DomainException('Пользователь не активирован.');
        }
        if ($this->email && $this->email->isEqual($email)) {
            throw new \DomainException('Email такой же.');
        }
        $this->newEmail = $email;
        $this->newEmailToken = $token;
    }

    public function confirmEmailChanging(string $token): void
    {
        if (!$this->newEmailToken) {
            throw new \DomainException('Изменение email не запрошено.');
        }
        if ($this->newEmailToken !== $token) {
            throw new \DomainException('Ошибочный код смены email.');
        }
        $this->email = $this->newEmail;
        $this->newEmail = null;
        $this->newEmailToken = null;
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
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return Email
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
        return $this->passwordHash;
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

    /**
     * @return ResetToken|null
     */
    public function getResetToken(): ?ResetToken
    {
        return $this->resetToken;
    }

    /**
     * @return Email|null
     */
    public function getNewEmail(): ?Email
    {
        return $this->newEmail;
    }

    /**
     * @return string|null
     */
    public function getNewEmailToken(): ?string
    {
        return $this->newEmailToken;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @ORM\PostLoad
     */
    public function checkEmbeds()
    {
        if ($this->resetToken->isEmpty()) {
            $this->resetToken = null;
        }
    }
}