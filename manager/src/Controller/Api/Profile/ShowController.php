<?php

declare(strict_types=1);

namespace App\Controller\Api\Profile;

use App\Model\User\Entity\User\Network;
use App\ReadModel\User\UserFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ShowController extends AbstractController
{
    /**
     * @Route("/profile", name="profile", methods={"GET"})
     *
     * @param UserFetcher $users
     *
     * @return JsonResponse
     */
    public function show(UserFetcher $users): JsonResponse
    {
        $user = $users->get($this->getUser()->getId());
    
        return $this->json([
            'id'       => $user->getId()->getValue(),
            'email'    => $user->getEmail() ? $user->getEmail()->getValue() : null,
            'name'     => [
                'first' => $user->getName()->getFirst(),
                'last'  => $user->getName()->getLast(),
            ],
            'networks' => array_map(static function (Network $network): array {
                return [
                    'name'     => $network->getNetwork(),
                    'identity' => $network->getIdentity(),
                ];
            }, $user->getNetworks()),
        ]);
    }
}
