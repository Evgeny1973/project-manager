<?php


namespace App\Model\Work\Entity\Projects\Task;


use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;

class TaskRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    private $connection;
    private $repo;

    public function __construct(EntityManagerInterface $em)
    {
        $this->repo = $em->getRepository(Task::class);
        $this->em = $em;
        $this->connection = $em->getConnection();
    }

    public function remove(Task $task): void
    {
        $this->em->remove($task);
    }
    
    /**
     * @param Id $id
     * @return Task[]
     */
    public function allByParent(Id $id): array
    {
        return $this->repo->findBy(['parent' => $id->getValue()]);
    }
    
    public function get(Id $id): Task
    {
        /** @var Task $task */
        if (!$task = $this->repo->find($id)) {
            throw new EntityNotFoundException('Задача не найдена.');
        }
        return $task;
    }

    public function add(Task $task): void
    {
        $this->em->persist($task);
    }

    public function nexId(): Id
    {
        return new Id((int)$this->connection->query('SELECT nextval(\'work_projects_tasks_seq\')')->fetchColumn());
    }
}