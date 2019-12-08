<?php

namespace App\Entity\Secondary;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Un autre utilisateur s'est déjà inscrit avec l'adresse email {{ value }} merci de vous enregistrer avec une autre adresse email"
 * )
 * @UniqueEntity(
 *     fields={"lastname", "firstname"},
 *     errorPath="firstname",
 *     message="Le prénom {{ value }} est déjà utilisé avec le nom de famille indiqué."
 * )
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(name="iduser", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez votre nom pour continuer"
     * )
     * @ORM\Column(name="firstname", type="string", length=45, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez votre prénom pour continuer"
     * )
     * @ORM\Column(name="lastname", type="string", length=45, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @Assert\Email(
     *     message = "L'adresse email '{{ value }}' n'est pas une adresse email valide.",
     * )
     * @Assert\NotBlank(
     *     message="Vous avez oublié de saisir votre adresse email"
     * )
     * 
     * @ORM\Column(name="email", type="string", length=155, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank(
     *     message="Choisissez un mot de passe.."
     * )
     * @ORM\Column(name="password", type="string", length=80, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez le nom de votre rue pour continuer"
     * )
     * @ORM\Column(name="street", type="string", length=155, nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez le code postal de votre ville pour continuer"
     * )
     * 
     * @ORM\Column(name="zip", type="string", length=20, nullable=false)
     */
    private $zip;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez le nom de votre ville pour continuer"
     * )
     * 
     * @ORM\Column(name="city", type="string", length=50, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez le nom de votre Pays pour continuer"
     * )
     * @ORM\Column(name="country", type="string", length=45, nullable=false, options={"default"="France"})
     */
    private $country = 'France';

    /**
     * @var \DateTime
     *

     * @ORM\Column(name="birthday", type="date", nullable=false)
     */
    private $birthday;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez votre sex pour continuer"
     * )
     * @ORM\Column(name="sexe", type="string", length=0, nullable=false, options={"default"="Femme"})
     */
    private $sexe = 'Femme';

    /**
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default"="1"})
     */
    private $active = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updetedAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updetedat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Secondary\Billing", mappedBy="userIduser", orphanRemoval=true)
     */
    private $billings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Secondary\Pet", mappedBy="userIduser", orphanRemoval=true)
     */
    private $pets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Secondary\Token", mappedBy="userIduser", orphanRemoval=true)
     */
    private $tokens;

    public function __construct()
    {
        $this->billings = new ArrayCollection();
        $this->pets = new ArrayCollection();
        $this->tokens = new ArrayCollection();
    }

    /**
     * Callback appelé à chaque fois qu'on créé une réservation
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @throws \Exception
     */
    public function prePersist(){
        if(empty($this->createdat)){
            $this->createdat = new \DateTime();
        }
        if(empty($this->updetedat)){
            $this->updetedat = new \DateTime();
        }
    }


    public function getFullName(){
        return "{$this->firstname} {$this->lastname}";
    }

    public function getiduser(): ?int
    {
        return $this->iduser;
    }



    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedat(): ?\DateTimeInterface
    {
        return $this->createdat;
    }

    public function setCreatedat(\DateTimeInterface $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

    public function getUpdetedat(): ?\DateTimeInterface
    {
        return $this->updetedat;
    }

    public function setUpdetedat(\DateTimeInterface $updetedat): self
    {
        $this->updetedat = $updetedat;

        return $this;
    }
    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }
    /**
     * @return Collection|Billing[]
     */
    public function getBillings(): Collection
    {
        return $this->billings;
    }

    public function addBilling(Billing $billing): self
    {
        if (!$this->billings->contains($billing)) {
            $this->billings[] = $billing;
            $billing->setUserIduser($this);
        }

        return $this;
    }

    public function removeBilling(Billing $billing): self
    {
        if ($this->billings->contains($billing)) {
            $this->billings->removeElement($billing);
            // set the owning side to null (unless already changed)
            if ($billing->getUserIduser() === $this) {
                $billing->setUserIduser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pet[]
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): self
    {
        if (!$this->pets->contains($pet)) {
            $this->pets[] = $pet;
            $pet->setUserIduser($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): self
    {
        if ($this->pets->contains($pet)) {
            $this->pets->removeElement($pet);
            // set the owning side to null (unless already changed)
            if ($pet->getUserIduser() === $this) {
                $pet->setUserIduser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Token[]
     */
    public function getTokens(): Collection
    {
        return $this->tokens;
    }

    public function addToken(Token $token): self
    {
        if (!$this->tokens->contains($token)) {
            $this->tokens[] = $token;
            $token->setUserIduser($this);
        }

        return $this;
    }

    public function removeToken(Token $token): self
    {
        if ($this->tokens->contains($token)) {
            $this->tokens->removeElement($token);
            // set the owning side to null (unless already changed)
            if ($token->getUserIduser() === $this) {
                $token->setUserIduser(null);
            }
        }

        return $this;
    }

    public function getRoles()
    {
    }


    public function getSalt()
    {
    }


    public function getUsername()
    {
        return $this->email;
    }


    public function eraseCredentials()
    {
    }

}