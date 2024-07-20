<?php

use App\Entity\Course;
use App\Entity\Phone;
use App\Helper\EntityManagerCreator;
use App\Entity\Student;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$studentClass = Student::class;
$dql = "SELECT student FROM $studentClass student";

/**@var Student[] $students*/
$students = $entityManager->createQuery($dql)->getResult();

$msg = "STUDENTS LIST \n";
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
    
    echo $msg . "\n";
}

$countQuery = "SELECT COUNT(student) FROM $studentClass student";
$count = $entityManager->createQuery($countQuery)->getSingleScalarResult();
echo "NUMBER OF STUDENTS: " . $count . "\n";