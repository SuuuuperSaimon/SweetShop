<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubCategoryRepository")
 */
class SubCategory
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
    private $subCatName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubCatName(): ?string
    {
        return $this->subCatName;
    }

    public function setSubCatName(string $subCatName): self
    {
        $this->subCatName = $subCatName;

        return $this;
    }
}
