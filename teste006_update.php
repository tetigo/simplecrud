<?php
    session_start();
    require 'Conn.php';
    $conn = new Conn();
    //////////// edita dados
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if(!empty($dados['sendEditUser'])):
        unset($dados['sendEditUser']);
        $consulta="update usuarios set nome=:nome, email=:email, usuario=:usuario, senha=:senha, modified=NOW() where id=:id;";
        $prep = $conn->getConn()->prepare($consulta);
        $prep->bindParam(':nome',$dados['nome'], PDO::PARAM_STR);
        $prep->bindParam(':email',$dados['email'], PDO::PARAM_STR);
        $prep->bindParam(':usuario',$dados['usuario'], PDO::PARAM_STR);
        $prep->bindParam(':senha',$dados['senha'], PDO::PARAM_STR);
        $prep->bindParam(':id', $dados['id'], PDO::PARAM_INT);
        if($prep->execute()):
            $_SESSION['msg'] = "Registro Editado Com Sucesso!";
        else:
            $_SESSION['msg'] = "Registro Nao Foi Editado!";
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
    <h1>Atualizar Usuario</h1>

    <form action="" name="editUsuario" method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']?>">
        
        <label for="campo_nome">Nome:</label>
        <input type="text" id="campo_nome" name="nome" value="<?php echo $user['nome']?>"><br><BR>

        <label for="campo_email">Email:</label>
        <input type="email" id="campo_email" name="email" value="<?php echo $user['email']?>"><br><BR>

        <label for="campo_usuario">Usuario:</label>
        <input type="text" id="campo_usuario" name="usuario" value="<?php echo $user['usuario']?>"><br><BR>

        <label for="campo_senha">Senha:</label>
        <input type="password" id="campo_senha" name="senha" value="<?php echo $user['senha']?>"><br><BR>
            
        <input type="submit" id="campo_button" name="sendEditUser" value="Salvar"><br><BR>
    </form>
   
    <hr>
    <a href='teste004_read.php'>Voltar</a><br><br>

</body>
</html>