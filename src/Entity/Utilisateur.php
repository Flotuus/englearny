<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @ApiResource()
 */
class Utilisateur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $password;
 /**
     * @ORM\OneToMany(targetEntity=RealiseTest::class, mappedBy="utilisateur")
     */
    private $realiseTests;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="utilisateurs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity=Abonnement::class, inversedBy="utilisateurs")
     */
    private $abonnement;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="utilisateurs")
     */
    private $entreprise;

    public function __construct()
    {
        $this->realiseTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
/**
     * @return Collection|RealiseTest[]
     */
    public function getRealiseTests(): Collection
    {
        return $this->realiseTests;
    }

    public function addRealiseTest(RealiseTest $realiseTest): self
    {
        if (!$this->realiseTests->contains($realiseTest)) {
            $this->realiseTests[] = $realiseTest;
            $realiseTest->setUtilisateur($this);
        }

        return $this;
    }

    public function removeRealiseTest(RealiseTest $realiseTest): self
    {
        if ($this->realiseTests->removeElement($realiseTest)) {
            // set the owning side to null (unless already changed)
            if ($realiseTest->getUtilisateur() === $this) {
                $realiseTest->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(?Abonnement $abonnement): self
    {
        $this->abonnement = $abonnement;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }
}
