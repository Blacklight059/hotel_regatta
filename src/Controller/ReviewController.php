<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'app_review')]
    public function index(
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
    
    #[Route('/admin/show_review', name: 'show_review')]
    public function validReview(
        ReviewRepository $reviewRepository
    ): Response
    {

        return $this->render('review/show.html.twig', [
            'reviews' => $reviewRepository->findAll(),
        ]);
    }
    
    #[Route('/admin/validation_review/{id}', name: 'validation_review')]
    public function validation_review(
        EntityManagerInterface $entityManager,
        ReviewRepository $reviewRepository,
        int $id=null
    ): Response
    {
        // We retrieve the review who corresponds to the id passed in the URL
        $reviewId = $reviewRepository->findBy(['id' => $id])[0];

        $reviewId->setValidate(true);

        $entityManager->persist($reviewId);
        $entityManager->flush();
        return $this->redirectToRoute('show_review');

        return $this->render('review/show.html.twig', [
            'controller_name' => 'ReviewController',
            'reviewId' => $reviewId,
        ]);
    }

    #[Route('/admin/remove_review/{id}', name: 'remove_review')]
    public function remove_review(
        EntityManagerInterface $entityManager,
        ReviewRepository $reviewRepository,
        int $id=null
    ): Response
    {
        // We retrieve the review who corresponds to the id passed in the URL
        $reviewId = $reviewRepository->findBy(['id' => $id])[0];

        $entityManager->remove($reviewId);
        $entityManager->flush();
        return $this->redirectToRoute('show_review');

        return $this->render('review/show.html.twig', [
            'controller_name' => 'ReviewController',
            'reviewId' => $reviewId,
        ]);
    }

       /**
     * @Route("/submit-review", name="submit_review", methods={"POST"})
     */
    public function submitReview(Request $request): JsonResponse
    {
        // Récupérer les données du formulaire
        $formData = $request->request->all();

        // Ici, vous pouvez faire quelque chose avec les données du formulaire, comme les enregistrer en base de données
        // Par exemple :
        // $entityManager = $this->getDoctrine()->getManager();
        // $review = new Review();
        // $review->setPseudo($formData['pseudo']);
        // $review->setComment($formData['comment']);
        // $review->setRating($formData['rating']);
        // $entityManager->persist($review);
        // $entityManager->flush();

        // Vous pouvez également retourner des données spécifiques que vous souhaitez afficher
        $responseData = [
            'message' => 'Votre avis a été soumis avec succès !',
            'formData' => $formData,
        ];

        return new JsonResponse($responseData);
    }
}
