<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     *
     * @ORM\GeneratedValue()
     *
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categoryName;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="children")
     *
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     */
    private $parent;

    /**
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parent")
     */
    private $children;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }


    /** @return Collection|Product[] */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function getParent(): ?int
    {
        return $this->parent;
    }

    public function setParent(Category $parent)//?int $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(?int $children): self
    {
        $this->children = $children;

        return $this;
    }

    public function addChild(Category $child) {
        $this->children[] = $child;
        $child->setParent($this);
    }

    /**
     * @return Collection|Category[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function removeChild(Category $child): self
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }
}
