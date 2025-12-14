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

        $query = $request->query->get('q');


        if ($query) {
            $movies = $movieRepository->findBySearch($query);
        } else {
            $movies = $movieRepository->findAll();
        }


        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'searchQuery' => $query
        ]);
    }
}
