<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository, Request $request): Response
    {
        // 1. On récupère ce que l'utilisateur a tapé dans la barre (paramètre 'q')
        $query = $request->query->get('q');

        // 2. Si une recherche existe, on filtre. Sinon, on affiche tout.
        if ($query) {
            $movies = $movieRepository->findBySearch($query);
        } else {
            $movies = $movieRepository->findAll();
        }

        // 3. On envoie les films et le mot cherché à la vue pour l'affichage
        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'searchQuery' => $query
        ]);
    }
}
