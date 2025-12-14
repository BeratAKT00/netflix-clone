<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $categories = [];
        $genres = ['Action', 'Comédie', 'Drame', 'Science-Fiction', 'Horreur', 'Animation'];

        foreach ($genres as $genreName) {
            $category = new Category();
            $category->setName($genreName);
            $manager->persist($category);
            $categories[] = $category;
        }


        $movies = [];
        for ($i = 1; $i <= 20; $i++) {
            $movie = new Movie();


            $movie->setTitre("Film " . $i);

            $movie->setDescription("Ceci est la description du film numéro " . $i);
            $movie->setReleaseDate(new \DateTime());
            $movie->setIsSeries($i % 2 === 0);
            $movie->setCoverImage("https://via.placeholder.com/300x450");

            $movie->addCategory($categories[array_rand($categories)]);

            $manager->persist($movie);
            $movies[] = $movie;
        }



        $admin = new User();
        $admin->setEmail('admin@netflix.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);


        $user = new User();
        $user->setEmail('user@netflix.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user123'));


        $user->addWatchlist($movies[0]);
        $user->addWatchlist($movies[5]);

        $manager->persist($user);

        $manager->flush();
    }
}
