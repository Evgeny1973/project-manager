<?php


namespace App\Model\Work\Entity\Projects\Task;


use App\Model\Work\Entity\Members\Member\Member;
use App\Model\Work\Entity\Projects\Project\Project;
use Webmozart\Assert\Assert;

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
     * @var \DateTimeImmutable|null
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

    /**
     * @var Task|null
     */
    private $parent;

    /**
     * @var Status
     */
    private $status;


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
        $this->status = Status::new();

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

    public function setChildOf(?Task $parent): void
    {
        if ($parent) {
            $current = $parent;
            do {
                if ($current === $this) {
                    throw new \DomainException('Нельзя: можем впасть в цикл.');
                }
            } while ($current && $current = $current->getParent());
        }
        $this->parent = $parent;
    }

    public function move(Project $project): void
    {
        if ($project === $this->project) {
            throw new \DomainException('Это тот же проект.');
        }
        $this->project = $project;
    }

    public function changeType(Type $type): void
    {
        if ($this->type->isEqual($type)) {
            throw new \DomainException('Это тот же тип.');
        }
        $this->type = $type;
    }

    public function changeStatus(Status $status): void
    {
        if ($this->status->isEqual($status)) {
            throw new \DomainException('Этот статус уже задан.');
        }
        $this->status = $status;
    }

    public function changeProgress(int $progress): void
    {
        Assert::range($progress, 0, 100);
        if ($this->progress === $progress) {
            throw new \DomainException('Сейчас прогресс тот же.');
        }
        $this->progress = $progress;
    }

    public function isNew(): bool
    {
        return $this->status->isNew();
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

    /**
     * @return Task|null
     */
    public function getParent(): ?Task
    {
        return $this->parent;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

}