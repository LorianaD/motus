<?php

namespace App\Controller;

use App\Service\AttemptService;
use App\Service\GameService;
use App\Service\WordService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/game')]
final class GameController extends AbstractController
{
    #[Route('/', name: 'app_game', methods: ['GET', 'POST'])]
    public function index(GameService $gameService, AttemptService $attemptService, WordService $wordService, Request $request): Response
    {
        $user = $this->getUser();

        $game = $gameService->getOrCreateGame($user);
        
        $error = null;

        $guess = $request->request->get('guess');

        if ($guess) {
            $result = $attemptService->createAttempt( $game, $guess );

            if (isset($result['error'])) {
                $error = $result['error'];
            }
        }

        $attemptResults = $wordService->getAttemptResults($game);

        return $this->render('game/index.html.twig', [
            'game' => $game,
            'attemptResults' => $attemptResults,
            'error' => $error,
        ]);
    }

    #[Route('/new', name: 'app_game_new', methods: ['GET', 'POST'])]
    public function new(GameService $gameService) : Response 
    {
        $user = $this->getUser();

        $gameService->createGame($user);

        return $this->redirectToRoute('app_game');
    }
}
