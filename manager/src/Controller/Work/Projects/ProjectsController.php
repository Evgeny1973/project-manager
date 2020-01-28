<?php


namespace App\Controller\Work\Projects;


use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/work/projects", name="work.projects")
 */
class ProjectsController extends AbstractController
{
    private const PER_PAGE = 50;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


}