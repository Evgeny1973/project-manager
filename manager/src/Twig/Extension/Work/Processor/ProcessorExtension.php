<?php

declare(strict_types=1);

namespace App\Twig\Extension\Work\Processor;

use App\Service\Work\Processor\Processor;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ProcessorExtension extends AbstractExtension
{
    private $processor;
    
    public function __construct(Processor $processor)
    {
        $this->processor = $processor;
    }
    
    public function getFilters(): array
    {
        return [
            new TwigFilter('work_processor', [$this, 'process'], ['is_safe' => ['html']]),
        ];
    }
    
    public function process(?string $text): string
    {
        return $this->processor->process($text);
    }
}
