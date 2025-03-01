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
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
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
        
        <h2>Добро пожаловать в демо-проект MVC!</h2>
        
        <p>Этот проект демонстрирует базовую структуру MVC-архитектуры на PHP.</p>
        <p>Выберите одну из ссылок в меню навигации для перехода между страницами.</p>
        
        <h3>Краткий список пользователей:</h3>
        
        <?php if (!empty($users)): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><a href="<?= BASE_URL ?>/home/users">Перейти на страницу пользователей &raquo;</a></p>
        <?php else: ?>
            <p>Нет доступных пользователей.</p>
        <?php endif; ?>
    </div>
</body>
</html> 