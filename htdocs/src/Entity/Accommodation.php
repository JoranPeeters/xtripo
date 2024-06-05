<?php

namespace App\Entity;

use App\Repository\AccommodationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccommodationRepository::class)]
#[ORM\Table(name: 'accommodation')]
#[ORM\HasLifecycleCallbacks]
class Accommodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: 'integer')]
    private ?string $popularity = null;

    #[ORM\Column(type: 'integer')]
    private ?int $price_level = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $address = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private $latitude;

    #[ORM\Column(type: 'float', nullable: true)]
    private $longitude;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2, nullable: true)]
    private $price;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $room_type;

    #[ORM\Column(type: 'time', nullable: true)]
    private $check_in;

    #[ORM\Column(type: 'time', nullable: true)]
    private $check_out;

    #[ORM\Column(type: 'json', nullable: true)]
    private $amenities = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo_reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $place_id;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\ManyToOne(targetEntity: Roadtrip::class, inversedBy: 'accommodations')]
    #[ORM\JoinColumn(nullable: false)]
    private $roadtrip;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getPriceLevel(): ?int
    {
        return $this->price_level;
    }

    public function setPriceLevel(int $price_level): self
    {
        $this->price_level = $price_level;

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

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLatitude($latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setLongitude($longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRoomType()
    {
        return $this->room_type;
    }

    public function setRoomType($room_type): self
    {
        $this->room_type = $room_type;

        return $this;
    }

    public function getCheckIn()
    {
        return $this->check_in;
    }

    public function setCheckIn($check_in): self
    {
        $this->check_in = $check_in;

        return $this;
    }

    public function getCheckOut()
    {
        return $this->check_out;
    }

    public function setCheckOut($check_out): self
    {
        $this->check_out = $check_out;

        return $this;
    }

    public function getAmenities()
    {
        return $this->amenities;
    }

    public function setAmenities($amenities): self
    {
        $this->amenities = $amenities;

        return $this;
    }

    public function getPhotoReference()
    {
        return $this->photo_reference;
    }

    public function setPhotoReference($photo_reference): self
    {
        $this->photo_reference = $photo_reference;

        return $this;
    }

    public function getPlaceId()
    {
        return $this->place_id;
    }

    public function setPlaceId($place_id): self
    {
        $this->place_id = $place_id;

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

    public function getRoadtrip(): ?Roadtrip
    {
        return $this->roadtrip;
    }

    public function setRoadtrip(?Roadtrip $roadtrip): self
    {
        $this->roadtrip = $roadtrip;

        return $this;
    }
}
