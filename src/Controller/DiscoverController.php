<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mercure\Discovery;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DiscoverController extends AbstractController
{
    /**
     * This method will be used to render the json-ld for a book.
     *
     * The mercure hub link will be added to the header.
     * This link could be used to subscribe to a mercure topic.
     * The topic is the same as @id
     *
     */
    #[Route(path:'/books/{id}.jsonld', requirements: [ 'id' => '\d+' ], name: 'discover_book')]
    public function discover(Request $request, Discovery $discovery, int $id): JsonResponse
    {
        //Generated Link: <https://hub.example.com/.well-known/mercure>; rel="mercure"
        $discovery->addLink($request);

        $topic = $this->generateUrl('get_book', ['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->json([
            '@id' => $topic,
            'availability' => 'https://schema.org/InStock',
        ]);
    }

    /**
     * This method will be used to render the json-ld for a book.
     *
     * The mercure hub link will be added to the header.
     * This link could be used to subscribe to a mercure topic.
     * The topic is the same as the @id
     *
     */
    #[Route(path:'/private-book/{id}.jsonld', requirements: [ 'id' => '\d+' ], name: 'discover_private_book')]
    public function discoverPrivateBook(Request $request, Discovery $discovery, int $id): JsonResponse
    {
        // Generated link: <https://hub.example.com/.well-known/mercure>; rel="mercure"
        $discovery->addLink($request);

        $topic = $this->generateUrl(
            'get_private_book',
            ['id' => $id],
            UrlGeneratorInterface::ABSOLUTE_URL
        );


        return $this->json([
            '@id' => $topic,
            'availability' => 'https://schema.org/InStock',
        ]);
    }
}
