<?php
// src/Entity/Roadtrip.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoadtripRepository;

#[ORM\Entity(repositoryClass: RoadtripRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Roadtrip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'json')]
    private $open_ai_output = [];

    #[ORM\Column(type: 'array')]
    private $info = [];

    #[ORM\Column(type: 'date')]
    private $start_date;

    #[ORM\Column(type: 'date')]
    private $end_date;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Vehicle::class)]
    private $vehicle;

    #[ORM\ManyToOne(targetEntity: RentalVehicle::class)]
    private $rental_vehicle;

    #[ORM\Column(type: 'string', length: 255)]
    private $budget;

    #[ORM\Column(type: 'integer')]
    private $distance;

    #[ORM\Column(type: 'integer')]
    private $travelers;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getOpenAiOutput(): ?array
    {
        return $this->open_ai_output;
    }

    public function setOpenAiOutput(array $open_ai_output): self
    {
        $this->open_ai_output = $open_ai_output;

        return $this;
    }

    public function getInfo(): ?array
    {
        return $this->info;
    }

    public function setInfo(array $info): self
    {
        $this->info = $info;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getRentalVehicle(): ?RentalVehicle
    {
        return $this->rental_vehicle;
    }

    public function setRentalVehicle(?RentalVehicle $rental_vehicle): self
    {
        $this->rental_vehicle = $rental_vehicle;

        return $this;
    }

    public function getBudget(): ?string
    {
        return $this->budget;
    }

    public function setBudget(string $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getDistance(): ?int
    {
        return $this->distance;
    }

    public function setDistance(int $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getTravelers(): ?int
    {
        return $this->travelers;
    }

    public function setTravelers(int $travelers): self
    {
        $this->travelers = $travelers;

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
