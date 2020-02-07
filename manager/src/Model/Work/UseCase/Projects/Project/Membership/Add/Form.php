<?php


namespace App\Model\Work\UseCase\Projects\Project\Membership\Add;


use App\ReadModel\Work\Members\Member\MemberFetcher;
use App\ReadModel\Work\Projects\Project\DepartmentFetcher;
use App\ReadModel\Work\Projects\RoleFetcher;
use Symfony\Component\Form\AbstractType;

class Form extends AbstractType
{
    /**
     * @var MemberFetcher
     */
    private $members;

    /**
     * @var RoleFetcher
     */
    private $roles;

    /**
     * @var DepartmentFetcher
     */
    private $departments;

    public function __construct(MemberFetcher $members, RoleFetcher $roles, DepartmentFetcher $departments)
    {
        $this->members = $members;
        $this->roles = $roles;
        $this->departments = $departments;
    }
}