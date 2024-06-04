<?php
// src/Entity/Roadtrip.php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RoadtripRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: RoadtripRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Roadtrip
{
    public function __construct()
    {
        $this->types = new ArrayCollection();
    }
    
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

    #[ORM\Column(type: 'string', length: 255)]
    private $destination;

    #[ORM\Column(type: 'string', length: 255)]
    private $vehicle_type;

    #[ORM\Column(type: 'string', length: 255)]
    private $vehicle_fuel;

    #[ORM\Column(type: 'string', length: 255)]
    private $vehicle_model;

    #[ORM\Column(type: 'boolean')]
    private $rent_vehicle;

    #[ORM\ManyToMany(targetEntity: Type::class, inversedBy: 'roadtrips')]
    #[ORM\JoinTable(name: 'roadtrips_types')]
    private $types;

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

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;
        return $this;
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

    public function getVehicleFuel(): ?string
    {
        return $this->vehicle_fuel;
    }

    public function setVehicleFuel(string $vehicle_fuel): self
    {
        $this->vehicle_fuel = $vehicle_fuel;
        return $this;
    }

    public function getVehicleModel(): ?string
    {
        return $this->vehicle_model;
    }

    public function setVehicleModel(string $vehicle_model): self
    {
        $this->vehicle_model = $vehicle_model;
        return $this;
    }

    /**
    * @return Collection|Type[]
    */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function setTypes(Collection $types): self
    {
        $this->types = $types;
        return $this;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
        $this->types[] = $type;
        $type->addRoadtrip($this);
        }
        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->removeElement($type)) {
        $type->removeRoadtrip($this);
        }
        return $this;
    }

    public function getRentCar(): ?bool
    {
        return $this->rent_vehicle;
    }

    public function setRentCar(bool $rent_vehicle): self
    {
        $this->rent_vehicle = $rent_vehicle;
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
