<?php

// array_count_values. Дан массив с элементами 'a', 'b', 'c', 'b', 'a'. Подсчитайте сколько раз встречается каждая из букв.
$array = ['a', 'b', 'c', 'b', 'a'];
$countedValues = array_count_values($array);
echo "<pre>";
print_r($countedValues);
echo "</pre>";

// Array
// (
//     [a] => 2
//     [b] => 2
//     [c] => 1
// )

// array_flip, array_reverse. Дан массив 'a'=>1, 'b'=>2, 'c'=>3. Поменяйте в нем местами ключи и значения.
$array = ['a' => 1, 'b' => 2, 'c' => 3];
$flippedArray = array_flip($array);
echo "<pre>";
print_r($flippedArray);
echo "</pre>";

// Array
// (
//     [1] => a
//     [2] => b
//     [3] => c
// )

// array_map. Дан массив с элементами 'a', 'b', 'c', 'd', 'e'. С помощью функций array_map и strtoupper сделайте из него массив 'A', 'B', 'C', 'D', 'E'.
$array = ['a', 'b', 'c', 'd', 'e'];
$uppercasedArray = array_map('strtoupper', $array);
echo "<pre>";
print_r($uppercasedArray);
echo "</pre>";

// Array
// (
//     [0] => A
//     [1] => B
//     [2] => C
//     [3] => D
//     [4] => E
// )

//array_merge. Даны два массива: первый с элементами 1, 2, 3, второй с элементами 'a', 'b', 'c'. Сделайте из них массив с элементами 1, 2, 3, 'a', 'b', 'c'.
$array1 = [1, 2, 3];
$array2 = ['a', 'b', 'c'];
$mergedArray = array_merge($array1, $array2);
echo "<pre>";
print_r($mergedArray);
echo "</pre>";

// Array
// (
//     [0] => 1
//     [1] => 2
//     [2] => 3
//     [3] => a
//     [4] => b
//     [5] => c
// )

// array_product. Дан массив [1, 2, 3, 4, 5]. Найдите произведение (умножение) элементов данного массива.(вам понадобятся следующие функции: array_product.)
$array = [1, 2, 3, 4, 5];
$product = array_product($array);
echo "Произведение элементов массива: $product<br>";

// Произведение элементов массива: 120

