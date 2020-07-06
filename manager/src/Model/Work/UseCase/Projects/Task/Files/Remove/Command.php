<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Files\Remove;

use Symfony\Component\Validator\Constraints as Assert;

final class Command
{
    /**
     * @var int
     */
    public $id;
    
    /**
     * @var string
     */
    public $file;
    
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $actor;
    
    public function __construct(string $actor, int $id, string $file)
    {
        $this->id = $id;
        $this->file = $file;
        $this->actor = $actor;
    }
}
