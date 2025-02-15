<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи</title>
</head>
<body>
    <header>
        <img src="logo.png" alt="Логотип МосПолитеха" style="float:left;">
        <h1 style="text-align:center;">Обратная связь</h1>
    </header>
    
    <main>
        <form action="https://httpbin.org/post" method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="email">E-mail пользователя:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="type">Тип обращения:</label>
            <select id="type" name="type" required>
                <option value="complaint">Жалоба</option>
                <option value="suggestion">Предложение</option>
                <option value="gratitude">Благодарность</option>
            </select><br>

            <label for="message">Текст обращения:</label><br>
            <textarea id="message" name="message" rows="4" required></textarea><br>

            <label>Вариант ответа:</label><br>
            <input type="checkbox" id="sms" name="response_type" value="sms">
            <label for="sms">СМС</label><br>
            <input type="checkbox" id="email_response" name="response_type" value="email">
            <label for="email_response">E-mail</label><br>

            <button type="submit">Отправить</button>
        </form>
        <br>
        <a href="page2.php">Перейти на 2 страницу</a>
    </main>
</body>
</html>
