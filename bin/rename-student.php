<?php

use App\Helper\EntityManagerCreator;
use App\Entity\Student;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$studentRepository = $entityManager->getRepository(Student::class);

/**@var Student $student*/
$student = $studentRepository->find($argv[1]);
$student->setName($argv[2]);

// $entityManager->persist($student);
$entityManager->flush();