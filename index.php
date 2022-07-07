<?php
    /* incluir funções, determinar página e processar formulários */
    session_start();
    require_once "includes/sistema/constants.inc.php";
    include_once "includes/sistema/funcoes.inc.php";
    require_once "includes/sistema/dbh.inc.php";
    $paginas = ["home", "login", "register", "recover", "reset", "confirm", "logout", "about", "blog", "perfil"];

    //array com categorias e página do site a partir do get
    $urlList = manageUrl();
    $pagina_atual = $urlList[0];

    /* se página for um formulário e existir um POST->submit
     * incluir o script de processamento de formulários
     * - Processa formulários e devolve erros/mensagems
     * */
    if((
        $pagina_atual == 'login' ||
        $pagina_atual == 'register' ||
        $pagina_atual == 'recover' ||
        $pagina_atual == 'reset'
        )
        && isset($_POST['submit'])
    )
    {
        include "includes/sistema/process.inc.php";
    }
    /* Logout */
    if($pagina_atual == "logout"){

        session_unset();
        session_destroy();
        header("location:".SITE_ROOT);
    }
    /* Confirm User */
    if($pagina_atual == "confirm"){
        include "includes/sistema/confirm_process.inc.php";
    }

    /* cabeçalho HTML */
    include_once "includes/html/head.php";

    /* menu */
    include_once "includes/html/menu.php";
?>
    <div class="wrapper">
<?php
    /* Conteudo */
    if (in_array($pagina_atual, $paginas)){
        include "includes/conteudo/".$pagina_atual.".php";
    }else{
        include "includes/conteudo/erro.php";
    }
?>
    </div>
<?php
    /* Terminação HTML/JS */
    include_once "includes/html/foot.php";
