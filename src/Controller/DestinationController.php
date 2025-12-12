<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Form\DestinationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class DestinationController extends AbstractController
{
    #[Route('/destinations', name: 'destination_list')]
    public function list(EntityManagerInterface $em): Response
    {
        $destinations = $em->getRepository(Destination::class)->findAll();

        return $this->render('destination/list.html.twig', [
            'destinations' => $destinations
        ]);
    }

    #[Route('/destination/add', name: 'destination_add')]
    #[Route('/destination/{id}/edit', name: 'destination_edit')]
    public function form(Request $request, EntityManagerInterface $em, ?Destination $destination = null): Response
    {
        if (!$destination) {
            $destination = new Destination();
        }

        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);//récupère les données envoyées par l’utilisateur.

        if ($form->isSubmitted() && $form->isValid()) {
            // Gestion de l'image uploadée
            $image = $form->get('image')->getData();

            if ($image) {
                $imageName = uniqid() . '.' . $image->guessExtension();
                $image->move($this->getParameter('uploads_dir'), $imageName);
                $destination->setImage($imageName);
            }
            // Si aucune nouvelle image, l'image existante reste inchangée

            $em->persist($destination);
            $em->flush();

            $this->addFlash('success', 'Destination sauvegardée.');
            return $this->redirectToRoute('destination_list');
        }

        //  Passage de la variable 'destination' au template pour éviter l'erreur Twig
        return $this->render('destination/form.html.twig', [
            'form' => $form->createView(),
            'destination' => $destination,
        ]);
    }

    #[Route('/destination/{id}/delete', name: 'destination_delete')]
    public function delete(EntityManagerInterface $em, Destination $destination): Response
    {
        $em->remove($destination);
        $em->flush();

        $this->addFlash('success', 'Destination supprimée.');
        return $this->redirectToRoute('destination_list');
    }
}
