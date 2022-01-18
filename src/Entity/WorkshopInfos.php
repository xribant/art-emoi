<?php

namespace App\Entity;

use App\Repository\WorkshopInfosRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WorkshopInfosRepository::class)
 */
class WorkshopInfos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank(message="Merci de sélectionner au moins un lieux de formation")
     */
    private $location = [];

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez entrer le nombre de journées de formation")
     * @Assert\Positive(message="Veuillez entrer une valeur correcte")
     */
    private $days;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(message="Veuillez entrer l'heure de début de la session")
     */
    private $start_at;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(message="Veuillez entrer l'heure de fin de la session")
     */
    private $stop_at;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="Veuillez entrer le prix")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer le nom de l'animateur/trice")
     */
    private $animator;

    /**
     * @ORM\OneToOne(targetEntity=Workshop::class, inversedBy="workshopInfos", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $workshop;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?array
    {
        return $this->location;
    }

    public function setLocation(array $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeInterface $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getStopAt(): ?\DateTimeInterface
    {
        return $this->stop_at;
    }

    public function setStopAt(\DateTimeInterface $stop_at): self
    {
        $this->stop_at = $stop_at;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getAnimator(): ?string
    {
        return $this->animator;
    }

    public function setAnimator(string $animator): self
    {
        $this->animator = $animator;

        return $this;
    }

    public function getWorkshop(): ?Workshop
    {
        return $this->workshop;
    }

    public function setWorkshop(Workshop $workshop): self
    {
        $this->workshop = $workshop;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }
}
