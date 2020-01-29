<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistrictRepository")
 */
class District
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
    private $district_name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shop", mappedBy="district")
     */
    private $shops;

    public function __construct()
    {
        $this->shops = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistrictName(): ?string
    {
        return $this->district_name;
    }

    public function setDistrictName(string $district_name): self
    {
        $this->district_name = $district_name;

        return $this;
    }

    /**
     * @return Collection|Shop[]
     */
    public function getShops(): Collection
    {
        return $this->shops;
    }

    public function addShop(Shop $shop): self
    {
        if (!$this->shops->contains($shop)) {
            $this->shops[] = $shop;
            $shop->setDistrict($this);
        }

        return $this;
    }

    public function removeShop(Shop $shop): self
    {
        if ($this->shops->contains($shop)) {
            $this->shops->removeElement($shop);
            // set the owning side to null (unless already changed)
            if ($shop->getDistrict() === $this) {
                $shop->setDistrict(null);
            }
        }

        return $this;
    }
}
