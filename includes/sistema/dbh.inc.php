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

/* Criar utilizador
 * Esta função precisa de devolver valores caso falhe */
function createUser($conn, $username, $email, $password): void{
    $userlevel = 1; //nível de utilizador por defeito no registo
    $sql = "INSERT INTO users ( usersEmail, usersUid, usersPwd, userlevel) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ".SITE_ROOT."?error=stmtfailed");
        exit();
    }

    /* encriptar password */
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $email, $username, $hashedPassword, $userlevel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* Apagar tokens se existir */
function deleteTokenUser($conn, $email): void{
    $sql = "DELETE FROM tokens WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        /* precisa de melhor formato de erro */
        echo "erro a preparar a query DELETE";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
    }
}

/* inserir token */
function addToken($conn, $email, $token_selector, $token, $expires):void{
    $sql = "INSERT INTO tokens (email, tokenSelector, token, expires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        /* precisa de melhor formato de erro */
        echo "erro a preparar a query INSERT";
        exit();
    }else{
        /* encriptar token */
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $email, $token_selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }
}