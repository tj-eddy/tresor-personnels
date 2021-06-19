<?php

namespace App\Entity;

use App\Repository\FactureSoinRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FactureSoinRepository::class)
 */
class FactureSoin
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
    private $num_fact;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_fact;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $pharmacie;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="factureSoins")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFact(): ?string
    {
        return $this->num_fact;
    }

    public function setNumFact(?string $num_fact): self
    {
        $this->num_fact = $num_fact;

        return $this;
    }

    public function getDateFact(): ?string
    {
        return $this->date_fact;
    }

    public function setDateFact(?string $date_fact): self
    {
        $this->date_fact = $date_fact;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(?float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getPharmacie(): ?string
    {
        return $this->pharmacie;
    }

    public function setPharmacie(?string $pharmacie): self
    {
        $this->pharmacie = $pharmacie;

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
