<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Skills
 *
 * @ORM\Table(name="skills", indexes={@ORM\Index(name="fk_Skills_Students1_idx", columns={"id_students"})})
 * @ORM\Entity
 */
class Skills
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_skills", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSkills;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="percentage", type="integer", nullable=false)
     */
    private $percentage;

    /**
     * @var \Students
     *
     * @ORM\ManyToOne(targetEntity="Students")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_students", referencedColumnName="id_students")
     * })
     */
    private $idStudents;

    public function getIdSkills(): ?int
    {
        return $this->idSkills;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPercentage(): ?int
    {
        return $this->percentage;
    }

    public function setPercentage(int $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getIdStudents(): ?Students
    {
        return $this->idStudents;
    }

    public function setIdStudents(?Students $idStudents): self
    {
        $this->idStudents = $idStudents;

        return $this;
    }


}
