<?php

use App\Entity\Course;
use App\Entity\Student;
use App\Helper\EntityManagerCreator;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$student = $entityManager->find(Student::class, $argv[1]);
$course = $entityManager->find(Course::class, $argv[2]);

$student->enrollInCourse($course);

$entityManager->flush();