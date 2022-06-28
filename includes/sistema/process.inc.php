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

        }elseif ($_POST['submit'] == 'register'){
            //echo "hello is it me you are looking for";

            $name = $_POST['completename'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_repeat = $_POST['password_repeat'];

            $form_error = processRegister($name, $username, $email, $password, $password_repeat, $conn);


        }else{
            header("location: ".SITE_ROOT."?error=illegalaccess");
        }
    }else{
        header("location: ".SITE_ROOT."?error=illegalaccess");
    }
