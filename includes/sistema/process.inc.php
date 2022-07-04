<?php
    if (isset($_POST['submit'])){
        //echo $_POST['submit'];

        require_once "dbh.inc.php";
        //require_once "funcoes.inc.php";
        require_once "process_funcoes.inc.php";
        require_once "mailer.inc.php";

        if ($_POST['submit'] == 'login'){
            $username = $_POST['username'];
            $password = $_POST['password'];

            /* Processar campos formulário de login */
            $form_error = processLogin($username, $password, $conn);

        }else if($_POST['submit'] == 'register'){
            //echo "hello is it me you are looking for";

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password_repeat'];

            $form_error = processRegister($username, $email, $password, $password_repeat, $conn);

        }else if($_POST['submit'] == 'recover'){
            /* credenciais: apesar de se chamar username os dados podem ser utilizador ou username*/
            $username = $_POST['username'];

            $form_error = processRecover($conn, $username);

        }else if($_POST['submit'] == 'reset') {
            /* campos do formulário */
            $password = $_POST['password'];
            $password_confirm = $_POST['confirm_password'];

            $form_error = [];
            $num_error = 0;

            /* verificar se campos não estão vazios */
            if (empty($password)){
                $form_error['password'] = "Password obrigatória";
                $num_error++;
            }
            if (empty($password_confirm)){
                $form_error['confirm_password'] = "Confirmação de password obrigatória";
                $num_error++;
            }
            /* Falta a verificação que as passwords são iguais */

            if($num_error == 0){//se o formulário não tiver erros
                $selector = $urlList[1];
                $token = $urlList[2];

                $currentDate = date("U");

                $sql = "SELECT * FROM tokens WHERE tokenSelector = ? AND expires >= ?;"; //expires não necessita de ? pode-se usar a variavel diretamente
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    /* precisa de melhor formato de erro */
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
                                /* precisa de melhor formato de erro */
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
                                        /* precisa de melhor formato de erro */
                                        echo "erro a preparar a query modifica password";
                                        exit();
                                    }else {
                                        $newPassword = password_hash($password, PASSWORD_DEFAULT);
                                        mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);
                                        mysqli_stmt_execute($stmt);

                                        $sql = "DELETE FROM tokens WHERE email = ?;";
                                        $stmt = mysqli_stmt_init($conn);
                                        if(!mysqli_stmt_prepare($stmt, $sql)){
                                            /* precisa de melhor formato de erro */
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
            $form_error['num_error'] = $num_error;

            /*echo $urlList[1]."/".$urlList[1];
            echo "reset";*/
        }else{
            header("location: ".SITE_ROOT."?error=illegalaccess");
        }
    }else{
        header("location: ".SITE_ROOT."?error=illegalaccess");
    }
