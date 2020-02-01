<?php


namespace App\Controller\Work\Projects;

use App\Model\Work\Entity\Projects\Role\Permission;
use App\Model\Work\Entity\Projects\Role\Role;
use App\Model\Work\UseCase\Projects\Role\Copy;
use App\Model\Work\UseCase\Projects\Role\Create;
use App\Model\Work\UseCase\Projects\Role\Edit;
use App\Model\Work\UseCase\Projects\Role\Remove;
use App\ReadModel\Work\Projects\RoleFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/work/projects/roles", name="work.project.roles")
 * @IsGranted("ROLE_WORK_MANGE_PROJECTS")
 */
class RolesController extends AbstractController
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {

        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param RoleFetcher $fetcher
     * @return Response
     */
    public function index(RoleFetcher $fetcher): Response
    {
        $roles = $fetcher->all();
        $permissions = Permission::names();

        return $this->render('app/work/projects/roles/index.html.twig', ['roles' => $roles, 'permissions' => $permissions]);
    }
}