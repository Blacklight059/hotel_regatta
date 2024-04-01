<?php

namespace App\Controller;

use App\Repository\DessertRepository;
use App\Repository\DishRepository;
use App\Repository\MenuRepository;
use App\Repository\StarterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant', name: 'app_restaurant')]
    public function index(
        StarterRepository $starterRepository,
        DishRepository $dishRepository,
        DessertRepository $dessertRepository,
        MenuRepository $menuRepository
    ): Response
    {

        $starter = $starterRepository->findAll();
        $dish = $dishRepository->findAll();
        $dessert = $dessertRepository->findAll();
        $menu = $menuRepository->findAll();

        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
            'starters' => $starter,
            'dishs' => $dish,
            'desserts' => $dessert,
            'menus' => $menu,

        ]);
    }
}
