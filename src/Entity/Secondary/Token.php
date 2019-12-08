<?php

namespace App\Entity\Secondary;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Token
 * 
 * @ORM\Entity()
 * @ORM\Entity(repositoryClass="App\Repository\TokenRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="token", uniqueConstraints={@ORM\UniqueConstraint(name="idtoken_UNIQUE", columns={"idtoken"})}, indexes={@ORM\Index(name="fk_token_user_idx", columns={"user_iduser"})})
 */
class Token
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(name="idtoken", type="string", length=80, nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idtoken;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=0, nullable=false, options={"default"="Bearer"})
     */
    private $type = 'Bearer';

    /**
     * @var string
     *
     * @ORM\Column(name="decive", type="string", length=0, nullable=false, options={"default"="Destop"})
     */
    private $decive = 'Destop';

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
    private $createdat;

    //@var \User
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secondary\User", inversedBy="tokens")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_iduser", referencedColumnName="iduser")
     * })
     */
    private $userIduser;

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
        
    public function getIdtoken(): ?string
    {
        return $this->idtoken;
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

    public function getDecive(): ?string
    {
        return $this->decive;
    }

    public function setDecive(string $decive): self
    {
        $this->decive = $decive;

        return $this;
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

    public function getUserIduser(): ?User
    {
        return $this->userIduser;
    }

    public function setUserIduser(?User $userIduser): self
    {
        $this->userIduser = $userIduser;

        return $this;
    }

}