<?php

use App\Helper\EntityManagerCreator;
use App\Entity\Student;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

// $student = $entityManager->getReference(Student::class, $argv[1]);
$student = $entityManager->find(Student::class, $argv[1]);

$entityManager->remove($student);

$entityManager->flush();