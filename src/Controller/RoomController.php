<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Review;
use App\Entity\Room;
use App\Form\ContactType;
use App\Form\ReviewType;
use App\Form\RoomType;
use App\Repository\ImagesRepository;
use App\Repository\RoomRepository;
use App\Service\MailerService;
use App\ServiceImages\PictureService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoomController extends AbstractController
{
    #[Route('admin/room', name: 'app_room_index', methods: ['GET'])]
    public function index(RoomRepository $roomRepository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }

    #[Route('admin/new', name: 'app_room_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        EntityManagerInterface $entityManager,
        PictureService $pictureService, 

    ): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach($images as $image){
                $folder = 'room/';
                // On génère un nouveau nom de fichier
                $fichier = $pictureService->add($image, $folder, 300, 300);

                $img = new Images();
                $img->setName($fichier);
                $room->addImage($img);
     
            }
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/new.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('admin/{id}', name: 'app_room_show', methods: ['GET'])]
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }

    #[Route('admin/{id}/edit', name: 'app_room_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Room $room,
        RoomRepository $roomRepository,
        ImagesRepository $imagesRepository,
        PictureService $pictureService,
        EntityManagerInterface $entityManager,
        int $id=null
    ): Response
    {
        $room = $roomRepository->findBy(['id' => $id])[0];
        $oldImages = $imagesRepository->findBy(['room' => $id]);

        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach($oldImages as $oldImage) {
                $entityManager->remove($oldImage);            
            }

            $images = $form->get('images')->getData();
            // On boucle sur les images
            foreach($images as $image){
                $folder = 'room/';
                // On génère un nouveau nom de fichier
                $fichier = $pictureService->add($image, $folder, 300, 300);

                $img = new Images();
                $img->setName($fichier);
                $room->addImage($img);
    
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('admin/{id}', name: 'app_room_delete', methods: ['POST'])]
    public function delete(Request $request, Room $room, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_room_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/roomDetail/{id}', name: 'roomDetail')]
    public function roomDetail(        
        RoomRepository $roomRepository,
        EntityManagerInterface $entityManager,
        Request $request, 
        int $id=null
    ): Response
    {
        $review = new Review();
        $room = $roomRepository->findBy(['id' => $id])[0];
        $reviews = $room->getReview();       
        
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $review->setRoom($room);
            $entityManager->persist($review);
            $entityManager->flush();
    
            $this->addFlash('success', 'Votre avis a été soumis avec succès !');
        }
    
        return $this->render('hotel/hotel_detail.html.twig', [
            'controller_name' => 'roomDetail',
            'room' => $room,
            'reviews' => $reviews,
            'reviewForm' => $form->createView()
        ]);
    }

    #[Route('/contactRoom/{id}', name: 'app_room_contact')]
    public function roomContact(
        Request $request, 
        MailerService $mailer,
        RoomRepository $roomRepository,
        int $id=null
        )
    {
        // contact form for room
        $room = $roomRepository->findBy(['id' => $id])[0];
        $roomName = $room->getTitle();
        
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $dateStart = $contactFormData['dateStart'];
            $dateEnd = $contactFormData['dateEnd'];
            $dateStartToString = $dateStart->format('Y-m-d H:i:s');
            $dateEndToString = $dateEnd->format('Y-m-d H:i:s');
            $subject = 'Demande de contact sur votre site de ' . 'email: ' . $contactFormData['email'] . ' téléphone: ' . $contactFormData['phoneNumber'];
            $content = 'Pour la chambre' . $roomName . 'Début du séjour: ' . $dateStartToString . 'Fin du séjour: ' . $dateEndToString . $contactFormData['name'] . $contactFormData['firstname'] . ' vous a envoyé le message suivant: ' . $contactFormData['message'];
            $mailer->sendEmail(subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('Homepage', $request->query->all());
        }
        return $this->render('room/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
   
}
