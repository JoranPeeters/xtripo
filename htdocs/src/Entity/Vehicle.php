<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ORM\Table(name: 'vehicle')]
#[ORM\HasLifecycleCallbacks]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $vehicle_type = null;

    #[ORM\Column(type: 'array')]
    private $models = [];

    #[ORM\Column(type: 'array')]
    private $fuel_types = [];

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\OneToMany(mappedBy: 'vehicle', targetEntity: Roadtrip::class)]
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

    public function getVehicleType(): ?string
    {
        return $this->vehicle_type;
    }

    public function setVehicleType(string $vehicle_type): self
    {
        $this->vehicle_type = $vehicle_type;

        return $this;
    }

    public function getModels(): ?array
    {
        return $this->models;
    }

    public function setModels(array $models): self
    {
        $this->models = $models;

        return $this;
    }

    public function getFuelTypes(): ?array
    {
        return $this->fuel_types;
    }

    public function setFuelTypes(array $fuel_types): self
    {
        $this->fuel_types = $fuel_types;

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
            $roadtrip->setVehicle($this);
        }

        return $this;
    }

    public function removeRoadtrip(Roadtrip $roadtrip): self
    {
        if ($this->roadtrips->removeElement($roadtrip)) {
            // set the owning side to null (unless already changed)
            if ($roadtrip->getVehicle() === $this) {
                $roadtrip->setVehicle(null);
            }
        }

        return $this;
    }
}
