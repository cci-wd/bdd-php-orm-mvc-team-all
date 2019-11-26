<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offers
 *
 * @ORM\Table(name="offers", indexes={@ORM\Index(name="fk_Offers_Businesses1_idx", columns={"id_businesses"}), @ORM\Index(name="fk_Offers_Sections1_idx", columns={"id_sections"})})
 * @ORM\Entity
 */
class Offers
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_offers", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOffers;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="min_description", type="string", length=255, nullable=true)
     */
    private $minDescription;

    /**
     * @var string|null
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=false)
     */
    private $location;

    /**
     * @var int|null
     *
     * @ORM\Column(name="hours_week", type="integer", nullable=true)
     */
    private $hoursWeek;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=400, nullable=false)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="statut", type="boolean", nullable=false)
     */
    private $statut;

    /**
     * @var \Businesses
     *
     * @ORM\ManyToOne(targetEntity="Businesses")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_businesses", referencedColumnName="id_businesses")
     * })
     */
    private $idBusinesses;

    /**
     * @var \Sections
     *
     * @ORM\ManyToOne(targetEntity="Sections")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_sections", referencedColumnName="id_sections")
     * })
     */
    private $idSections;

    public function getIdOffers(): ?int
    {
        return $this->idOffers;
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

    public function getMinDescription(): ?string
    {
        return $this->minDescription;
    }

    public function setMinDescription(?string $minDescription): self
    {
        $this->minDescription = $minDescription;

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

    public function getIdBusinesses(): ?Businesses
    {
        return $this->idBusinesses;
    }

    public function setIdBusinesses(?Businesses $idBusinesses): self
    {
        $this->idBusinesses = $idBusinesses;

        return $this;
    }

    public function getIdSections(): ?Sections
    {
        return $this->idSections;
    }

    public function setIdSections(?Sections $idSections): self
    {
        $this->idSections = $idSections;

        return $this;
    }


}
