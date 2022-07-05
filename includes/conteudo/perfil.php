<?php
//determinar se o utilizador está logado e qual é o nível de utilizador
if(isset($_SESSION['userLvl'])){
    $sessionUid = $_SESSION['userUid'];
    require_once "includes/sistema/dbh.inc.php";

    if(!$utilizador = uidExists($conn,$sessionUid, $sessionUid)){
        echo "fail";
    }else{
        /* variáveis de dados do utilizador para login */
        $userid = $utilizador['usersId'];
        $username = $utilizador['usersUid'];
        $useremail = $utilizador['usersEmail'];
        $userLvl = $utilizador['userlevel'];

        /*echo "<pre>";
        print_r($utilizador);
        echo "</pre>";*/
    }
?>
    <div>
        <h2>Dados do utilizador</h2>
        <table class="perfil">
            <thead>
                <tr><td colspan='2'>Dados de login</td></tr>
            </thead>
            <tbody>
                <tr><td>Utilizador</td><td><?php echo $username ?></td></tr>
                <tr><td>Email</td><td><?php echo $useremail ?></td></tr>
                <tr><td>Nível</td><td><?php echo $userLvl ?></td></tr>
            </tbody>
        </table>

        <h2>Dados pessoais</h2>
    </div>
<?php
}else{
    //utilizador não logado, enviar de volta para a pagina inicial
    header("location: ".SITE_ROOT);
}
?>