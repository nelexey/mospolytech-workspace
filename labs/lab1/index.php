
<?php

    echo "№1 <br>";

    $a = 27;
    $b = 12;
    $hypotenuse = sqrt($a**2 + $b**2);
    echo number_format($hypotenuse, 2);

    echo "<br> №2 <br>";

    $other_cathetus = sqrt($hypotenuse**2 - $b**2);
    echo number_format($other_cathetus, 2);

    echo "<br> №3 <br>";

    $c = 23;
    $angle_radians = atan($b / $c);
    $angle_degrees = rad2deg($angle_radians);
    echo "Другой острый угол: " . number_format($angle_degrees, 2) . "<br>";

    $other_cathetus = sqrt($hypotenuse**2 - $c**2);
    echo "Значение другого катета: " . number_format($other_cathetus, 2) . "<br>";

    echo "<br> №4 <br>";

    $angle1_radians = atan($b / $a);
    $angle1_degrees = rad2deg($angle1_radians);
    echo "Первый острый угол: " . number_format($angle1_degrees, 2) . "<br>";

    $angle2_radians = atan($a / $b);
    $angle2_degrees = rad2deg($angle2_radians);
    echo "Второй острый угол: " . number_format($angle2_degrees, 2) . "<br>";

    $angle3_degrees = 90; // Прямой угол
    echo "Третий угол: " . $angle3_degrees . "<br>";

    echo "<br> №5 <br>";

    $a = 2;
    $b = 2.0;
    $c = '2';
    $d = 'two';
    $g = true;
    $f = false;

    $results = [];

    $results[] = $c . $d; 
    $results[] = $d . $c; 
    $results[] = $g . $d; 
    $results[] = $f . $d; 
    $results[] = $d . $g; 
    $results[] = $d . $f; 
    $results[] = $a + $b; 
    $results[] = $a - $b; 
    $results[] = $a * $b; 
    $results[] = $a / $b; 
    $results[] = $a % $b; 
    $results[] = $c . $c; 
    $results[] = $c . $g; 
    $results[] = $c . $f; 
    $results[] = $b . $c; 
    $results[] = $b . $d; 

    print_r($results);

    echo "<br> №6 <br>";

    $a = 2; $b = 2.0; $c = '2'; $d = 'two'; $g = true; $f = false;

    echo $a == $b;
    echo $a === $b;
    echo $g;
    echo $f;
    echo $a > $f;
    echo $a < $g;
    echo $b > $f;
    echo $b < $g;
    echo $c == $g;
    echo $c == $f;
    echo $d == $g;
    echo $d == $f;

    echo "<br> №7 <br>";

    $results[] = $a + $b; // 4.0
    $results[] = $a - $b; // 0.0
    $results[] = $a * $b; // 4.0
    $results[] = $a / $b; // 1.0
    $results[] = $a + $g; // 3.0
    $results[] = $a + $f; // 2.0
    $results[] = $b + $g; // 3.0
    $results[] = $b + $f; // 2.0
    $results[] = $g + $f; // 1.0
    $results[] = $a + (float)$c; // 4.0
    $results[] = (float)$c + $b; // 4.0
    $results[] = (float)$c + $g; // 3.0
    $results[] = (float)$c + $f; // 2.0

    print_r($results);

    echo "<br> №8 <br>";

    $a = true; // Присваиваем логическое значение true
    $b = false; // Присваиваем логическое значение false

    echo "Значение переменной a: " . ($a ? 'true' : 'false') . "<br>";
    echo "Значение переменной b: " . ($b ? 'true' : 'false') . "<br>";

    echo "<br> №9 <br>";

    $results[] = $a + $f; // 2
    $results[] = $a + (int)$c; // 4
    $results[] = (int)$c + $f; // 2
    $results[] = (int)$c + $g; // 3
    $results[] = (int)$c + $b; // 4
    $results[] = (int)$c + $a; // 4
    $results[] = (int)$g + $f; // 1
    $results[] = (int)$g + $a; // 3
    $results[] = (int)$g + $b; // 3
    $results[] = (int)$f + $a; // 2
    $results[] = (int)$f + $b; // 2
    $results[] = (int)$f + $c; // 2

    print_r($results);

    echo "<br> №10 <br>";

    $hunter = 'охотник';
    $wants_to = 'желает';
    $know = 'знать';
    $fizan = 'фазан';
    $sits = 'сидит';

    $mnemonic_phrase = "Каждый $hunter $wants_to $know, где $sits $fizan.";
    echo $mnemonic_phrase;

    echo "<br> №11 <br>";

    $quieter = 'Тише';
    $go = 'едешь';
    $further = 'дальше';

    $proverb = "Тише едешь, дальше будешь.";
    echo $proverb;

    echo "<br> №12 <br>";

    $not_take_risks = 'Кто не рискует';
    $not_drink = 'не пьет';
    $ellipsis = '...';

    $proverb_risk = "$not_take_risks, тот $not_drink $ellipsis";
    echo $proverb_risk;
?>