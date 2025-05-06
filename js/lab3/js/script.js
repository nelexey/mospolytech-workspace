const regButton = document.getElementsByClassName('start-now-button')[0];
const dialog = document.getElementById('registration-form-dialog');
const closeDialogButton = document.getElementById('closeDialog');
const togglePasswordButton = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const form = document.querySelector('#registration-form-dialog form');
const inputs = form.querySelectorAll('input');


regButton.addEventListener('click', function() {
    dialog.showModal();
});


closeDialogButton.addEventListener('click', function() {
    dialog.close();
});


dialog.addEventListener('click', function(event) {
    if (event.target === dialog) {
        dialog.close();
    }
});


function validateField(input) {
    const errorElement = document.getElementById(`${input.id}-error`);
    
    if (!input.validity.valid) {
        input.setAttribute('aria-invalid', 'true');
        errorElement.hidden = false;
        
        if (input.validity.valueMissing) {
            errorElement.textContent = 'Это поле обязательно для заполнения';
        } else if (input.validity.typeMismatch && input.type === 'email') {
            errorElement.textContent = 'Введите корректный адрес электронной почты';
        } else if (input.validity.tooShort) {
            errorElement.textContent = `Минимальная длина ${input.minLength} символов`;
        }
        
        return false;
    } else {
        input.removeAttribute('aria-invalid');
        errorElement.hidden = true;
        errorElement.textContent = '';
        return true;
    }
}


inputs.forEach(input => {
    input.addEventListener('blur', function() {
        validateField(this);
    });
});


form.addEventListener('submit', function(event) {
    event.preventDefault();
    
    let isValid = true;
    let firstInvalidInput = null;
    
    inputs.forEach(input => {
        if (!validateField(input)) {
            isValid = false;
            if (!firstInvalidInput) {
                firstInvalidInput = input;
            }
        }
    });
    
    if (isValid) {
        const formData = new FormData(form);
        console.log('Данные формы:');
        for (let [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        dialog.close();
    } else if (firstInvalidInput) {
        firstInvalidInput.focus();
    }
});

// Изменение типа поля пароля при нажатии/отпускании кнопки
togglePasswordButton.addEventListener('pointerdown', function() {
    passwordInput.type = 'text';
});

togglePasswordButton.addEventListener('pointerup', function() {
    passwordInput.type = 'password';
});

// Дополнительная обработка, чтобы вернуть тип password, если указатель покинул кнопку
togglePasswordButton.addEventListener('pointerleave', function() {
    passwordInput.type = 'password';
});