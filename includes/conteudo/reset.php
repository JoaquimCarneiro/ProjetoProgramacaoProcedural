<?php
    /* o script tem que ter pelo menos duas variaveis: os tokens enviados por email.
     * caso estas não existam, o "utilizador" chegou aqui de forma ilegal
     * e tem que ser redireccionado */
    if (!empty($urlList[1]) || !empty($urlList[2])){
        /* Verificar se as variáveis estão num formato hexadecimal, caso contrário o "utilizador",
         * mais uma vez chegou aqui de forma ilegal e tem que ser redirecionado
         * isto pode ser levado mais longe já que o tamanho das strings hexadecimais é predeterminado */
        $selector = $urlList[1];
        $token = $urlList[2];
        if (!ctype_xdigit($selector) || !ctype_xdigit($token)){
            header("location: ".SITE_ROOT."?error=invalidFormat");
        }else{
?>
            <div class="login">
                <h2>Recuperar Password</h2>
                <form action="/reset/<?php echo $selector."/".$token; ?>" method="post">
                    <fieldset class="input_field">
                        <label for="password">Password</label>
                        <input class=
                               ' <?php if(isset($form_error['password'])) {echo " form_error";}?> '
                               type="password" id="password" name="password" placeholder="Nova password" value=
                               '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['password'];}?>'>
                    </fieldset>
                    <fieldset class="input_field">
                        <label for="confirm_password">Confirmar Password</label>
                        <input class=
                               ' <?php if(isset($form_error['confirm_password'])) {echo " form_error";}?> '
                               type="password" id="confirm_password" name="confirm_password" placeholder="Confirmar password" value=
                               '<?php if(isset($form_error['originais'])) {echo $form_error['originais']['confirm_password'];}?>'>
                    </fieldset>
                    <fieldset>
                        <button class="submit" name="submit" value="reset">Recuperar</button>
                    </fieldset>
                </form>
                <?php
                /* isto tem que ser revisto */
                if(isset($form_error) && $form_error['num_error'] != 0){
                    echo "<p>O formulário tem ".$form_error['num_error']." erros.</p>";
                    echo "<ul class='lista_erros'>";
                    echo "<li>Campos inválidos</li>";
                    if (isset($form_error['password'])){echo "<li>".$form_error['password']."</li>";}
                    if (isset($form_error['confirm_password'])){echo "<li>".$form_error['confirm_password']."</li>";}
                    if (isset($form_error['password_confirmation'])){echo "<li>".$form_error['password_confirmation']."</li>";}
                    if (isset($form_error['token_error'])){echo "<li>".$form_error['token_error']."</li>";}
                    echo "</ul>";

                }
                ?>
            </div>
<?php
        }
    }else{
        //sai daqui
        header("location: ".SITE_ROOT."?error=illegalaccess");
    }
?>