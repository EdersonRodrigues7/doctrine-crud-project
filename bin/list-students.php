<?php

use App\Entity\Course;
use App\Entity\Phone;
use App\Helper\EntityManagerCreator;
use App\Entity\Student;
use App\Repository\StudentRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

/**@var StudentRepository $studentRepository*/
$studentRepository = $entityManager->getRepository(Student::class);

/**@var Student[] $students*/
$students = $studentRepository->studentsAndCourses();

$msg = "\nSTUDENTS LIST \n";
foreach($students as $student){
    $msg .= "ID: {$student->getId()} | Name: {$student->getName()} ";

    // Phones
    $msg .= "| Phones: ";
    $phones = $student
        ->phones()
        ->map(fn(Phone $phone) => $phone->getNumber())
        ->toArray();

    $msg .= implode(',', $phones);

    // Courses
    $msg .= "| Courses: ";
    $courses = $student
        ->courses()
        ->map(fn(Course $course) => $course->getName())
        ->toArray();

    $msg .= implode(',', $courses);
    $msg .= "\n";
    
}

echo $msg . "\n";

echo $studentRepository->count([]) . "\n";