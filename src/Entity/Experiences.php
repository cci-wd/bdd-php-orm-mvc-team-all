<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Experiences
 *
 * @ORM\Table(name="experiences", indexes={@ORM\Index(name="fk_Work_experiences_Students1_idx", columns={"id_students"})})
 * @ORM\Entity
 */
class Experiences
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_experiences", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idExperiences;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="post", type="string", length=255, nullable=false)
     */
    private $post;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_from", type="date", nullable=false)
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_to", type="date", nullable=false)
     */
    private $dateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=400, nullable=false)
     */
    private $description;

    /**
     * @var \Students
     *
     * @ORM\ManyToOne(targetEntity="Students")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_students", referencedColumnName="id_students")
     * })
     */
    private $idStudents;


}
