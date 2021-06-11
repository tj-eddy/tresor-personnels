<?php

namespace App\Entity;

use App\Repository\DocumentRecrutementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocumentRecrutementRepository::class)
 */
class DocumentRecrutement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_doc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_doc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_doc;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $corps;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $indice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $categorie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $grade;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="documentRecrutements")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_deleted = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumDoc(): ?string
    {
        return $this->num_doc;
    }

    public function setNumDoc(string $num_doc): self
    {
        $this->num_doc = $num_doc;

        return $this;
    }

    public function getTypeDoc(): ?string
    {
        return $this->type_doc;
    }

    public function setTypeDoc(string $type_doc): self
    {
        $this->type_doc = $type_doc;

        return $this;
    }

    public function getDateDoc(): ?string
    {
        return $this->date_doc;
    }

    public function setDateDoc(?string $date_doc): self
    {
        $this->date_doc = $date_doc;

        return $this;
    }

    public function getCorps(): ?string
    {
        return $this->corps;
    }

    public function setCorps(?string $corps): self
    {
        $this->corps = $corps;

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

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): self
    {
        $this->grade = $grade;

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

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }
}
