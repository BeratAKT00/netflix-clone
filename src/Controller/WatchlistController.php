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
    #[Route('/watchlist/add/{id}', name: 'app_watchlist_toggle')]
    #[IsGranted('ROLE_USER')] // Sécurité : Il faut être connecté
    public function toggle(Movie $movie, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Si le film est déjà dans la liste, on l'enlève
        if ($user->getWatchlist()->contains($movie)) {
            $user->removeWatchlist($movie);
        } else {
            // Sinon, on l'ajoute
            $user->addWatchlist($movie);
        }

        $entityManager->flush();

        // On revient sur la page du film
        return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
    }
}
