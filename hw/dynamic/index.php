<link rel="stylesheet" type="text/css" href="styles.css">
<form method="GET" action="">
    <label for="place">Введите город:</label>
    <input type="text" id="place" name="place" required>
    <button type="submit">Получить погоду</button>
</form>

<?php
if (isset($_GET['place'])) {
    $place = $_GET['place'];
    $url = "https://wttr.in/{$place}"; 
    $response = file_get_contents($url);
    echo "<pre style='font-size: 8px;'>";
    print_r($response);
    echo "</pre>";
}

?>
