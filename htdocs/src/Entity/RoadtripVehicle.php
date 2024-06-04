<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoadtripVehicleRepository;

#[ORM\Entity(repositoryClass: RoadtripVehicleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class RoadtripVehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Roadtrip::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $roadtrip;

    #[ORM\ManyToOne(targetEntity: Vehicle::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $vehicle;

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

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }
}
