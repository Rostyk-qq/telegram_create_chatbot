<?php
    // Get the data sent in the POST request
    if (empty($_POST['username']) && empty($_POST['user_chat_id'])) die('Params is empty!');

    $usernameTelegram = $_POST['username'];
    $user_chat_id = $_POST['user_chat_id'];


    $server = 'localhost';
    $username = 'root';
    $password = '';

    $sql = new mysqli($server, $username, $password);

    if (mysqli_connect_error()){
        die('Error' . mysqli_connect_error());
    }
    else{
        echo 'We created connection';
    }
    //create db
    $db = "CREATE DATABASE IF NOT EXISTS telegram_db";

    if (!($sql->query($db))){
        die('Error in creation database' . mysqli_connect_error());
    }


    // get dbname
    $dbMassive = explode(' ', $db);
    $dbName = $dbMassive[count($dbMassive) - 1];

    $sql = new mysqli($server, $username, $password, $dbName);

    // create table
    $table = 'CREATE TABLE IF NOT EXISTS users_telegram (
        id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(22) NOT NULL UNIQUE,
        chat_id VARCHAR(22) NOT NULL UNIQUE
    )'; // тут потірбно використовувати для значень username і chat_id unique(я для тесту прибрав)

    if (!mysqli_query($sql, $table)){
        die('Error' . mysqli_connect_error());
    }

    //add users
    $add = "INSERT INTO `users_telegram` (username, chat_id) VALUES ('$usernameTelegram', '$user_chat_id')";

    if (!mysqli_query($sql, $add)){
        die('Error' . mysqli_connect_error());
    }
    else {
        // get elements from db
        // if they exist
        // echo All went good

        $select = "SELECT * FROM `users_telegram` where username = '$usernameTelegram' and chat_id = '$user_chat_id'";
        $query = $sql->query($select);

        if ($query->num_rows > 0){
            while($mas = $query->fetch_assoc()){
                if (isset($mas['username']) && isset($mas['chat_id'])){
                    echo 'All went good';
                }
                else{
                    die('Get fields error' . mysqli_connect_error());
                }
            }
        }
        else{
            die('Get fields error' . mysqli_connect_error());
        }
    }
    mysqli_close($sql);
?>