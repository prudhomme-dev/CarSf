<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CarRepository $carRepository, BrandRepository $brandRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'cars' => $carRepository->findBy(["active" => true]), "brands" => $brandRepository->findAll()
        ]);
    }

    #[Route('/filter/{idBrand}', name: 'app_filter')]
    public function filter(Request $request, CarRepository $carRepository, BrandRepository $brandRepository): Response
    {
//        $request->get("idBrand");
        return $this->render('main/index.html.twig', [
            'cars' => $carRepository->findBy(["active" => true, "brand" => $request->get("idBrand")]), "brands" => $brandRepository->findAll()
        ]);
    }
}
