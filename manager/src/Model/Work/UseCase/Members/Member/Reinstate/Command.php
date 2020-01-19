<?php


namespace App\Model\Work\UseCase\Members\Member\Reinstate;


class Command
{
    /**
     * @var string
     */
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}