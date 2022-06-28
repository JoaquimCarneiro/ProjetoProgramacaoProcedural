<?php
if (isset($_POST['submit'])){
    /* post vars */
    $name = $_POST['completeName'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    //echo $name."<br>".$username."<br>".$email."<br>".$password."<br>".$password_repeat;

    require_once "dbh.inc.php";
    require_once "funcoes.inc.php";

    if(emptyInputSignUp($name, $username, $email, $password, $password_repeat) !== false){
        header("location: ../../index.php?pag=register&error=emptyinput");
        exit();
    }
    if(invalidUid($username) !== false){
        header("location: ../../index.php?pag=register&error=invaliduserid");
        exit();
    }
    if(invalidEmail($email) !== false){
        header("location: ../../index.php?pag=register&error=invalidemail");
        exit();
    }
    if(pwdMatch($password, $password_repeat) !== false){
        header("location: ../../index.php?pag=register&error=passwordontmatch");
        exit();
    }
    if(uidExists($conn, $username, $email) !== false){
        header("location: ../../index.php?pag=register&error=usernametaken");
        exit();
    }

    createUser($conn, $name, $username, $email, $password);

}else{
    header("location: ../../index.php?pag=register");
    exit();
}