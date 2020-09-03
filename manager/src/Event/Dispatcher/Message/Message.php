<?php

declare(strict_types=1);

namespace App\Event\Dispatcher\Message;

final class Message
{
    private $event;
    
    public function __construct($event)
    {
        $this->event = $event;
    }
    
    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }
}
