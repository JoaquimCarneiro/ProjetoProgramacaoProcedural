<?php
    if (isset($_POST['submit'])){
        //echo $_POST['submit'];

        //require_once "dbh.inc.php";
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
            // campos do formulário
            $password = $_POST['password'];
            $password_confirm = $_POST['confirm_password'];
            /* urlList vem do index*/
            $form_error = processReset($conn, $password, $password_confirm, $urlList);

        }else if($_POST['submit'] == 'editlogin') {
            $form_error = [];
            $num_error = 0;

            // campos do formulário e session
            $utilizador = $_POST['nomeUtilizador'];
            $userId = $_SESSION['userId'];

            if(empty($utilizador)){
                $form_error['username'] = "Utilizador obrigatório";
                $num_error ++;
            }else{
                if(invalidUid($utilizador)){
                    $form_error['username'] = "Formato de utilizador inválido";
                    $num_error ++;
                }
            }

            if($num_error != 0){
                $form_error['num_error'] = $num_error;
                //return $form_error;
            }else{
                if (uidExists($conn, $utilizador, $utilizador) !== false){
                    $form_error['username'] = "Utilizador já existe";
                    $num_error ++;

                }else{
                    updateUsenameById($conn, $utilizador, $userId);
                    $_SESSION['userUid'] = $utilizador;
                    header("location: /perfil/");
                }
            }

            $form_error['num_error'] = $num_error;
            $form_error['form'] = "editlogin";
            //return $form_error;
        }else if($_POST['submit'] == 'editlogin_pwd') {
            $form_error = [];
            $num_error = 0;

            $oldpassword = $_POST['oldpassword'];
            $novaPassword = $_POST['nova_password'];
            $password_confirm = $_POST['password_confirm'];
            $userUid = $_SESSION['userUid'];

            if(empty($oldpassword)){
                $form_error['password'] = "Password antiga obrigatória";
                $num_error ++;
            }
            if(empty($novaPassword)){
                $form_error['novapassword'] = "Password nova obrigatória";
                $num_error ++;
            }
            if(empty($password_confirm)){
                $form_error['passwordconfirm'] = "Password de confirmação obrigatória";
                $num_error ++;
            }
            if($num_error == 0){
                $row = uidExists($conn, $userUid, $userUid);
                if($row ==! false){
                    /* verifica password antiga */
                    //$hashedPassword = password_verify($password, $pwdHashed);
                    if(password_verify($oldpassword, $row['usersPwd'])){//passwords antiga confirma-se
                        if (pwdMatch($novaPassword, $password_confirm)){// nova password e confirmação falhou
                            $form_error['password_confirmation'] = "Confirmação de nova password falhou";
                            $num_error ++;
                        }else{
                            updatePwdByUid($conn, $novaPassword, $userUid);
                            header("location: /perfil/");
                        }
                    }else{
                        $form_error['password'] = "Password antiga errada";
                        $num_error ++;
                    }

                    print_r($row);
                }else{
                    $form_error['baduser'] = "User/session Error";
                }
            }

            $form_error['num_error'] = $num_error;
            $form_error['form'] = "editlogin_pwd";
            //return $form_error;
            exit();
        }else if($_POST['submit'] == 'editinfo') {
            //check if user has info in the table
            $userId = $_SESSION['userId'];

            /***** Gerir variaveis post - Faltam todo o tipo de verificações ******/

            $nome = $_POST['nome'];
            $sobreNome = $_POST['sobrenome'];
            /* Tipos de Dados MYSQL do tipo DATA tem que ter o formato específico ou NULL senão a query falha
             * este if pode ser substituido por um operador ternario: $result = condition ? value1 : value2; */
            $aniversario = !$_POST['nascimento'] ? NULL : $_POST['nascimento'];
            //if(!$_POST['nascimento']){ $aniversario = NULL;}else{$aniversario = $_POST['nascimento'];}
            $nacionalidade = !$_POST['nacionalidade'] ? NULL : $_POST['nacionalidade'];
            $genero = $_POST['genero'];

            setUpdateUserInfo($conn, $userId, $nome, $sobreNome, $aniversario, $nacionalidade, $genero);
            header("location: /perfil/");

            exit();
        }else if($_POST['submit'] == 'editfoto') {
            echo "editinfo<br>";
            // campos do formulário
            echo "<pre>";
            print_r($_POST);
            $file = $_FILES['file'];
            echo "file Array<br>";
            print_r($file);
            echo "</pre>";
            exit();
        }else{
            header("location: ".SITE_ROOT."?error=illegalaccess");
        }
    }else{
        header("location: ".SITE_ROOT."?error=illegalaccess");
    }
