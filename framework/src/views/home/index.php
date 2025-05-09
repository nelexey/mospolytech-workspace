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
        .article-preview { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px; }
        .article-preview h2 { margin-bottom: 10px; }
        .article-preview p { color: #666; }
        .article-preview a { text-decoration: none; color: #0066cc; }
        .article-preview a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?></h1>
        
        <nav>
            <a href="<?= BASE_URL ?>/">Главная</a>
            <a href="<?= BASE_URL ?>/home/about">О блоге</a>
            <a href="<?= BASE_URL ?>/article/list">Список статей</a>
        </nav>
        
        <div class="welcome">
            <h2>Добро пожаловать в блог!</h2>
            <p>Здесь много интере сных записей из таблицы articles и comments, которые пишут настоящие Users!!!!</p>
        </div>
    </div>
</body>
</html> 