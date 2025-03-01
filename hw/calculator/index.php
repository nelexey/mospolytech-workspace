<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Простой калькулятор</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .calculator {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            padding: 20px;
        }
        #display {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            text-align: right;
            font-size: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px 10px;
            box-sizing: border-box;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        button {
            padding: 15px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #f0f0f0;
        }
        button:hover {
            background-color: #e0e0e0;
        }
        .equals {
            background-color: #4caf50;
            color: white;
        }
        .clear {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <form method="post" action="">
            <input type="text" id="display" name="expression" value="<?php 
                if(isset($_POST['expression']) && isset($_POST['calculate'])) {
                    $expression = $_POST['expression'];
                    if(preg_match('/^[0-9\+\-\*\/\(\)\.\s]+$/', $expression)) {
                        try {
                            $result = eval("return $expression;");
                            echo $result;
                        } catch(Throwable $e) {
                            echo "Ошибка";
                        }
                    } else {
                        echo "Ошибка";
                    }
                } else {
                    echo "0";
                }
            ?>" readonly>
            
            <div class="buttons">
                <button type="button" class="clear" onclick="clearDisplay()">C</button>
                <button type="button" onclick="addToDisplay('(')">(</button>
                <button type="button" onclick="addToDisplay(')')">)</button>
                <button type="button" onclick="addToDisplay('/')">/</button>
                
                <button type="button" onclick="addToDisplay('7')">7</button>
                <button type="button" onclick="addToDisplay('8')">8</button>
                <button type="button" onclick="addToDisplay('9')">9</button>
                <button type="button" onclick="addToDisplay('*')">*</button>
                
                <button type="button" onclick="addToDisplay('4')">4</button>
                <button type="button" onclick="addToDisplay('5')">5</button>
                <button type="button" onclick="addToDisplay('6')">6</button>
                <button type="button" onclick="addToDisplay('-')">-</button>
                
                <button type="button" onclick="addToDisplay('1')">1</button>
                <button type="button" onclick="addToDisplay('2')">2</button>
                <button type="button" onclick="addToDisplay('3')">3</button>
                <button type="button" onclick="addToDisplay('+')">+</button>
                
                <button type="button" onclick="addToDisplay('0')">0</button>
                <button type="button" onclick="addToDisplay('.')">.</button>
                <button type="button" onclick="addToDisplay(' ')">&nbsp;</button>
                <button type="submit" name="calculate" class="equals">=</button>
            </div>
        </form>
    </div>

    <script src="dynamic_string.js"></script>
</body>
</html> 