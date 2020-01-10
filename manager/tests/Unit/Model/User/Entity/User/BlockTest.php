<?php


namespace App\Tests\Unit\Model\User\Entity\User;

use App\Tests\Builder\User\UserBuilder;
use PHPUnit\Framework\TestCase;

class BlockTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->viaEmail()->build();
        $user->block();
        self::assertFalse($user->isActive());
        self::assertTrue($user->isBlocked());
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())->viaEmail()->build();
        $user->block();
        $this->expectExceptionMessage('Пользователь уже заблокирован.');
        $user->block();
    }
}