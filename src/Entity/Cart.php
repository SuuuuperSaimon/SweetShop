<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $closed_at;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CartRow", mappedBy="cart", orphanRemoval=true)
     */
    private $row;

    /**
     * @ORM\Column(type="float")
     */
    private $subtotal_price;

    /**
     * @ORM\Column(type="float")
     */
    private $shipping_price;

    /**
     * @ORM\Column(type="float")
     */
    private $total_price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    public function __construct()
    {
        $this->row = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getClosedAt(): ?\DateTimeInterface
    {
        return $this->closed_at;
    }

    public function setClosedAt(?\DateTimeInterface $closed_at): self
    {
        $this->closed_at = $closed_at;

        return $this;
    }

    /**
     * @return Collection|CartRow[]
     */
    public function getRow(): Collection
    {
        return $this->row;
    }

    public function addRow(CartRow $row): self
    {
        if (!$this->row->contains($row)) {
            $this->row[] = $row;
            $row->setCart($this);
        }

        return $this;
    }

    public function removeRow(CartRow $row): self
    {
        if ($this->row->contains($row)) {
            $this->row->removeElement($row);
            // set the owning side to null (unless already changed)
            if ($row->getCart() === $this) {
                $row->setCart(null);
            }
        }

        return $this;
    }

    public function getSubtotalPrice(): ?float
    {
        return $this->subtotal_price;
    }

    public function setSubtotalPrice(float $subtotal_price): self
    {
        $this->subtotal_price = $subtotal_price;

        return $this;
    }

    public function getShippingPrice(): ?float
    {
        return $this->shipping_price;
    }

    public function setShippingPrice(float $shipping_price): self
    {
        $this->shipping_price = $shipping_price;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->total_price;
    }

    public function setTotalPrice(float $total_price): self
    {
        $this->total_price = $total_price;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
