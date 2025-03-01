<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма обратной связи</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        main {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
        }
        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>    
    <main>
        <form action="submit.php" method="POST">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-mail пользователя:</label>
            <input type="email" id="email" name="email" required>

            <label for="type">Тип обращения:</label>
            <select id="type" name="type" required>
                <option value="complaint">Жалоба</option>
                <option value="suggestion">Предложение</option>
                <option value="gratitude">Благодарность</option>
            </select>

            <label for="message">Текст обращения:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <label>Вариант ответа:</label>
            <input type="checkbox" id="sms" name="response_type" value="sms">
            <label for="sms">СМС</label>
            <input type="checkbox" id="email_response" name="response_type" value="email">
            <label for="email_response">E-mail</label>

            <button type="submit">Отправить</button>
        </form>
        <br>
        <a href="page2.php">Перейти на 2 страницу</a>
    </main>
</body>
</html>
