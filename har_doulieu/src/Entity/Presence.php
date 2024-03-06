<?php

namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $reponse = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    private ?Sorties $Event = null;

    #[ORM\ManyToOne(inversedBy: 'presences')]
    private ?User $User = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReponse(): ?int
    {
        return $this->reponse;
    }

    public function setReponse(int $reponse): static
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getEvent(): ?Sorties
    {
        return $this->Event;
    }

    public function setEvent(?Sorties $Event): static
    {
        $this->Event = $Event;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
