<?php

namespace App\Entity;

use App\Repository\DossierMedicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DossierMedicalRepository::class)]
class DossierMedical
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date_creation = null;

    #[ORM\Column]
    private ?\DateTime $date_maj = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $notes = null;

    #[ORM\OneToOne(mappedBy: 'dossierMedical', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne]
    private ?GrpSanguin $groupeSanguin = null;

    /**
     * @var Collection<int, Allergies>
     */
    #[ORM\ManyToMany(targetEntity: Allergies::class)]
    private Collection $allergies;

    /**
     * @var Collection<int, Traitements>
     */
    #[ORM\ManyToMany(targetEntity: Traitements::class)]
    private Collection $traitements;

    public function __construct()
    {
        $this->allergies = new ArrayCollection();
        $this->traitements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->date_creation;
    }
    public function setDateCreation(\DateTime $date): static
    {
        $this->date_creation = $date;
        return $this;
    }

    public function getDateMaj(): ?\DateTime
    {
        return $this->date_maj;
    }
    public function setDateMaj(\DateTime $date): static
    {
        $this->date_maj = $date;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }
    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(?User $user): static
    {
        $this->user = $user;
        if ($user && $user->getDossierMedical() !== $this) {
            $user->setDossierMedical($this);
        }
        return $this;
    }

    public function getGroupeSanguin(): ?GrpSanguin
    {
        return $this->groupeSanguin;
    }
    public function setGroupeSanguin(?GrpSanguin $g): static
    {
        $this->groupeSanguin = $g;
        return $this;
    }

    /** @return Collection<int, Allergies> */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }
    public function addAllergy(Allergies $a): static
    {
        if (!$this->allergies->contains($a)) $this->allergies->add($a);
        return $this;
    }
    public function removeAllergy(Allergies $a): static
    {
        $this->allergies->removeElement($a);
        return $this;
    }

    /** @return Collection<int, Traitements> */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }
    public function addTraitement(Traitements $t): static
    {
        if (!$this->traitements->contains($t)) $this->traitements->add($t);
        return $this;
    }
    public function removeTraitement(Traitements $t): static
    {
        $this->traitements->removeElement($t);
        return $this;
    }
}
