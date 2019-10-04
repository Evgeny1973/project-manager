<?php


namespace App\Model\User\Service;


use Ramsey\Uuid\Uuid;

class ConfirmTokinizer
{
    public function generate()
    {
    return Uuid::uuid4()->toString();
    }
}