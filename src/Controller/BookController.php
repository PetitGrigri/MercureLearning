<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    const AVAILABLE_STATUS = ['InStock', 'OutOfStock'];

    // We should use a PUT as http method, but we use GET to simplify the learning process
    #[Route(path: '/books/{id}/{status}', name: 'book_status', requirements: [
        'id' => '\d+',
        'status' => 'in-stock|out-of-stock'
    ])]
    public function updateBookStatus(
        HubInterface $hub,
        int $id,
        string $status,
    ): Response {
        $update = new Update(
            sprintf('https://example.com/books/%s', $id),
            json_encode([
                'id' => $id,
                'status' => match ($status) {
                    'in-stock' => 'InStock',
                    'out-of-stock' => 'OutOfStock',
                    default => 'Unknown'
                }
            ])
        );
        $hub->publish($update);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/books/{id}', name: 'get_book', requirements: [
        'id' => '\d+',
        'status' => 'in-stock|out-of-stock'
    ])]
    public function getBook(
        HubInterface $hub,
        int $id
    ): Response {
        return $this->json([
            'id' => $id,
            'status' => self::AVAILABLE_STATUS[array_rand(self::AVAILABLE_STATUS)],
        ]);
    }
}
