<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservations', name: 'reservation_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $reservations = $em->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/list.html.twig', [
            'reservations' => $reservations
        ]);
    }

    #[Route('/reservation/add', name: 'reservation_add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($reservation);
            $em->flush();

            $this->addFlash('success', 'Réservation confirmée !');
            return $this->redirectToRoute('reservation_list');
        }

        return $this->render('reservation/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/reservation/{id}/delete', name: 'reservation_delete', methods: ['POST'])]
    public function delete(EntityManagerInterface $em, Reservation $reservation): Response
    {
        $em->remove($reservation);
        $em->flush();

        $this->addFlash('success', 'Réservation supprimée.');
        return $this->redirectToRoute('reservation_list');
    }
}
