<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRowRepository")
 */
class CartRow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $product_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $product_price;

    /**
     * @ORM\Column(type="float")
     */
    private $product_shipping_price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cart", inversedBy="row")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cart;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductQuantity(): ?int
    {
        return $this->product_quantity;
    }

    public function setProductQuantity(int $product_quantity): self
    {
        $this->product_quantity = $product_quantity;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->product_price;
    }

    public function setProductPrice(float $product_price): self
    {
        $this->product_price = $product_price;

        return $this;
    }

    public function getProductShippingPrice(): ?float
    {
        return $this->product_shipping_price;
    }

    public function setProductShippingPrice(float $product_shipping_price): self
    {
        $this->product_shipping_price = $product_shipping_price;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }
}
