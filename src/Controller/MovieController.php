<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MovieController extends AbstractController
{
    #[Route('/catalogue', name: 'app_movie_index')]
    public function index(Request $request): Response
    {
        $search = $request->query->get('search', 'general');

        return $this->render('movie/index.html.twig', [
            'movies' => $this->getMovies(),
            'tag' => $search,
        ]);
    }

    #[Route('/catalogue/{id}', name: 'app_movie_show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(int $id): Response
    {
        foreach ($this->getMovies() as $movie) {
            if ($movie['id'] === $id) {
                return $this->render('movie/show.html.twig', ['movie' => $movie]);
            }
        }

        throw $this->createNotFoundException('Film introuvable');
    }

    #[Route('/api/catalogue', name: 'app_movie_list')]
    public function ping(): JsonResponse
    {
        return $this->json([
            'premier film' => 'star trek',
            'deuxième film' => 'harry potter',
            'troisieme film' => 'dune',
        ]);
    }

    private function getMovies(): array
    {
        return [
            ['id' => 1, 'name' => 'Star Trek, le film', 'category' => 'science fiction', 'releaseYear' => 1979, 'synopsis' => 'Une entité extraterrestre menaçante approche de la Terre. L\'USS Enterprise, remis en service sous le commandement de l\'amiral Kirk, doit l\'intercepter.', 'rating' => '4.2'],
            ['id' => 2, 'name' => 'La Colère de Khan', 'category' => 'science fiction', 'releaseYear' => 1982, 'synopsis' => 'Khan, l\'ennemi juré de Kirk, revient se venger et s\'empare du projet Genesis, un dispositif capable de créer la vie sur une planète morte.', 'rating' => '3.9'],
            ['id' => 3, 'name' => 'À la recherche de Spock', 'category' => 'science fiction', 'releaseYear' => 1984, 'synopsis' => 'Kirk et son équipage volent l\'Enterprise pour retrouver Spock, ressuscité sur la planète Genesis, où les Klingons sont aussi en route.', 'rating' => '4.8'],
            ['id' => 4, 'name' => 'Retour sur Terre', 'category' => 'science fiction', 'releaseYear' => 1986, 'synopsis' => 'Pour sauver la Terre d\'une sonde qui perturbe les océans, l\'équipage remonte dans le temps jusqu\'au XXe siècle afin de capturer des baleines.', 'rating' => '4.5'],
            ['id' => 5, 'name' => 'Star Trek V : L\'Ultime Frontière', 'category' => 'science fiction', 'releaseYear' => 1989, 'synopsis' => 'Sybok, demi-frère de Spock, détourne l\'Enterprise vers une mystérieuse entité au centre de la galaxie.', 'rating' => '3.8'],
        ];
    }
}
