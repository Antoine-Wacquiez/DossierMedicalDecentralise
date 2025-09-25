<?php

namespace App\Entity;

use App\Repository\TraitementsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraitementsRepository::class)]
class Traitements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    private ?string $libelle = null;

    #[ORM\Column]
    private ?int $qteJour = null;

    #[ORM\Column]
    private ?int $duree = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getQteJour(): ?int
    {
        return $this->qteJour;
    }

    public function setQteJour(int $qteJour): static
    {
        $this->qteJour = $qteJour;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }
}
