<!DOCTYPE html>
<html>
<head>
    <title>GET Request Example</title>
    <meta charset="utf-8">
</head>
<body>
    <?php
    if (isset($_GET['number'])) {
        $number = $_GET['number'];
        
        if ($number == 1) {
            echo 'привет';
        } elseif ($number == 2) {
            echo 'пока';
        }
    }
    ?>

    <form method="GET">
        <select name="number">
            <option value="1">1</option>
            <option value="2">2</option>
        </select>
        <input type="submit" value="Отправить">
    </form>
</body>
</html>
