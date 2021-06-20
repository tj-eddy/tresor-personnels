<?php

namespace App\Entity;

use App\Repository\PointageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PointageRepository::class)
 */
class Pointage
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
    private $date_arrive_matinee;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $heure_sortie_matinee;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $heure_arrivee_ap;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $heure_sortie_ap;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="pointages")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateArriveMatinee(): ?\DateTimeInterface
    {
        return $this->date_arrive_matinee;
    }

    public function setDateArriveMatinee(?\DateTimeInterface $date_arrive_matinee): self
    {
        $this->date_arrive_matinee = $date_arrive_matinee;

        return $this;
    }

    public function getHeureSortieMatinee(): ?\DateTimeInterface
    {
        return $this->heure_sortie_matinee;
    }

    public function setHeureSortieMatinee(?\DateTimeInterface $heure_sortie_matinee): self
    {
        $this->heure_sortie_matinee = $heure_sortie_matinee;

        return $this;
    }

    public function getHeureArriveeAp(): ?\DateTimeInterface
    {
        return $this->heure_arrivee_ap;
    }

    public function setHeureArriveeAp(?\DateTimeInterface $heure_arrivee_ap): self
    {
        $this->heure_arrivee_ap = $heure_arrivee_ap;

        return $this;
    }

    public function getHeureSortieAp(): ?\DateTimeInterface
    {
        return $this->heure_sortie_ap;
    }

    public function setHeureSortieAp(?\DateTimeInterface $heure_sortie_ap): self
    {
        $this->heure_sortie_ap = $heure_sortie_ap;

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
}
