<?php

declare(strict_types=1);

namespace App\Service\Uploader;

final class File
{
    /**
     * @var string
     */
    private $path;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var int
     */
    private $size;
    
    public function __construct(string $path, string $name, int $size)
    {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
    }
    
    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }
}
