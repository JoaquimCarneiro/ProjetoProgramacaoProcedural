<?php
$conn = mysqli_connect(DB_SERVER, DB_USER, DB_PWD, DB_NAME);
if (!$conn){
    die("Ligação falhou: ".mysqli_connect_error());
}

function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ".SITE_ROOT."?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)){
        //codigo para login
        mysqli_stmt_close($stmt);
        return $row;
    }else{
        mysqli_stmt_close($stmt);
        return false;
    }

}

/* Criar utilizador
 * Esta função precisa de devolver valores caso falhe */
function createUser($conn, $username, $email, $password): void{
    $userlevel = 1; //nível de utilizador por defeito no registo
    $sql = "INSERT INTO users ( usersEmail, usersUid, usersPwd, userlevel) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ".SITE_ROOT."?error=stmtfailed");
        exit();
    }

    /* encriptar password */
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $email, $username, $hashedPassword, $userlevel);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

/* Apagar tokens se existir */
function deleteTokenUser($conn, $email, $tokenType): void{
    $sql = "DELETE FROM tokens WHERE email = ? AND type = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        /* precisa de melhor formato de erro */
        echo "erro a preparar a query DELETE";
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "ss", $email, $tokenType);
        mysqli_stmt_execute($stmt);
    }
}

/* inserir token */
function addToken($conn, $email, $token_selector, $token, $expires, $type):void{
    $sql = "INSERT INTO tokens (email, tokenSelector, token, expires, type) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        /* precisa de melhor formato de erro */
        echo "erro a preparar a query INSERT";
        exit();
    }else{
        /* encriptar token */
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "sssss", $email, $token_selector, $hashedToken, $expires, $type);
        mysqli_stmt_execute($stmt);
    }
}

/* procura token e devolve array */
function getTokenInfo($conn, $selector, $currentDate){
    $sql = "SELECT * FROM tokens WHERE tokenSelector = ? AND expires >= ?;"; //expires não necessita de ? pode-se usar a variavel diretamente
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        // precisa de melhor formato de erro
        return ['erro' => "erro a preparar a query INSERT"];
    }else{
        mysqli_stmt_bind_param($stmt, "ss", $selector, $currentDate);
        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($resultado)) {//não ha registo ou a data é inválida
            return ['erro' => "Pedido inválido ou expirado"];
        }else{
            return $row;
        }
    }
}

function updatePwdByEmail($conn, $password, $email){
    $sql = "UPDATE users SET usersPwd = ? WHERE usersEmail = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        // precisa de melhor formato de erro
        return ["erro" => "erro a preparar a query modifica password"];
    }else {
        $newPassword = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $newPassword, $email);
        mysqli_stmt_execute($stmt);
    }
}

function updatePwdByUid($conn, $password, $userUid){
    $sql = "UPDATE users SET usersPwd = ? WHERE usersUid = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        // precisa de melhor formato de erro
        return ["erro" => "erro a preparar a query modifica password"];
    }else {
        $newPassword = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $newPassword, $userUid);
        mysqli_stmt_execute($stmt);
    }
}

function updateLvlByEmail($conn, $lvl, $email){
    $sql = "UPDATE users SET userlevel = ? WHERE usersEmail = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        // precisa de melhor formato de erro
        return ["erro" => "erro a preparar a query modifica password"];
    }else {
        mysqli_stmt_bind_param($stmt, "ss", $lvl, $email);
        mysqli_stmt_execute($stmt);
    }
}

/* Devolve um erro, sob a forma de um array, ou os campos da tabela de nível de utilizadores e as devidas descrições
 * na base de dados a partir do nível de utilizador na base de dados.
 * a ser usado para ir buscar o nome do nível e a descrição */
function getUserLvl($conn, $userlvl){
    $sql = "SELECT * FROM user_level WHERE userlevel = ? ;"; //expires não necessita de ? pode-se usar a variavel diretamente
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        // precisa de melhor formato de erro
        return ['erro' => "erro a preparar a query INSERT"];
    }else{
        mysqli_stmt_bind_param($stmt, "s", $userlvl);
        mysqli_stmt_execute($stmt);

        $resultado = mysqli_stmt_get_result($stmt);
        if(!$row = mysqli_fetch_assoc($resultado)) {//não ha registo ou a data é inválida
            return ['erro' => "Pedido inválido ou expirado"];
        }else{
            return $row;
        }
    }
}
/***** Informações de perfil do utilizador *****/
/* Procura se o utilizador já adicionou info à base de dados e se tiver devolve array com dados
 * - usado para multiplos efeitos */

function getUserInfo($conn, $userId){
    $sql = "SELECT * FROM user_info WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)){
        return ['erro' => "erro a preparar a query SELECT"];
        //header("location: ".SITE_ROOT."?error=stmtfailed");
    }
    mysqli_stmt_bind_param($stmt, "s", $userId);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    if(!$row = mysqli_fetch_assoc($resultData)){
        return false;
    }else{
        return $row;
    }
}

function setUpdateUserInfo($conn, $userId, $nome, $sobreNome, $aniversario, $nacionalidade, $genero){
    $infoExists = getUserInfo($conn, $userId);
    // build querys
    if(!$infoExists){//não existe info
        $query = "INSERT INTO user_info 
                            (usersId, firstName, lastName, aniversario, nacionalidade, genero)
                            VALUES (?, ?, ?, ?, ?, ?);";
    }else{
        $query = "UPDATE user_info SET 
                            firstName = ?, lastName = ?, aniversario = ?, nacionalidade = ?, genero = ? WHERE usersId = ?;";
    }
    //executa
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $query)){
        return ['erro' => "erro a preparar a query SELECT"];
        //header("location: ".SITE_ROOT."?error=stmtfailed");
    }
    if(!$infoExists){
        mysqli_stmt_bind_param($stmt, "ssssss", $userId, $nome, $sobreNome, $aniversario, $nacionalidade, $genero);
    }else{
        mysqli_stmt_bind_param($stmt, "ssssss", $nome, $sobreNome, $aniversario, $nacionalidade, $genero, $userId);
    }
    mysqli_stmt_execute($stmt);
}

function updateUsenameById($conn, $utilizador, $userId){
    $sql = "UPDATE users SET usersUid = ? WHERE usersId = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        // precisa de melhor formato de erro
        return ["erro" => "erro a preparar a query modifica password"];
    }else {

        mysqli_stmt_bind_param($stmt, "ss", $utilizador, $userId);
        mysqli_stmt_execute($stmt);
    }
}