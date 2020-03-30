<?php

namespace App\Entity;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="account_from", orphanRemoval=true)
     */
    private $transactions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Transaction", mappedBy="account_to", orphanRemoval=true)
     */
    private $transactions_to;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
        $this->transactions_to = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setAccountFrom($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getAccountFrom() === $this) {
                $transaction->setAccountFrom(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionsTo(): Collection
    {
        return $this->transactions_to;
    }

    public function addTransactionsTo(Transaction $transactionsTo): self
    {
        if (!$this->transactions_to->contains($transactionsTo)) {
            $this->transactions_to[] = $transactionsTo;
            $transactionsTo->setAccountTo($this);
        }

        return $this;
    }

    public function removeTransactionsTo(Transaction $transactionsTo): self
    {
        if ($this->transactions_to->contains($transactionsTo)) {
            $this->transactions_to->removeElement($transactionsTo);
            // set the owning side to null (unless already changed)
            if ($transactionsTo->getAccountTo() === $this) {
                $transactionsTo->setAccountTo(null);
            }
        }

        return $this;
    }
}
