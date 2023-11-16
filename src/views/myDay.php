<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/menu.css">
    <link rel="stylesheet" href="../../public/css/myday.css">


    <title>Your Day</title>
</head>
<body>
    <div class="site-container">
        <nav>
            
            <span class = "logo-span">
                <img src = "../../public/images/logo.png">
                <h1>NutriQuest</h1>
            </span>
            
            <ul>
                <li>
                    
                    <img src = "../../public/images/castleIcon.png">
                    <a href="myDay">HOME</a>
                </li>
                <li>
                    <img src = "../../public/images/statisticsIcon.png">
                    <a href="myDay">STATS</a>
                </li>
                <li>
                    <img src = "../../public/images/logoutIcon.png">
                    <a href="login">LOGOUT</a>
                </li>
            </ul>
        </nav>
        <main>
            <div id = "level-bar">
                <div class ="level-bar-edge"></div>
                <div id = "progress-bar">
                    <h2>Level: 0</h2>
                    <progress max="100" value="10"></progress>
                </div>
                <div class = "profile-icon level-bar-edge">
                    <img src = "../../public/images/knightProf.png">
                </div>

            </div>
            <div id = "content-window">
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
                    <tr class="show-me concrete-product hide-row">
                        <td>Name</td>
                        <td>calories</td>
                        <td>delete</td>
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

                





            </div>
        </main>
    </div>
</body>
</html>