<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PlaceRepository::class)]
#[ORM\Table(name: 'place')]
#[ORM\HasLifecycleCallbacks]
class Place
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $website_url = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $tripadvisor_url = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $popularity = null;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $price_level = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $rating = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $rating_image_url = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $num_reviews = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $check_in = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $check_out = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private array $amenities = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $photo_url = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $place_id = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $category;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $created_at;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updated_at;

    #[ORM\ManyToMany(targetEntity: Roadtrip::class, mappedBy: 'places')]
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

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getWebsiteUrl(): ?string
    {
        return $this->website_url;
    }

    public function setWebsiteUrl(?string $website_url): self
    {
        $this->website_url = $website_url;

        return $this;
    }

    public function getTripadvisorUrl(): ?string
    {
        return $this->tripadvisor_url;
    }

    public function setTripadvisorUrl(?string $tripadvisor_url): self
    {
        $this->tripadvisor_url = $tripadvisor_url;

        return $this;
    }

    public function getPopularity(): ?int
    {
        return $this->popularity;
    }

    public function setPopularity(?int $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getPriceLevel(): ?string
    {
        return $this->price_level;
    }

    public function setPriceLevel(?string $price_level): self
    {
        $this->price_level = $price_level;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getRatingImageUrl(): ?string
    {
        return $this->rating_image_url;
    }

    public function setRatingImageUrl(?string $rating_image_url): self
    {
        $this->rating_image_url = $rating_image_url;

        return $this;
    }

    public function getNumReviews(): ?int
    {
        return $this->num_reviews;
    }

    public function setNumReviews(?int $num_reviews): self
    {
        $this->num_reviews = $num_reviews;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCheckIn(): ?\DateTimeInterface
    {
        return $this->check_in;
    }

    public function setCheckIn(\DateTimeInterface $check_in): self
    {
        $this->check_in = $check_in;

        return $this;
    }

    public function getCheckOut(): ?\DateTimeInterface
    {
        return $this->check_out;
    }

    public function setCheckOut(\DateTimeInterface $check_out): self
    {
        $this->check_out = $check_out;

        return $this;
    }

    public function getAmenities(): ?array
    {
        return $this->amenities;
    }

    public function setAmenities(?array $amenities): self
    {
        $this->amenities = $amenities;

        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photo_url;
    }

    public function setPhotoUrl(?string $photo_url): self
    {
        $this->photo_url = $photo_url;

        return $this;
    }

    public function getPlaceId(): ?string
    {
        return $this->place_id;
    }

    public function setPlaceId(?string $place_id): self
    {
        $this->place_id = $place_id;

        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @return Collection|Roadtrip[]
     */
    public function getRoadtrips(): Collection
    {
        return $this->roadtrips;
    }

    public function addRoadtrip(Roadtrip $roadtrip): self
    {
        if (!$this->roadtrips->contains($roadtrip)) {
            $this->roadtrips[] = $roadtrip;
            $roadtrip->addPlace($this);
        }

        return $this;
    }

    public function removeRoadtrip(Roadtrip $roadtrip): self
    {
        if ($this->roadtrips->removeElement($roadtrip)) {
            $roadtrip->removePlace($this);
        }

        return $this;
    }
}
