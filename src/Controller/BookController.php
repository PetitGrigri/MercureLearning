<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route(path: '/books/{id}/{status}', name: 'book_status', requirements: [
        'id' => '\d+',
        'status' => 'available|out-of-stock'
    ])]
    public function publishBookStatus(
        HubInterface $hub,
        int $id,
        string $status,
    ): Response {
        $update = new Update(
            sprintf('https://example.com/books/%s', $id),
            json_encode([
                'id' => $id,
                'status' => match ($status) {
                    'available' => 'Available',
                    'out-of-stock' => 'Out of Scope',
                    default => 'Unknown'
                }
            ])
        );

        $hub->publish($update);

        return new Response('published!');
    }
}
