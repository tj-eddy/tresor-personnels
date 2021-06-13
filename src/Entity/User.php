<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_deleted = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Profil;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_create_or_update;



    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $child_number = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $matricule;

    /**
     * @ORM\OneToMany(targetEntity=DocumentRecrutement::class, mappedBy="user")
     */
    private $documentRecrutements;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date_start_service;

    /**
     * @ORM\OneToMany(targetEntity=DemandeConge::class, mappedBy="user")
     */
    private $demandeConges;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $conge_initial;


    public function __construct()
    {
        $this->date_create_or_update = new \DateTime();
        $this->documentRecrutements = new ArrayCollection();
        $this->demandeConges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(?bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    public function getProfil(): ?string
    {
        return $this->Profil;
    }

    public function setProfil(?string $Profil): self
    {
        $this->Profil = $Profil;

        return $this;
    }

    public function getDateCreateOrUpdate(): ?\DateTimeInterface
    {
        return $this->date_create_or_update;
    }

    public function setDateCreateOrUpdate(\DateTimeInterface $date_create_or_update): self
    {
        $this->date_create_or_update = $date_create_or_update;

        return $this;
    }


    public function getChildNumber(): ?int
    {
        return $this->child_number;
    }

    public function setChildNumber(?int $child_number): self
    {
        $this->child_number = $child_number;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(?string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * @return Collection|DocumentRecrutement[]
     */
    public function getDocumentRecrutements(): Collection
    {
        return $this->documentRecrutements;
    }

    public function addDocumentRecrutement(DocumentRecrutement $documentRecrutement): self
    {
        if (!$this->documentRecrutements->contains($documentRecrutement)) {
            $this->documentRecrutements[] = $documentRecrutement;
            $documentRecrutement->setUser($this);
        }

        return $this;
    }

    public function removeDocumentRecrutement(DocumentRecrutement $documentRecrutement): self
    {
        if ($this->documentRecrutements->removeElement($documentRecrutement)) {
            // set the owning side to null (unless already changed)
            if ($documentRecrutement->getUser() === $this) {
                $documentRecrutement->setUser(null);
            }
        }

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?string $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getDateStartService(): ?string
    {
        return $this->date_start_service;
    }

    public function setDateStartService(?string $date_start_service): self
    {
        $this->date_start_service = $date_start_service;

        return $this;
    }

    /**
     * @return Collection|DemandeConge[]
     */
    public function getDemandeConges(): Collection
    {
        return $this->demandeConges;
    }

    public function addDemandeConge(DemandeConge $demandeConge): self
    {
        if (!$this->demandeConges->contains($demandeConge)) {
            $this->demandeConges[] = $demandeConge;
            $demandeConge->setUser($this);
        }

        return $this;
    }

    public function removeDemandeConge(DemandeConge $demandeConge): self
    {
        if ($this->demandeConges->removeElement($demandeConge)) {
            // set the owning side to null (unless already changed)
            if ($demandeConge->getUser() === $this) {
                $demandeConge->setUser(null);
            }
        }

        return $this;
    }

    public function getCongeInitial(): ?int
    {
        return $this->conge_initial;
    }

    public function setCongeInitial(?int $conge_initial): self
    {
        $this->conge_initial = $conge_initial;

        return $this;
    }
}
