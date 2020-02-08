<?php


namespace App\Controller\Work\Projects\Project\Settings;


use App\Model\Work\Entity\Projects\Project\Project;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/work/projects/{project_id}/settings/members", name="work.projects.project.settings.members")
 * @ParamConverter("project", options={"id" = "project_id"})
 * @IsGranted("ROLE_WORK_MANAGE_PROJECTS")
 */
class MembersController extends AbstractController
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
     * @param Project $project
     * @return Response
     */
    public function index(Project $project): Response
    {
        return $this->render('app/work/projects/project/settings/members/index.html.twig',
            ['project' => $project, 'memberships' => $project->getMemberships()]);
    }


}