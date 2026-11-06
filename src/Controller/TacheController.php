<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TacheController extends AbstractController
{
    // Liste des tâches
    #[Route('/taches', name: 'app_taches')]
    public function index(TacheRepository $tacheRepository): Response
    {
        $taches = $tacheRepository->findBy(
            [],
            [
                'terminee' => 'ASC',
                'dateCreation' => 'DESC',
            ]
        );

        return $this->render('tache/index.html.twig', [
            'taches' => $taches,
        ]);
    }

    // Ajouter une tâche en dur
    #[Route('/taches/ajouter', name: 'app_tache_ajouter')]
    public function ajouter(EntityManagerInterface $entityManager): Response
    {
        $tache = new Tache();

        $tache->setTitre('Apprendre Symfony');
        $tache->setDescription('Comprendre Doctrine ORM et Twig.');
        $tache->setTerminee(false);

        $entityManager->persist($tache);
        $entityManager->flush();

        $this->addFlash('success', 'La tâche a été ajoutée avec succès.');

        return $this->redirectToRoute('app_taches');
    }

    // Afficher les détails d'une tâche
    #[Route('/taches/{id}', name: 'app_tache_detail', requirements: ['id' => '\d+'])]
    public function detail(Tache $tache): Response
    {
        return $this->render('tache/detail.html.twig', [
            'tache' => $tache,
        ]);
    }

    // Marquer une tâche comme terminée
    #[Route('/taches/{id}/terminer', name: 'app_tache_terminer', requirements: ['id' => '\d+'])]
    public function terminer(
        Tache $tache,
        EntityManagerInterface $entityManager
    ): Response {
        $tache->setTerminee(true);

        $entityManager->flush();

        $this->addFlash('success', 'La tâche est terminée.');

        return $this->redirectToRoute('app_taches');
    }
}