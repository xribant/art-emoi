<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fileName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=FreeRegistration::class, mappedBy="invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $freeRegistration;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="invoice", cascade={"persist", "remove"})
     */
    private $linkedOrder;

    public function __construct() {
        $this->created_at = New \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    
    public function getFreeRegistration(): ?FreeRegistration
    {
        return $this->freeRegistration;
    }

    public function setFreeRegistration(FreeRegistration $freeRegistration): self
    {
        // set the owning side of the relation if necessary
        if ($freeRegistration->getInvoice() !== $this) {
            $freeRegistration->setInvoice($this);
        }

        $this->freeRegistration = $freeRegistration;

        return $this;
    }

    public function getLinkedOrder(): ?Order
    {
        return $this->linkedOrder;
    }

    public function setLinkedOrder(?Order $linkedOrder): self
    {
        $this->linkedOrder = $linkedOrder;

        return $this;
    }
}
