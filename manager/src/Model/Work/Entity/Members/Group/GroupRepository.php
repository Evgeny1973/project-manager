<?php


namespace App\Model\Work\Entity\Members\Group;


use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class GroupRepository
{
    private $repo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Group::class);
        $this->em = $em;
    }

    public function get(Id $id): Group
    {
        if (!$group = $this->repo->find($id->getValue())) {
            throw new EntityNotFoundException('Группа не найдена.');
        }
        return $group;
    }

    public function add(Group $group): void
    {
        $this->em->persist($group);
    }

    public function remove(Group $group): void
    {
        $this->em->remove($group);
    }
}