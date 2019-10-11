<?php


namespace App\Model\User\Service;


class PasswordHasher
{
    public function hash(string $password): string
    {
        $hash = password_hash($password, PASSWORD_ARGON2I);
        if ($hash === false) {
            throw new \RuntimeException('Ошибка генерации password hash.');
        }
        return $hash;
    }
}