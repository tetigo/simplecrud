<?php
session_start();

require 'Conn.php';
$conn = new Conn();
//////////// edita user
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if(!empty($dados['sendEditUser'])):
    unset($dados['sendEditUser']);
    $consulta="delete from usuarios where id=:id;";
    $prep = $conn->getConn()->prepare($consulta);
    $prep->bindParam(':id', $dados['id'], PDO::PARAM_INT);
    if($prep->execute()):
        $_SESSION['msg'] = 'Registro Apagado com Sucesso!';
    else:
        $_SESSION['msg'] = 'Registro Nao Foi Apagado!';
    endif;
    header('Location: teste004_read.php');
endif;

//////////// pesquisa dados
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$consulta = "select * from usuarios where id=:id;";
$result = $conn->getConn()->prepare($consulta);
$result->bindParam(':id', $id, PDO::PARAM_INT);
$result->execute();

$user = $result->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Apagar Usuario</h1>


    <form action="" name="editUsuario" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']?>">
        
        <label for="campo_nome">Nome:</label>
        <input disabled type="text" id="campo_nome" name="nome" value="<?php echo $user['nome']?>"><br><BR>

        <label for="campo_email">Email:</label>
        <input disabled type="email" id="campo_email" name="email" value="<?php echo $user['email']?>"><br><BR>

        <label for="campo_usuario">Usuario:</label>
        <input disabled type="text" id="campo_usuario" name="usuario" value="<?php echo $user['usuario']?>"><br><BR>

        <label for="campo_senha">Senha:</label>
        <input disabled type="password" id="campo_senha" name="senha" value="<?php echo $user['senha']?>"><br><BR>
            
        <input type="submit" id="campo_button" name="sendEditUser" value="Apagar"><br><BR>
    </form>
   
    <hr>
    <a href='teste004_read.php'>Voltar</a><br><br>

</body>
</html>