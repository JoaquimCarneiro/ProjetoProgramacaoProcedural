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
            // campos do formulário
            echo "editLogin<br>";
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();
        }else if($_POST['submit'] == 'editlogin_pwd') {
            // campos do formulário
            echo "editLogin_pwd<br>";
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit();
        }else if($_POST['submit'] == 'editinfo') {
            echo "editinfo<br>";
            // campos do formulário
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
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
