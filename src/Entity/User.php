<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

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
     * @ORM\OneToMany(targetEntity="App\Entity\Tache", mappedBy="responsable")
     */
    private $taches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comptabilite", mappedBy="createur", orphanRemoval=true)
     */
    private $comptabilites;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Budget", mappedBy="createur")
     */
    private $budgets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Liste", mappedBy="createur", orphanRemoval=true)
     */
    private $listes;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->comptabilites = new ArrayCollection();
        $this->budgets = new ArrayCollection();
        $this->listes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function addRole(string $role): self
    {
      array_push($this->roles, $role);

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
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setResponsable($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->contains($tach)) {
            $this->taches->removeElement($tach);
            // set the owning side to null (unless already changed)
            if ($tach->getResponsable() === $this) {
                $tach->setResponsable(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comptabilite[]
     */
    public function getComptabilites(): Collection
    {
        return $this->comptabilites;
    }

    public function addComptabilite(Comptabilite $comptabilite): self
    {
        if (!$this->comptabilites->contains($comptabilite)) {
            $this->comptabilites[] = $comptabilite;
            $comptabilite->setCreateur($this);
        }

        return $this;
    }

    public function removeComptabilite(Comptabilite $comptabilite): self
    {
        if ($this->comptabilites->contains($comptabilite)) {
            $this->comptabilites->removeElement($comptabilite);
            // set the owning side to null (unless already changed)
            if ($comptabilite->getCreateur() === $this) {
                $comptabilite->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Budget[]
     */
    public function getBudgets(): Collection
    {
        return $this->budgets;
    }

    public function addBudget(Budget $budget): self
    {
        if (!$this->budgets->contains($budget)) {
            $this->budgets[] = $budget;
            $budget->setCreateur($this);
        }

        return $this;
    }

    public function removeBudget(Budget $budget): self
    {
        if ($this->budgets->contains($budget)) {
            $this->budgets->removeElement($budget);
            // set the owning side to null (unless already changed)
            if ($budget->getCreateur() === $this) {
                $budget->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Liste[]
     */
    public function getListes(): Collection
    {
        return $this->listes;
    }

    public function addListe(Liste $liste): self
    {
        if (!$this->listes->contains($liste)) {
            $this->listes[] = $liste;
            $liste->setCreateur($this);
        }

        return $this;
    }

    public function removeListe(Liste $liste): self
    {
        if ($this->listes->contains($liste)) {
            $this->listes->removeElement($liste);
            // set the owning side to null (unless already changed)
            if ($liste->getCreateur() === $this) {
                $liste->setCreateur(null);
            }
        }

        return $this;
    }
}
