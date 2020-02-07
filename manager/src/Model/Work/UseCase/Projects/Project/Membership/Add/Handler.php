<?php


namespace App\Model\Work\UseCase\Projects\Project\Membership\Add;


use App\Model\Flusher;
use App\Model\Work\Entity\Members\Member\MemberRepository;
use App\Model\Work\Entity\Projects\Project\Department\Id as DepartmentId;
use App\Model\Work\Entity\Projects\Project\Id as ProjectId;
use \App\Model\Work\Entity\Members\Member\Id as MemberId;
use App\Model\Work\Entity\Projects\Role\Id as RoleId;
use App\Model\Work\Entity\Projects\Role\Role;
use App\Model\Work\Entity\Projects\Project\ProjectRepository;
use App\Model\Work\Entity\Projects\Role\RoleRepository;

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
     * @var RoleRepository
     */
    private $roles;

    /**
     * @var Flusher
     */
    private $flusher;

    public function __construct(ProjectRepository $projects, MemberRepository $members, RoleRepository $roles, Flusher $flusher)
    {
        $this->projects = $projects;
        $this->members = $members;
        $this->roles = $roles;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     * @throws \Exception
     */
    public function handle(Command $command): void
    {
        $project = $this->projects->get(new ProjectId($command->project));
        $member = $this->members->get(new MemberId($command->member));

        $departments = array_map(static function(string $id): DepartmentId {
            return new DepartmentId($id);
        }, $command->departments);

        $roles = array_map(function(string $id): Role {
            return $this->roles->get(new RoleId($id));
        }, $command->roles);

        $project->addMember($member, $departments, $roles);
        $this->flusher->flush();
    }
}