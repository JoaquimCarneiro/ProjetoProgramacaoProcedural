<?php

/*in process.inc.php*/
if($_POST['submit'] == 'recover'){
    /* credenciais: apesar de se chamar username os dados podem ser utilizador ou username*/
    $username = $_POST['username'];

    /* Cria um token em binário e cria uma string em hexadecimal para poder ser utilizada num URL
     * random_bytes pede um try catch
     * */
    $token_selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    /* Link contendo os tokens */
    $url = SITE_ROOT."reset/".$token_selector."/".bin2hex($token)."/";

    /* data de expiração dos tokens - data em formato UNIX + 1 hora*/
    $expires = date("U") + 1800;

    /* ver se utilizador existe e devolver os dados */
    $form_error = [];
    $num_error = 0;

    /* verificar se campo não está vazio */
    if (empty($username)){
        $form_error['username'] = "Utilizador obrigatório";
        $num_error++;

        /* se campo não estiver vazio porcurar utilizador na base de dados e devolver dados */
    }else if (!$uidExists = uidExists($conn, $username, $username)){
        $form_error['username'] = "Utilizador não existe";
        $num_error ++;
    }

    $form_error['num_error'] = $num_error;

    if ($num_error == 0){
        /* Atribui o email do uid exists a um email*/
        $email = $uidExists['usersEmail'];
        $userId = $uidExists['usersUid'];

        /* Limpar qualque token pertencente ao utilizador*/
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

        mysqli_stmt_close($stmt);
        mysqli_close($conn);

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
    }
}

/*$form_error = [];
            $num_error = 0;

            // verificar se campos não estão vazios
            if (empty($password)){
                $form_error['password'] = "Password obrigatória";
                $num_error++;
            }
            if (empty($password_confirm)){
                $form_error['confirm_password'] = "Confirmação de password obrigatória";
                $num_error++;
            }
            // Falta a verificação que as passwords são iguais

            if($num_error == 0){//se o formulário não tiver erros
                $selector = $urlList[1];
                $token = $urlList[2];

                $currentDate = date("U");

                $sql = "SELECT * FROM tokens WHERE tokenSelector = ? AND expires >= ?;"; //expires não necessita de ? pode-se usar a variavel diretamente
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    // precisa de melhor formato de erro
                    echo "erro a preparar a query INSERT";
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
                    mysqli_stmt_execute($stmt);

                    $resultado = mysqli_stmt_get_result($stmt);
                    if(!$row = mysqli_fetch_assoc($resultado)){//não ha registo ou a data é inválida
                        echo "Pedido inválido ou expirado.";
                        exit();
                    }else{
                        //volta a converter o token para binario
                        $tokenbin = hex2bin($token);
                        //compara com os dados da base de dados(row)
                        $verificaToken = password_verify($tokenbin, $row['token']);
                        if (!$verificaToken){
                            echo "Tokens inválidos.";
                            exit();
                        }else{
                            //email que está na tabela de tokens
                            $email = $row['email'];

                            $sql = "SELECT * FROM users WHERE usersEmail = ?;";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt, $sql)){
                                // precisa de melhor formato de erro
                                echo "erro a preparar a query select modifica email";
                                exit();
                            }else{
                                mysqli_stmt_bind_param($stmt, "s", $email);
                                mysqli_stmt_execute($stmt);
                                $resultado = mysqli_stmt_get_result($stmt);
                                if(!$row = mysqli_fetch_assoc($resultado)){
                                    echo "erro a preparar a query select modifica email2";
                                    exit();
                                }else{
                                    $sql = "UPDATE users SET usersPwd = ? WHERE usersEmail = ?";
                                    $stmt = mysqli_stmt_init($conn);
                                    if(!mysqli_stmt_prepare($stmt, $sql)){
                                        // precisa de melhor formato de erro
                                        echo "erro a preparar a query modifica password";
                                        exit();
                                    }else {
                                        $newPassword = password_hash($password, PASSWORD_DEFAULT);
                                        mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);
                                        mysqli_stmt_execute($stmt);

                                        $sql = "DELETE FROM tokens WHERE email = ?;";
                                        $stmt = mysqli_stmt_init($conn);
                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            //* precisa de melhor formato de erro
                                            echo "erro a preparar a query DELETE2";
                                            exit();
                                        }else{
                                            mysqli_stmt_bind_param($stmt, "s", $email);
                                            mysqli_stmt_execute($stmt);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
            }
            $form_error['num_error'] = $num_error;*/

/*echo $urlList[1]."/".$urlList[1];
echo "reset";*/