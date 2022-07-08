<main>
<div class="perfil">
    <h3>Alterar Nome de utilizador</h3>
    <form action="/perfil/editlogin/" method="post">
        <fieldset class="input_field">
            <label for="nome">Nome</label>
            <input class=
                   ' <?php if(isset($form_error['nome'])) {echo " form_error";}?> '
                   type="text" id="nome" name="nomeUtilizador" placeholder="Nome" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['nome'];}?>'>
        </fieldset>
        <fieldset>
            <button class="submit" name="submit" value="editlogin">Alterar</button>
        </fieldset>
    </form>
    <?php
    if (isset($form_error) && $form_error['num_error'] != 0 && $form_error['form'] == "editlogin"){
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
<div class="perfil">
    <h3>Nova password</h3>
    <form action="/perfil/editlogin/" method="post">
        <fieldset class="input_field">
            <label for="password">Password antiga</label>
            <input class=
                   ' <?php if(isset($form_error['nome'])) {echo " form_error";}?> '
                   type="password" id="password" name="oldpassword" placeholder="Password Antiga" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['nome'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="nova_password">Nova Password</label>
            <input class=
                   ' <?php if(isset($form_error['sobrenome'])) {echo " form_error";}?> '
                   type="password" id="nova_password" name="nova_password" placeholder="Nova password" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['sobrenome'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="confirm_password">Confirmar nova password</label>
            <input class=
                   ' <?php if(isset($form_error['sobrenome'])) {echo " form_error";}?> '
                   type="password" id="confirm_password" name="password_confirm" placeholder="Confirmar nova password"  value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['sobrenome'];}?>'>
        </fieldset>
        <fieldset>
            <button class="submit" name="submit" value="editlogin_pwd">Alterar</button>
        </fieldset>
    </form>
    <?php
    if (isset($form_error) && $form_error['num_error'] != 0 && $form_error['form'] == "editlogin_pwd"){
        echo "<p>O formulário tem ".$form_error['num_error']." erros.</p>";
        echo "<ul class='lista_erros'><li>Campos inválidos</li>";
        if (isset($form_error['password'])){echo "<li>".$form_error['password']."</li>";}
        if (isset($form_error['novapassword'])){echo "<li>".$form_error['novapassword']."</li>";}
        if (isset($form_error['passwordconfirm'])){echo "<li>".$form_error['passwordconfirm']."</li>";}
        echo "</ul>";
    }
    ?>
</div>
</main>