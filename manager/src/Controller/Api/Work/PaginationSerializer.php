<?php

declare(strict_types=1);

namespace App\Controller\Api\Work;

use Knp\Component\Pager\Pagination\PaginationInterface;

final class PaginationSerializer
{
    public static function toArray(PaginationInterface $pagination): array
    {
        return [
            'count'    => $pagination->count(),
            'total'    => $pagination->getTotalItemCount(),
            'per_page' => $pagination->getItemNumberPerPage(),
            'page'     => $pagination->getCurrentPageNumber(),
            'pages'    => ceil($pagination->getTotalItemCount() / $pagination->getItemNumberPerPage()),
        ];
    }
}
