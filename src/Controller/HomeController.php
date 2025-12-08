<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    // J'ai changé la route '/home' en '/' pour que ce soit la vraie page d'accueil du site
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository): Response
    {
        // On demande au Repository de nous donner TOUS les films
        $movies = $movieRepository->findAll();

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
        ]);
    }
}
