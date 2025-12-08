<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class WatchlistController extends AbstractController
{
    // 1. La nouvelle page pour VOIR la liste
    #[Route('/my-list', name: 'app_watchlist_index')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('watchlist/index.html.twig', [
            // On récupère la liste de l'utilisateur connecté
            'movies' => $this->getUser()->getWatchlist(),
        ]);
    }

    // 2. L'action pour AJOUTER/RETIRER (qu'on a fait avant)
    #[Route('/watchlist/add/{id}', name: 'app_watchlist_toggle')]
    #[IsGranted('ROLE_USER')]
    public function toggle(Movie $movie, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if ($user->getWatchlist()->contains($movie)) {
            $user->removeWatchlist($movie);
        } else {
            $user->addWatchlist($movie);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
    }
}
