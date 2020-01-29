<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AwardRepository")
 */
class Award
{
    //const SERVER_PATH_TO_IMAGE_FOLDER = 'img/awards';

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $award_image;

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

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

    /**
     * @param string|null $award_image
     *
     * @return $this
     */
    public function setAwardImage( ?string $award_image): self
    {
        $this->award_image = $award_image;

        return $this;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }


}
