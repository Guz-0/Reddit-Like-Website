<?php

    session_start();
    session_destroy();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <form action="register_db.php" method="post" class="wrapper">
        <div class="divs">
            <h2>REGISTRATION</h2>
            <label for="">USERNAME</label><br>
            <input type="text" name="username" id="inp"><br>
        </div>

        <div class="divs">
            <label for="">PASSWORD</label><br>
            <input type="text" name="password" id="inp"><br>
        </div>

        <div class="divs">
            <input type="submit" name="" id="" value="Register">
            <p> <?php
                if(isset($_SESSION["error"])){
                    echo $_SESSION["error"];
                    //echo $_SESSION["username"] . $_SESSION["password"];
                }
            ?>
            </p>
            <a href="index.php">LOGIN</a>
        </div>
    </form>

</body>
</html>