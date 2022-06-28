<?php
/*
 * função que cria as ligações do menu principal, incluindo quando a ligação deixa de o ser,
 * passando a ser uma etiqueta do tipo span, quando é, por exemplo, uma ligação ativa.
 * */
function menu_link($pagina_atual, $nome, $link): void{
    echo "<li>";
    if($pagina_atual == $link){
        echo "<span class='activelink'>$nome</span>";
    }else{
        echo "<a class='link' href='?pag=$link'>$nome</a>";
    }
    echo "</li>";
}

