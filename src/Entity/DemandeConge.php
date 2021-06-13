<?php

namespace App\Entity;

use App\Repository\DemandeCongeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeCongeRepository::class)
 */
class DemandeConge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_debut;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_jouissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $type_conge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $motif;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_interim;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_demande;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demandeConges")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getLieuJouissance(): ?string
    {
        return $this->lieu_jouissance;
    }

    public function setLieuJouissance(?string $lieu_jouissance): self
    {
        $this->lieu_jouissance = $lieu_jouissance;

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

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): self
    {
        $this->motif = $motif;

        return $this;
    }

    public function getNomInterim(): ?string
    {
        return $this->nom_interim;
    }

    public function setNomInterim(?string $nom_interim): self
    {
        $this->nom_interim = $nom_interim;

        return $this;
    }

    public function getNumDemande(): ?string
    {
        return $this->num_demande;
    }

    public function setNumDemande(?string $num_demande): self
    {
        $this->num_demande = $num_demande;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
