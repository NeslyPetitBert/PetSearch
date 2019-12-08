<?php

namespace App\Entity\Secondary;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Location
 *
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="location", indexes={@ORM\Index(name="fk_location_pet1_idx", columns={"pet_idpet"})})
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="idlocation", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlocation;

    /**
     * @var string
     *
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez la lalitude pour continuer"
     * )
     * @ORM\Column(name="lat", type="string", length=45, nullable=false)
     */
    private $lat;

    /**
     * @var string
     * 
     * @Assert\Type(
     *     "string",
     *     message="Cette valeur n'est pas valide."
     * )
     * @Assert\NotBlank(
     *     message="Merci d'indiquez la longitude pour continuer"
     * )
     * @ORM\Column(name="lon", type="string", length=45, nullable=false)
     */
    private $lon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat;

    //@var \Pet
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secondary\Pet", inversedBy="locations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pet_idpet", referencedColumnName="idpet")
     * })
     */
    private $petIdpet;


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
    }

    public function getIdlocation(): ?int
    {
        return $this->idlocation;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?string
    {
        return $this->lon;
    }

    public function setLon(string $lon): self
    {
        $this->lon = $lon;

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

    public function getPetIdpet(): ?Pet
    {
        return $this->petIdpet;
    }

    public function setPetIdpet(?Pet $petIdpet): self
    {
        $this->petIdpet = $petIdpet;

        return $this;
    }
}
