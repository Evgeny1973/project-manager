<?php


namespace App\Model\Work\UseCase\Projects\Project\Membership\Remove;


use App\Model\Flusher;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Work\Entity\Projects\Project\Id;
use App\Model\Work\Entity\Members\Member\Id as MemberId;
use App\Model\Work\Entity\Projects\Project\ProjectRepository;

class Handler
{
    /**
     * @var ProjectRepository
     */
    private $projects;

    /**
     * @var MemberRepository
     */
    private $members;

    /**
     * @var Flusher
     */
    private $flusher;

    public function __construct(ProjectRepository $projects, MemberRepository $members, Flusher $flusher)
    {
        $this->projects = $projects;
        $this->members = $members;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $project = $this->projects->get(new Id($command->project));
        $member = $this->members->get(new MemberId($command->member));

        $project->removeMember($member->getId());
        $this->flusher->flush();
    }
}