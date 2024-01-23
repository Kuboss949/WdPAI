export function validateEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}

export function validateNumber(input) {
    const numberRegex = /^[0-9]+$/;
    return numberRegex.test(input);
}

export function validateFloat(input) {
    const floatRegex = /^\d+(\.\d{1})?$/;
    return floatRegex.test(input);
}

export function validateMinLength(input, minLength) {
    const regex = new RegExp(`^.{${minLength},}$`);
    return regex.test(input);
}

export function validatePassword(password) {
    const lengthRegex = /^.{8,}$/;  // Minimum length of 8 characters
    const capitalLetterRegex = /[A-Z]/;  // At least one capital letter
    const numberRegex = /\d/;  // At least one digit

    return lengthRegex.test(password) && capitalLetterRegex.test(password) && numberRegex.test(password);
}

export function displayErrorMessage(container, message) {
    let errorMessageElement = container.querySelector('.error-message');
    if (!errorMessageElement) {
        errorMessageElement = document.createElement('div');
        errorMessageElement.classList.add('error-message');
        container.appendChild(errorMessageElement);
    }
    errorMessageElement.innerHTML= message;
}

export function hideErrorMessage(container) {
    const errorMessageElement = container.querySelector('.error-message');
    if (errorMessageElement) {
        container.removeChild(errorMessageElement);
    }
}

