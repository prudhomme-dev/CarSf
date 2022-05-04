<?php

namespace App\Controller;

use App\Entity\Energy;
use App\Form\EnergyType;
use App\Repository\EnergyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted("ROLE_ADMIN")]
#[Route('/energy')]
class EnergyController extends AbstractController
{
    #[Route('/', name: 'app_energy_index', methods: ['GET'])]
    public function index(EnergyRepository $energyRepository): Response
    {
        return $this->render('energy/index.html.twig', [
            'energies' => $energyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_energy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnergyRepository $energyRepository): Response
    {
        $energy = new Energy();
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $energyRepository->add($energy);
            return $this->redirectToRoute('app_energy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('energy/new.html.twig', [
            'energy' => $energy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_energy_show', methods: ['GET'])]
    public function show(Energy $energy): Response
    {
        return $this->render('energy/show.html.twig', [
            'energy' => $energy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_energy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Energy $energy, EnergyRepository $energyRepository): Response
    {
        $form = $this->createForm(EnergyType::class, $energy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $energyRepository->add($energy);
            return $this->redirectToRoute('app_energy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('energy/edit.html.twig', [
            'energy' => $energy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_energy_delete', methods: ['POST'])]
    public function delete(Request $request, Energy $energy, EnergyRepository $energyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $energy->getId(), $request->request->get('_token'))) {
            $energyRepository->remove($energy);
        }

        return $this->redirectToRoute('app_energy_index', [], Response::HTTP_SEE_OTHER);
    }
}
