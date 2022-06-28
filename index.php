<?php
    /* incluir funções, determinar página e processar formulários */
    session_start();
    require_once "includes/sistema/constants.inc.php";
    $paginas = ["home", "login", "register", "about", "blog", "logout"];
    if(isset($_GET['pag'])){
        $pagina_atual = $_GET['pag'];
        if (empty($pagina_atual)){
            $pagina_atual = 'home';
        }else{
            if($pagina_atual[-1] == '/'){
                $pagina_atual = substr($pagina_atual, 0, -1);
            }
        }
        /* se página for um formulário incluir o script de processamento de formulários
         *  - Processa formulários e devolve erros/mensagems */
        if(($pagina_atual == 'login' || $pagina_atual == 'register') && isset($_POST['submit'])){
            include "includes/sistema/process.inc.php";
        }
        if($pagina_atual == "logout"){
            //include_once "includes/sistema/logout.inc.php";
            session_unset();
            session_destroy();
            header("location:".SITE_ROOT);
            exit();
        }
    }else{
        $pagina_atual = 'home';
    }
    include_once "includes/sistema/funcoes.inc.php";

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
    /* Terminação HTML */
    include_once "includes/html/foot.php";
