<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <form action="index.php" method="POST" class="wrapper">
        <div class="divs">
            <h2>LOGIN</h2>
        </div>

        <div class="divs">
            <label for="">USERNAME</label><br>
            <input type="text" name="username" id=""><br>
        </div>
        
        <div class="divs">
            <label for="">PASSWORD</label><br>
            <input type="password" name="psw" id=""><br>
        </div>
        
        <div class="divs">
            <input type="submit" name="submit"><br>
            <label for="">Not registered? Register <a href="register.php">HERE</a></label><br>
            <a href="homepage.php">HOMEPAGE</a>
        </div>

    </form>

    

</body>
</html>

<?php

    include "searchDB.php";

    session_start();
    session_destroy();

    #Checking if the LOGIN DATA is right and then redirecting the USER to the HOMEPAGE
    if(isset($_POST["submit"])){

        session_start();
        

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);

        $psw = $_POST["psw"];

        if(empty($username) || empty($psw)){
            echo '<center style="padding: 20px;">FILL EVERY FIELD</center>';
        }else{
            if(searchCombo($username,$psw)){
                header('Location: homepage.php');
            }else{
                echo '<center style="padding: 20px;">USERNAME OR PASSWORD WRONG</center>';
            }
        }

        $_SESSION["username"] = $username;
        

        
    }else{
        echo '<center style="padding: 20px;">NOT SUBMITTED YET</center>';
    }

?>