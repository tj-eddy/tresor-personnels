<?php

namespace App\Entity;

use App\Repository\DiplomeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiplomeRepository::class)
 */
class Diplome
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $annee;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nom_diplome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etablissement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $scan;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="diplomes")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(?string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }

    public function getNomDiplome(): ?string
    {
        return $this->nom_diplome;
    }

    public function setNomDiplome(?string $nom_diplome): self
    {
        $this->nom_diplome = $nom_diplome;

        return $this;
    }

    public function getEtablissement(): ?string
    {
        return $this->etablissement;
    }

    public function setEtablissement(string $etablissement): self
    {
        $this->etablissement = $etablissement;

        return $this;
    }

    public function getScan(): ?string
    {
        return $this->scan;
    }

    public function setScan(string $scan): self
    {
        $this->scan = $scan;

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
