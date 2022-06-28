<?php
/* REGISTER */

/*function emptyInputSignUp($name, $username, $email, $password, $password_repeat): bool{

    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($password_repeat)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}*/

/* LOGIN */
/*function emptyInputLogin($username, $pwd){
    if (empty($username) || empty($pwd)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}*/

/* Interações com base de dados
 * criar utilizador | verificar utilizador */




/* logar utilizador */
/*function loginUser($conn, $username, $pwd ){
    $uidExists = uidExists($conn, $username, $username);

    $num_error = 0;
    if($uidExists === false){ // utilizador não existe na base de dades
        //header("location: index.php?pag=login&error=wronglogin");
        $form_error['username'] = ["original" => $username, "mensagem" => "Nome de utilizador inválido"];
        $num_error ++;

    }else{ // utilizador existe na base de dados
        // adequirir password
        $pwdHashed = $uidExists["usersPwd"];
        //comparar password (função interna PHP)
        $checkPwd = password_verify($pwd, $pwdHashed);
        if ($checkPwd === false){
            $form_error['password'] = ["original" => $pwd, "mensagem" => "Password inválida"];
            $num_error ++;
        }
    }

    // o erro nos dados de login é um erro unico que pode ser subdividido em dois erros mais específicos
    if ($num_error != 0){
        $form_error['credenciais'] = "Dados de utilizador inválidos";
        if (!isset($form_error['username'])){
            $form_error['username'] = ["original" => $username];
        }
        if (!isset($form_error['password'])){
            $form_error['password'] = ["original" => $pwd];
        }
        $form_error['num_error'] = $num_error;
        return $form_error;
    }else{
        session_start();
        $_SESSION['userId'] = $uidExists["usersId"];
        $_SESSION['userUid'] = $uidExists["usersUid"];
        header("location:/");
        exit();
    }

}*/