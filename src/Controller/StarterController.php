<?php

namespace App\Controller;

use App\Entity\Starter;
use App\Form\StarterType;
use App\Repository\StarterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/starter')]
class StarterController extends AbstractController
{
    #[Route('/', name: 'app_starter_index', methods: ['GET'])]
    public function index(StarterRepository $starterRepository): Response
    {
        return $this->render('starter/index.html.twig', [
            'starters' => $starterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_starter_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $starter = new Starter();
        $form = $this->createForm(StarterType::class, $starter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($starter);
            $entityManager->flush();

            return $this->redirectToRoute('app_starter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('starter/new.html.twig', [
            'starter' => $starter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_starter_show', methods: ['GET'])]
    public function show(Starter $starter): Response
    {
        return $this->render('starter/show.html.twig', [
            'starter' => $starter,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_starter_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Starter $starter, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StarterType::class, $starter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_starter_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('starter/edit.html.twig', [
            'starter' => $starter,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_starter_delete', methods: ['POST'])]
    public function delete(Request $request, Starter $starter, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$starter->getId(), $request->request->get('_token'))) {
            $entityManager->remove($starter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_starter_index', [], Response::HTTP_SEE_OTHER);
    }
}
