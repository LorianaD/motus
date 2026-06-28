<?php

namespace App\Service;

use App\Entity\Game;
use App\Entity\User;
use App\Entity\Word;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class GameService
{
    public function __construct(private WordRepository $wordRepository, private EntityManagerInterface $em)
    {
        
    }

    public function getRandomWord(): ?Word
    {
        return $this->wordRepository->findRandom();
    }

    public function createGame(User $user) : Game
    {
        $word = $this->getRandomWord();

        if (!$word) {
            throw new Exception('Aucun mot disponible.');
        }

        $game = $this->initializeGame($user, $word);

        $this->em->persist($game);
        $this->em->flush();

        return $game;        
    }

    public function getCurrentGame(User $user): ?Game
    {
        return $this->em
            ->getRepository(Game::class)
            ->findOneBy(
                [
                    'user' => $user,
                    'status' => Game::STATUS_IN_PROGRESS,
                ],
                [
                    'createdAt' => 'DESC',
                ]
            );
    }

    public function getOrCreateGame(User $user) : Game
    {
        $game = $this->getCurrentGame($user);

        if (!$game) {
            $game = $this->createGame($user);
        }

        return $game;
    }

    private function initializeGame(User $user, Word $word) : Game
    {
        $game = new Game();

        $game->setUser($user);
        $game->setWord($word);
        $game->setStatus(Game::STATUS_IN_PROGRESS);
        $game->setAttemptsCount(0);
        $game->setCreatedAt(new \DateTimeImmutable());

        return $game;
    }
}

