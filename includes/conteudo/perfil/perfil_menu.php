<h3>Perfil de Utilizador</h3>
<ul class="menu-perfil">
    <?php
        if (isset($urlList[1])){
            $link = $urlList[1];
        }else{
            $link = $pagina_atual;
        }
    ?>
    <?php menu_link($link, "Inicio", "perfil");?>
    <li class="menu-separador">Editar perfil</li>
    <?php

    if (isset($_SESSION['userId'])){
        if($_SESSION['userLvl'] >= 2){
            menu_link($link, "Dados de Login", "perfil/editlogin");
            menu_link($link, "Dados Pessoais", "perfil/editinfo");
            menu_link($link, "Foto de Perfil", "perfil/editfoto");
        }else{
            echo "<li>Utilizador não tem permições de edição</li>";
        }
    }
    ?>
</ul>