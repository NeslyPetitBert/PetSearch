<?php

namespace App\Entity\Secondary;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billing
 *
 * @ORM\Entity(repositoryClass="App\Repository\BillingRepository")
 * @ORM\Table(name="billing", indexes={@ORM\Index(name="fk_billing_user1_idx", columns={"user_iduser"})})
 */
class Billing
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(name="idbilling", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idbilling;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateBilling", type="date", nullable=false)
     */
    private $datebilling;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=16, scale=3, nullable=false)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdat = 'CURRENT_TIMESTAMP';

    //@var \User
    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Secondary\User", inversedBy="billings")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_iduser", referencedColumnName="iduser")
     * })
     */
    private $userIduser;

    public function getIdbilling(): ?int
    {
        return $this->idbilling;
    }

    public function getDatebilling(): ?\DateTimeInterface
    {
        return $this->datebilling;
    }

    public function setDatebilling(\DateTimeInterface $datebilling): self
    {
        $this->datebilling = $datebilling;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

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
}
