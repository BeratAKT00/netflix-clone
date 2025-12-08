<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'movies' => $movieRepository->findAll(),
        ]);
    }

    // --- AJOUTE CETTE PARTIE ---
    #[Route('/movie/{id}', name: 'app_movie_show')]
    public function show(Movie $movie): Response
    {
        return $this->render('home/show.html.twig', [
            'movie' => $movie,
        ]);
    }
}
