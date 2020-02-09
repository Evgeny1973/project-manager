<?php


namespace App\Controller\Work\Projects\Project;

use App\Security\Voter\Work\ProjectAccess;
use App\Annotation\Guid;
use App\Model\Work\Entity\Projects\Project\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/work/projects/{id}", name="work.projects.project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Project $project
     * @return Response
     */
    public function show(Project $project): Response
    {
        $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);

        return $this->render('app/work/projects/project/show.html.twig', ['project' => $project]);
    }
}