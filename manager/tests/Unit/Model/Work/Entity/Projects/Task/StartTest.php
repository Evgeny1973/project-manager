<?php


namespace App\Tests\Unit\Model\Work\Entity\Projects\Task;

use App\Tests\Builder\Work\Members\GroupBuilder;
use App\Tests\Builder\Work\Members\MemberBuilder;
use App\Tests\Builder\Work\Projects\ProjectBuilder;
use App\Tests\Builder\Work\Projects\TaskBuilder;
use PHPUnit\Framework\TestCase;

class StartTest extends TestCase
{
    public function testSuccess(): void
    {
        $group = (new GroupBuilder())->build();
        $member = (new MemberBuilder())->build($group);
        $project = (new ProjectBuilder())->build();
        $task = (new TaskBuilder())->build($project, $member);

        $task->assignExecutor($member);
        $task->start($date = new \DateTimeImmutable('+2 days'));

        self::assertTrue($task->isWorking());
        self::assertEquals($date, $task->getStartDate());
    }

    public function testAlready(): void
    {
        $group = (new GroupBuilder())->build();
        $member = (new MemberBuilder())->build($group);
        $project = (new ProjectBuilder())->build();
        $task = (new TaskBuilder())->build($project, $member);

        $task->assignExecutor($member);
        $task->start($date = new \DateTimeImmutable());

        $this->expectExceptionMessage('Задача уже в работе.');
        $task->start($date);
    }

    public function testWithoutExecutors(): void
    {
        $group = (new GroupBuilder())->build();
        $member = (new MemberBuilder())->build($group);
        $project = (new ProjectBuilder())->build();
        $task = (new TaskBuilder())->build($project, $member);

        $this->expectExceptionMessage('У задачи нет исполнителей.');
        $task->start(new \DateTimeImmutable());
    }
}