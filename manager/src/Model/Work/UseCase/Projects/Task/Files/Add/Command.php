<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Files\Add;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $actor;
    
    /**
     * @var File[]
     */
    public $files;
    
    public function __construct(string $actor, int $id)
    {
        $this->id = $id;
        $this->actor = $actor;
    }
}
