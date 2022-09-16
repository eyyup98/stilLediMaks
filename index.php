<?php

/*Задание 3 методы 2 и 3 не были реализованы, т.к. обсалютно не понял условие*/

include "Database.php";
include "HumanDb.php";
include "FindHuman.php";

$human_1  = new HumanDb('Ivan','Ivanov','1995-01-14',1,'Braslav');
print_r($human_1->formatHuman());

$human_2  = new HumanDb('Petr','Petrov','1993-01-16',1,'Vitebsk');
print_r($human_2->formatHuman());

$human_3  = new HumanDb('Stas','Stasov','1999-05-10',1,'Gomel');
print_r($human_3->formatHuman());
$human_3->deleteHuman(3);

$human_4  = new HumanDb('Aleksandra','Aleksandrovna','1999-05-10',0,'Gomel');
print_r($human_3->formatHuman());
$human_4->saveHuman('Stas','Stasov','1999-05-10',1,'Gomel');

HumanDb::convertAge('1999-05-10');

$find_1 = new FindHuman(['firstname' => 'Stas', 'birthday' => '1995-04-23'], '>');
$find_1 = new FindHuman(['firstname' => 'Petr', 'city' => 'Vitebsk']);


