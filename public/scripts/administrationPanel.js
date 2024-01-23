const deleteButtons = document.querySelectorAll('.row-element>img');

deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        deleteUser(button);
    });
});

function deleteUser(element){
    const user = element.parentNode.parentNode;
    const userId = user.querySelector('.row-element:first-child').innerHTML;
    console.log(userId)


    fetch("/deleteUser", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: userId})
    })
        .then(response => response.json())
        .then(data => {
            console.log('Odpowiedź z serwera:', data);
        })
        .catch(error => {
            console.error('Błąd podczas wysyłania danych na serwer:', error);
        });
    user.remove();

}