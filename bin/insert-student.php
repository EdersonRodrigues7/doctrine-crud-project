<?php

use App\Entity\Phone;
use App\Helper\EntityManagerCreator;
use App\Entity\Student;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$student = new Student($argv[1]);
$student->addPhone(new Phone('(21) 98475-2154', true));
$student->addPhone(new Phone('(21) 3514-1466', true));
$entityManager->persist($student);

$entityManager->flush();