<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AwardRepository")
 */
class Award
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
    private $award_name;

    /**
     * @ORM\Column(type="text")
     */
    private $award_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $award_image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAwardName(): ?string
    {
        return $this->award_name;
    }

    public function setAwardName(string $award_name): self
    {
        $this->award_name = $award_name;

        return $this;
    }

    public function getAwardDescription(): ?string
    {
        return $this->award_description;
    }

    public function setAwardDescription(string $award_description): self
    {
        $this->award_description = $award_description;

        return $this;
    }

    public function getAwardImage(): ?string
    {
        return $this->award_image;
    }

    public function setAwardImage(string $award_image): self
    {
        $this->award_image = $award_image;

        return $this;
    }
}
