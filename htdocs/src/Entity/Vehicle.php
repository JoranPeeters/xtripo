<?php

// src/Entity/Vehicle.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VehicleRepository;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'array')]
    private $fuel_types = [];

    #[ORM\Column(type: 'array')]
    private $models = [];

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFuelTypes(): array
    {
        return $this->fuel_types;
    }

    public function setFuelTypes(array $fuel_types): self
    {
        $this->fuel_types = $fuel_types;

        return $this;
    }

    public function getModels(): array
    {
        return $this->models;
    }

    public function setModels(array $models): self
    {
        $this->models = $models;

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
}

