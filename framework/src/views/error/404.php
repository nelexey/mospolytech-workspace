<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Страница не найдена</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; text-align: center; }
        .container { max-width: 800px; margin: 0 auto; padding-top: 50px; }
        h1 { color: #e74c3c; font-size: 72px; margin-bottom: 0; }
        p { font-size: 18px; color: #333; }
        a { color: #3498db; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>404</h1>
        <h2>Страница не найдена</h2>
        <p>Запрашиваемая страница не существует.</p>
        <p><a href="<?= BASE_URL ?>/">Вернуться на главную</a></p>
    </div>
</body>
</html> 