<?php
/*
 * função que cria as ligações do menu principal, incluindo quando a ligação deixa de o ser,
 * passando a ser uma etiqueta do tipo span, quando é, por exemplo, uma ligação ativa.
 * */
function menu_link($pagina_atual, $nome, $link): void{
    if (strpos($link, "/")){
        $templink = explode("/", $link);
        $templink = end($templink);
    }else{
        $templink = $link;
    }
    echo "<li>";
    if($pagina_atual == $templink){
        echo "<span class='activelink'>$nome</span>";
    }else{
        echo "<a class='link' href='/".$link."/'>$nome</a>";
    }
    echo "</li>";
}

/* gerir url */
function manageUrl():array{

    if (empty($_GET['pag'])){
        $paginas[] = 'home';
    }else{
        $url = $_GET['pag'];
        if(substr($url, -1) == '/'){
            $url = substr($url, 0, -1);
        }
        $paginas = explode('/', $url);
    }
    return $paginas;
}

function debug($activo, $vars){
    if($activo){
        echo "<pre>";
        print_r($vars);
        echo "</pre>";
    }
}
