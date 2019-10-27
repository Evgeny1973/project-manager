<?php


namespace App\Tests\Unit\Model\User\Entity\User\Email;

use App\Model\User\Entity\User\Email;
use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();
        $user->requestEmailChanging(
            $email = new Email('new@app.test'),
            $token = 'token'
        );
        self::assertEquals($email, $user->getNewEmail());
        self::assertEquals($token, $user->getNewEmailToken());
    }

    public function testSame(): void
    {
        $user = (new UserBuilder())
            ->viaEmail($email = new Email('new@test.com'))
            ->confirmed()->build();
        $this->expectExceptionMessage('Email такой же.');
        $user->requestEmailChanging($email, 'token');
    }

    public function testNotConfirmed(): void
    {
        $user = (new UserBuilder())->viaEmail()->build();
        $this->expectExceptionMessage('Пользователь не активирован.');
        $user->requestEmailChanging(new Email('new@test.com'), 'token');
    }
}