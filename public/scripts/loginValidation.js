import {
    validateEmail,
    validateMinLength,
    validatePassword,
    hideErrorMessage,
    displayErrorMessage,
} from './validationFunctions.js';

var form = document.querySelector('#login');
if (!form) form = document.querySelector('#register');

const applyButton = document.querySelector('.form-button[type="submit"]');
applyButton.disabled = true;
applyButton.classList.add('disabled');

setupRealTimeValidation(form);

form.addEventListener('submit', function (event) {
    if (!validateFormInputs(this)) {
        event.preventDefault();
    }
});

function validateInput(input) {
    const inputValue = input.value.trim();
    const container = input.parentElement;

    switch (input.name) {
        case 'email':
            if (!validateEmail(inputValue)) {
                input.classList.add('invalid');
                displayErrorMessage(container, 'Invalid email address');
                return false;
            } else {
                input.classList.remove('invalid');
                hideErrorMessage(container);
                return true;
            }

        case 'password':
            if (form.id === 'login') {
                if (!validateMinLength(inputValue, 8)) {;
                    return false;
                }else{
                    hideErrorMessage(container);
                    return true;
                }
            } else {
                if (!validatePassword(inputValue)) {
                    input.classList.add('invalid');
                    displayErrorMessage(
                        container,
                        'Length at least 8<br>At least 1 capital character<br>At least 1 number'
                    );
                    return false;
                } else {
                    input.classList.remove('invalid');
                    hideErrorMessage(container);
                    return true;
                }
            }
            break;

        case 'login':
            if (!validateMinLength(inputValue, 3)) {
                input.classList.add('invalid');
                displayErrorMessage(container, 'Input at least 3 characters');
                return false;
            } else {
                input.classList.remove('invalid');
                hideErrorMessage(container);
                return true;
            }

        default:
            return true;
    }
}

function validateFormInputs(form) {
    const inputs = form.querySelectorAll('.form-field');
    let isFormValid = true;

    inputs.forEach((input) => {
        if (!validateInput(input)) {
            isFormValid = false;
        }
    });

    return isFormValid;
}

function updateButtonState(form) {
    const applyButton = form.querySelector('.form-button[type="submit"]');
    const inputs = form.querySelectorAll('input.form-field');
    const isValid = Array.from(inputs).every((input) => validateInput(input));

    if (!isValid) {
        applyButton.disabled = true;
        applyButton.classList.add('disabled');
    } else {
        applyButton.disabled = false;
        applyButton.classList.remove('disabled');
    }
}

function setupRealTimeValidation(form) {
    const inputs = form.querySelectorAll('input.form-field');

    inputs.forEach((input) => {
        input.addEventListener('input', function () {
            validateInput(input);
            updateButtonState(form);
        });
    });
}
