<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank
     */
    private $vacancyName;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $vacancyDescr;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobReview", mappedBy="vacancy", cascade={"all"})
     * @Assert\NotBlank
     */
    private $jobReviews;

    public function __construct()
    {
        $this->jobReviews = new ArrayCollection();
    }

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

    /**
     * @return Collection|JobReview[]
     */
    public function getJobReviews(): Collection
    {
        return $this->jobReviews;
    }

    public function addJobReview(JobReview $jobReview): self
    {
        if (!$this->jobReviews->contains($jobReview)) {
            $this->jobReviews[] = $jobReview;
            $jobReview->setVacancy($this);
        }

        return $this;
    }

    public function removeJobReview(JobReview $jobReview): self
    {
        if ($this->jobReviews->contains($jobReview)) {
            $this->jobReviews->removeElement($jobReview);
            // set the owning side to null (unless already changed)
            if ($jobReview->getVacancy() === $this) {
                $jobReview->setVacancy(null);
            }
        }

        return $this;
    }

}
