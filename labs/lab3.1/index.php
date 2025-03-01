<!-- 21 --> 

<?php
$XVI = "Иван Васильевич";
$XVIII = "Пётр Алексеевич";
$XIX = "Николай Павлович";

if (isset($_GET['century'])) {
    $century = $_GET['century'];
    
    if ($century == 'XVI') {
        echo "В $century веке царствовал $XVI";
    } elseif ($century == 'XVIII') {
        echo "В $century веке царствовал $XVIII";
    } elseif ($century == 'XIX') {
        echo "В $century веке царствовал $XIX";
    } else {
        echo "Царствующий монарх для века $century не найден.";
    }
}
?>

<form method="GET">
    <input type="text" name="century" placeholder="Введите римские цифры">
    <input type="submit" value="Отправить">
</form>

<!-- 23 --> 

<?php
if (isset($_GET['create_file'])) {
    $file_path = '/Users/Asyncz/Downloads/new.txt';
    if (!file_exists($file_path)) {
        file_put_contents($file_path, '');
        echo "Файл $file_path успешно создан.";
    } else {
        echo "Файл $file_path уже существует.";
    }
}
?>

<form method="GET">
    <input type="hidden" name="create_file" value="1">
    <input type="submit" value="Создать файл new.txt">
</form>

<!-- 24 --> 

<?php
if (isset($_GET['create_test_file'])) {
    $test_file_path = '/Users/Asyncz/Downloads/test.txt';
    if (!file_exists($test_file_path)) {
        file_put_contents($test_file_path, '12345');
        echo "Файл $test_file_path успешно создан и записан.";
    } else {
        echo "Файл $test_file_path уже существует.";
    }
}
?>

<form method="GET">
    <input type="hidden" name="create_test_file" value="1">
    <input type="submit" value="Создать файл test.txt">
</form>

<!-- 1 --> 
<form method="GET">
    <input type="text" name="century" placeholder="Введите римские цифры" required>
    <input type="submit" value="Отправить">
</form>

<?php
if (isset($_GET['century'])) {
    $input_text = $_GET['century'];
    $words = explode(' ', $input_text);
    $newString = transformWords($words);
    echo '<p>Результат: ' . $newString . '</p>';
}

function transformWords($words) {
    $newString = '';
    foreach ($words as $index => &$word) {
        $newWord = $word;
        if (($index+1) % 2 == 0) {
            $newWord = mb_strtoupper($word);
        }
        $newString .= $newWord . ' ';
    }
    return $newString;
}
?>
