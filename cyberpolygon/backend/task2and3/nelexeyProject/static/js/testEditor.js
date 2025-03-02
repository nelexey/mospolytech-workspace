export default class TestEditor {
    constructor(testData = {}) {
        this.questionCounter = 0;
        this.existingQuestions = testData.questions || [];
        
        const form = document.getElementById('test-form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        const addButton = document.getElementById('add-question');
        if (addButton) {
            addButton.addEventListener('click', () => this.addQuestion());
        }

        requestAnimationFrame(() => {
            if (this.existingQuestions.length > 0) {
                this.populateQuestions(this.existingQuestions);
            }
        });
    }

    populateQuestions(questions) {
        questions.forEach((question, index) => {
            this.addQuestion();
            
            const questionId = this.questionCounter - 1;
            const questionBlock = document.querySelector(`[data-question-id="${questionId}"]`);
            if (!questionBlock) return;

            const textArea = questionBlock.querySelector('textarea');
            textArea.value = question.text;

            const typeSelect = questionBlock.querySelector('select');
            typeSelect.value = this.getQuestionType(question.type);
            
            this.handleTypeChange(questionId);

            if (question.type === 'text' && question.answers && question.answers.length > 0) {
                setTimeout(() => {
                    const textInput = questionBlock.querySelector('input[name$="[correct]"]');
                    if (textInput) {
                        textInput.value = question.answers[0];
                    }
                }, 0);
            } else if (question.variants) {
                const variantsList = questionBlock.querySelector('.variants-list');
                if (variantsList) {
                    variantsList.innerHTML = '';
                    question.variants.forEach((variant, variantIndex) => {
                        this.addVariant(questionId);
                        const variantInput = questionBlock.querySelector(
                            `input[name="questions[${questionId}][variants][${variantIndex}]"]`
                        );
                        if (variantInput) {
                            variantInput.value = variant;
                            if (question.answers && question.answers.includes(variantIndex)) {
                                const correctInput = variantInput
                                    .closest('.variant-item')
                                    .querySelector(`input[type="${typeSelect.value === 'radio' ? 'radio' : 'checkbox'}"]`);
                                if (correctInput) {
                                    correctInput.checked = true;
                                }
                            }
                        }
                    });
                }
            }
        });
    }

    getQuestionType(type) {
        const typeMap = {
            'text': 'input',
            'radioButton': 'radio',
            'checkbox': 'checkbox'
        };
        return typeMap[type] || type;
    }

    initializeEventListeners() {
        document.getElementById('add-question').addEventListener('click', () => this.addQuestion());
        document.getElementById('test-form').addEventListener('submit', (e) => this.handleSubmit(e));
    }

    generateUniqueId(prefix) {
        return `${prefix}-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
    }

    addQuestion() {
        const container = document.getElementById('questions-container');
        const questionDiv = document.createElement('div');
        const questionId = this.questionCounter;
        const uniquePrefix = this.generateUniqueId('question');

        questionDiv.className = 'question-block';
        questionDiv.dataset.questionId = questionId;

        const typeId = `${uniquePrefix}-type`;
        const textId = `${uniquePrefix}-text`;
        const pointsId = `${uniquePrefix}-points`;

        questionDiv.innerHTML = `
            <style>
                .answers-block {
                    margin-bottom: 10px;
                }
            </style>
            <hr>
            <div class="question-header">
                <h3>Вопрос ${questionId + 1}</h3>
                <button type="button" 
                        class="delete-question" 
                        id="${uniquePrefix}-delete"
                        aria-label="Удалить вопрос ${questionId + 1}">
                    Удалить вопрос
                </button>
            </div>
            
            <div class="form-group">
                <label for="${typeId}">Тип вопроса:</label>
                <select id="${typeId}" 
                        name="questions[${questionId}][type]" 
                        aria-label="Выберите тип вопроса">
                    <option value="input">Текстовый ответ</option>
                    <option value="radio">Один из списка</option>
                    <option value="checkbox">Множественный выбор</option>
                </select>
            </div>

            <div class="form-group">
                <label for="${textId}">Текст вопроса:</label>
                <textarea id="${textId}" 
                         name="questions[${questionId}][text]" 
                         required
                         aria-label="Введите текст вопроса"></textarea>
            </div>

            <div class="answers-block" id="answers-${questionId}"
                 aria-label="Блок ответов">
                <!-- Блок для вариантов ответа -->
            </div>

        `;
        // <div class="form-group">
        //     <label for="${pointsId}">Баллы за вопрос:</label>
        //     <input type="number"
        //            id="${pointsId}"
        //            name="questions[${questionId}][points]"
        //            value="1"
        //            min="1"
        //            required
        //            aria-label="Укажите количество баллов за вопрос">
        // </div>

        container.appendChild(questionDiv);

        // Добавляем обработчики событий после добавления в DOM
        const typeSelect = document.getElementById(typeId);
        typeSelect.addEventListener('change', () => this.handleTypeChange(questionId));

        document.getElementById(`${uniquePrefix}-delete`)
            .addEventListener('click', () => this.deleteQuestion(questionId));

        this.handleTypeChange(questionId);
        this.questionCounter++;
    }

    handleTypeChange(questionId) {
        const questionBlock = document.querySelector(`[data-question-id="${questionId}"]`);
        const type = questionBlock.querySelector('select').value;
        const answersBlock = document.getElementById(`answers-${questionId}`);
        const uniquePrefix = this.generateUniqueId('answer');

        answersBlock.innerHTML = '';

        switch (type) {
            case 'input':
                const correctId = `${uniquePrefix}-correct`;
                answersBlock.innerHTML = `
                    <div class="form-group">
                        <label for="${correctId}">Правильный ответ:</label>
                        <input type="text" 
                               id="${correctId}"
                               name="questions[${questionId}][correct]" 
                               required
                               aria-label="Введите правильный ответ">
                    </div>
                `;
                break;

            case 'radio':
            case 'checkbox':
                answersBlock.innerHTML = `
                    <div class="variants-list" 
                         id="variants-${questionId}"
                         aria-label="Список вариантов ответа">
                    </div>
                    <button type="button" 
                            id="${uniquePrefix}-add-variant"
                            aria-label="Добавить вариант ответа">
                        Добавить вариант
                    </button>
                `;

                document.getElementById(`${uniquePrefix}-add-variant`)
                    .addEventListener('click', () => this.addVariant(questionId));

                // Добавляем два варианта по умолчанию
                this.addVariant(questionId);
                this.addVariant(questionId);
                break;
        }
    }

    addVariant(questionId) {
        const variantsList = document.getElementById(`variants-${questionId}`);
        const variantIndex = variantsList.children.length;
        const uniquePrefix = this.generateUniqueId('variant');
        const variantDiv = document.createElement('div');
        variantDiv.className = 'variant-item';

        const questionBlock = document.querySelector(`[data-question-id="${questionId}"]`);
        const type = questionBlock.querySelector('select').value;
        const inputType = type === 'radio' ? 'radio' : 'checkbox';

        const variantId = `${uniquePrefix}-text`;
        const correctId = `${uniquePrefix}-correct`;

        // Изменим способ удаления варианта, так как onclick больше не имеет доступа к глобальному объекту
        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.textContent = 'Удалить';
        deleteButton.setAttribute('aria-label', 'Удалить вариант ответа');
        deleteButton.addEventListener('click', function () {
            this.closest('.variant-item').remove();
        });

        variantDiv.innerHTML = `
            <div class="form-group">
                <input type="${inputType}" 
                       id="${correctId}"
                       name="questions[${questionId}][correct]" 
                       value="${variantIndex}"
                       aria-label="Отметить как правильный ответ">
                <label for="${variantId}" class="visually-hidden">Вариант ответа ${variantIndex + 1}</label>
                <input type="text" 
                       id="${variantId}"
                       name="questions[${questionId}][variants][${variantIndex}]" 
                       required
                       aria-label="Текст варианта ответа">
            </div>
        `;

        variantDiv.querySelector('.form-group').appendChild(deleteButton);
        variantsList.appendChild(variantDiv);
    }

    deleteQuestion(questionId) {
        const questionBlock = document.querySelector(`[data-question-id="${questionId}"]`);
        questionBlock.remove();
        this.updateQuestionNumbers();
    }

    updateQuestionNumbers() {
        const questions = document.querySelectorAll('.question-block h3');
        questions.forEach((q, index) => {
            q.textContent = `Вопрос ${index + 1}`;
        });
    }

    handleSubmit(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const testData = {
            title: formData.get('title'),
            description: formData.get('description'),
            duration: parseInt(formData.get('duration')),
            difficulty: formData.get('difficulty'),
            category: formData.get('category'),
            attempts_allowed: parseInt(formData.get('attempts_allowed')),
            is_published: formData.get('is_published') === 'on',
            questions: []
        };

        const questionBlocks = document.querySelectorAll('.question-block');
        questionBlocks.forEach((block) => {
            const questionId = block.dataset.questionId;
            const questionData = {
                text: formData.get(`questions[${questionId}][text]`),
                type: '',
                variants: [],
                answers: []
            };

            const selectedType = formData.get(`questions[${questionId}][type]`);
            switch (selectedType) {
                case 'input':
                    questionData.type = 'text';
                    const textAnswer = formData.get(`questions[${questionId}][correct]`);
                    if (textAnswer) {
                        questionData.answers = [textAnswer];
                    }
                    break;

                case 'radio':
                    questionData.type = 'radioButton';
                    const radioVariants = block.querySelectorAll('.variant-item input[type="text"]');
                    radioVariants.forEach((variant) => {
                        questionData.variants.push(variant.value);
                    });
                    const selectedRadio = block.querySelector('input[type="radio"]:checked');
                    if (selectedRadio) {
                        questionData.answers = [parseInt(selectedRadio.value)];
                    }
                    break;

                case 'checkbox':
                    questionData.type = 'checkbox';
                    const checkboxVariants = block.querySelectorAll('.variant-item input[type="text"]');
                    checkboxVariants.forEach((variant) => {
                        questionData.variants.push(variant.value);
                    });
                    const selectedCheckboxes = block.querySelectorAll('input[type="checkbox"]:checked');
                    selectedCheckboxes.forEach((checkbox) => {
                        questionData.answers.push(parseInt(checkbox.value));
                    });
                    break;
            }

            testData.questions.push(questionData);
        });

        const testJsonInput = document.createElement('input');
        testJsonInput.type = 'hidden';
        testJsonInput.name = 'test_json';
        testJsonInput.value = JSON.stringify(testData);
        form.appendChild(testJsonInput);

        form.submit();
    }
}
