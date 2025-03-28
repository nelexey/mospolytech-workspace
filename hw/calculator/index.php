<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Простой калькулятор</title>
    <?php
    function customEval($expression) {

        $expression = str_replace(' ', '', $expression);
        
        function evaluateSimple($expr) {

            while (preg_match('/(-?\d+\.?\d*)([\*\/])(-?\d+\.?\d*)/', $expr, $matches)) {
                $left = $matches[1];
                $operator = $matches[2];
                $right = $matches[3];
                $result = 0;
                
                if ($operator == '*') {
                    $result = $left * $right;
                } elseif ($operator == '/') {
                    if ($right == 0) {
                        throw new Exception("Деление на ноль");
                    }
                    $result = $left / $right;
                }
                
                $expr = str_replace($matches[0], $result, $expr);
            }
            
            $expr = str_replace('--', '+', $expr);
            
            if (substr($expr, 0, 1) == '+') {
                $expr = substr($expr, 1);
            }
            

            while (preg_match('/(-?\d+\.?\d*)([\+\-])(-?\d+\.?\d*)/', $expr, $matches)) {
                $left = $matches[1];
                $operator = $matches[2];
                $right = $matches[3];
                $result = 0;
                
                if ($operator == '+') {
                    $result = $left + $right;
                } elseif ($operator == '-') {
                    $result = $left - $right;
                }
                
                $expr = str_replace($matches[0], $result, $expr);
            }
            
            return $expr;
        }
        

        while (preg_match('/\(([^()]+)\)/', $expression, $matches)) {
            $subResult = evaluateSimple($matches[1]);
            $expression = str_replace($matches[0], $subResult, $expression);
        }
        return evaluateSimple($expression);
    }
    ?>
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
                            // Заменяем eval() на нашу собственную функцию
                            $result = customEval($expression);
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

    <script>
        function addToDisplay(value) {
            const display = document.getElementById('display');
            if (display.value === '0' && value !== '.') {
                display.value = value;
            } else {
                display.value += value;
            }
        }
        
        function clearDisplay() {
            document.getElementById('display').value = '0';
        }
    </script>
</body>
</html> 