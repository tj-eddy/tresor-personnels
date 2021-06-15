<?php

namespace App\Entity;

use App\Repository\AttributionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributionRepository::class)
 */
class Attribution
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom_tache;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numero_tache;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="attributions")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_debut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_fin;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTache(): ?string
    {
        return $this->nom_tache;
    }

    public function setNomTache(?string $nom_tache): self
    {
        $this->nom_tache = $nom_tache;

        return $this;
    }

    public function getNumeroTache(): ?string
    {
        return $this->numero_tache;
    }

    public function setNumeroTache(?string $numero_tache): self
    {
        $this->numero_tache = $numero_tache;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
