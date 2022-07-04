<?php
/****************************************************************************************************
 * Processar campos do formulário de login devolve um array com o número de erros e campos de erro. *
 * Devolve sempre o numero de erros nem que este seja zero -> $form_error['num_error']              *
 ****************************************************************************************************/
function processLogin($username, $password, $conn):array {
    /* atribuir campos */
    /* variaveis de erro */
    $form_error = [];
    $num_error = 0;

    /***** Verificações ******/
    /* username */
    if(empty($username)){
        $form_error['username'] = "Utilizador obrigatório";
        $num_error ++;
    }
    /* password */
    if(empty($password)){
        $form_error['password'] = "Password obrigatória";
        $num_error ++;
    }

    /* formulário não tem erros - só executa se formulário não tiver erros
         *  -> tentar logar utilizador
         *  -> se credenciais não forem válidas devolve erro (função loginuser) */
    if ($num_error == 0){
        /*$form_error = loginUser($conn, $username, $password);
        $num_error ++;*/
        $uidExists = uidExists($conn, $username, $username);

        if($uidExists === false){ // utilizador não existe na base de dades
            $form_error['username'] = "Nome de utilizador não existe";
            $num_error ++;

        }else{ // utilizador existe na base de dados
            // adequirir password
            $pwdHashed = $uidExists["usersPwd"];
            //comparar password (função interna PHP)
            $checkPwd = password_verify($password, $pwdHashed);
            if ($checkPwd === false){
                $form_error['password'] = "Password inválida";
                $num_error ++;
            }
        }

        /* Se o login falhar criar um erro generico, caso contrário iniciar a sessão com dados do utilizador
         * este erro genérico é um erro que pode ser subdividido em dois erros mais específicos
         * se existe erro nos dados de utilizador cria variavel credenciais para poder controlar
         * se mostra qual dado falhou na verificação, estes erros não devem ser usados em produção
         * */
        if ($num_error != 0){
            $form_error['credenciais'] = "Dados de utilizador inválidos";
        }else{
            session_start();
            $_SESSION['userId'] = $uidExists["usersId"];
            $_SESSION['userUid'] = $uidExists["usersUid"];
            $_SESSION['userLvl'] = $uidExists["userlevel"];
            header("location: ".SITE_ROOT);
        }
    }

    // se formulário tiver erros devolver variaveis originais
    if ($num_error != 0){
        $form_error['originais'] = ['username' => $username, 'password' => $password];
    }
    $form_error['num_error'] = $num_error;
    return $form_error;
}

/**************************************************************
 * Processa campos do formulário register e cria novo registo *
 **************************************************************/
function processRegister($username, $email, $password, $password_repeat, $conn):array{
    $form_error = [];
    $num_error = 0;

    /***** Verificações *****/
    /* Nome Inteiro do utilizador - só necessita de ser verificado se não está vazio
     * (campo a ser removido do formulário de registo) */
    /*if (empty($name)){
        $form_error['completename'] = "Nome de utilizador obrigatório";
        $num_error++;
    }*/

    /* Utilizador */
    if (empty($username)){
        $form_error['username'] = "Utilizador obrigatório";
        $num_error++;
    }else if(invalidUid($username) !== false){ // verifica formato
        $form_error['username'] = "Utilizador inválido";
        $num_error++;
    }

    /* email */
    if (empty($email)){
        $form_error['email'] = "Email obrigatório";
        $num_error++;
    }else if(invalidEmail($email) !== false){ // verifica formato
        $form_error['email'] = "Email inválido";
        $num_error++;
    }

    /* Verifica passwords
     * só está a verificar se as passwords foram introduzidas e a comparar */
    if (empty($password) || empty($password_repeat)){
        if (empty($password)){
            $form_error['password'] = "Password obrigatória";
            $num_error++;
        }
        if (empty($password_repeat)){
            $form_error['password_repeat'] = "Confirmação de password obrigatória";
            $num_error++;
        }
    }else if(pwdMatch($password, $password_repeat) !== false){ // verifica se passwords são iguais
        $form_error['password'] = $form_error['password_repeat'] = "erro pass";
        $form_error['match_pass'] = "Passwords não são iguais";
        $num_error++;
    }

    /* Só verifica se existe utilizador e se os campos forem todos correctamente preenchidos */
    if ($num_error == 0){
        if(uidExists($conn, $username, $email) !== false){
            $form_error['username'] = $form_error['email'] = "erro pass";
            $form_error['userexists'] = "Utilizador/Email já existe";
            $num_error++;
        }else{
            //Cria utilizador - falta fazer um try/catch para que em caso de erro devolva o mes em vez de quebrar o script
            createUser($conn, $username, $email, $password);
            /* envia email - falta fazer verificação de que o email foi enviado*/
            if (REGISTER_SEND_EMAIL){
                /* tokens e link */
                /* Cria um token em binário e cria uma string em hexadecimal para poder ser utilizada num URL
                 * random_bytes pede um try catch
                 * */
                $token_selector = bin2hex(random_bytes(8));
                $token = random_bytes(32);

                /* Link contendo os tokens */
                $url = SITE_ROOT."confirm/".$token_selector."/".bin2hex($token)."/";

                /* data de expiração dos tokens - data em formato UNIX + 1 hora*/
                $expires = date("U") + 18000;

                /* tipo de token, neste caso recover. identifica onde foi gerado o token */
                $type = "register";

                /* Limpa tokens na BD */
                deleteTokenUser($conn, $email, "register");

                /* adiciona tokens á BD*/
                addToken($conn, $email, $token_selector, $token, $expires, $type);

                /* Variaveis para o email */
                $assunto = "Novo registo no site ".SITE_TITLE;
                $mensagem_html = "<p>Bem vindo ao site ".SITE_TITLE."! Acabou de fazer o seu registo. Para concluir o processo siga ou copie o link abaixo:</p>";
                $mensagem_html .= "<a href='".$url."'>".$url."</a>";
                $mensagem_txt = "Bem vindo ao site ".SITE_TITLE."! Acabou de fazer o seu registo. Para concluir o processo siga ou copie o link abaixo:\n";
                $mensagem_txt .= "$url";
                $emailregisto = conteudo_email($assunto, $mensagem_html, $mensagem_txt);

                /* remetente e nome de remetente tem que ser modificados*/
                envia_email(SMTP_USERNAME, SITE_TITLE,
                    $email, $username,
                    $assunto, $emailregisto['html'], $emailregisto['txt']);
            }

            header("location: ".SITE_ROOT);
        }
    }

    // se formulário tiver erros devolver variaveis originais
    if ($num_error != 0){
        //$name, $username, $email, $password, $password_repeat
        $form_error['originais'] = [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'password_repeat' => $password_repeat
        ];
    }
    $form_error['num_error'] = $num_error;
    return $form_error;
}
/**************************************************************
 * Processa campos do formulário recover                      *
 * - cria tokens para verificação de identidade               *
 * - envia email com link de recuperação                      *
 **************************************************************/
function processRecover($conn, $username):array{
    $form_error = [];
    $num_error = 0;

    /* credenciais: apesar de se chamar username os dados podem ser utilizador ou email*/
    //$username = $_POST['username'];

    /* verificar se campo não está vazio */
    if (empty($username)){
        $form_error['username'] = "Utilizador obrigatório";
        $num_error++;
        /* se campo não estiver vazio porcurar utilizador na base de dados e devolver dados */
    }else if (!$uidExists = uidExists($conn, $username, $username)){
        $form_error['username'] = "Utilizador não existe";
        $num_error ++;
    }

    if ($num_error == 0){
        /* Cria um token em binário e cria uma string em hexadecimal para poder ser utilizada num URL
         * random_bytes pede um try catch
         * */
        $token_selector = bin2hex(random_bytes(8));
        $token = random_bytes(32);

        /* Link contendo os tokens */
        $url = SITE_ROOT."reset/".$token_selector."/".bin2hex($token)."/";

        /* data de expiração dos tokens - data em formato UNIX + 1 hora*/
        $expires = date("U") + 18000;

        /* tipo de token, neste caso recover. identifica onde foi gerado o token */
        $type = "recover";

        /* email e nome do utilizador */
        $email = $uidExists['usersEmail'];
        $userId = $uidExists['usersUid'];

        /* Limpa tokens na BD */
        deleteTokenUser($conn, $email, "recover");

        /* adiciona tokens á BD*/
        addToken($conn, $email, $token_selector, $token, $expires, $type);

        /* ENVIA EMAIL */
        /* assunto */
        $assunto = "Recuperação de password no site ".SITE_TITLE;
        /* mensagem --> tem que ser feita função para formatar texto */
        $mensagem['html'] = "<p>Foi feito um pedido de recuperação para a sua conta, siga o link abaixo para criar uma nova password.</p>";
        $mensagem['html'] .= "<a href='".$url."'>".$url."</a>";
        $mensagem['txt'] = "Copie o seguinte link para criar uma nova password\n".$url;

        envia_email(SMTP_USERNAME, SITE_TITLE,
            $email, $userId,
            $assunto, $mensagem['html'], $mensagem['txt']);

        header("location: ".SITE_ROOT);
    }
    $form_error['num_error'] = $num_error;
    return $form_error;
}

/*****
 * Process reset
 * ATENÇÃO: o $urlist é um array de elementos obtidos a partir do url e criado no index.php atravéz da função manageUrl()
 * este url tem como index 0 oendereço da página (neste caso 'reset') e
 * pressupostamente o index 1 será o selector e o index 2 será o token
 *****/
function processReset($conn, $password, $password_confirm, $urlList):array{
    $form_error = [];
    $num_error = 0;

    /* Verificar campos do formulário */
    /* verificar se campos estã vazios */
    if (empty($password)){
        $form_error['password'] = "Password obrigatória";
        $num_error++;
    }
    if (empty($password_confirm)){
        $form_error['confirm_password'] = "Confirmação de password obrigatória";
        $num_error++;
    }
    /* só verificar validade dos campos se os campos não estiverem vazios */
    if($num_error == 0){
        /* comparar password e verificação */
        if ($password != $password_confirm){
            $form_error['password_confirmation'] = "Passwords não são iguais";
            $num_error++;
        }
    }
    /* So executa se campos forem totalmens validados */
    if ($num_error == 0){
        /* selector e token do url */
        $selector = $urlList[1];
        $token = $urlList[2];

        /* data actual em formato unix */
        $currentDate = date("U");

        /* Verificar se token existe na base de dados e devolve array com dados */
        $getToken = getTokenInfo($conn, $selector, $currentDate);
        if (isset($getToken['erro'])){
            $form_error['token_error'] = $getToken['erro'];
            $num_error++;
        }else{
            /* comparar o token com o token na base de dados*/
            /* o token tem que se do tipo recover */
            $tokenType = "recover";
            if($getToken['type'] != $tokenType){
                $form_error['token_error'] = "Tipo de token invalido.";
                $num_error++;
            }else{
                /* converter o token de volta para binário */
                $tokenbin = hex2bin($token);
                /* comparar tokens (url x BD) */
                $verificaToken = password_verify($tokenbin, $getToken['token']);
                if (!$verificaToken){
                    $form_error['token_error'] =  "Tokens inválidos.";
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
                $form_error['user_error'] = "Utilizador não existe";
                $num_error++;
            }
        }
        /* */
        if ($num_error == 0){
            $updatePwd = updatePwdByEmail($conn, $password, $email);
            if (isset($updatePwd['erro'])){
                $form_error['user_error'] = "Erro ao modificar password";
                $num_error++;
            }
        }

        /* apagagar token */
        if ($num_error == 0){
            deleteTokenUser($conn, $email, $tokenType);
        }

    }

    if ($num_error == 0){
        header("location: ".SITE_ROOT);
    }
    $form_error['originais']['password'] = $password;
    $form_error['originais']['confirm_password'] = $password_confirm;
    $form_error['num_error'] = $num_error;
    return $form_error;
}


/* Verificação de campos */
function invalidUid($username): bool{
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;

}

function invalidEmail($email): bool{
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}

function pwdMatch($password, $password_repeat): bool{
    if($password !== $password_repeat){
        $result = true;
    }else{
        $result = false;
    }
    return $result;
}