<?php

namespace App\Entity;

use App\Repository\AttemptRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttemptRepository::class)]
class Attempt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $proposedWord = null;

    #[ORM\Column]
    private ?int $attemptNumber = null;

    #[ORM\ManyToOne(inversedBy: 'attempts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Game $game = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProposedWord(): ?string
    {
        return $this->proposedWord;
    }

    public function setProposedWord(string $proposedWord): static
    {
        $this->proposedWord = $proposedWord;

        return $this;
    }

    public function getAttemptNumber(): ?int
    {
        return $this->attemptNumber;
    }

    public function setAttemptNumber(int $attemptNumber): static
    {
        $this->attemptNumber = $attemptNumber;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }
}
