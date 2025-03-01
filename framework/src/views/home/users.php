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
        .user-card { 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }
        .user-email { 
            color: #666; 
            font-style: italic;
        }
        .user-name { 
            font-weight: bold; 
            color: #333;
            font-size: 18px;
        }
        .counter {
            background-color: #e0e0e0;
            padding: 8px 15px;
            border-radius: 15px;
            display: inline-block;
            margin-left: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= $title ?> <span class="counter">Всего: <?= $total ?></span></h1>
        
        <nav>
            <a href="<?= BASE_URL ?>/">Главная</a>
            <a href="<?= BASE_URL ?>/home/about">О проекте</a>
            <a href="<?= BASE_URL ?>/home/users">Пользователи</a>
        </nav>
        
        <div class="users-list">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <div class="user-card">
                        <div class="user-name"><?= $user['name'] ?></div>
                        <div class="user-email"><?= $user['email'] ?></div>
                        <div class="user-id">ID: <?= $user['id'] ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Нет доступных пользователей.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html> 