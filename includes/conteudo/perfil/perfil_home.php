
    <div class="conteudo">
        <h2>Area de utilizador</h2>
        <h3>Benvindo, <?php echo $username; ?></h3>
        <table class="perfil">
            <thead>
            <tr><td colspan='2'>Dados de login</td></tr>
            </thead>
            <tbody>
            <tr><td>Utilizador</td><td><?php echo $username; ?></td></tr>
            <tr><td>Email</td><td><?php echo $useremail; ?></td></tr>
            <tr><td>Nível</td><td><?php echo "<p>".$userLvl." - ".$userlvlName."</p><p>".$userlvlDiscription."</p>"; ?></td></tr>
            </tbody>
        </table>

        <h2>Dados pessoais</h2>

    </div>


<?php
