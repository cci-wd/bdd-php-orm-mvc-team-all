<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offer
 *
 * @ORM\Table(name="offers", indexes={@ORM\Index(name="Offers_Businesses", columns={"business_id"}), @ORM\Index(name="Offers_Sections", columns={"section_id"})})
 * @ORM\Entity
 */
class Offer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * 
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Le titre doit contenir {{ limit }} caractères au minimum",
     *      maxMessage = "Le titre ne doit pas dépasser {{ limit }} caractères"
     * )
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     * 
     * @Assert\Url(
     *      message = "L'url {{ value }} n'est pas valide",
     * )
     *
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     * 
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "L'adresse doit contenir {{ limit }} caractères au minimum",
     *      maxMessage = "L'adresse ne doit pas dépasser {{ limit }} caractères"
     * )
     * 
     */
    private $location;

    /**
     * @var int|null
     *
     * @ORM\Column(name="hours_week", type="integer", nullable=true)
     *
     */
    private $hoursWeek;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=400, nullable=false)
     * 
     * @Assert\Length(
     *      min = 50,
     *      max = 400,
     *      minMessage = "La description doit contenir {{ limit }} caractères au minimum",
     *      maxMessage = "La description ne doit pas dépasser {{ limit }} caractères"
     * )
     * 
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="statut", type="boolean", nullable=false)
     *   
     */
    private $statut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publish_date", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    private $publishDate;

    /**
     * @var \Business
     *
     * @ORM\ManyToOne(targetEntity="Business")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="business_id", referencedColumnName="id")
     * })
     */
    private $business;

    /**
     * @var \Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     * })
     */
    private $section;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getHoursWeek(): ?int
    {
        return $this->hoursWeek;
    }

    public function setHoursWeek(?int $hoursWeek): self
    {
        $this->hoursWeek = $hoursWeek;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPublishDate(): ?\DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate): self
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    public function getBusiness(): ?Business
    {
        return $this->business;
    }

    public function setBusiness(?Business $business): self
    {
        $this->business = $business;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }


}
