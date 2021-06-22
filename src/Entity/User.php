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

    /**
     * @ORM\OneToMany(targetEntity=Attribution::class, mappedBy="user")
     */
    private $attributions;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status_tache;

    /**
     * @ORM\OneToMany(targetEntity=Diplome::class, mappedBy="user")
     */
    private $diplomes;

    /**
     * @ORM\OneToMany(targetEntity=FactureSoin::class, mappedBy="user")
     */
    private $factureSoins;

    /**
     * @ORM\OneToMany(targetEntity=Pointage::class, mappedBy="user")
     */
    private $pointages;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenom;


    public function __construct()
    {
        $this->date_create_or_update = new \DateTime();
        $this->documentRecrutements = new ArrayCollection();
        $this->demandeConges = new ArrayCollection();
        $this->attributions = new ArrayCollection();
        $this->diplomes = new ArrayCollection();
        $this->factureSoins = new ArrayCollection();
        $this->pointages = new ArrayCollection();
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

    /**
     * @return Collection|Attribution[]
     */
    public function getAttributions(): Collection
    {
        return $this->attributions;
    }

    public function addAttribution(Attribution $attribution): self
    {
        if (!$this->attributions->contains($attribution)) {
            $this->attributions[] = $attribution;
            $attribution->setUser($this);
        }

        return $this;
    }

    public function removeAttribution(Attribution $attribution): self
    {
        if ($this->attributions->removeElement($attribution)) {
            // set the owning side to null (unless already changed)
            if ($attribution->getUser() === $this) {
                $attribution->setUser(null);
            }
        }

        return $this;
    }

    public function getStatusTache(): ?int
    {
        return $this->status_tache;
    }

    public function setStatusTache(?int $status_tache): self
    {
        $this->status_tache = $status_tache;

        return $this;
    }

    /**
     * @return Collection|Diplome[]
     */
    public function getDiplomes(): Collection
    {
        return $this->diplomes;
    }

    public function addDiplome(Diplome $diplome): self
    {
        if (!$this->diplomes->contains($diplome)) {
            $this->diplomes[] = $diplome;
            $diplome->setUser($this);
        }

        return $this;
    }

    public function removeDiplome(Diplome $diplome): self
    {
        if ($this->diplomes->removeElement($diplome)) {
            // set the owning side to null (unless already changed)
            if ($diplome->getUser() === $this) {
                $diplome->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FactureSoin[]
     */
    public function getFactureSoins(): Collection
    {
        return $this->factureSoins;
    }

    public function addFactureSoin(FactureSoin $factureSoin): self
    {
        if (!$this->factureSoins->contains($factureSoin)) {
            $this->factureSoins[] = $factureSoin;
            $factureSoin->setUser($this);
        }

        return $this;
    }

    public function removeFactureSoin(FactureSoin $factureSoin): self
    {
        if ($this->factureSoins->removeElement($factureSoin)) {
            // set the owning side to null (unless already changed)
            if ($factureSoin->getUser() === $this) {
                $factureSoin->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pointage[]
     */
    public function getPointages(): Collection
    {
        return $this->pointages;
    }

    public function addPointage(Pointage $pointage): self
    {
        if (!$this->pointages->contains($pointage)) {
            $this->pointages[] = $pointage;
            $pointage->setUser($this);
        }

        return $this;
    }

    public function removePointage(Pointage $pointage): self
    {
        if ($this->pointages->removeElement($pointage)) {
            // set the owning side to null (unless already changed)
            if ($pointage->getUser() === $this) {
                $pointage->setUser(null);
            }
        }

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }
}
