<?php

namespace App\Entity;

use App\Repository\InstrumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstrumentRepository::class)]
class Instrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $numero_serie = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?Pupitres $pupitre = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?User $locataire_musicien = null;

    #[ORM\ManyToOne(inversedBy: 'instruments')]
    private ?Eleves $locataire_eleves = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroSerie(): ?string
    {
        return $this->numero_serie;
    }

    public function setNumeroSerie(string $numero_serie): static
    {
        $this->numero_serie = $numero_serie;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getPupitre(): ?Pupitres
    {
        return $this->pupitre;
    }

    public function setPupitre(?Pupitres $pupitre): static
    {
        $this->pupitre = $pupitre;

        return $this;
    }

    public function getLocataireMusicien(): ?User
    {
        return $this->locataire_musicien;
    }

    public function setLocataireMusicien(?User $locataire_musicien): static
    {
        $this->locataire_musicien = $locataire_musicien;

        return $this;
    }

    public function getLocataireEleves(): ?Eleves
    {
        return $this->locataire_eleves;
    }

    public function setLocataireEleves(?Eleves $locataire_eleves): static
    {
        $this->locataire_eleves = $locataire_eleves;

        return $this;
    }
}
