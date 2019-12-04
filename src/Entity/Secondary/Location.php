<?php

namespace App\Entity\Secondary;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ORM\Table(name="location", indexes={@ORM\Index(name="fk_location_pet1_idx", columns={"pet_idpet"})})
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="idlocation", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idlocation;

    /**
     * @var string
     *
     * @ORM\Column(name="lat", type="string", length=45, nullable=false)
     */
    private $lat;

    /**
     * @var string
     *
     * @ORM\Column(name="lon", type="string", length=45, nullable=false)
     */
    private $lon;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat = 'CURRENT_TIMESTAMP';

    //@var \Pet
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secondary\Pet", inversedBy="locations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pet_idpet", referencedColumnName="idpet")
     * })
     */
    private $petIdpet;

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
