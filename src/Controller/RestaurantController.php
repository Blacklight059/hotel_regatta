<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\DessertRepository;
use App\Repository\DishRepository;
use App\Repository\MenuRepository;
use App\Repository\StarterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant', name: 'app_restaurant')]
    public function index(
        StarterRepository $starterRepository,
        DishRepository $dishRepository,
        DessertRepository $dessertRepository,
        MenuRepository $menuRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {

        $starter = $starterRepository->findAll();
        $dish = $dishRepository->findAll();
        $dessert = $dessertRepository->findAll();
        $menu = $menuRepository->findAll();
        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('Homepage');            
        }

        $entityManager->flush();

        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
            'starters' => $starter,
            'dishs' => $dish,
            'desserts' => $dessert,
            'menus' => $menu,
            'form' => $form->createView()

        ]);
    }

    #[Route('/review', name: 'app_review')]
    public function reviewRestaurant(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($review);
            $entityManager->flush();
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('Homepage');            
        }

        $entityManager->flush();


        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
            'form' => $form->createView()

        ]);
    }
}
