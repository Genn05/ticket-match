<?php

namespace App\Controller;

use App\Entity\Stade;
use App\Form\StadeForm;
use App\Repository\StadeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/stade')]
final class StadeController extends AbstractController
{
    #[Route(name: 'app_stade_index', methods: ['GET'])]
    public function index(StadeRepository $stadeRepository): Response
    {
        return $this->render('stade/index.html.twig', [
            'stades' => $stadeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stade_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stade = new Stade();
        $form = $this->createForm(StadeForm::class, $stade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($stade);
            $entityManager->flush();

            return $this->redirectToRoute('app_stade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stade/new.html.twig', [
            'stade' => $stade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stade_show', methods: ['GET'])]
    public function show(Stade $stade): Response
    {
        return $this->render('stade/show.html.twig', [
            'stade' => $stade,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stade_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stade $stade, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StadeForm::class, $stade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stade_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stade/edit.html.twig', [
            'stade' => $stade,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stade_delete', methods: ['POST'])]
    public function delete(Request $request, Stade $stade, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stade->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($stade);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stade_index', [], Response::HTTP_SEE_OTHER);
    }
}
