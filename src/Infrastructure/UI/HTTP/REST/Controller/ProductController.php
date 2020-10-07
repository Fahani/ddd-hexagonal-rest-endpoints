<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\HTTP\REST\Controller;

use App\Application\ApplicationServices\FetchAndSanitizeProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private FetchAndSanitizeProducts $fetchAndSanitizeProducts;

    public function __construct(FetchAndSanitizeProducts $fetchAndSanitizeProducts)
    {
        $this->fetchAndSanitizeProducts = $fetchAndSanitizeProducts;
    }

    /**
     * @Route("/feed/products", name="products")
     * @return Response
     */
    public function aboutUsPage()
    {
        return new JsonResponse($this->fetchAndSanitizeProducts->execute(), 200, [], true);
    }
}