<?php

session_start();


//session_destroy();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title></title>
    <script src="scripts.js"></script>
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

    <?php

    if (isset($_SESSION["not_enough_chars"])) {
        echo '<h2 style="color: black; background-color: red;"><center> AT LEAST 5 CHARACTERS TO SUBMIT POST </center></h2>';
        #im in hashing password
    }

    ?>




    <div class="wrapper" style="background-color: aquamarine; width:auto;">
        <!-- PHP Code to show THREADS -->
        <?php
        #Stores the DATABASE in a local ASSOCIATIVE ARRAY
        include_once "searchDB.php";
        $database = getThreads();

        $idx = 0;

        #Check is user is LOGGED or not
        if (!isset($_SESSION["user_name"])) {
            echo "LOG IN TO SEE THREADS";
            echo "username" . $_SESSION["user_name"];
            die;
        }

        #Check if the DATABASE has any THREADS at all
        if (sizeof($database) == 0) {
            echo "[NO THREADS POSTED YET]";
        }
        while ($idx < sizeof($database)) { ?>
            <div class="wrapper-header" style="text-align: left;">
                <?php
                $userData = getUserData(whoPosted($database[$idx]["thread_id"]));

                echo '<div class="user-detail" id=' . $idx . ' style="display: none";>
                    
                    Username: ' . whoPosted($database[$idx]["thread_id"]) . '<br>' . 'Registration date: ' . $userData["user_reg_date"] .

                    '</div>';

                #Retrieves from DATABASE the needed DATA 
                echo '<span class="p-thread">' . "From" . '</span>';
                echo '<span class="p-thread"  style="cursor: pointer; text-decoration: underline;" onclick="UserDetails(' . $idx . ' )">' . "[" . whoPosted($database[$idx]["thread_id"]) . "]<br>" . '</span>';
                #echo "From: [" . whoPosted($database[$idx]["thread_id"]) . "]<br>";
                echo '<p class="p-thread"> ' . $database[$idx]["thread_text"] . '<br></p>';
                #echo '<p style="text-align: right;>' . $database[$idx]["thread_date"] . "<br>" . '</p>';
                echo '<p style="text-align: right; margin-right: 15px;">' . $database[$idx]["thread_date"] . "<br>" . '</p>';

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
unset($_SESSION["not_enough_chars"]);

if (isset($_POST["post"])) {

    $text = $_POST["text"];

    if (strlen($text) < 5) {
        $_SESSION["not_enough_chars"] = true;
        header("Location: homepage.php");
    } else {
        unset($_SESSION["not_enough_chars"]);

        #Retrieving from the DATABASE the USER info to attach them to the THREAD that
        #is getting  created
        include_once "searchDB.php";
        $user_id = getUserID($_SESSION["user_name"]);
        $text = filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS);

        $today = date("Y-m-d");

        include_once "db_connection.php";
        $connection = connectToDB("website1");

        #Creating and adding a THREAD with all the needed information
        $sql = "INSERT INTO thread (thread_user_id, thread_text, thread_date) VALUES ('$user_id','$text','$today')";
        $result = mysqli_query($connection, $sql);

        header("Location: homepage.php");
    }
}
?>