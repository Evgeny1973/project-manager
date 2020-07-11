<?php

declare(strict_types=1);

namespace App\ReadModel\Work\Projects\Action\Feed;

use App\ReadModel\Comment\CommentRow;

final class Item
{
    /**
     * @var \DateTimeImmutable
     */
    private $date;
    
    /**
     * @var array|null
     */
    private $action;
    
    /**
     * @var CommentRow|null
     */
    private $comment;
    
    private function __construct(\DateTimeImmutable $date)
    {
        $this->date = $date;
    }
    
    public static function forAction(\DateTimeImmutable $date, array $action): self
    {
        $item = new self($date);
        $item->action = $action;
        return $item;
    }
    
    public static function forComment(\DateTimeImmutable $date, CommentRow $comment): self
    {
        $item = new self($date);
        $item->comment = $comment;
        return $item;
    }
    
    /**
     * @return \DateTimeImmutable|null
     */
    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }
    
    /**
     * @return array|null
     */
    public function getAction(): ?array
    {
        return $this->action;
    }
    
    /**
     * @return CommentRow|null
     */
    public function getComment(): ?CommentRow
    {
        return $this->comment;
    }
}
