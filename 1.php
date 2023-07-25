<?php
$array = [
   [
      'id' => 1,
      'name' => 'Ivan',
      'last_name' => 'Ivanov',
      'age' => 25,
   ],
   [
      'id' => 2,
      'name' => 'Andrey',
      'last_name' => 'Petrov',
      'age' => 42,
   ],
   [
      'id' => 3,
      'name' => 'Vladimir',
      'last_name' => 'Kolosov',
      'age' => 35,
   ],
];

function getAgeBySurname($array, $surname)
{
   $result = 'Не найдено';
   foreach ($array as $value) {
      if ($value['last_name'] == $surname) $result = $value['age'];
   }
   return $result;
}

echo getAgeBySurname($array, "Kolosov");
