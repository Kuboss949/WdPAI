            
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

                <?php /*foreach($variables as $product): */?><!--
                    <tr class="show-me concrete-product hide-row">
                        <td><?php /*= $product->getName(); */?></td>
                        <td><?php /*= $product->getEnergeticValue(); */?></td>
                        <td>delete</td>
                    </tr>
                    --><?php /*endforeach; */?>

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
                        // Get the next element with the class 'show-me' below the clicked row
                        const sibling = element.nextElementSibling;
                        // Get the second td element inside the clicked row
                        const td = element.querySelector('td:nth-child(2)');
                        // Get the image element with the class 'arrow-img' inside the second td
                        const img = td.querySelector('.arrow-img');

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
            
        