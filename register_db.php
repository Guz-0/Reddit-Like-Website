<?php

    session_start();

    include_once "searchDB.php";

    $username = filter_input(INPUT_POST, "username",FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password",FILTER_SANITIZE_SPECIAL_CHARS);

    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;

    $condition = empty($username) || empty($password);

    if($condition){
        $_SESSION["error"] = "FILL EVERYTHING";
        //echo $username . $password;
        //echo "EMPTY";
        header("Location: register.php");
    }else{
        if(strlen($password) < 8){
            $_SESSION["error"] = "PASSWORD AT LEAST 8 CHARACTERS";
            header("Location: register.php");
        }
        else if(searchUser($username)){
            $_SESSION["error"] = "USERNAME ALREADY USED";
            header("Location: register.php");
        }
        else{
            insertUser($username,$password);
            header("Location: homepage.php");
        }
    }

?>