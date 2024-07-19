<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity]
class Course
{
    #[Id, GeneratedValue, Column]
    private int $id;

    #[ManyToMany(targetEntity: Student::class, mappedBy: 'courses')]
    private Collection $students;

    public function __construct(
        #[Column]
        private string $name
    ){
        $this->students = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection<Student> 
     */
    public function students(): Collection
    {
        return $this->students;
    }
    
    public function addStudent(Student $student): void
    {
        if($this->students->contains($student)){
            return;
        }
        
        $this->students->add($student);
        $student->enrollInCourse($this);
    }
}