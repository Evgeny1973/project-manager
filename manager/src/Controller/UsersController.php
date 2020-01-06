<?php


namespace App\Controller;


use App\ReadModel\User\UserFetcher;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/users")
 */
class UsersController extends AbstractController
{
    /**
     * @var UserFetcher
     */
    private $users;

    public function __construct(UserFetcher $users)
    {
        $this->users = $users;
    }

    /**
     * @Route("", name="users")
     * @return Response
     */
    public function index():Response
    {
        $users = $this->users->all();

        return $this->render('app/users/index.html.twig', ['users' => $users]);
    }
}