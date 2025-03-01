<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        h1 { color: #333; }
        nav { margin-bottom: 20px; }
        nav a { margin-right: 10px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        .content { line-height: 1.6; }
        .features { background-color: #f5f5f5; padding: 15px; border-radius: 5px; }
        .features li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>
        
        <nav>
            <a href="<?= BASE_URL ?>/">Главная</a>
            <a href="<?= BASE_URL ?>/home/about">О проекте</a>
            <a href="<?= BASE_URL ?>/home/users">Пользователи</a>
        </nav>
        
        <div class="content">
            <p><?= $description ?></p>
            
            <div class="features">
                <h3>Основные особенности проекта:</h3>
                <ul>
                    <?php foreach ($features as $feature): ?>
                        <li><?= $feature ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <p>MVC - это паттерн, который делит приложение на три части:</p>
            <ul>
                <li><strong>Модель</strong> — данные.</li>
                <li><strong>Представление</strong> — вывод.</li>
                <li><strong>Контроллер</strong> — связь между ними.</li>
            </ul>
        </div>
    </div>
</body>
</html> 