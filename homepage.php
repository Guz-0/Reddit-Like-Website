<?php

session_start();


//session_destroy();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <header class="wrapper-header">
        <div class="divs">
            <h1 style="text-align: left;">
                <?php

                if (isset($_SESSION["username"])) {
                    echo "Hello " . $_SESSION["username"] . "!";
                } else {
                    echo "[YOU ARE NOT LOGGED IN] ";
                    echo '<a href="index.php">LOGIN PAGE</a>';
                }

                ?>

            </h1>
            <h1 style="text-align: right;">
                <?php

                if (isset($_SESSION["username"])) {
                    echo '<a href="index.php">LOGOUT</a>';
                }

                ?>
            </h1>
        </div>
    </header>

    <?php

    if (isset($_SESSION["not_enough_chars"])) {
        echo '<h2 style="color: black; background-color: red;"><center> AT LEAST 5 CHARACTERS TO SUBMIT POST </center></h2>';
    }

    ?>


    <div class="wrapper" style="background-color: aquamarine;">
        <!-- PHP Code to show THREADS -->
        <?php
        #Stores the DATABASE in a local ASSOCIATIVE ARRAY
        include_once "searchDB.php";
        $database = getThreads();

        $idx = 0;

        #Check is user is LOGGED or not
        if (!isset($_SESSION["username"])) {
            echo "LOG IN TO SEE THREADS";
            die;
        }

        #Check if the DATABASE has any THREADS at all
        if (sizeof($database) == 0) {
            echo "[NO THREADS POSTED YET]";
        }
        while ($idx < sizeof($database)) { ?>
            <div class="wrapper">
                <?php

                #Retrieves from DATABASE the needed DATA
                echo "From: [" . whoPosted($database[$idx]["thread_id"]) . "]<br>";
                echo "' " . $database[$idx]["thread_text"] . " '<br>";
                echo $database[$idx]["thread_date"] . "<br>";

                $idx++;
                ?>
            </div>
        <?php } ?>
    </div>

    <form action="homepage.php" method="post">
        <div class="wrapper">
            <textarea name="text" id="" cols="100" rows="10" style="align-items: center;" placeholder="Enter your text here"></textarea>
            <br>
            <input type="submit" value="SUBMIT POST" name="post">
        </div>

    </form>



</body>

</html>

<?php
#SuperGlobal variable used to check if the text inserted is enough or not
$_SESSION["not_enough_chars"] = NULL;

if (isset($_POST["post"])) {

    $text = $_POST["text"];

    if (strlen($text) < 5) {
        $_SESSION["not_enough_chars"] = true;
        header("Location: homepage.php");
    } else {
        $_SESSION["not_enough_chars"] = NULL;

        #Retrieving from the DATABASE the USER info to attach them to the THREAD that
        #is getting  created
        include_once "searchDB.php";
        $user_id = getUserID($_SESSION["username"]);

        $today = date("Y-m-d");

        include_once "db_connection.php";
        $connection = connectToDB("website1");

        #Creating and adding a THREAD with all the needed information
        $sql = "INSERT INTO thread (user_id, thread_text, thread_date) VALUES ('$user_id','$text','$today')";
        $result = mysqli_query($connection, $sql);

        header("Location: homepage.php");
    }
}
?>