<?php

declare(strict_types=1);

namespace App\Twig\Extension;

use App\Service\Uploader\FileUploader;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class StoragePathExtension extends AbstractExtension
{
    /**
     * @var FileUploader
     */
    private $uploader;
    
    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }
    
    public function getFunctions()
    {
        return [
          new TwigFunction('storage_path', [$this, 'path'], ['is_safe' => ['html']])
        ];
    }
    
    public function path(string $path): string
    {
        return $this->uploader->generateUrl($path);
    }
}
