const deleteButtons = document.querySelectorAll('.row-element>img');

deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        deleteUser(button);
    });
});

async function deleteUser(element) {
    const user = element.parentNode.parentNode;
    const userId = user.querySelector('.row-element:first-child').innerHTML;
    console.log(userId);

    try {
        const response = await fetch("/deleteUser", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id: userId})
        });

        const data = await response.json();
        console.log('Odpowiedź z serwera:', data);

    } catch (error) {
        console.error('Błąd podczas wysyłania danych na serwer:', error);
    }

    user.remove();
}