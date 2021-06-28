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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_or;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objet_mission;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_debut_mission;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_fin_mission;

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

    public function getDateOr(): ?\DateTimeInterface
    {
        return $this->date_or;
    }

    public function setDateOr(?\DateTimeInterface $date_or): self
    {
        $this->date_or = $date_or;

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

    public function getDateDebutMission(): ?\DateTimeInterface
    {
        return $this->date_debut_mission;
    }

    public function setDateDebutMission(?\DateTimeInterface $date_debut_mission): self
    {
        $this->date_debut_mission = $date_debut_mission;

        return $this;
    }

    public function getDateFinMission(): ?\DateTimeInterface
    {
        return $this->date_fin_mission;
    }

    public function setDateFinMission(?\DateTimeInterface $date_fin_mission): self
    {
        $this->date_fin_mission = $date_fin_mission;

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
}
