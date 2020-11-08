<?php
    include("../mysql.php");

    //make sure we have the user & pass:
    $username;
    $password;

    if (isset($_POST["tfUsername"])) {
        $username = $_POST["tfUsername"];
        $password = $_POST["tfPassword"];
    } else { 
        exit;
    }

    //Check the users table
    $sql = "select id, password, admin from rex.users where name='$username' limit 1";
    $statement = $db->prepare($sql);
    $statement->execute();

    $data = $statement->fetchObject();

    if (password_verify($password, $data->password)) {
        echo "Password ok";
        $_SESSION["userID"] = $data->id;
        $_SESSION["admin"] = $data->admin;
        header("Location: /index.php");
    } else {
        //echo password_hash($password, PASSWORD_BCRYPT);
        header("Location: /index.php?loginError=Incorrect password");
    }
?>