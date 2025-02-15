<?php
echo "<br> №1 <br>";

// Пример использования цикла for
echo "Цикл for:<br>";
for ($i = 0; $i < 5; $i++) {
    echo "Итерация $i<br>";
}

echo "<br> №2 <br>";

// Пример использования цикла foreach
echo "Цикл foreach:<br>";
$colors = ["красный", "зеленый", "синий"];
foreach ($colors as $color) {
    echo "Цвет: $color<br>";
}

echo "<br> №3 <br>";

// Пример обычной функции
function add($a, $b) {
    return $a + $b;
}
echo "Сумма 2 и 3: " . add(2, 3) . "<br>";

echo "<br> №4 <br>";

// Пример функции со скрытой типизацией, вернётся строка
function multiply(int $a, int $b): string {
    return $a * $b;
}
echo "Произведение 4 и 5: " . multiply(4, 5) . "<br>";