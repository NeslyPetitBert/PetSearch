<?php

namespace App\Entity\Secondary;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Pet
 *
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="App\Repository\PetRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="pet", indexes={@ORM\Index(name="fk_pet_user1_idx", columns={"user_iduser"})})
 */
class Pet
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="idpet", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idpet;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez le nom de votre animal pour continuer"
     * )
     * @ORM\Column(name="name", type="string", length=45, nullable=false, options={"default"="Rex"})
     */
    private $name = 'Rex';

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez le type d'animal pour continuer"
     * )
     * 
     * @ORM\Column(name="type", type="string", length=60, nullable=false, options={"default"="Chien"})
     */
    private $type = 'Chien';

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez la race de l'animal pour continuer"
     * )
     * @ORM\Column(name="race", type="string", length=50, nullable=false)
     */
    private $race;

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
     *     message="Merci d'indiquez le sex de l'animal pour continuer"
     * )
     * 
     * @ORM\Column(name="sexe", type="string", length=0, nullable=false, options={"default"="Homme"})
     */
    private $sexe = 'Homme';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAcquisition", type="date", nullable=false)
     */
    private $dateacquisition;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedat;

    //@var \User
    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Secondary\User", inversedBy="pets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_iduser", referencedColumnName="iduser")
     * })
     */
    private $userIduser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Secondary\Location", mappedBy="petIdpet", orphanRemoval=true)
     */
    private $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
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
        if(empty($this->updatedat)){
            $this->updatedat = new \DateTime();
        }
    }

    public function getIdpet(): ?int
    {
        return $this->idpet;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRace(): ?string
    {
        return $this->race;
    }

    public function setRace(string $race): self
    {
        $this->race = $race;

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

    public function getDateacquisition(): ?\DateTimeInterface
    {
        return $this->dateacquisition;
    }

    public function setDateacquisition(\DateTimeInterface $dateacquisition): self
    {
        $this->dateacquisition = $dateacquisition;

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

    public function getUpdatedat(): ?\DateTimeInterface
    {
        return $this->updatedat;
    }

    public function setUpdatedat(\DateTimeInterface $updatedat): self
    {
        $this->updatedat = $updatedat;

        return $this;
    }

    public function getUserIduser(): ?User
    {
        return $this->userIduser;
    }

    public function setUserIduser(?User $userIduser): self
    {
        $this->userIduser = $userIduser;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setPetIdpet($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getPetIdpet() === $this) {
                $location->setPetIdpet(null);
            }
        }

        return $this;
    }
}
