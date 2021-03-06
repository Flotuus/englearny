<?php

namespace App\Entity;

use App\Repository\MotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=MotRepository::class)
 * @ApiResource()
 */
class Mot
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
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="mot")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity=Liste::class, inversedBy="mots")
     */
    private $liste;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $traduction;

    public function __construct()
    {
        $this->liste = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|Liste[]
     */
    public function getListe(): Collection
    {
        return $this->liste;
    }

    public function addListe(Liste $liste): self
    {
        if (!$this->liste->contains($liste)) {
            $this->liste[] = $liste;
        }

        return $this;
    }

    public function removeListe(Liste $liste): self
    {
        $this->liste->removeElement($liste);

        return $this;
    }

    public function getTraduction(): ?string
    {
        return $this->traduction;
    }

    public function setTraduction(string $traduction): self
    {
        $this->traduction = $traduction;

        return $this;
    }
}
