<?php


namespace App\Controller;


use App\Model\User\Entity\User\User;
use App\ReadModel\User\UserFetcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{

    /**
     * @Route("", name="users")
     * @param Request $request
     * @param UserFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, UserFetcher $fetcher):Response
    {
        $users = $fetcher->all();

        return $this->render('app/users/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/{id}", name="users.show")
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('app/users/show.html.twig', ['user' => $user]);
    }
}