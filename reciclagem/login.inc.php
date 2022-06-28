<?php
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $pwd = $_POST['password'];

    require_once 'dbh.inc.php';
    require_once 'funcoes.inc.php';

    /* error handlers */

    if(emptyInputLogin($username, $pwd) !== false){
        header("location: ../../index.php?pag=login&error=emptyinput");
        exit();
    }
    /* fazer o resto das verificações ... */

    /* verificar utilizador */
    loginUser($conn, $username, $pwd );

}else{
    header("location: ../../index.php?pag=login&erros");
    exit();
}