<?php

namespace App\Entity;

use App\Repository\TitreCongeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TitreCongeRepository::class)
 */
class TitreConge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_decision;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre_annee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_conge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nombre_jrs_oct;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $scan_decision_conge;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="titre_conge")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumDecision(): ?string
    {
        return $this->num_decision;
    }

    public function setNumDecision(?string $num_decision): self
    {
        $this->num_decision = $num_decision;

        return $this;
    }

    public function getTitreAnnee(): ?string
    {
        return $this->titre_annee;
    }

    public function setTitreAnnee(?string $titre_annee): self
    {
        $this->titre_annee = $titre_annee;

        return $this;
    }

    public function getTypeConge(): ?string
    {
        return $this->type_conge;
    }

    public function setTypeConge(?string $type_conge): self
    {
        $this->type_conge = $type_conge;

        return $this;
    }

    public function getNombreJrsOct(): ?string
    {
        return $this->nombre_jrs_oct;
    }

    public function setNombreJrsOct(?string $nombre_jrs_oct): self
    {
        $this->nombre_jrs_oct = $nombre_jrs_oct;

        return $this;
    }

    public function getScanDecisionConge(): ?string
    {
        return $this->scan_decision_conge;
    }

    public function setScanDecisionConge(string $scan_decision_conge): self
    {
        $this->scan_decision_conge = $scan_decision_conge;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setTitreConge($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTitreConge() === $this) {
                $user->setTitreConge(null);
            }
        }

        return $this;
    }
}
