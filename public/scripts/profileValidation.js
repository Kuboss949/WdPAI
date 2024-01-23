import { validateEmail, validateNumber, validateFloat, hideErrorMessage, displayErrorMessage } from './validationFunctions.js';
const profileForm = document.getElementById('profile-settings-form');
const goalsForm = document.getElementById('goals-settings-form');
const applyButtons = document.querySelectorAll('.form-button[type="submit"]');

applyButtons.forEach(button => {
    button.disabled = true; // Initially disable the buttons
    button.classList.add("disabled");
});

setupRealTimeValidation(profileForm);
setupRealTimeValidation(goalsForm);

profileForm.addEventListener('submit', function (event) {
    if (!validateFormInputs(this)) {
        event.preventDefault(); // Prevent the form from submitting if validation fails
    }
});

goalsForm.addEventListener('submit', function (event) {
    if (!validateFormInputs(this)) {
        event.preventDefault(); // Prevent the form from submitting if validation fails
    }
});



function validateAgeHeightInput(inputElement) {
    if (inputElement.name === 'age' || inputElement.name === 'height') {
        inputElement.value = inputElement.value.replace(/[^\d]/g, ''); // Allow only digits
    }
}

function validateInput(inputElement) {
    if (inputElement.name === 'age' || inputElement.name === 'height' || inputElement.name === 'weight') {
        inputElement.value = inputElement.value.replace(/[^\d.]/g, ''); // Allow only digits and one dot

        const dotIndex = inputElement.value.indexOf('.');
        if (dotIndex !== -1) {
            // If a dot is present, allow only one digit after the dot for weight
            if (inputElement.name === 'weight') {
                inputElement.value = inputElement.value.substring(0, dotIndex + 2);
            } else {
                // For age and height, remove dots
                inputElement.value = inputElement.value.replace(/\./g, '');
            }
        }
    }
}

function validateFormInputs(form) {
    const inputs = form.querySelectorAll('.form-field');
    let isFormValid = true;

    inputs.forEach(input => {
        validateInput(input);
        validateAgeHeightInput(input);

        const inputValue = input.value.trim();
        const container = input.name === "weight" ? input.parentElement.parentElement : input.parentElement;


        switch (input.name) {
            case 'email':
                if (!validateEmail(inputValue)) {
                    isFormValid = false;
                    input.classList.add("invalid");
                    displayErrorMessage(container, "Invalid email address");
                } else {
                    input.classList.remove("invalid");
                    hideErrorMessage(container);
                }
                break;

            case 'height':
            case 'age':
                if (!validateNumber(inputValue)) {
                    isFormValid = false;
                    input.classList.add("invalid");
                    displayErrorMessage(container, "Please enter a valid number");
                } else {
                    input.classList.remove("invalid");
                    hideErrorMessage(container);
                }
                break;

            case 'weight':
                if (!validateFloat(inputValue)) {
                    isFormValid = false;
                    input.classList.add("invalid");
                    displayErrorMessage(container, "Please enter a valid number");
                } else {
                    input.classList.remove("invalid");
                    hideErrorMessage(container);
                }
                break;

            default:
                break;
        }
    });

    return isFormValid;
}



function updateButtonState(form) {
    const applyButton = form.querySelector('.form-button[type="submit"]');
    if(!validateFormInputs(form)){
        applyButton.disabled = true;
        applyButton.classList.add("disabled");
    }
    else{
        applyButton.disabled = false;
        applyButton.classList.remove("disabled");
    }
}

function setupRealTimeValidation(form) {
    const inputs = form.querySelectorAll('input.form-field');

    inputs.forEach(input => {
        input.addEventListener('input', function () {
            validateInput(this);
            validateAgeHeightInput(this); // Additional validation for age and height
            updateButtonState(form);
        });
    });
}
