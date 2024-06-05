<?php

namespace App\Entity;

use App\Repository\RentalVehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: RentalVehicleRepository::class)]
#[ORM\Table(name: 'rental_vehicle')]
#[ORM\HasLifecycleCallbacks]
class RentalVehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $vehicle_type = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $model = null;

    #[ORM\column(type: 'string', length: 255)]
    private ?string $rental_company = null;

    #[ORM\column(type: 'string', length: 255)]
    private ?string $pickup_location = null;

    #[ORM\column(type: 'string', length: 255)]
    private ?string $dropoff_location = null;

    #[ORM\column(type: 'datetime')]
    private $pickup_date;

    #[ORM\column(type: 'datetime')]
    private $dropoff_date;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\OneToMany(mappedBy: 'rental_vehicle', targetEntity: Roadtrip::class)]
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

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

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

    public function getPickupDate(): ?\DateTimeInterface
    {
        return $this->pickup_date;
    }

    public function setPickupDate(\DateTimeInterface $pickup_date): self
    {
        $this->pickup_date = $pickup_date;

        return $this;
    }

    public function getDropoffDate(): ?\DateTimeInterface
    {
        return $this->dropoff_date;
    }

    public function setDropoffDate(\DateTimeInterface $dropoff_date): self
    {
        $this->dropoff_date = $dropoff_date;

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
            $roadtrip->setRentalVehicle($this);
        }

        return $this;
    } 
    
    public function removeRoadtrip(Roadtrip $roadtrip): self
    {
        if ($this->roadtrips->removeElement($roadtrip)) {
            // set the owning side to null (unless already changed)
            if ($roadtrip->getRentalVehicle() === $this) {
                $roadtrip->setRentalVehicle(null);
            }
        }

        return $this;
    }


}
