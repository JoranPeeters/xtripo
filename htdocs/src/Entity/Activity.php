<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[ORM\Table(name: 'activity')]
#[ORM\HasLifecycleCallbacks]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $website_url = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $tripadvisor_url = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $num_reviews = null;

    #[ORM\Column(type: 'integer')]
    private ?string $popularity = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private $latitude;

    #[ORM\Column(type: 'float', nullable: true)]
    private $longitude;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $opening_hours = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo_url;

    #[ORM\Column(type: 'string',length: 255)]
    private ?string $place_id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $rating;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $rating_image_url;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToMany(targetEntity: Roadtrip::class, mappedBy: 'activities')]
    private Collection $roadtrips;

    public function __construct()
    {
        $this->roadtrips = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
        $this->setUpdatedAtValue();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWebsiteUrl(): ?string
    {
        return $this->website_url;
    }

    public function setWebsiteUrl(string $website_url): self
    {
        $this->website_url = $website_url;

        return $this;
    }

    public function getTripadvisorUrl(): ?string
    {
        return $this->tripadvisor_url;
    }

    public function setTripadvisorUrl(string $tripadvisor_url): self
    {
        $this->tripadvisor_url = $tripadvisor_url;

        return $this;
    }

    public function getNumReviews(): ?string
    {
        return $this->num_reviews;
    }

    public function setNumReviews(string $num_reviews): self
    {
        $this->num_reviews = $num_reviews;

        return $this;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function setPopularity(int $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getOpeningHours(): ?string
    {
        return $this->opening_hours;
    }

    public function setOpeningHours(string $opening_hours): self
    {
        $this->opening_hours = $opening_hours;

        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    public function setPhotoUrl(string $photo_url): self
    {
        $this->photo_url = $photo_url;

        return $this;
    }

    public function getPlaceId(): ?string
    {
        return $this->place_id;
    }

    public function setPlaceId(string $place_id): self
    {
        $this->place_id = $place_id;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(string $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getRatingImageUrl(): ?string
    {
        return $this->rating_image_url;
    }

    public function setRatingImageUrl(string $rating_image_url): self
    {
        $this->rating_image_url = $rating_image_url;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }
    
    /**
     * @return Collection|Roadrip[]
     */
    public function getRoadtrips(): Collection
    {
        return $this->roadtrips;
    }

    public function addRoadtrip(Roadtrip $roadtrip): self
    {
        if (!$this->roadtrips->contains($roadtrip)) {
            $this->roadtrips->add($roadtrip);
            $roadtrip->addActivity($this);
        }

        return $this;
    }

    public function removeRoadtrip(Roadtrip $roadtrip): self
    {
        if ($this->roadtrips->removeElement($roadtrip)) {
            $roadtrip->removeActivity($this);
        }

        return $this;
    }
}
