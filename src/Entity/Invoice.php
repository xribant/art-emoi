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
     * @ORM\OneToOne(targetEntity=EventRegistration::class, inversedBy="invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $eventRegistration;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    /**
     * @ORM\OneToOne(targetEntity=FreeRegistration::class, mappedBy="invoice", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $freeRegistration;

    public function __construct() {
        $this->created_at = New \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEventRegistration(): ?EventRegistration
    {
        return $this->eventRegistration;
    }

    public function setEventRegistration(EventRegistration $eventRegistration): self
    {
        $this->eventRegistration = $eventRegistration;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

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
}
