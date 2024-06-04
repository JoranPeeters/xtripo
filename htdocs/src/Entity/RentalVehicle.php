<?php

namespace App\Entity;

use App\Repository\RentalVehicleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentalVehicleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RentalVehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Roadtrip::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $roadtrip;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $rental_company;

    #[ORM\Column(type: 'string', length: 255)]
    private $pickup_location;

    #[ORM\Column(type: 'string', length: 255)]
    private $dropoff_location;

    #[ORM\Column(type: 'date')]
    private $start_date;

    #[ORM\Column(type: 'date')]
    private $end_date;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

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

    public function getRoadtrip(): ?Roadtrip
    {
        return $this->roadtrip;
    }

    public function setRoadtrip(?Roadtrip $roadtrip): self
    {
        $this->roadtrip = $roadtrip;

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

    public function getRentalCompany(): ?string
    {
        return $this->rental_company;
    }

    public function setRentalCompany(string $rental_company): self
    {
        $this->rental_company = $rental_company;

        return $this;
    }

    public function getPickupLocation(): ?string
    {
        return $this->pickup_location;
    }

    public function setPickupLocation(string $pickup_location): self
    {
        $this->pickup_location = $pickup_location;

        return $this;
    }

    public function getDropoffLocation(): ?string
    {
        return $this->dropoff_location;
    }

    public function setDropoffLocation(string $dropoff_location): self
    {
        $this->dropoff_location = $dropoff_location;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

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
}
