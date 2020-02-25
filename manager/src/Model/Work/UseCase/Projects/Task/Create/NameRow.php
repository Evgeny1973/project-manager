<?php


namespace App\Model\Work\UseCase\Projects\Task\Create;


use Symfony\Component\Validator\Constraints as Assert;

class NameRow
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    public $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}