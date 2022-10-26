<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Veuillez entrer une date de début")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Veuillez entrer une date de fin")
     */
    private $end_date;

    /**
     * @ORM\ManyToOne(targetEntity=Workshop::class, inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir la formation")
     */
    private $workshop;

    /**
     * @ORM\OneToMany(targetEntity=EventRegistration::class, mappedBy="event", orphanRemoval=true)
     */
    private $eventRegistrations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=WorkshopLocation::class, inversedBy="events")
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\Column(type="boolean")
     */
    private $presentiel;

    /**
     * @ORM\OneToMany(targetEntity=Discount::class, mappedBy="event", fetch="EAGER")
     */
    private $discounts;

    public function __construct()
    {
        $this->eventRegistrations = new ArrayCollection();
        $this->discounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }


    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(?Workshop $workshop): self
    {
        $this->workshop = $workshop;

        return $this;
    }

    /**
     * @return Collection|EventRegistration[]
     */
    public function getEventRegistrations(): Collection
    {
        return $this->eventRegistrations;
    }

    public function addEventRegistration(EventRegistration $eventRegistration): self
    {
        if (!$this->eventRegistrations->contains($eventRegistration)) {
            $this->eventRegistrations[] = $eventRegistration;
            $eventRegistration->setEvent($this);
        }

        return $this;
    }

    public function removeEventRegistration(EventRegistration $eventRegistration): self
    {
        if ($this->eventRegistrations->removeElement($eventRegistration)) {
            // set the owning side to null (unless already changed)
            if ($eventRegistration->getEvent() === $this) {
                $eventRegistration->setEvent(null);
            }
        }

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getLocation(): ?WorkshopLocation
    {
        return $this->location;
    }

    public function setLocation(?WorkshopLocation $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getPresentiel(): ?bool
    {
        return $this->presentiel;
    }

    public function setPresentiel(bool $presentiel): self
    {
        $this->presentiel = $presentiel;

        return $this;
    }

    /**
     * @return Collection<int, Discount>
     */
    public function getDiscounts(): Collection
    {
        return $this->discounts;
    }

    public function addDiscount(Discount $discount): self
    {
        if (!$this->discounts->contains($discount)) {
            $this->discounts[] = $discount;
            $discount->setEvent($this);
        }

        return $this;
    }

    public function removeDiscount(Discount $discount): self
    {
        if ($this->discounts->removeElement($discount)) {
            // set the owning side to null (unless already changed)
            if ($discount->getEvent() === $this) {
                $discount->setEvent(null);
            }
        }

        return $this;
    }
}
