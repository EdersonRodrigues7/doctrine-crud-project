<?php 

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity()]
class Phone
{
    #[Id, GeneratedValue, Column]
    private int $id;

    #[ManyToOne(Student::class, inversedBy:'phones')]
    public readonly Student $student;

    public function __construct(
        #[Column]
        private string $number,
        #[Column]
        private bool $active
    )
    {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getActive(): string
    {
        return $this->name;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function getNumber(): string
    {
        return $this->number;
    }
} 