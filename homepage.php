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

                if(isset($_SESSION["username"])){
                    echo "Hello ".$_SESSION["username"] . "!";
                }else{
                    echo "[YOU ARE NOT LOGGED IN] ";
                    echo '<a href="index.php">LOGIN PAGE</a>';
                }
            
                ?>
            
            </h1>
            <h1 style="text-align: right;">
                <?php

                    if(isset($_SESSION["username"])){
                        echo '<a href="index.php">LOGOUT</a>';
                    }

                ?>
            </h1>
        </div>
    </header>

    <div class="wrapper" style="background-color: aquamarine;">
            
            <?php
            
                    include_once "searchDB.php";
                    $database = getThreads();
                    $thread_info;
                    $idx = 0;
                    /*
                    while($idx < sizeof($database)){
                        echo "[$idx]" . $database[$idx][0] . "<br>";
                        $idx++;
                    }*/
            while($idx <= sizeof($database)){ ?>
            <div class="wrapper">
                <?php
                    if(getThreadInfo($idx+1) != NULL){
                        try {
                            $thread_info = getThreadInfo($idx+1);
                            echo "From: " . whoPosted($idx+1) . "<br>";
        
                            echo "[". ($idx+1) . "] " . $thread_info["thread_text"] . "<br>";
                            echo "";
                        } catch (\Throwable $e) {
                            echo "ERROR";
                        }
                    }else{
                        echo "POST ELIMINATED";
                    }
                    
                    $idx++;
                ?>
            </div>
            <?php }?>
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
    
    if(isset($_POST["post"])){
        
        $text = $_POST["text"];

        include_once "searchDB.php";
        $user_id = getUserID($_SESSION["username"]);

        $today = date("Y-m-d");

        include_once "db_connection.php";
        $connection = connectToDB("website1");


        $sql = "INSERT INTO thread (user_id, thread_text, thread_date) VALUES ('$user_id','$text','$today')";
        $result = mysqli_query($connection,$sql);
        header("Location: homepage.php");
        var_dump($result);
        echo $result . "caio";
    }else{
        echo "NON";
    }
?>