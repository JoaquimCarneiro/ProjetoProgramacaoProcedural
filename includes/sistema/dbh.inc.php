<?php
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PWD, DB_NAME);
if (!$conn){
    die("Ligação falhou: ".mysqli_connect_error());
}

function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ".SITE_ROOT."?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        //codigo para login
        mysqli_stmt_close($stmt);
        return $row;
    }else{
        mysqli_stmt_close($stmt);
        return false;
    }

}

/* Criar utilizador */
function createUser($conn, $name, $username, $email, $password): void{
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ".SITE_ROOT."?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    /*header("location: ".SITE_ROOT);
    exit();*/
}