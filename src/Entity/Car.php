<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 70)]
    private $model;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private $price;

    #[ORM\Column(type: 'string', length: 4)]
    private $releaseYear;

    #[ORM\Column(type: 'integer')]
    private $km;

    #[ORM\Column(type: 'boolean')]
    private $licenceDriver;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $photo;

    #[ORM\ManyToOne(targetEntity: Brand::class, inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private $brand;

    #[ORM\ManyToOne(targetEntity: Energy::class, inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private $Energy;

    #[ORM\Column(type: 'boolean')]
    private $active;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getReleaseYear(): ?string
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(string $releaseYear): self
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getKm(): ?int
    {
        return $this->km;
    }

    public function setKm(int $km): self
    {
        $this->km = $km;

        return $this;
    }

    public function getLicenceDriver(): ?bool
    {
        return $this->licenceDriver;
    }

    public function setLicenceDriver(bool $licenceDriver): self
    {
        $this->licenceDriver = $licenceDriver;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getEnergy(): ?Energy
    {
        return $this->Energy;
    }

    public function setEnergy(?Energy $Energy): self
    {
        $this->Energy = $Energy;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
