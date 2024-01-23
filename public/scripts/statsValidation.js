import {validateFloat, hideErrorMessage, displayErrorMessage } from './validationFunctions.js';

const statsForm = document.querySelector('#weight-form');
console.log(statsForm);

const applyButton = document.querySelector('.form-button[type="submit"]');
applyButton.disabled = true;
applyButton.classList.add('disabled');

setupRealTimeValidation(statsForm);

function validateInput(inputElement) {
        if (inputElement.name === 'new_weight') {
            inputElement.value = inputElement.value.replace(/[^\d.]/g, ''); // Allow only digits and one dot
            const dotIndex = inputElement.value.indexOf('.');
            if (dotIndex !== -1) {
                // If a dot is present, allow only one digit after the dot for weight
                inputElement.value = inputElement.value.substring(0, dotIndex + 2);
            }
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

function updateButtonState(form) {
    const applyButton = form.querySelector('.form-button[type="submit"]');
    const input = form.querySelector('input');
    const isValid = validateFloat(input.value);
    const container = input.parentNode;

    if (!isValid) {
        applyButton.disabled = true;
        applyButton.classList.add('disabled');
        input.classList.add("invalid");
        displayErrorMessage(container, "Invalid number");
    } else {
        applyButton.disabled = false;
        applyButton.classList.remove('disabled');
        input.classList.remove("invalid");
        hideErrorMessage(container);
    }
}
