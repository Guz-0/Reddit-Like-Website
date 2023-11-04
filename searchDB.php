<?php


### EVERY FUNCTION DOES WHAT THE ITS NAME SAYS ###

function searchCombo($username, $password)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT * FROM user";
    $result = mysqli_query($connection, $sql);
    $database = mysqli_fetch_all($result, MYSQLI_ASSOC);
    try {
        $idx = 0;
        $found = false;
        $lenght = sizeof($database);
        while ($idx < $lenght) {

            $usernamesDB = $database[$idx]['user_name'];
            $passwordsDB = $database[$idx]['user_password'];

            $condition = ($username == $usernamesDB) && (password_verify($password, $passwordsDB));

            //echo "<br> ${idx} USERNAME: " . $username . " | PASSWORD: " . $password ."<br>" ;

            if ($condition) {
                $found = true;
                //echo $username . $password;
                return $found;
            }
            $idx++;
        }
    } catch (\Throwable $th) {
        throw $th;
    }
    return $found;
}


function searchUser($username)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT user_name FROM user";
    $result = mysqli_query($connection, $sql);
    $usernameDB = mysqli_fetch_all($result);

    $flag = false;

    try {
        $idx = 0;

        while ($idx < sizeof($usernameDB)) {
            $usernameFromDB = $usernameDB[$idx][0];
            $condition = $usernameFromDB == $username;
            if ($condition) {
                $flag = true;
                //echo $flag;
                return $flag;
            }
            $idx++;
        }
    } catch (Exception $e) {
        throw $e;
    }
    return $flag;
}


function insertUser($us, $pw)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");
    $today = date("Y-m-d");

    $pwHashed = password_hash($pw, PASSWORD_BCRYPT);

    $sql = "INSERT INTO user (user_id, user_name, user_password, user_reg_date) VALUES (NULL, '$us', '$pwHashed','$today')";
    mysqli_query($connection, $sql);

    //var_dump(mysqli_store_result($connection,MYSQLI_STORE_RESULT_COPY_DATA));
    //echo $connection->error;
}

function getThreads()
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT * FROM thread";
    $result = mysqli_query($connection, $sql);
    $db = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $db;
}

function whoPosted($thread_id)
{
    include_once "db_connection.php";

    $connection = connectToDB("website1");

    try {
        $sql = "SELECT thread_user_id FROM thread WHERE thread_id = '$thread_id'";
        $result = mysqli_query($connection, $sql);
        $user_id = mysqli_fetch_all($result);

        if (isset($user_id[0][0])) {
            $user_id_converted = $user_id[0][0];
        } else {
            return false;
        }


        $sql = "SELECT user_name FROM user WHERE user_id = '$user_id_converted' ";
        $result = mysqli_query($connection, $sql);
        $user_name = mysqli_fetch_all($result);
        $user_name_converted = $user_name[0][0];

        return $user_name_converted;
    } catch (\Throwable $th) {
        return "eror";
    }
}

function getUserID($user_name)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $result = mysqli_query($connection, $sql);
    $fetched_result = mysqli_fetch_all($result);
    return $fetched_result[0][0];
}

function getThreadInfo($thread_id)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT * FROM thread WHERE thread_id = '$thread_id'";
    $result = mysqli_query($connection, $sql);
    $db = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (isset($db[0]['thread_id'])) {
        $info["thread_id"] = $db[0]['thread_id'];
        $info["user_id"] = $db[0]['thread_user_id'];
        $info["thread_text"] = $db[0]['thread_text'];
        $info["thread_date"] = $db[0]['thread_date'];
    } else {
        return null;
    }


    return $info;
}
