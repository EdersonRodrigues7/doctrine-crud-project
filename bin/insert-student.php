<?php

use App\Entity\Phone;
use App\Helper\EntityManagerCreator;
use App\Entity\Student;

require_once __DIR__ . '/../vendor/autoload.php';

$entityManager = EntityManagerCreator::createEntityManager();

$student = new Student($argv[1]);

for($i = 2; $i < $argc; $i++){
    $student->addPhone(new Phone($argv[$i], true));
}

$entityManager->persist($student);

$entityManager->flush();