<?php
/***** VERIFICAR SE O UTILIZADOR JÁ TEM INFORMAÇÕES E BUSCAR DADOS*****/
$userId = $_SESSION['userId'];
$userInfo = getUserInfo($conn, $userId);
if($userInfo){
    $nome = $userInfo['firstName'];
    $sobreNome = $userInfo['lastName'];
    $aniversario = $userInfo['aniversario'];
    $nacionalidade = $userInfo['nacionalidade'];
    $genero = $userInfo['genero'];
}
?>
    <div class="conteudo">
        <h2>Area de utilizador</h2>
        <h3>Benvindo, <?php echo $username; ?></h3>
        <table class="table_perfil">
            <thead>
            <tr><td colspan='2'>Dados de login</td></tr>
            </thead>
            <tbody>
            <tr><td>Utilizador</td><td><?php echo $username; ?></td></tr>
            <tr><td>Email</td><td><?php echo $useremail; ?></td></tr>
            <tr><td>Nível</td><td><?php echo "<p>".$userLvl." - ".$userlvlName."</p><p>".$userlvlDiscription."</p>"; ?></td></tr>
            </tbody>
        </table>

        <table class="table_perfil">
            <thead>
            <tr><td colspan='2'>Dados Pessoais</td></tr>
            </thead>
            <tbody>
            <tr><td>Nome</td><td><?php if($userInfo){echo $nome;} ?></td></tr>
            <tr><td>Sobrenome</td><td><?php if($userInfo){echo $sobreNome;} ?></td></tr>
            <tr><td>Data de Nascimento</td><td><?php if($userInfo){echo $aniversario;} ?></td></tr>
            <tr><td>País</td><td><?php if($userInfo){echo $nacionalidade;} ?></td></tr>
            <tr><td>Genero</td><td><?php if($userInfo){echo $genero;} ?></td></tr>
            </tbody>
        </table>

    </div>