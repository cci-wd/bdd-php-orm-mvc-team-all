<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Educations
 *
 * @ORM\Table(name="educations", indexes={@ORM\Index(name="fk_Educations_Students1_idx", columns={"id_students"})})
 * @ORM\Entity
 */
class Educations
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_educations", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEducations;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="degree", type="string", length=255, nullable=false)
     */
    private $degree;

    /**
     * @var string
     *
     * @ORM\Column(name="speciality", type="string", length=255, nullable=false)
     */
    private $speciality;

    /**
     * @var string
     *
     * @ORM\Column(name="school_name", type="string", length=255, nullable=false)
     */
    private $schoolName;

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
