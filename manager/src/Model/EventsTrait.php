<?php

declare(strict_types=1);

namespace App\Model;

trait EventsTrait
{
    private $recordedEvents = [];
    
    public function recordEvent($event)
    {
        $this->recordedEvents[] = $event;
    }
    
    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}
