const searchInput = document.querySelector("#search-input");
searchInput.addEventListener('input', function () {
    search();
});

const productContainer = document.querySelector(".table");

async function search() {
    try {
        const query = searchInput.value.toLowerCase();

        const response = await fetch("/searchProduct", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ search: query })
        });

        if (!response.ok) {
            throw new Error("Network response was not ok");
        }

        const products = await response.json();
        productContainer.innerHTML = "";
        loadProducts(products);

    } catch (error) {
        console.error("There was a problem with the fetch operation:", error.message);
    }
}

function loadProducts(products) {
    const productKeys = Object.keys(products);

    // Iterate through the keys
    productKeys.forEach(key => {
        const product = products[key];
        createProduct(product);
    });
}

function createProduct(product) {
    const template = document.querySelector(".product");
    //console.log(product);
    const clone = template.cloneNode(true);
    clone.classList.remove("hidden");
    const name = clone.querySelector(".name");
    name.innerHTML = product.name;
    const unitSelect = clone.querySelector(".unit");
    unitSelect.innerHTML = "";
    if (product.units) {
        for (const unit in product.units) {
            const option = document.createElement("option");
            option.value = product.units[unit] + unit;
            option.text = `${unit} - ${product.units[unit]} kcal`;
            unitSelect.appendChild(option);
        }
    }
    const amountInput = clone.querySelector(".amount");

    amountInput.addEventListener('input', function () {updateCalories(amountInput);});
    unitSelect.addEventListener('change', function () {updateCalories(unitSelect);});


    productContainer.appendChild(clone);
}

function updateCalories(element){
    const product = element.parentNode.parentNode;
    const unitSelect = product.querySelector(".unit");
    const amountInput = product.querySelector(".amount");
    const kcal = parseFloat(unitSelect.value.match(/\d+/)[0]);
    const caloriesValue = product.querySelector(".calories-value");
    const amount = amountInput.value == "" ? 0 : parseInt(amountInput.value);
    caloriesValue.innerHTML = amount* parseInt(kcal);
}

function validateInput(inputElement) {
    inputElement.value = inputElement.value.replace(/\D/g, '');
}

async function addProductToMeal(element, id, meal) {
    const product = element.parentNode.parentNode;
    const productName = product.querySelector('.name').innerHTML;
    const productAmount = product.querySelector('.amount').value;
    const productUnit = extractName(product.querySelector('.unit').value);

    if (productAmount !== "" && productAmount !== 0) {
        const productData = {
            userID: id,
            name: productName,
            amount: productAmount,
            unit: productUnit,
            meal: meal
        };

        try {
            console.log(productData);

            const response = await fetch("/addProductToMeal", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ productData: productData })
            });

            const data = await response.json();
            console.log('Odpowiedź z serwera:', data);

        } catch (error) {
            console.error('Błąd podczas wysyłania danych na serwer:', error);
        }
    }
}

function addProductToMealAndRedirect(element, id, meal){
    addProductToMeal(element, id, meal);
    setTimeout( () =>{window.location.href = "myDay";}, 300)
}

function extractName(inputString) {
    // Utwórz wyrażenie regularne, aby dopasować liczbę i nazwę
    const match = inputString.match(/^(\d+)([a-zA-Z]+)/);
    if (match) {
        const name = match[2];
        return name;
    } else {
        // Jeśli dopasowanie się nie udało, zwróć null lub inne odpowiednie wartości
        return null;
    }
}