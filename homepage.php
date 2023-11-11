<?php

session_start();


//session_destroy();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Homepage</title>

</head>

<body>

    <header class="wrapper-header" id="user_name">
        <div class="divs">
            <h1 style="text-align: left;">
                <?php

                if (isset($_SESSION["user_name"])) {
                    echo "Hello " . $_SESSION["user_name"] . "!";
                } else {
                    echo "[YOU ARE NOT LOGGED IN] ";
                    echo '<a href="index.php">LOGIN PAGE</a>';
                }

                ?>

            </h1>
            <h1 style="text-align: right;">
                <?php

                if (isset($_SESSION["user_name"])) {
                    echo '<a href="index.php">LOGOUT</a>';
                }

                ?>
            </h1>
        </div>
    </header>

    <div id="container">

    </div>






    <div class="wrapper">
        <textarea name="text" id="textarea" cols="100" rows="10" style="align-items: center;" placeholder="Enter your text here"></textarea>
        <br>
        <?php echo '<button id="button" onclick="addThread(' . "'" . $_SESSION["user_id"] . "'" . ')"> SUBMIT THREAD </button>' ?>
    </div>


    <script src="scripts.js"></script>
</body>

</html>