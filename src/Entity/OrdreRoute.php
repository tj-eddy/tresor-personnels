<?php

namespace App\Entity;

use App\Repository\OrdreRouteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrdreRouteRepository::class)
 */
class OrdreRoute
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $num_or;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objet_mission;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $scan_or;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ordreRoutes")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status = 0;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $duree_mission;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $decompte_or;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indice;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $date_or;

    /**
     * @ORM\Column(type="string",nullable=true, length=255)
     */
    private $date_debut_mission;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_fin_mission;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $montant_p;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $montant_n;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumOr(): ?string
    {
        return $this->num_or;
    }

    public function setNumOr(?string $num_or): self
    {
        $this->num_or = $num_or;

        return $this;
    }


    public function getObjetMission(): ?string
    {
        return $this->objet_mission;
    }

    public function setObjetMission(?string $objet_mission): self
    {
        $this->objet_mission = $objet_mission;

        return $this;
    }

    public function getScanOr(): ?string
    {
        return $this->scan_or;
    }

    public function setScanOr(?string $scan_or): self
    {
        $this->scan_or = $scan_or;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDureeMission(): ?string
    {
        return $this->duree_mission;
    }

    public function setDureeMission(?string $duree_mission): self
    {
        $this->duree_mission = $duree_mission;

        return $this;
    }

    public function getDecompteOr(): ?float
    {
        return $this->decompte_or;
    }

    public function setDecompteOr(?float $decompte_or): self
    {
        $this->decompte_or = $decompte_or;

        return $this;
    }


    public function getIndice(): ?string
    {
        return $this->indice;
    }

    public function setIndice(?string $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getDateOr(): ?string
    {
        return $this->date_or;
    }

    public function setDateOr(?string $date_or): self
    {
        $this->date_or = $date_or;

        return $this;
    }

    public function getDateDebutMission(): ?string
    {
        return $this->date_debut_mission;
    }

    public function setDateDebutMission(string $date_debut_mission): self
    {
        $this->date_debut_mission = $date_debut_mission;

        return $this;
    }

    public function getDateFinMission(): ?string
    {
        return $this->date_fin_mission;
    }

    public function setDateFinMission(?string $date_fin_mission): self
    {
        $this->date_fin_mission = $date_fin_mission;

        return $this;
    }

    public function getMontantP(): ?float
    {
        return $this->montant_p;
    }

    public function setMontantP(?float $montant_p): self
    {
        $this->montant_p = $montant_p;

        return $this;
    }

    public function getMontantN(): ?float
    {
        return $this->montant_n;
    }

    public function setMontantN(?float $montant_n): self
    {
        $this->montant_n = $montant_n;

        return $this;
    }


}
