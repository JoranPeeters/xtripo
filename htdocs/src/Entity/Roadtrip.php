<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'roadtrip')]
#[HasLifecycleCallbacks]
class Roadtrip
{
    public const COST_LOW = 'economy';
    public const COST_MODERATE = 'comfort';
    public const COST_HIGH = 'premium';

    public const DISTANCE_SHORT = 'short';
    public const DISTANCE_MEDIUM = 'medium';
    public const DISTANCE_LONG = 'long';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $title;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Choice(choices: [self::COST_LOW, self::COST_MODERATE, self::COST_HIGH], message: 'Choose a valid budget.')]
    private $cost_preferences;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Choice(choices: [self::DISTANCE_SHORT, self::DISTANCE_MEDIUM, self::DISTANCE_LONG], message: 'Choose a valid distance.')]
    private $distance;

    #[ORM\Column(type: 'integer')]
    private $travelers;

    #[ORM\Column(type: 'boolean')]
    private $rent_car;

    #[ORM\Column(type: 'boolean')]
    private $start_from_home;

    #[ORM\Column(type: 'date')]
    private $start_date;

    #[ORM\Column(type: 'date')]
    private $end_date;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'roadtrips')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\OneToMany(mappedBy: 'roadtrip', targetEntity: Waypoint::class)]
    private Collection $waypoints;

    #[ORM\ManyToOne(targetEntity: Country::class, inversedBy: 'roadtrips')]
    #[ORM\JoinColumn(nullable: false)]
    private $country;

    #[ORM\ManyToOne(targetEntity: Vehicle::class, inversedBy: 'roadtrips')]
    #[ORM\JoinColumn(nullable: true)]   
    private $vehicle;

    #[ORM\ManyToOne(targetEntity: RentalVehicle::class, inversedBy: 'roadtrips')]
    #[ORM\JoinColumn(nullable: true)]
    private $rental_vehicle;

    #[ORM\ManyToMany(targetEntity: RoadtripType::class, inversedBy: 'roadtrips')]
    #[ORM\JoinTable(name: 'roadtrip_roadtrip_type')]
    private $roadtrip_types;

    #[ORM\OneToMany(mappedBy: 'roadtrip', targetEntity: Activity::class)]
    private $activities;
    
    #[ORM\OneToMany(mappedBy: 'roadtrip', targetEntity: Accommodation::class)]
    private $accommodations;

    #[ORM\ManyToOne(targetEntity: City::class, inversedBy: 'roadtrips')]
    #[ORM\JoinColumn(nullable: false)]
    private $starting_point;

    public function __construct()
    {
        $this->activities = new ArrayCollection(); 
        $this->roadtrip_types = new ArrayCollection();                         
        $this->waypoints = new ArrayCollection();
    }

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

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCostPreferences(): ?string
    { 
        return $this->cost_preferences;
    }

    public function setCostPreferences(string $cost_preferences): self
    {
        $this->cost_preferences = $cost_preferences;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): self
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

    public function getRentCar(): ?bool
    {
        return $this->rent_car;
    }

    public function setRentCar(bool $rent_car): self
    {
        $this->rent_car = $rent_car;

        return $this;
    }

    public function getStartFromHome(): ?bool
    {
        return $this->start_from_home;
    }

    public function setStartFromHome(bool $start_from_home): self
    {
        $this->start_from_home = $start_from_home;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @return Collection|Waypoint[]
     */
    public function getWaypoints(): Collection
    {
        return $this->waypoints;
    }

    public function addWaypoint(Waypoint $waypoint): self
    {
        if (!$this->waypoints->contains($waypoint)) {
            $this->waypoints[] = $waypoint;
            $waypoint->setRoadtrip($this);
        }

        return $this;
    }

    public function removeWaypoint(Waypoint $waypoint): self
    {
        if ($this->waypoints->removeElement($waypoint)) {
            // Set the owning side to null (unless already changed)
            if ($waypoint->getRoadtrip() === $this) {
                $waypoint->setRoadtrip(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

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

    /**
     * @return Collection|RoadtripType[]
     */
    public function getRoadtripTypes(): Collection
    {
        return $this->roadtrip_types;
    }

    public function addRoadtripType(RoadtripType $roadtripType): self
    {
        if (!$this->roadtrip_types->contains($roadtripType)) {
            $this->roadtrip_types[] = $roadtripType;
        }

        return $this;
    }

    public function removeRoadtripType(RoadtripType $roadtripType): self
    {
        $this->roadtrip_types->removeElement($roadtripType);

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setRoadtrip($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getRoadtrip() === $this) {
                $activity->setRoadtrip(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Accommodation[]
     */
    public function getAccommodations(): Collection
    {
        return $this->accommodations;
    }

    public function addAccommodation(Accommodation $accommodation): self
    {
        if (!$this->accommodations->contains($accommodation)) {
            $this->accommodations[] = $accommodation;
            $accommodation->setRoadtrip($this);
        }

        return $this;
    }

    public function removeAccommodation(Accommodation $accommodation): self
    {
        if ($this->accommodations->removeElement($accommodation)) {
            // set the owning side to null (unless already changed)
            if ($accommodation->getRoadtrip() === $this) {
                $accommodation->setRoadtrip(null);
            }
        }

        return $this;
    }

    public function getStartingPoint(): ?City
    {
        return $this->starting_point;
    }

    public function setStartingPoint(?City $starting_point): self
    {
        $this->starting_point = $starting_point;

        return $this;
    }
}
