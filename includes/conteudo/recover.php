<div class="login">
    <h2>Recuperar Password</h2>
    <form action="/recover/" method="post">
        <fieldset class="input_field">
            <label for="login_user">Utilizador</label>
            <input class=
                   ' <?php if(isset($form_error['username'])) {echo " form_error";}?> '
                   type="text" id="login_user" name="username" placeholder="Utilizador/email" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['username'];}?>'>
        </fieldset>
        <fieldset>
            <button class="submit" name="submit" value="recover">Recuperar</button>
        </fieldset>
    </form>
    <?php
    /* isto tem que ser revisto */
    if(isset($form_error) && $form_error['num_error'] != 0){
        echo "<p>O formulário tem ".$form_error['num_error']." erros.</p>";
        echo "<ul class='lista_erros'>";
        if(isset($form_error['credenciais'])){
            echo "<li>".$form_error['credenciais']."</li>";
            if (!HIDE_CREDENCIALS){
                if (isset($form_error['username'])){echo "<li>".$form_error['username']."</li>";}
                if (isset($form_error['password'])){echo "<li>".$form_error['password']."</li>";}
            }
        }else{
            echo "<li>Campos inválidos</li>";
            if (isset($form_error['username'])){echo "<li>".$form_error['username']."</li>";}
            if (isset($form_error['password'])){echo "<li>".$form_error['password']."</li>";}
        }
        echo "</ul>";
    }
    ?>
</div>