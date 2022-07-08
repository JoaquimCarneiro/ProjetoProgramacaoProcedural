<div class="contentor-home">
    <section class="index-intro">
        <h1>Esta é a página inicial</h1>
        <p>... Introdução ...</p>

        <?php
            /******************************************************************************************
             * Estas mensagens e erros tem que ser limpas e tranformadas numa funcionalidade
             * ou apagadas completamente do sistema para que isto não se torne confuso e
             * para que não seja necessário abrir uma tag PHP só para fazer um comentário estupido...
             ******************************************************************************************/


        ?>
        <p><?php if(isset($message)){
                echo $message;
            } ?></p>
        <p><?php debug(false, $_SESSION); ?></p>
        <?php
            if(isset($mensagens)){print_r($mensagens);}
            if(isset($error_msg)){print_r($error_msg);}
        ?>
    </section>

    <section class="index-categories">
        <h2>Categorias exemplo</h2>
        <ul class="index-categories-lists">
            <li><h3>Banana</h3></li>
            <li><h3>Bimbo</h3></li>
            <li><h3>Miau</h3></li>
            <li><h3>Fluff</h3></li>
        </ul>
    </section>
</div>