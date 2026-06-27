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

        $game = $gameService->getCurrentGame($user);

        if (!$game) {
            $game = $gameService->createGame($user);
        }

        $guess = $request->request->get('guess');
        $result = null;

        if ($guess) {
            $result = $attemptService->createAttempt(
                $game,
                $guess,
            );
        }

        $attemptResults = [];

        foreach ($game->getAttempts() as $attempt) {
            $attemptResults[] = $wordService->wordCheck(
                $attempt->getProposedWord(),
                $game->getWord()->getWord()
            );
        }        

        return $this->render('game/index.html.twig', [
            'game' => $game,
            'attemptResults' => $attemptResults,
        ]);
    }
}
