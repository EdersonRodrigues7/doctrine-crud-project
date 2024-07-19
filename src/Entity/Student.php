<?php 

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;

#[Entity()]
class Student
{
    #[Id, GeneratedValue, Column]
    private int $id;

    #[OneToMany(targetEntity: Phone::class, mappedBy: 'student', cascade: ['persist', 'remove'])]
    private Collection $phones;

    #[ManyToMany(targetEntity: Course::class, inversedBy: 'students')]
    private Collection $courses;

    public function __construct(
        #[Column]
        private string $name
    )
    {
        $this->phones = new ArrayCollection();
        $this->courses = new ArrayCollection();
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

    public function addPhone(Phone $phone): void
    {
        $this->phones->add($phone);
        $phone->setStudent($this);
    }
    
    /**
     * @return Collection<Phone> 
     */
    public function phones(): Collection
    {
        return $this->phones;
    }
    
    /**
     * @return Collection<Course> 
     */
    public function courses(): Collection
    {
        return $this->courses;
    }

    public function enrollInCourse(Course $course): void
    {
        if($this->courses->contains($course)){
            return;
        }
        
        $this->courses->add($course);
        $course->addStudent($this);
    }
}