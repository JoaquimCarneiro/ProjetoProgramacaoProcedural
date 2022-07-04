<div class="login">
    <h2>Registar</h2>
    <form action="/register/" method="post">
        <fieldset class="input_field">
            <label for="login_user">Utilizador</label>
            <input class=
                   ' <?php if(isset($form_error['username'])) {echo " form_error";}?> '
                    type="text" id="login_user" name="username" placeholder="Utilizador" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['username'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="login_email">Email</label>
            <input class=
                   ' <?php if(isset($form_error['email'])) {echo " form_error";}?> '
                    type="text" id="login_email" name="email" placeholder="Endereço de email" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['email'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="login_pwd">Password</label>
            <input class=
                   ' <?php if(isset($form_error['password'])) {echo " form_error";}?> '
                    type="password" id="login_pwd" name="password" placeholder="Palavra passe" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['password'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="login_pwd_repeat">Repetir Password</label>
            <input
                    class=
                    ' <?php if(isset($form_error['password_repeat'])) {echo " form_error";}?> '
                    type="password" id="login_pwd_repeat" name="password_repeat" placeholder="Repetir palavra passe" value=
                    '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['password_repeat'];}?>'>
        </fieldset>
        <fieldset>
            <button class="submit" name="submit" value="register">Registar</button>
        </fieldset>
    </form>
    <?php
        if (isset($form_error) && $form_error['num_error'] != 0){
            echo "<p>O formulário tem ".$form_error['num_error']." erros.</p>";
            echo "<ul class='lista_erros'><li>Campos inválidos</li>";
            if (isset($form_error['completename'])){echo "<li>".$form_error['completename']."</li>";}
            if (isset($form_error['username'])){echo "<li>".$form_error['username']."</li>";}
            if (isset($form_error['email'])){echo "<li>".$form_error['email']."</li>";}
            if (isset($form_error['match_pass'])){
                echo "<li>".$form_error['match_pass']."</li>";
            }else{
                if (isset($form_error['password'])){echo "<li>".$form_error['password']."</li>";}
                if (isset($form_error['password_repeat'])){echo "<li>".$form_error['password_repeat']."</li>";}
            }
            if (isset($form_error['userexists'])){echo "<li>".$form_error['userexists']."</li>";}
            echo "</ul>";
        }
    ?>
</div>
