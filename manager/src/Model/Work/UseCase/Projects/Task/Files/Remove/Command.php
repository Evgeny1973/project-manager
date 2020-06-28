<?php

declare(strict_types=1);

namespace App\Model\Work\UseCase\Projects\Task\Files\Remove;

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
    
    public function __construct(int $id, string $file)
    {
        $this->id = $id;
        $this->file = $file;
    }
}
