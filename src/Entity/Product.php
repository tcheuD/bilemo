<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "show"})
     */
    private $operating_system;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "show"})
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     * @Groups({"list", "show"})
     */
    private $release_date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"show"})
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $brand;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $display_type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $resolution;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $battery;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     */
    private $weight;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"list", "show"})
     */
    private $stock;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"list", "show"})
     */
    private $product_description;

    /** @Groups({"list"}) */
    private $productList;

    /** @Groups({"show"}) */
    private $productShow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operating_system;
    }

    public function setOperatingSystem(string $operating_system): self
    {
        $this->operating_system = $operating_system;

        return $this;
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

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): self
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDisplayType(): ?string
    {
        return $this->display_type;
    }

    public function setDisplayType(string $display_type): self
    {
        $this->display_type = $display_type;

        return $this;
    }

    public function getResolution(): ?string
    {
        return $this->resolution;
    }

    public function setResolution(string $resolution): self
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getBattery(): ?string
    {
        return $this->battery;
    }

    public function setBattery(string $battery): self
    {
        $this->battery = $battery;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->product_description;
    }

    public function setProductDescription(string $product_description): self
    {
        $this->product_description = $product_description;

        return $this;
    }

    public function getProductList(): array
    {
       return [
           '_links' => [
               'self' => '/api/product/'.$this->getId()
           ]
       ];
    }

    public function getProductShow(): array
    {
        return [
            '_links' => [
                'list all products' => '/api/product/',
                'self' => '/api/product/'.$this->getId()
            ]
        ];
    }
}
