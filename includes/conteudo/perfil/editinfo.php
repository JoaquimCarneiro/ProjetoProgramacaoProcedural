<div class="perfil">
    <h2>Alterar Informação de perfil</h2>
    <form action="/perfil/editinfo/" method="post">
        <fieldset class="input_field">
            <label for="nome">Nome</label>
            <input class=
                   ' <?php if(isset($form_error['nome'])) {echo " form_error";}?> '
                   type="text" id="nome" name="nome" placeholder="Nome" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['nome'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="sobrenome">Sobrenome</label>
            <input class=
                   ' <?php if(isset($form_error['sobrenome'])) {echo " form_error";}?> '
                   type="text" id="sobrenome" name="sobrenome" placeholder="Sobrenome" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['sobrenome'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="nascimento">Data de nascimento</label>
            <input class=
                   ' <?php if(isset($form_error['sobrenome'])) {echo " form_error";}?> '
                   type="date" id="nascimento" name="nascimento" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['sobrenome'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="nacionalidade">Nacionalidade</label>
            <input class=
                   ' <?php if(isset($form_error['nacionalidade'])) {echo " form_error";}?> '
                   type="text" id="nacionalidade" name="nacionalidade" placeholder="Nacionalidade" value=
                   '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['nacionalidade'];}?>'>
        </fieldset>
        <fieldset class="input_field">
            <label for="genero">Genero</label>
            <input
                class=
                ' <?php if(isset($form_error['genero'])) {echo " form_error";}?> '
                type="text" id="genero" name="genero" placeholder="Repetir palavra passe" value=
                '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['genero'];}?>'>
        </fieldset>
        <fieldset>
            <button class="submit" name="submit" value="editinfo">Alterar</button>
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