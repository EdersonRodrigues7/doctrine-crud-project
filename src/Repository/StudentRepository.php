<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    private string $mainClass = Student::class;

    /**@return Student[] */
    public function studentsAndCourses(): array
    {
        return $this->createQueryBuilder('student')
            ->addSelect('phone')
            ->addSelect('course')
            ->join('student.phones', 'phone')
            ->join('student.courses', 'course')
            ->getQuery()
            ->getResult();
    }
}