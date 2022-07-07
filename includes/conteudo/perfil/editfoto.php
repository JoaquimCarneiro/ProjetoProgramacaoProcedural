<div class="perfil">
    <h2>Alterar foto de perfil</h2>
    <h3>Nome de utilizador</h3>
    <form action="/perfil/editlogin/" method="post" enctype="multipart/form-data">
        <fieldset class="input_field">
            <label for="file">Imagem</label>
            <input class=
                   ' <?php if(isset($form_error['nome'])) {echo " form_error";}?> '
                   type="file" id="file" name="file">
        </fieldset>
        <fieldset>
            <button class="submit" name="submit" value="editfoto">Alterar</button>
        </fieldset>
    </form>
</div>