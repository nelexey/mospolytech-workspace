class TestTimer {
    constructor(duration, formId, timerId) {
        this.totalSeconds = duration * 60;
        this.remainingSeconds = this.totalSeconds;
        this.timerElement = document.getElementById(timerId);
        this.form = document.getElementById(formId);
        this.paused = false;
    }

    init() {
        this.updateDisplay();
        this.startTimer();
        this.setupEventListeners();
    }

    updateDisplay() {
        const minutes = Math.floor(this.remainingSeconds / 60);
        const seconds = this.remainingSeconds % 60;
        this.timerElement.textContent = `Осталось времени: ${minutes}:${seconds.toString().padStart(2, '0')}`;

        // Добавляем визуальное предупреждение, когда осталось мало времени
        if (this.remainingSeconds <= 300) { // 5 минут
            this.timerElement.style.color = 'red';
        }
    }

    startTimer() {
        this.interval = setInterval(() => {
            if (!this.paused) {
                this.remainingSeconds--;
                this.updateDisplay();

                if (this.remainingSeconds <= 0) {
                    this.stopTimer();
                    this.submitTest();
                }
            }
        }, 1000);
    }

    stopTimer() {
        clearInterval(this.interval);
    }

    pauseTimer() {
        this.paused = true;
    }

    resumeTimer() {
        this.paused = false;
    }

    setupEventListeners() {
        // Приостанавливаем таймер, когда вкладка/окно не активно
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.pauseTimer();
            } else {
                this.resumeTimer();
            }
        });

        // Сохраняем состояние таймера перед уходом со страницы
        window.addEventListener('beforeunload', (e) => {
            if (this.remainingSeconds > 0) {
                e.preventDefault();
                e.returnValue = 'У вас остается незавершенный тест. Вы уверены, что хотите покинуть страницу?';
            }
        });
    }

    submitTest() {
        const timeSpentInput = document.createElement('input');
        timeSpentInput.type = 'hidden';
        timeSpentInput.name = 'time_spent';
        timeSpentInput.value = this.totalSeconds - this.remainingSeconds;
        this.form.appendChild(timeSpentInput);

        this.form.submit();
    }
}

export default TestTimer;