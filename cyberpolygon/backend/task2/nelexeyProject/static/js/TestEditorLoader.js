export default class TestEditorLoader {
    constructor(editor) {
        this.editor = editor;
    }

    populateQuestions(questions) {
        if (!questions || !Array.isArray(questions)) return;
        
        questions.forEach((question, index) => {
            this.editor.addQuestion();
            const questionBlock = document.querySelector(`[data-question-id="${index}"]`);
            if (!questionBlock) return;

            // Set question text
            const textArea = questionBlock.querySelector('textarea');
            textArea.value = question.text || '';

            // Set question type
            const typeSelect = questionBlock.querySelector('select');
            let selectedType;
            switch (question.type) {
                case 'text':
                    selectedType = 'input';
                    break;
                case 'radioButton':
                    selectedType = 'radio';
                    break;
                case 'checkbox':
                    selectedType = 'checkbox';
                    break;
                default:
                    selectedType = question.type;
            }
            
            typeSelect.value = selectedType;
            this.editor.handleTypeChange(index);

            // Handle text answers immediately after type change
            if (selectedType === 'input' && question.answers && question.answers.length > 0) {
                setTimeout(() => {
                    const textInput = questionBlock.querySelector('input[name$="[correct]"]');
                    if (textInput) {
                        textInput.value = question.answers[0];
                    }
                }, 0);
            } else if ((selectedType === 'radio' || selectedType === 'checkbox') && question.variants) {
                const variantsList = questionBlock.querySelector('.variants-list');
                if (!variantsList) return;
                
                variantsList.innerHTML = '';
                question.variants.forEach((variant, variantIndex) => {
                    this.editor.addVariant(index);
                    const variantInput = questionBlock.querySelector(
                        `input[name="questions[${index}][variants][${variantIndex}]"]`
                    );
                    
                    if (variantInput) {
                        variantInput.value = variant;
                        
                        // Set correct answers
                        if (question.answers && question.answers.includes(variantIndex)) {
                            const inputType = selectedType === 'radio' ? 'radio' : 'checkbox';
                            const correctInput = variantInput
                                .closest('.variant-item')
                                .querySelector(`input[type="${inputType}"]`);
                            if (correctInput) {
                                correctInput.checked = true;
                            }
                        }
                    }
                });
            }
        });
    }
}