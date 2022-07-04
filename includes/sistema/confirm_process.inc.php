<?php
require_once "dbh.inc.php";

require_once "process_funcoes.inc.php";


$error_msg = [];
$num_error = 0;
/*nivel registado*/
$lvl = 2;

$selector = $urlList[1];
$token = $urlList[2];

/* data actual em formato unix */
$currentDate = date("U");

/* Verificar se token existe na base de dados e devolve array com dados */
$getToken = getTokenInfo($conn, $selector, $currentDate);
if (isset($getToken['erro'])){
    $error_msg['token_error'] = $getToken['erro'];
    $num_error++;
}else{
    /* comparar o token com o token na base de dados*/
    /* o token tem que se do tipo recover */
    $tokenType = "register";
    if($getToken['type'] != $tokenType){
        $error_msg['token_error'] = "Tipo de token invalido.";
        $num_error++;
    }else{
        /* converter o token de volta para binário */
        $tokenbin = hex2bin($token);
        /* comparar tokens (url x BD) */
        $verificaToken = password_verify($tokenbin, $getToken['token']);
        if (!$verificaToken){
            $error_msg['token_error'] =  "Tokens inválidos.";
            $num_error++;
        }else{
            $email = $getToken['email'];
        }
    }
}

/* Verificar que utilizador (email) existe na base de dados
 * Esta verificação não me parece necessária, de quelquer maneira...
 * Só executa se não existir nenhum erro */
if ($num_error == 0){
    $getUser = uidExists($conn, $email, $email);
    if (!$getUser){//uidExiste devolve false ou o array com os dados do utilizador
        $error_msg['user_error'] = "Utilizador não existe";
        $num_error++;
    }
}
/* */
if ($num_error == 0){
    $updateLvl = updateLvlByEmail($conn, $lvl, $email);
    if (isset($updateLvl['erro'])){
        $error_msg['user_error'] = "Erro ao modificar password";
        $num_error++;
    }
}

/* apagagar token */
if ($num_error == 0){
    deleteTokenUser($conn, $email, $tokenType);
}

// enviar mensagens e erros para a pagina principal
if($num_error == 0){
    header("location: ".SITE_ROOT."?User_confirm=sucesso");
}else{
    $error_msg['num_erro'] = $num_error;
    header("location: ".SITE_ROOT."?".http_build_query($error_msg));
}

