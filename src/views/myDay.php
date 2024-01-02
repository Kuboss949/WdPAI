            
                <div class = "daily-progress">
                    <span class = "calories-left">Calories left: 0</span>
                    <span class = "daily-progress-bar">
                        <img src="../../public/images/dragon.png">
                        <img src="../../public/images/dragon.png">
                        <img src="../../public/images/dragon.png">
                        <img src="../../public/images/dragon.png">
                        <img src="../../public/images/dragon.png">
                    </span>
                </div>
                <table class="table">

                    <tr onclick="toggleRows(this)">
                        <td class="meal-row">
                            <h3>Breakfast</h3>
                            <p class="calories">Calories: 0</p>
                        </td>
                        <td>
                            <img class="arrow-img" src = "../../public/images/arrows.png">
                        </td>
                        
                    </tr>
                    <?php foreach($variables as $product): ?> 
                    <tr class="show-me concrete-product hide-row">
                        <td><?= $product->getName(); ?></td>
                        <td><?= $product->getEnergeticValue(); ?></td>
                        <td>delete</td>
                    </tr>
                    <?php endforeach; ?> 
                    <tr class="show-me add-product hide-row">
                        <td></td>
                        <td>Add Product</td>
                        <td></td>
                    </tr>
                    
                    <tr onclick="toggleRows(this)">
                        <td class="meal-row">
                            <h3>Lunch</h3>
                            <p class="calories">Calories: 0</p>
                        </td>
                        <td>
                            <img class="arrow-img" src = "../../public/images/arrows.png">
                        </td>
                    </tr>
                    <tr class="show-me add-product hide-row">
                        <td></td>
                        <td>Add Product</td>
                        <td></td>
                    </tr>
                    <tr onclick="toggleRows(this)">
                        <td class="meal-row">
                            <h3>Dinner</h3>
                            <p class="calories">Calories: 0</p>
                        </td>
                        <td>
                            <img class="arrow-img" src = "../../public/images/arrows.png">
                        </td>
                    </tr>
                    <tr class="show-me add-product hide-row">
                        <td></td>
                        <td>Add Product</td>
                        <td></td>
                    </tr>
                    <tr onclick="toggleRows(this)">
                        <td class="meal-row">
                            <h3>Breakfast</h3>
                            <p class="calories">Calories: 0</p>
                        </td>
                        <td>
                            <img class="arrow-img" src = "../../public/images/arrows.png">
                        </td>
                    </tr>
                    <tr class="show-me add-product hide-row">
                        <td></td>
                        <td>Add Product</td>
                        <td></td>
                    </tr>
                    <tr onclick="toggleRows(this)">
                        <td class="meal-row">
                            <h3>Snacks</h3>
                            <p class="calories">Calories: 0</p>
                        </td>
                        <td>
                            <img class="arrow-img" src = "../../public/images/arrows.png">
                        </td>
                    </tr>
                    <tr class="show-me add-product hide-row">
                        <td></td>
                        <td>Add Product</td>
                        <td></td>
                    </tr>
                    <tr onclick="toggleRows(this)">
                        <td class="meal-row">
                            <h3>Supper</h3>
                            <p class="calories">Calories: 0</p>
                        </td>
                        <td>
                            <img class="arrow-img" src = "../../public/images/arrows.png">
                        </td>
                    </tr>
                    <tr class="show-me add-product hide-row">
                        <td></td>
                        <td>Add Product</td>
                        <td></td>
                    </tr>
                    
                </table>  
                <script>
                    function toggleRows(element) {
                        // Get all elements with the class 'show-me' below the clicked row
                        var sibling = element.nextElementSibling;
                        // Get the image element with the class 'arrow-img' inside the clicked row
                        var td = element.getElementsByTagName('td')[1];

                        // Get the image element with the class 'arrow-img' inside the second td
                        var img = td.getElementsByClassName('arrow-img')[0];


                    // Check if the image element is found
                        if (img) {
                            // Toggle the 'rotated-image' class for the image element
                            img.classList.toggle('rotated-image');
                        }

                        // Check if the next element has the 'show-me' class
                        if (sibling && sibling.classList.contains('show-me')) {
                            // Toggle the 'hide-row' class for the next element
                            sibling.classList.toggle('hide-row');
                            toggleRows(sibling);
                        }
                    }
                </script>
            
        