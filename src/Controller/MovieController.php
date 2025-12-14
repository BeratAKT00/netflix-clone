<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{
    #[Route('/movie/{id}', name: 'app_movie_show')]
    public function show(Movie $movie): Response
    {

        $user = $this->getUser();
        $isInWatchlist = false;


        if ($user) {

            $isInWatchlist = $user->getWatchlist()->contains($movie);
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'isInWatchlist' => $isInWatchlist
        ]);
    }

    #[Route('/movie/{id}/watchlist', name: 'app_watchlist_toggle')]
    public function toggleWatchlist(Movie $movie, EntityManagerInterface $entityManager): Response
    {
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        if (!$user) {

            return $this->redirectToRoute('app_login');
        }


        if ($user->getWatchlist()->contains($movie)) {
            $user->removeWatchlist($movie);
        } else {

            $user->addWatchlist($movie);
        }


        $entityManager->flush();


        return $this->redirectToRoute('app_movie_show', ['id' => $movie->getId()]);
    }
}
