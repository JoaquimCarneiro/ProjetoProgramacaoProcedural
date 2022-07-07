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

        //echo $pagina_atual;
        //echo $urlList[0];
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
?>
        <div class="contentor-pag">
        <aside>

            <?php include "perfil/perfil_menu.php"; ?>
        </aside>
<?php
        if(count($urlList) == 1){
            include "perfil/perfil_home.php";
        }else{
            $perfil_sub = ["editlogin", "editinfo", "editfoto"];
            if(in_array($urlList[1], $perfil_sub)){
                include "perfil/".$urlList[1].".php";
            }else{
                include "erro.php";
            }

        }
    }
?>
    </div>

<?php

}else{
    //utilizador não logado, enviar de volta para a pagina inicial
    header("location: ".SITE_ROOT);
}
?>