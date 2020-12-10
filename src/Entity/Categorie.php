<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;


/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @ApiResource()
 */
class Categorie
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
     * @ORM\OneToMany(targetEntity=Mot::class, mappedBy="categorie", orphanRemoval=false)
     */
    private $mot;

    public function __construct()
    {
        $this->mot = new ArrayCollection();
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

    /**
     * @return Collection|Mot[]
     */
    public function getMot(): Collection
    {
        return $this->mot;
    }

    public function addMot(Mot $mot): self
    {
        if (!$this->mot->contains($mot)) {
            $this->mot[] = $mot;
            $mot->setCategorie($this);
        }

        return $this;
    }

    public function removeMot(Mot $mot): self
    {
        if ($this->mot->removeElement($mot)) {
            // set the owning side to null (unless already changed)
            if ($mot->getCategorie() === $this) {
                $mot->setCategorie(null);
            }
        }

        return $this;
    }
}
