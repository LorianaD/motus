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

    public function createAttempt(Game $game, string $guess) 
    {
        $attempt = new Attempt();

        $attempt->setGame($game);
        $attempt->setProposedWord(strtoupper($guess));
        $attempt->setAttemptNumber($game->getAttemptsCount() + 1);

        $this->em->persist($attempt);

        $game->setAttemptsCount($game->getAttemptsCount() + 1);

        if (strtoupper($guess) === strtoupper($game->getWord()->getWord())) {
            $game->setStatus('won');
        } elseif ($game->getAttemptsCount() >= 6) {
            $game->setStatus('lost');
        }

        $this->em->flush();

        return $this->wordService->wordCheck($guess, $game->getWord()->getWord());
    }
}