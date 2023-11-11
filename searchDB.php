<?php


### EVERY FUNCTION DOES WHAT THE ITS NAME SAYS ###

### NEED TO PUT mysqli_close($connection) AFTER FINISHING RETRIEVING DATA ###

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

    echo json_encode($db);
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
            return "USER ELIMINATED";
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

function getUserData($username)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT * FROM user WHERE user_name = '$username'";
    $result = mysqli_query($connection, $sql);
    $fetchedResult = mysqli_fetch_assoc($result);

    /*echo '<pre>';
    print_r($fetchedResult);
    echo $fetchedResult['user_id'];
    echo '</pre>';*/

    mysqli_close($connection);
    return $fetchedResult;
}

function addThread($user_id, $thread_text)
{
    if (strlen($thread_text) < 5) {
        echo "AT LEAST 5 CHARACTERS";
        return "AT LEAST 5 CHARACTERS";
    }

    include_once "db_connection.php";

    $response = false;

    $today = date("Y-m-d");

    $connection = connectToDB("website1");
    $sql = "INSERT INTO thread (thread_user_id, thread_text, thread_date) VALUES ('$user_id','$thread_text','$today')";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $response = "DATA SENT CORRECTLY";
    } else {
        $response = "DATA NOT SENT";
    }

    echo $response;
}

if (isset($_GET["action"])) {
    switch ($_GET["action"]) {
        case "searchCombo":
            searchCombo($_GET["username"], $_GET["password"]);
            break;

        case "getThreads":
            getThreads();
            break;

        case "addThread":
            addThread($_GET["user_id"], $_GET["thread_text"]);
            break;
    }
}
