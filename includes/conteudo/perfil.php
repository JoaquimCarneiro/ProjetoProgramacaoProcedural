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

        /*user level info*/
        $userlvl_info = getUserLvl($conn, $userLvl);

        $userlvlName = $userlvl_info['levelname'];
        $userlvlDiscription = $userlvl_info['discription'];

        /*echo "<pre>";
        print_r($userlvl_info);
        echo "</pre>";*/
    }
?>
    <div class="contentor-pag">
        <aside><h3>Menu</h3></aside>
        <div class="conteudo">
            <h2>Area de utilizador</h2>
            <h3>Benvindo, <?php echo $username; ?></h3>
            <table class="perfil">
                <thead>
                <tr><td colspan='2'>Dados de login</td></tr>
                </thead>
                <tbody>
                <tr><td>Utilizador</td><td><?php echo $username; ?></td></tr>
                <tr><td>Email</td><td><?php echo $useremail; ?></td></tr>
                <tr><td>Nível</td><td><?php echo "<p>".$userLvl." - ".$userlvlName."</p><p>".$userlvlDiscription."</p>"; ?></td></tr>
                </tbody>
            </table>

            <h2>Dados pessoais</h2>

        </div>
    </div>
<?php
}else{
    //utilizador não logado, enviar de volta para a pagina inicial
    header("location: ".SITE_ROOT);
}
?>