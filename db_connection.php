<?php

    function connectToDB($dbName){
        $hostname_db = "localhost";
        $username_db = "root";
        $password_db = "";
        $database_db = $dbName;

        $connection = mysqli_connect($hostname_db, $username_db, $password_db, $database_db);

        if($connection->connect_error){
            die ("[CONNECTION TO DB FAILED " . $connection->connect_error . " ]");
        }

        //echo "<br>[CONNECTED TO DATABASE]<br>";
        return $connection;
    }
    


?>