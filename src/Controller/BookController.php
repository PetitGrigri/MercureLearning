<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Hub;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BookController extends AbstractController
{
    const AVAILABLE_STATUS = ['InStock', 'OutOfStock'];

    /**
     * This method will return the information concerning a book
     */
    #[Route(path: '/books/{id}', name: 'get_book', requirements: [
        'id' => '\d+',
        'status' => 'in-stock|out-of-stock'
    ])]
    public function getBook(
        int $id
    ): Response {
        return $this->json([
            'id' => $id,
            'status' => self::AVAILABLE_STATUS[array_rand(self::AVAILABLE_STATUS)],
        ]);
    }

    /**
     * This method will return the information concerning a book
     */
    #[Route(path: '/private-books/{id}', name: 'get_private_book', requirements: [
        'id' => '\d+',
        'status' => 'in-stock|out-of-stock'
    ])]
    public function getPrivateBook(
        int $id
    ): Response {
        return $this->json([
            'id' => $id,
            'status' => self::AVAILABLE_STATUS[array_rand(self::AVAILABLE_STATUS)],
        ]);
    }

    /**
     * This method is used to update the status of a PUBLIC book
     *
     * We are able to publish our update with this method because the mercure use the JWT
     * configured in the {@see config/packages/mercure.yaml}
     * This JWT Publisher must contain the published topic or '*'
     *
     * @example { "mercure": { "publish" : ["*"] } }
     * @example { "mercure": { "publish" : ["https://localhost/books/__BOOK_ID__"] } }
     *          (__BOOK_ID__ is replaced by the current book id)
     *
     *
     * We should use a PUT as http method, but we use GET to simplify the learning process
     */
    #[Route(path: '/books/{id}/{status}', name: 'book_status', requirements: [
        'id' => '\d+',
        'status' => 'in-stock|out-of-stock'
    ])]
    public function updateBookStatus(
        HubInterface $hub,
        int $id,
        string $status,
    ): Response {
        $topic = $this->generateUrl('get_book', ['id' => 1], UrlGeneratorInterface::ABSOLUTE_URL);

        $update = new Update(
            topics: $topic,
            data: json_encode([
                'id' => $id,
                'status' => match ($status) {
                    'in-stock' => 'InStock',
                    'out-of-stock' => 'OutOfStock',
                    default => 'Unknown'
                }
            ]),
            private: false,
        );
        $hub->publish($update);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * This method is used to update the status of a PRIVATE book
     *
     * We are able to publish our update in this method because the hub, will use the JWT
     * configured in the {@see config/packages/mercure.yaml}
     * This JWT Publisher must contain the published topic or '*'
     * @example { "mercure": { "publish" : ["*"] } }
     * @example { "mercure": { "publish" : ["https://localhost/private-books/__BOOK_ID__"] } }
     *          (__BOOK_ID__ is replaced by the current book id)
     *
     * By indicating that the Update is private, a subscriber can only access to the private topic if he is allowed :
     * - By using an Authorization header with a bearer token set with a JWT
     * - By using a cookie named mercureAuthorization with the JWT as value
     *
     * This JWT Subscriber's must contain the published topic or '*'
     * @example { "mercure": { "subscribe" : ["*"] } }
     * @example { "mercure": { "subscribe" : ["https://example.com/private-books/__BOOK_ID__"] } }
     *          (__BOOK_ID__ is replaced by the current book id)
     *
     * We should use a PUT as http method, but we use GET to simplify the learning process
     */
    #[Route(path: '/private-books/{id}/{status}', name: 'private_book_status', requirements: [
        'id' => '\d+',
        'status' => 'in-stock|out-of-stock'
    ])]
    public function updatePrivateBookStatus(
        HubInterface $hub,
        int $id,
        string $status,
    ): Response {

        $topic = $this->generateUrl(
            'get_private_book',
            ['id' => $id],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        $update = new Update(
            topics: $topic,
            data: json_encode([
                'id' => $id,
                'status' => match ($status) {
                    'in-stock' => 'InStock',
                    'out-of-stock' => 'OutOfStock',
                    default => 'Unknown'
                }
            ]),
            private: true
        );

        $hub->publish($update);

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
