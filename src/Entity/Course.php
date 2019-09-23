<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $term;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coursename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instructorname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $callnumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $building;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $room;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $days;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $may;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $summerterm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTerm(): ?string
    {
        return $this->term;
    }

    public function setTerm(?string $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getCoursename(): ?string
    {
        return $this->coursename;
    }

    public function setCoursename(?string $coursename): self
    {
        $this->coursename = $coursename;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getInstructorname(): ?string
    {
        return $this->instructorname;
    }

    public function setInstructorname(?string $instructorname): self
    {
        $this->instructorname = $instructorname;

        return $this;
    }

    public function getCallnumber(): ?string
    {
        return $this->callnumber;
    }

    public function setCallnumber(?string $callnumber): self
    {
        $this->callnumber = $callnumber;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function setBuilding(?string $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(?string $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getDays(): ?string
    {
        return $this->days;
    }

    public function setDays(?string $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getMay(): ?string
    {
        return $this->may;
    }

    public function setMay(?string $may): self
    {
        $this->may = $may;

        return $this;
    }

    public function getSummerterm(): ?string
    {
        return $this->summerterm;
    }

    public function setSummerterm(?string $summerterm): self
    {
        $this->summerterm = $summerterm;

        return $this;
    }

}
