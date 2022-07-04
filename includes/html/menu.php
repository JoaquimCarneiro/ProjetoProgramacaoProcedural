<nav>
    <div class="wrapper">
        <a class="logo" href="<?php echo SITE_ROOT ?>">
            <svg id="imglogo" viewBox="0 0 200 200">
                <rect x="25" y="25" width="150" height="150"
                      style="fill:none;stroke:darkorange;stroke-width:50;" />
            </svg>
            <h2><?php echo SITE_TITLE; ?></h2>
        </a>
        <ul class="menu">
            <?php
                menu_link($pagina_atual, "Sobre", "about");
                menu_link($pagina_atual, "Blog", "blog");
                if (isset($_SESSION['userId'])){
                    menu_link($pagina_atual, "Perfil", "perfil");
                    menu_link($pagina_atual, "Sair", "logout");
                }else{
                    menu_link($pagina_atual, "Registar", "register");
                    menu_link($pagina_atual, "Recuperar", "recover");
                    menu_link($pagina_atual, "Entrar", "login");
                }
                ?>
        </ul>
    </div>
</nav>
