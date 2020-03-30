<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account_from;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Account", inversedBy="transactions_to")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account_to;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_create;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $error;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountFrom(): ?Account
    {
        return $this->account_from;
    }

    public function setAccountFrom(?Account $account_from): self
    {
        $this->account_from = $account_from;

        return $this;
    }

    public function getAccountTo(): ?Account
    {
        return $this->account_to;
    }

    public function setAccountTo(?Account $account_to): self
    {
        $this->account_to = $account_to;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDateCreate(): ?string
    {
        return $this->date_create;
    }

    public function setDateCreate(string $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getError(): ?string
    {
        return $this->error;
    }

    public function setError(?string $error): self
    {
        $this->error = $error;

        return $this;
    }
}
