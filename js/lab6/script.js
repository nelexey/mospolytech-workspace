// Задание 1: Версионирование
function VersionManager(version) {
    this.history = [];
    
    if (version === undefined || version === '') {
        this.currentMajor = 0;
        this.currentMinor = 0;
        this.currentPatch = 1;
    } else {
        const parts = version.split('.');
        if (parts.length !== 3 || 
            !Number.isInteger(Number(parts[0])) || 
            !Number.isInteger(Number(parts[1])) || 
            !Number.isInteger(Number(parts[2]))) {
            throw new Error("Некорректный формат версии!");
        }
        
        this.currentMajor = Number(parts[0]);
        this.currentMinor = Number(parts[1]);
        this.currentPatch = Number(parts[2]);
    }
}

VersionManager.prototype.major = function() {
    this.saveState();
    this.currentMajor++;
    this.currentMinor = 0;
    this.currentPatch = 0;
    return this;
};

VersionManager.prototype.minor = function() {
    this.saveState();
    this.currentMinor++;
    this.currentPatch = 0;
    return this;
};

VersionManager.prototype.patch = function() {
    this.saveState();
    this.currentPatch++;
    return this;
};

VersionManager.prototype.rollback = function() {
    if (this.history.length === 0) {
        throw new Error("Невозможно выполнить откат!");
    }
    
    const previousState = this.history.pop();
    this.currentMajor = previousState.major;
    this.currentMinor = previousState.minor;
    this.currentPatch = previousState.patch;
    
    return this;
};

VersionManager.prototype.release = function() {
    return `${this.currentMajor}.${this.currentMinor}.${this.currentPatch}`;
};

VersionManager.prototype.saveState = function() {
    this.history.push({
        major: this.currentMajor,
        minor: this.currentMinor,
        patch: this.currentPatch
    });
};

// Задание 2: Прямоугольник и квадрат
class Rectangle {
    constructor(width, height) {
        this.width = width;
        this.height = height;
    }
    
    getArea() {
        return this.width * this.height;
    }
    
    getPerimeter() {
        return 2 * (this.width + this.height);
    }
}

class Square extends Rectangle {
    constructor(side) {
        super(side, side);
    }
}

// Задание 3: Температура
class Temperature {
    constructor(celsius) {
        this.setCelsius(celsius);
    }
    
    setCelsius(value) {
        const MIN_TEMP = -273.16;
        const MAX_TEMP = 1.41e32;
        
        if (value < MIN_TEMP || value > MAX_TEMP) {
            throw new Error("Неверное значение температуры");
        }
        
        this._celsius = value;
    }
    
    get celsius() {
        return this._celsius;
    }
    
    toKelvin() {
        return Number((this._celsius + 273.15).toFixed(2));
    }
    
    toFahrenheit() {
        return Number(((this._celsius * 9/5) + 32).toFixed(2));
    }
    
    toString() {
        return `${this.toKelvin()} K`;
    }
    
    static add(temp1, temp2) {
        if (!(temp1 instanceof Temperature) || !(temp2 instanceof Temperature)) {
            throw new Error("Оба аргумента должны быть экземплярами класса Temperature");
        }
        
        return new Temperature(temp1.celsius + temp2.celsius);
    }
    
    static subtract(temp1, temp2) {
        if (!(temp1 instanceof Temperature) || !(temp2 instanceof Temperature)) {
            throw new Error("Оба аргумента должны быть экземплярами класса Temperature");
        }
        
        return new Temperature(temp1.celsius - temp2.celsius);
    }
}

// Задание 4: Камень-ножницы-бумага
class Subject {
    constructor() {
        this.observers = [];
    }
    
    subscribe(observer) {
        this.observers.push(observer);
    }
    
    unsubscribe(observer) {
        this.observers = this.observers.filter(obs => obs !== observer);
    }
    
    notify(data) {
        this.observers.forEach(observer => observer.update(data));
    }
}

class RoundSubject extends Subject {
    constructor() {
        super();
        this.rounds = [];
    }
    
    addRound(roundData) {
        this.rounds.push(roundData);
        this.notify(roundData);
    }
}

class StatsObserver {
    constructor(elementIds) {
        this.elements = {
            player1Wins: document.getElementById(elementIds.player1Wins),
            player2Wins: document.getElementById(elementIds.player2Wins),
            draws: document.getElementById(elementIds.draws)
        };
        this.stats = {
            player1Wins: 0,
            player2Wins: 0,
            draws: 0
        };
    }
    
    update(roundData) {
        const { player1, player2 } = roundData;
        
        if (this.getWinner(player1, player2) === 1) {
            this.stats.player1Wins++;
        } else if (this.getWinner(player1, player2) === 2) {
            this.stats.player2Wins++;
        } else {
            this.stats.draws++;
        }
        
        this.render();
    }
    
    getWinner(choice1, choice2) {
        if (choice1 === choice2) return 0; // ничья
        
        if ((choice1 === "Камень" && choice2 === "Ножницы") ||
            (choice1 === "Ножницы" && choice2 === "Бумага") ||
            (choice1 === "Бумага" && choice2 === "Камень")) {
            return 1; // победа первого игрока
        }
        
        return 2; // победа второго игрока
    }
    
    render() {
        this.elements.player1Wins.textContent = this.stats.player1Wins;
        this.elements.player2Wins.textContent = this.stats.player2Wins;
        this.elements.draws.textContent = this.stats.draws;
    }
}

class ChoicesObserver {
    constructor(elementIds) {
        this.elements = {
            player1Rock: document.getElementById(elementIds.player1Rock),
            player1Scissors: document.getElementById(elementIds.player1Scissors),
            player1Paper: document.getElementById(elementIds.player1Paper),
            player2Rock: document.getElementById(elementIds.player2Rock),
            player2Scissors: document.getElementById(elementIds.player2Scissors),
            player2Paper: document.getElementById(elementIds.player2Paper)
        };
        this.choices = {
            player1: { "Камень": 0, "Ножницы": 0, "Бумага": 0 },
            player2: { "Камень": 0, "Ножницы": 0, "Бумага": 0 }
        };
    }
    
    update(roundData) {
        const { player1, player2 } = roundData;
        
        this.choices.player1[player1]++;
        this.choices.player2[player2]++;
        
        this.render();
    }
    
    render() {
        this.elements.player1Rock.textContent = this.choices.player1["Камень"];
        this.elements.player1Scissors.textContent = this.choices.player1["Ножницы"];
        this.elements.player1Paper.textContent = this.choices.player1["Бумага"];
        this.elements.player2Rock.textContent = this.choices.player2["Камень"];
        this.elements.player2Scissors.textContent = this.choices.player2["Ножницы"];
        this.elements.player2Paper.textContent = this.choices.player2["Бумага"];
    }
}

class HistoryObserver {
    constructor(elementId) {
        this.element = document.getElementById(elementId);
        this.rounds = [];
    }
    
    update(roundData) {
        this.rounds.push(roundData);
        this.render();
    }
    
    render() {
        const lastRound = this.rounds[this.rounds.length - 1];
        const roundElement = document.createElement('div');
        roundElement.className = 'history-item';
        
        let winner = "Ничья";
        if (this.getWinner(lastRound.player1, lastRound.player2) === 1) {
            winner = "Игрок 1";
        } else if (this.getWinner(lastRound.player1, lastRound.player2) === 2) {
            winner = "Игрок 2";
        }
        
        roundElement.textContent = `Раунд ${this.rounds.length}: Игрок 1 - ${lastRound.player1}, Игрок 2 - ${lastRound.player2}. Победитель: ${winner}`;
        this.element.prepend(roundElement);
    }
    
    getWinner(choice1, choice2) {
        if (choice1 === choice2) return 0;
        
        if ((choice1 === "Камень" && choice2 === "Ножницы") ||
            (choice1 === "Ножницы" && choice2 === "Бумага") ||
            (choice1 === "Бумага" && choice2 === "Камень")) {
            return 1;
        }
        
        return 2;
    }
}

// Инициализация обработчиков событий при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Задание 1: Версионирование
    let versionManager = null;
    
    document.getElementById('create-version').addEventListener('click', function() {
        try {
            const versionInput = document.getElementById('version-input');
            versionManager = new VersionManager(versionInput.value);
            
            document.getElementById('version-display').textContent = versionManager.release();
            document.getElementById('version-buttons').style.display = 'block';
            versionInput.value = '';
        } catch (error) {
            alert(error.message);
        }
    });
    
    document.getElementById('major-btn').addEventListener('click', function() {
        if (versionManager) {
            versionManager.major();
            document.getElementById('version-display').textContent = versionManager.release();
        }
    });
    
    document.getElementById('minor-btn').addEventListener('click', function() {
        if (versionManager) {
            versionManager.minor();
            document.getElementById('version-display').textContent = versionManager.release();
        }
    });
    
    document.getElementById('patch-btn').addEventListener('click', function() {
        if (versionManager) {
            versionManager.patch();
            document.getElementById('version-display').textContent = versionManager.release();
        }
    });
    
    document.getElementById('rollback-btn').addEventListener('click', function() {
        if (versionManager) {
            try {
                versionManager.rollback();
                document.getElementById('version-display').textContent = versionManager.release();
            } catch (error) {
                alert(error.message);
            }
        }
    });
    
    // Задание 2: Прямоугольник и квадрат
    document.getElementById('calc-perimeter').addEventListener('click', function() {
        const width = Number(document.getElementById('width-input').value);
        const height = Number(document.getElementById('height-input').value);
        
        if (width <= 0 || height <= 0) {
            alert('Введите положительные значения для ширины и высоты');
            return;
        }
        
        let shape;
        if (width === height) {
            shape = new Square(width);
            document.getElementById('shape-result').textContent = `Периметр квадрата со стороной ${width}: ${shape.getPerimeter()}`;
        } else {
            shape = new Rectangle(width, height);
            document.getElementById('shape-result').textContent = `Периметр прямоугольника ${width}x${height}: ${shape.getPerimeter()}`;
        }
    });
    
    document.getElementById('calc-area').addEventListener('click', function() {
        const width = Number(document.getElementById('width-input').value);
        const height = Number(document.getElementById('height-input').value);
        
        if (width <= 0 || height <= 0) {
            alert('Введите положительные значения для ширины и высоты');
            return;
        }
        
        let shape;
        if (width === height) {
            shape = new Square(width);
            document.getElementById('shape-result').textContent = `Площадь квадрата со стороной ${width}: ${shape.getArea()}`;
        } else {
            shape = new Rectangle(width, height);
            document.getElementById('shape-result').textContent = `Площадь прямоугольника ${width}x${height}: ${shape.getArea()}`;
        }
    });
    
    // Задание 3: Температура
    const temp1Input = document.getElementById('temp1-input');
    const temp2Input = document.getElementById('temp2-input');
    const temp1Display = document.getElementById('temp1-display');
    const temp2Display = document.getElementById('temp2-display');
    const tempResult = document.getElementById('temp-result');
    const radioButtons = document.querySelectorAll('input[name="unit"]');
    
    let temp1 = null;
    let temp2 = null;
    
    function updateTempDisplay() {
        if (!temp1 && !temp2) return;
        
        const unit = document.querySelector('input[name="unit"]:checked').value;
        
        if (temp1) {
            switch(unit) {
                case 'celsius':
                    temp1Display.textContent = `${temp1.celsius.toFixed(2)} °C`;
                    break;
                case 'kelvin':
                    temp1Display.textContent = `${temp1.toKelvin()} K`;
                    break;
                case 'fahrenheit':
                    temp1Display.textContent = `${temp1.toFahrenheit()} °F`;
                    break;
            }
        }
        
        if (temp2) {
            switch(unit) {
                case 'celsius':
                    temp2Display.textContent = `${temp2.celsius.toFixed(2)} °C`;
                    break;
                case 'kelvin':
                    temp2Display.textContent = `${temp2.toKelvin()} K`;
                    break;
                case 'fahrenheit':
                    temp2Display.textContent = `${temp2.toFahrenheit()} °F`;
                    break;
            }
        }
    }
    
    temp1Input.addEventListener('input', function() {
        try {
            temp1 = new Temperature(Number(temp1Input.value));
            updateTempDisplay();
        } catch (error) {
            alert(error.message);
            temp1Input.value = '';
            temp1Display.textContent = '';
            temp1 = null;
        }
    });
    
    temp2Input.addEventListener('input', function() {
        try {
            temp2 = new Temperature(Number(temp2Input.value));
            updateTempDisplay();
        } catch (error) {
            alert(error.message);
            temp2Input.value = '';
            temp2Display.textContent = '';
            temp2 = null;
        }
    });
    
    radioButtons.forEach(function(radioButton) {
        radioButton.addEventListener('change', updateTempDisplay);
    });
    
    document.getElementById('add-temps').addEventListener('click', function() {
        if (!temp1 || !temp2) {
            alert('Введите оба значения температуры');
            return;
        }
        
        try {
            const resultTemp = Temperature.add(temp1, temp2);
            const unit = document.querySelector('input[name="unit"]:checked').value;
            
            switch(unit) {
                case 'celsius':
                    tempResult.textContent = `Результат сложения: ${resultTemp.celsius.toFixed(2)} °C`;
                    break;
                case 'kelvin':
                    tempResult.textContent = `Результат сложения: ${resultTemp.toKelvin()} K`;
                    break;
                case 'fahrenheit':
                    tempResult.textContent = `Результат сложения: ${resultTemp.toFahrenheit()} °F`;
                    break;
            }
        } catch (error) {
            alert(error.message);
        }
    });
    
    document.getElementById('subtract-temps').addEventListener('click', function() {
        if (!temp1 || !temp2) {
            alert('Введите оба значения температуры');
            return;
        }
        
        try {
            const resultTemp = Temperature.subtract(temp1, temp2);
            const unit = document.querySelector('input[name="unit"]:checked').value;
            
            switch(unit) {
                case 'celsius':
                    tempResult.textContent = `Результат вычитания: ${resultTemp.celsius.toFixed(2)} °C`;
                    break;
                case 'kelvin':
                    tempResult.textContent = `Результат вычитания: ${resultTemp.toKelvin()} K`;
                    break;
                case 'fahrenheit':
                    tempResult.textContent = `Результат вычитания: ${resultTemp.toFahrenheit()} °F`;
                    break;
            }
        } catch (error) {
            alert(error.message);
        }
    });
    
    // Задание 4: Камень-ножницы-бумага (полный упрощенный код)
    let es = null;
    let wins1 = 0, wins2 = 0, draws = 0;
    
    document.getElementById('start-stream').addEventListener('click', () => {
        document.getElementById('start-stream').disabled = true;
        document.getElementById('stop-stream').disabled = false;
        
        es = new EventSource('http://194.67.93.117:80/rps/stream');
        
        es.addEventListener('round', (e) => {
            try {
                console.log(e.data);
                const data = JSON.parse(e.data);
                
                if (data.player1 === data.player2) {
                    draws++;
                } else if (
                    (data.player1 === "Камень" && data.player2 === "Ножницы") ||
                    (data.player1 === "Ножницы" && data.player2 === "Бумага") ||
                    (data.player1 === "Бумага" && data.player2 === "Камень")
                ) {
                    wins1++;
                } else {
                    wins2++;
                }
                
                document.getElementById('player1-wins').textContent = wins1;
                document.getElementById('player2-wins').textContent = wins2;
                document.getElementById('draws').textContent = draws;
                
                const round = document.createElement('div');
                round.textContent = `${data.player1} vs ${data.player2}`;
                document.getElementById('rounds-history').prepend(round);
                
            } catch (err) {}
        });
    });
    
    document.getElementById('stop-stream').addEventListener('click', () => {
        if (es) es.close();
        document.getElementById('start-stream').disabled = false;
        document.getElementById('stop-stream').disabled = true;
    });
});