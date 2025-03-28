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
        .features { background-color: #f5f5f5; padding: 15px; border-radius: 5px; margin-top: 20px; }
        .features li { margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>
        
        <nav>
            <a href="<?= BASE_URL ?>/">Главная</a>
            <a href="<?= BASE_URL ?>/home/about">О блоге</a>
        </nav>
        
        <div class="content">
            <p>Это простой блог, созданный с использованием PHP и шаблона проектирования MVC.</p>
            
            <p>Блог позволяет просматривать статьи и комментарии к ним. Комментарии могут иметь вложенную структуру, позволяя пользователям отвечать на другие комментарии.</p>
            
            <div class="features">
                <h3>Особенности блога:</h3>
                <ul>
                    <li>Просмотр списка статей</li>
                    <li>Чтение полного текста статей</li>
                    <li>Просмотр комментариев к статьям</li>
                    <li>Вложенные ответы на комментарии</li>
                </ul>
            </div>
            
            <p>Структура проекта основана на шаблоне MVC (Модель-Представление-Контроллер):</p>
            <ul>
                <li><strong>Модель</strong> — отвечает за данные и взаимодействие с базой данных.</li>
                <li><strong>Представление</strong> — отвечает за отображение данных пользователю.</li>
                <li><strong>Контроллер</strong> — обрабатывает запросы пользователя и связывает модели с представлениями.</li>
            </ul>
        </div>
    </div>
</body>
</html> 