<?php

declare(strict_types=1);

namespace App\Infrastructure\UI\HTTP\REST\Controller;

use App\Application\ApplicationServices\CreateAdsFromProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdsController extends AbstractController
{
    private CreateAdsFromProducts $adsFromProducts;

    public function __construct(CreateAdsFromProducts $adsFromProducts)
    {
        $this->adsFromProducts = $adsFromProducts;
    }

    /**
     * @Route("/ads", name="ads")
     * @return Response
     */
    public function aboutUsPage()
    {
        return new JsonResponse($this->adsFromProducts->execute(), 200, [], true);
    }
}