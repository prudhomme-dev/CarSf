<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/car')]
class CarController extends AbstractController
{
    private const DIRECTORY = "./photos/";

    #[Route('/', name: 'app_car_index', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    {
        return $this->render('car/index.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CarRepository $carRepository): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        // Upload photo
        $files = $form->get('photoUpload')->getData();
        if ($files) {
            $extension = $files->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }
            $newFileName = uniqid("ph_") . "." . $extension;
            $files->move(self::DIRECTORY, $newFileName);
            $car->setPhoto(self::DIRECTORY . $newFileName);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $car->setActive(true);
            $carRepository->add($car);
            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->redirectToRoute("app_main");
    }

    #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        if ($car->getActive()) {
            return $this->render('car/show.html.twig', [
                'car' => $car,
            ]);
        }
        return $this->redirectToRoute("app_main");

    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, CarRepository $carRepository): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        // Upload photo
        $files = $form->get('photoUpload')->getData();
        if ($files) {
            $extension = $files->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }
            $newFileName = uniqid("ph_") . "." . $extension;
            $files->move(self::DIRECTORY, $newFileName);
            $car->setPhoto(self::DIRECTORY . $newFileName);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepository->add($car);
            return $this->redirectToRoute('app_main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/{id}', name: 'app_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, CarRepository $carRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $car->setActive(false);
            $carRepository->add($car);
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }

}
