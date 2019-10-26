<?php


namespace App\Tests\Unit\Model\User\Entity\User\Email;

use App\Model\User\Entity\User\Email;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;
class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();
        $user->requestEmailChanging(
            $email = new Email('new@app.test'),
            $token = 'token'
        );
        $user->confirmEmailChanging($token);
        self::assertEquals($email, $user->getEmail());
        self::assertNull($user->getNewEmailToken());
        self::assertNull($user->getNewEmail());
    }
    public function testNotRequested(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();
        $this->expectExceptionMessage('Изменение email не запрошено.');
        $user->confirmEmailChanging('token');
    }
    public function testIncorrect(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();
        $user->requestEmailChanging(
            $email = new Email('new@test.com'),
            'token'
        );
        $this->expectExceptionMessage('Ошибкочный код смены email.');
        $user->confirmEmailChanging('incorrect-token');
    }
}