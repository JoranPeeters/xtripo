<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table(name: 'country')]
#[ORM\HasLifecycleCallbacks]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'integer')]
    private $popularity;

    #[ORM\Column(type: 'array')]
    private $cities = [];

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'datetime')]
    private $updated_at;

    #[ORM\OneToMany(mappedBy: 'roadtrip', targetEntity: Roadtrip::class)]
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

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCities(): ?array
    {
        return $this->cities;
    }

    public function setCities(array $cities): self
    {
        $this->cities = $cities;

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

    public function getRoadtrips(): Collection
    {
        return $this->roadtrips;
    }

    public function addRoadtrip(Roadtrip $roadtrip): self
    {
        if (!$this->roadtrips->contains($roadtrip)) {
            $this->roadtrips[] = $roadtrip;
            $roadtrip->setCountry($this);
        }

        return $this;
    }

    public function removeRoadtrip(Roadtrip $roadtrip): self
    {
        if ($this->roadtrips->removeElement($roadtrip)) {
            // set the owning side to null (unless already changed)
            if ($roadtrip->getCountry() === $this) {
                $roadtrip->setCountry(null);
            }
        }

        return $this;
    }
}
