<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $status = null;

    #[ORM\Column]
    private ?int $attemptsCount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'games')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Word $word = null;

    public const MAX_ATTEMPTS = 6;

    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_WON = 'won';
    public const STATUS_LOST = 'lost';

    /**
     * @var Collection<int, Attempt>
     */
    #[ORM\OneToMany(targetEntity: Attempt::class, mappedBy: 'game')]
    private Collection $attempts;

    public function __construct()
    {
        $this->attempts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getAttemptsCount(): ?int
    {
        return $this->attemptsCount;
    }

    public function setAttemptsCount(int $attemptsCount): static
    {
        $this->attemptsCount = $attemptsCount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getWord(): ?Word
    {
        return $this->word;
    }

    public function setWord(?Word $word): static
    {
        $this->word = $word;

        return $this;
    }

    /**
     * @return Collection<int, Attempt>
     */
    public function getAttempts(): Collection
    {
        return $this->attempts;
    }

    public function addAttempt(Attempt $attempt): static
    {
        if (!$this->attempts->contains($attempt)) {
            $this->attempts->add($attempt);
            $attempt->setGame($this);
        }

        return $this;
    }

    public function removeAttempt(Attempt $attempt): static
    {
        if ($this->attempts->removeElement($attempt)) {
            // set the owning side to null (unless already changed)
            if ($attempt->getGame() === $this) {
                $attempt->setGame(null);
            }
        }

        return $this;
    }
}
