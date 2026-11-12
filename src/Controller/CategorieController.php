<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategorieController extends AbstractController
{
    // Afficher toutes les catégories
    #[Route('/categories', name: 'app_categories')]
    public function index(CategorieRepository $repository): Response
    {
        $categories = $repository->findAll();

        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    // Créer une catégorie
    #[Route('/categories/nouvelle', name: 'app_categorie_nouvelle')]
    public function nouvelle(
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Catégorie créée avec succès !');

            return $this->redirectToRoute('app_categories');
        }

        return $this->render('categorie/nouvelle.html.twig', [
            'formulaire' => $form,
        ]);
    }

    // Afficher une catégorie
    #[Route('/categories/{id}', name: 'app_categorie_detail', requirements: ['id' => '\d+'])]
    public function detail(Categorie $categorie): Response
    {
        return $this->render('categorie/detail.html.twig', [
            'categorie' => $categorie,
        ]);
    }

    // Modifier une catégorie
    #[Route('/categories/{id}/modifier', name: 'app_categorie_modifier', requirements: ['id' => '\d+'])]
    public function modifier(
        Categorie $categorie,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Catégorie modifiée avec succès !');

            return $this->redirectToRoute('app_categorie_detail', [
                'id' => $categorie->getId(),
            ]);
        }

        return $this->render('categorie/modifier.html.twig', [
            'formulaire' => $form,
            'categorie' => $categorie,
        ]);
    }

    // Supprimer une catégorie
    #[Route('/categories/{id}/supprimer', name: 'app_categorie_supprimer', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function supprimer(
        Categorie $categorie,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid(
            'supprimer_categorie_' . $categorie->getId(),
            $request->request->get('_token')
        )) {
            $em->remove($categorie);
            $em->flush();

            $this->addFlash('success', 'Catégorie supprimée avec succès !');
        } else {
            $this->addFlash('danger', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('app_categories');
    }
}