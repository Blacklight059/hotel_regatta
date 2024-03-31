<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\MailerService;


class HotelController extends AbstractController
{
    #[Route('/hotel', name: 'app_hotel')]
    public function index(RoomRepository $roomRepository): Response
    {
        $rooms = $roomRepository->findAll();
        return $this->render('hotel/index.html.twig', [
            'controller_name' => 'HotelController',
            'rooms' => $rooms
        ]);
    }
    
    #[Route('/contactRoom', name: 'app_room_contact')]
    public function contact(
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
            $subject = 'Demande de contact sur votre site de ' . 'email: ' . $contactFormData['email'] . ' téléphone: ' . $contactFormData['phoneNumber'];
            $content = 'Pour la chambre' . $roomName . 'Début du séjour: ' . $contactFormData['dateStart'] . 'Fin du séjour: ' . $contactFormData['dateEnd'] . $contactFormData['name'] . $contactFormData['firstname'] . ' vous a envoyé le message suivant: ' . $contactFormData['message'];
            $mailer->sendEmail(subject: $subject, content: $content);
            $this->addFlash('success', 'Votre message a été envoyé');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('hotel/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
