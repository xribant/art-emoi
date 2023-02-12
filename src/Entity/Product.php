<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable()
 */
class Product
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
    private $uid;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de sélectionner un type de service")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci d'entrer un nom ou un titre")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageName;

    /**
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize="1M",
     *     maxSizeMessage="La taille du fichier doit être inférieure à 1 Mb",
     *     mimeTypes={"image/jpeg", "image/jpg", "image/png"},
     *     mimeTypesMessage = "Fichiers .jpeg ou .png uniquement"
     * )
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de sélectionner un public")
     */
    private $public;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Merci d'entrer une date de début")
     */
    private $start_at;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Merci d'entrer une date de fin")
     */
    private $end_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nbr_sessions;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\PositiveOrZero(message="Veuillez entre un montant valide")
     * @Assert\Type(type="float", message="Veuillez entre un montant valide")
     */
    private $onlinePrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\PositiveOrZero(message="Veuillez entre un montant valide")
     * @Assert\Type(type="float", message="Veuillez entre un montant valide")
     */
    private $visioPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\PositiveOrZero(message="Veuillez entre un montant valide")
     * @Assert\Type(type="float", message="Veuillez entre un montant valide")
     */
    private $presentPrice;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez entrer le nom d'un(e) animateur/trice")
     */
    private $trainer;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $video_link;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $testimonial;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $hardware_list;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $online;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visio;

    /**
     * @ORM\Column(type="boolean")
     */
    private $present;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rdv;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $present_location;

    public function __construct()
    {
        $this->created_at = new DateTime();
        $this->updated_at = new DateTime();
        $this->uid = uniqid();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile): Product
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublic(): ?string
    {
        return $this->public;
    }

    public function setPublic(string $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(?\DateTimeInterface $start_at): self
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(?\DateTimeInterface $end_at): self
    {
        $this->end_at = $end_at;

        return $this;
    }

    public function getNbrSessions(): ?string
    {
        return $this->nbr_sessions;
    }

    public function setNbrSessions(?string $nbr_sessions): self
    {
        $this->nbr_sessions = $nbr_sessions;

        return $this;
    }

    public function getOnlinePrice(): ?float
    {
        return $this->onlinePrice;
    }

    public function setOnlinePrice(?float $onlinePrice): self
    {
        $this->onlinePrice = $onlinePrice;

        return $this;
    }

    public function getVisioPrice(): ?float
    {
        return $this->visioPrice;
    }

    public function setVisioPrice(?float $visioPrice): self
    {
        $this->visioPrice = $visioPrice;

        return $this;
    }

    public function getPresentPrice(): ?float
    {
        return $this->presentPrice;
    }

    public function setPresentPrice(?float $presentPrice): self
    {
        $this->presentPrice = $presentPrice;

        return $this;
    }

    public function getTrainer(): ?string
    {
        return $this->trainer;
    }

    public function setTrainer(string $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

    public function getVideoLink(): ?string
    {
        return $this->video_link;
    }

    public function setVideoLink(?string $video_link): self
    {
        $this->video_link = $video_link;

        return $this;
    }

    public function getTestimonial(): ?string
    {
        return $this->testimonial;
    }

    public function setTestimonial(?string $testimonial): self
    {
        $this->testimonial = $testimonial;

        return $this;
    }

    public function getHardwareList(): ?string
    {
        return $this->hardware_list;
    }

    public function setHardwareList(?string $hardware_list): self
    {
        $this->hardware_list = $hardware_list;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getOnline(): ?bool
    {
        return $this->online;
    }

    public function setOnline(bool $online): self
    {
        $this->online = $online;

        return $this;
    }

    public function getVisio(): ?bool
    {
        return $this->visio;
    }

    public function setVisio(bool $visio): self
    {
        $this->visio = $visio;

        return $this;
    }

    public function getPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(bool $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getRdv(): ?bool
    {
        return $this->rdv;
    }

    public function setRdv(bool $rdv): self
    {
        $this->rdv = $rdv;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPresentLocation(): ?string
    {
        return $this->present_location;
    }

    public function setPresentLocation(?string $present_location): self
    {
        $this->present_location = $present_location;

        return $this;
    }
}
