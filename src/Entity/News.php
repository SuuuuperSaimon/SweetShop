<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $newsName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $newsAnnotation;

    /**
     * @ORM\Column(type="text")
     */
    private $newsText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $newsImage;

    /**
     * @ORM\Column(type="date")
     */
    private $newsDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNewsName(): ?string
    {
        return $this->newsName;
    }

    public function setNewsName(string $newsName): self
    {
        $this->newsName = $newsName;

        return $this;
    }

    public function getNewsAnnotation(): ?string
    {
        return $this->newsAnnotation;
    }

    public function setNewsAnnotation(string $newsAnnotation): self
    {
        $this->newsAnnotation = $newsAnnotation;

        return $this;
    }

    public function getNewsText(): ?string
    {
        return $this->newsText;
    }

    public function setNewsText(string $newsText): self
    {
        $this->newsText = $newsText;

        return $this;
    }

    public function getNewsImage(): ?string
    {
        return $this->newsImage;
    }

    public function setNewsImage(?string $newsImage): self
    {
        $this->newsImage = $newsImage;

        return $this;
    }

    public function getNewsDate(): ?\DateTimeInterface
    {
        return $this->newsDate;
    }

    public function setNewsDate(\DateTimeInterface $newsDate): self
    {
        $this->newsDate = $newsDate;

        return $this;
    }
}
