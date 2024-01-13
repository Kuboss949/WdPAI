const arrowButtons = document.querySelectorAll('.arrow-img');
const deleteButtons = document.querySelectorAll('.delete-button');
const caloriesLeftSpan = document.querySelector("#left");
const caloriesLimit = parseInt(caloriesLeftSpan.innerHTML);
var caloriesConsumed = 0;
arrowButtons.forEach(button => {
    button.addEventListener('click', () => {
        toggleRows(button);
    });
});
deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        deleteEntry(button);
        reloadCalories();
        updateProgressBar();
    });
});

reloadCalories();
updateProgressBar();

function toggleRows(image) {
    const mealDiv = image.closest('.meal-div');

    const siblings = mealDiv.querySelectorAll('.show-me');
    image.classList.toggle('rotated-image');
    siblings.forEach(sibling => {
        sibling.classList.toggle('hide-row');
    });
}


function addProduct(mealName){
    var expirationDate = new Date();
    expirationDate.setTime(expirationDate.getTime() + (60 * 60 * 1000));
    document.cookie = "meal_name=" + mealName + "; expires=" + expirationDate.toUTCString() + "; path=/";
}

function deleteEntry(element){
    const entry = element.parentNode.parentNode;
    const entryId = entry.querySelector('.entry-id').innerHTML;


    fetch("/deleteEntry", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({id: entryId})
    })
        .then(response => response.json())
        .then(data => {
            console.log('Odpowiedź z serwera:', data);
        })
        .catch(error => {
            console.error('Błąd podczas wysyłania danych na serwer:', error);
        });
    entry.remove();

}

function reloadCalories(){
    const mealDiv = document.querySelectorAll('.meal-div')
    var sum = 0;
    mealDiv.forEach(div => {
        sum+=reloadCaloriesForDiv(div);
    });
    caloriesConsumed = sum;
    var left = caloriesLimit - sum;
    caloriesLeftSpan.innerHTML = left.toString();
}

function reloadCaloriesForDiv(div){
    const caloriesSummary = div.querySelector('.calories-summary');
    const caloriesFromEntries = div.querySelectorAll('.calories');
    var sum = 0;
    caloriesFromEntries.forEach(element => {
        sum += parseInt(element.innerHTML)
    });
    caloriesSummary.innerHTML = sum;
    return sum;
}

function updateProgressBar(){
    const progressImages = document.querySelectorAll('.daily-progress img');
    const progress = caloriesConsumed/caloriesLimit;
    const partsToColor = Math.floor(progressImages.length * progress);

    progressImages.forEach(image => {
        if (!image.classList.contains('gray')) {    //wolę się upewnić
            image.classList.add('gray');
        }
    });

    for(var i=0; i<partsToColor; i++){
      progressImages.item(i).classList.remove('gray');
    }


}


