<?php

namespace App\Service;

use App\Entity\Attempt;
use App\Entity\Game;
use Doctrine\ORM\EntityManagerInterface;

class AttemptService
{
    public function __construct(private EntityManagerInterface $em, private WordService $wordService)
    {
        
    }

    public function createAttempt(Game $game, string $guess) : array
    {
        $guess = strtoupper(trim($guess));
        $secret = strtoupper($game->getWord()->getWord());

        $error = $this->validateGuess($guess, $secret);

        if ($error) {
            return ['error' => $error];
        }

        if ($game->getStatus() !== Game::STATUS_IN_PROGRESS) {
            return $this->wordService->wordCheck($guess, $secret);
        }

        if ($game->getAttemptsCount() >= Game::MAX_ATTEMPTS) {
            $game->setStatus(Game::STATUS_LOST);
            $this->em->flush();

            return [];
        }

        $this->saveAttempt($game, $guess);
        $this->updateGameStatus($game, $guess, $secret);

        $this->em->flush();

        return $this->wordService->wordCheck($guess, $secret);
    }

    private function validateGuess(string $guess, string $secret) : ?string
    {
        if (!preg_match('/^[A-ZÀ-Ÿ]+$/u', $guess)) {
            return  'Le mot doit contenir uniquement des lettres.';
        }

        if (strlen($guess) !== strlen($secret)) {
            return 'Le mot doit contenir ' . strlen($secret) . ' lettres.';
        }

        return null;
    }

    private function saveAttempt(Game $game, string $guess) : void
    {
        $attempt = new Attempt();

        $attempt->setGame($game);
        $attempt->setProposedWord($guess);
        $attempt->setAttemptNumber($game->getAttemptsCount() + 1);

        $this->em->persist($attempt);

        $game->setAttemptsCount($game->getAttemptsCount() + 1);        
    }

    private function updateGameStatus(Game $game, string $guess, string $secret) : void
    {
        if ($guess === $secret) {
            $game->setStatus(Game::STATUS_WON);
        } elseif ($game->getAttemptsCount() >= Game::MAX_ATTEMPTS) {
            $game->setStatus(Game::STATUS_LOST);
        }        
    }
}