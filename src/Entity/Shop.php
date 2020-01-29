<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopRepository")
 */
class Shop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $shop_address;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\District", inversedBy="shops")
     */
    private $district;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopAddress(): ?string
    {
        return $this->shop_address;
    }

    public function setShopAddress(string $shop_address): self
    {
        $this->shop_address = $shop_address;

        return $this;
    }

    public function getIsBrand(): ?bool
    {
        return $this->is_brand;
    }

    public function setIsBrand(bool $is_brand): self
    {
        $this->is_brand = $is_brand;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }
}
