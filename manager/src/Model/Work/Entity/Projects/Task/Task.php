<?php


namespace App\Model\Work\Entity\Projects\Task;


use App\Model\Work\Entity\Members\Member\Member;
use App\Model\Work\Entity\Projects\Project\Project;
use phpDocumentor\Reflection\Types\Null_;

class Task
{
    /**
     * @var Id
     */
    private $id;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Member
     */
    private $author;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    /**
     * @var \DateTimeImmutable|Null
     */
    private $planDate;

    /**
     * @var Type
     */
    private $type;

    /**
     * @var int
     */
    private $priority;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|null
     */
    private $content;

    /**
     * @var int
     */
    private $progress;


    public function __construct(
        Id $id,
        Project $project,
        Member $author,
        \DateTimeImmutable $date,
        Type $type,
        int $priority,
        string $name,
        ?string $content)
    {
        $this->id = $id;
        $this->project = $project;
        $this->author = $author;
        $this->date = $date;
        $this->name = $name;
        $this->content = $content;
        $this->progress = 0;
        $this->type = $type;
        $this->priority = $priority;
    }

    public function edit(string $name, ?string $content): void
    {
        $this->name = $name;
        $this->content = $content;
    }

    public function plan(?\DateTimeImmutable $date): void
    {
        $this->planDate = $date;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Project
     */
    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return Member
     */
    public function getAuthor(): Member
    {
        return $this->author;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return \DateTimeImmutable|Null
     */
    public function getPlanDate(): ?\DateTimeImmutable
    {
        return $this->planDate;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return $this->priority;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getProgress(): int
    {
        return $this->progress;
    }


}