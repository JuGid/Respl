<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BudgetRepository")
 */
class Budget
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BudgetLine", mappedBy="budget")
     */
    private $lignes;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $max;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="budgets")
     */
    private $createur;

    public function __construct()
    {
        $this->lignes = new ArrayCollection();
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

    /**
     * @return Collection|BudgetLine[]
     */
    public function getLignes(): Collection
    {
        return $this->lignes;
    }

    public function addLigne(BudgetLine $ligne): self
    {
        if (!$this->lignes->contains($ligne)) {
            $this->lignes[] = $ligne;
            $ligne->setBudget($this);
        }

        return $this;
    }

    public function removeLigne(BudgetLine $ligne): self
    {
        if ($this->lignes->contains($ligne)) {
            $this->lignes->removeElement($ligne);
            // set the owning side to null (unless already changed)
            if ($ligne->getBudget() === $this) {
                $ligne->setBudget(null);
            }
        }

        return $this;
    }

    public function getMontant() {
      $montant = 0;
      foreach($this->lignes as $ligne){
        $montant += $ligne->getMontant();
      }

      return $montant;
    }

    public function getMax(): ?float
    {
        return $this->max;
    }

    public function setMax(?float $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }
}
