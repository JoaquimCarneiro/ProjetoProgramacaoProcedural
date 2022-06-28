<div class="login">
    <h2>Entrar</h2>
    <form action="?pag=login" method="post">
        <fieldset class="input_field">
            <label for="login_user">Utilizador</label>
            <input class=
                   ' <?php if(isset($form_error['username'])) {echo " form_error";}?> '
                   type="text" id="login_pwd" name="username" placeholder="Utilizador/email" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['username'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="login_pwd">Password</label>
            <input class=
                   ' <?php if(isset($form_error['password'])) {echo " form_error";}?> '
                   type="password" id="login_pwd" name="password" placeholder="Palavra passe" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['password'];}?>'>
        </fieldset>
        <fieldset>
            <button class="submit" name="submit" value="login">Entrar</button>
        </fieldset>
    </form>
    <?php
    if(isset($form_error) && $form_error['num_error'] != 0){
        echo "<p>O formulário tem ".$form_error['num_error']." erros.</p>";
        if(isset($form_error['credenciais'])){
            echo "<ul class='lista_erros'><li>".$form_error['credenciais']."</li>";
            if (!HIDE_CREDENCIALS){
                if (isset($form_error['username'])){echo "<li>".$form_error['username']."</li>";}
                if (isset($form_error['password'])){echo "<li>".$form_error['password']."</li>";}
            }
            echo "</ul>";
        }else{
            echo "<ul class='lista_erros'><li>Campos inválidos</li>";
            if (isset($form_error['username'])){echo "<li>".$form_error['username']."</li>";}
            if (isset($form_error['password'])){echo "<li>".$form_error['password']."</li>";}
            echo "</ul>";
        }
    }
    ?>
</div>