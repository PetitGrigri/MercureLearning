<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Discovery;
use Symfony\Component\Routing\Annotation\Route;

class DiscoverController extends AbstractController
{
    /**
     * This method will be used to render the json-ld for a book.
     *
     * The mercure hub link will be added to the header.
     * This link could be used to subscribe to a mercure topic.
     * The topic is the same than the @id
     *
     */
    #[Route(path:'/books/{id}.jsonld', requirements: [ 'id' => '\d+' ], name: 'discover_book')]
    public function discover(Request $request, Discovery $discovery, int $id): JsonResponse
    {
        // Link: <https://hub.example.com/.well-known/mercure>; rel="mercure"
        $discovery->addLink($request);

        return $this->json([
            '@id' => sprintf('https://example.com/books/%s', $id),
            'availability' => 'https://schema.org/InStock',
        ]);
    }
}
