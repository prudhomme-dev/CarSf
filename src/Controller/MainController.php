<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Repository\BrandRepository;
use App\Repository\CarRepository;
use App\Repository\FavoriteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CarRepository $carRepository, BrandRepository $brandRepository, FavoriteRepository $favoriteRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'cars' => $carRepository->findBy(["active" => true], ["id" => "DESC"]), "brands" => $brandRepository->findAll()
        ]);
    }

    #[Route('/filter/{idBrand}', name: 'app_filter')]
    public function filter(Request $request, CarRepository $carRepository, BrandRepository $brandRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'cars' => $carRepository->findBy(["active" => true, "brand" => $request->get("idBrand")], ["id" => "DESC"]), "brands" => $brandRepository->findAll()
        ]);
    }

    #[Route('/favorite/{idCar}', name: 'app_favorite', methods: ['GET'])]
    public function favorite(Request $request, FavoriteRepository $favoriteRepository, CarRepository $carRepository): Response
    {
        if ($this->getUser()) {
            $favoriteControl = $favoriteRepository->findOneBy(["User" => $this->getUser()->getId(), "Car" => $request->get('idCar')]);
            if (!$favoriteControl) {
                $favorite = new Favorite();
                $favorite->setUser($this->getUser());
                $car = $carRepository->find($request->get('idCar'));
                $favorite->setCar($car);
                $favoriteRepository->add($favorite);
                $this->addFlash("Evénements", "Inscription à l'évenement réussie");
            } else {
                $favoriteRepository->remove($favoriteControl);
                $this->addFlash("Evénements", "Désinscription de l'évenement réussie");
            }

        }
        return $this->redirectToRoute('app_main');
    }

    #[Route('/favorite', name: 'app_favorite_list', methods: ['GET'])]
    public function favoriteList(Request $request, FavoriteRepository $favoriteRepository): Response
    {
        if ($this->getUser()) {

            return $this->render('main/favorite.html.twig',
                ['favorites' => $favoriteRepository->findBy(["User" => $this->getUser()->getId()])]);
        }
        return $this->redirectToRoute('app_main');
    }
}
