<?php

namespace App\Controller;

use App\Entity\Tour;
use App\Form\TourType;
use App\Repository\TourRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class TourController extends AbstractController
{
    #[Route('/tours', name: 'tour_list')]
    public function list(TourRepository $repo, Request $request): Response
    {
        $destId = $request->query->get('destination');

        if ($destId) {
            $tours = $repo->findToursByDestination((int)$destId);
        } else {
            $tours = $repo->findAll();
        }

        return $this->render('tour/list.html.twig', [
            'tours' => $tours,
        ]);
    }

    #[Route('/tour/add', name: 'tour_add')]
    #[Route('/tour/{id}/edit', name: 'tour_edit')]
    public function form(Request $request, EntityManagerInterface $em, ?Tour $tour = null): Response
    {
        if (!$tour) {
            $tour = new Tour();
        }

        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($tour);
            $em->flush();

            $this->addFlash('success', 'Tour sauvegardé.');
            return $this->redirectToRoute('tour_list');
        }

        return $this->render('tour/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/tour/{id}/delete', name: 'tour_delete')]
    public function delete(EntityManagerInterface $em, Tour $tour): Response
    {
        $em->remove($tour);
        $em->flush();

        $this->addFlash('success', 'Tour supprimé.');
        return $this->redirectToRoute('tour_list');
    }
}

