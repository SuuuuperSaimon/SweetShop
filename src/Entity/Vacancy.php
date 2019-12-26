<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VacancyRepository")
 */
class Vacancy
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
    private $vacancyName;

    /**
     * @ORM\Column(type="text")
     */
    private $vacancyDescr;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVacancyName(): ?string
    {
        return $this->vacancyName;
    }

    public function setVacancyName(string $vacancyName): self
    {
        $this->vacancyName = $vacancyName;

        return $this;
    }

    public function getVacancyDescr(): ?string
    {
        return $this->vacancyDescr;
    }

    public function setVacancyDescr(string $vacancyDescr): self
    {
        $this->vacancyDescr = $vacancyDescr;

        return $this;
    }

}
