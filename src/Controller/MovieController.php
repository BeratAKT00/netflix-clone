<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface; // <-- Indispensable pour le flush()
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'app_movie_show')]
    public function show(Movie $movie): Response
    {
        // 1. On récupère l'utilisateur connecté
        $user = $this->getUser();
        $isInWatchlist = false;

        // 2. Si l'utilisateur est connecté, on vérifie si le film est dans sa liste
        if ($user) {
            // "contains" vérifie si le film existe dans la collection watchlist
            $isInWatchlist = $user->getWatchlist()->contains($movie);
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'isInWatchlist' => $isInWatchlist // On envoie l'info à la vue
        ]);
    }

    #[Route('/movie/{id}/watchlist', name: 'app_watchlist_toggle')]
    public function toggleWatchlist(Movie $movie, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$user) {
            // Si pas connecté, on redirige vers la connexion
            return $this->redirectToRoute('app_login');
        }

        // Si le film est déjà dans la liste, on l'enlève
        if ($user->getWatchlist()->contains($movie)) {
            $user->removeWatchlist($movie);
        } else {
            // Sinon, on l'ajoute
            $user->addWatchlist($movie);
        }

        // On sauvegarde en base de données
        $entityManager->flush();

        // On revient sur la page du film (ça rafraichit le bouton et son état)
        return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
    }
}
