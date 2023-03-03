<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripe_description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $creation_date;

    /**
     * @ORM\Column(type="datetime", nullable="true")
     */
    private $closure_date;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="payments", cascade={"persist"})
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="payment")
     */
    private $targetOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStripeDescription(): ?string
    {
        return $this->stripe_description;
    }

    public function setStripeDescription(string $stripe_description): self
    {
        $this->stripe_description = $stripe_description;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(\DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    public function getClosureDate(): ?\DateTimeInterface
    {
        return $this->closure_date;
    }

    public function setClosureDate(\DateTimeInterface $closure_date): self
    {
        $this->closure_date = $closure_date;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTargetOrder(): ?Order
    {
        return $this->targetOrder;
    }

    public function setTargetOrder(?Order $targetOrder): self
    {
        $this->targetOrder = $targetOrder;

        return $this;
    }
}
