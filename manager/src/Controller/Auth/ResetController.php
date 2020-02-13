<?php


namespace App\Controller\Auth;

use App\Controller\Work\ErrorHandler;
use App\ReadModel\User\UserFetcher;
use App\Model\User\UseCase\Reset;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ResetController extends AbstractController
{
    /**
     * @var ErrorHandler
     */
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/reset", name="auth.reset")
     * @param Request $request
     * @param Reset\Request\Handler $handler
     * @return Response
     */
    public function request(Request $request, Reset\Request\Handler $handler): Response
    {
        $command = new Reset\Request\Command;
        $form = $this->createForm(Reset\Request\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Проверьте вашу почту.');
                return $this->redirectToRoute('home');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/auth/reset/request.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset/{token}", name="auth.reset.reset")
     * @param string $token
     * @param Request $request
     * @param Reset\Reset\Handler $handler
     * @param UserFetcher $users
     * @return Response
     */
    public function reset(string $token, Request $request, Reset\Reset\Handler $handler, UserFetcher $users): Response
    {
        if (!$users->existsByResetToken($token)) {
            $this->addFlash('error', 'Некорректный или уже подтверждённый токен.');
            return $this->redirectToRoute('home');
        }

        $command = new Reset\Reset\Command($token);
        $form = $this->createForm(Reset\Reset\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                $this->addFlash('success', 'Пароль успешно изменён.');
                return $this->redirectToRoute('home');
            } catch (\DomainException $e) {
                $this->errors->handle($e);;
                $this->addFlash('error', $e->getMessage());
            }
        }
        return $this->render('app/auth/reset/reset.html.twig', [
            'form' => $form->createView()
        ]);
    }
}