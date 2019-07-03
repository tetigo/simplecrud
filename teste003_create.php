<?php
    session_start();


///////// pulando codigo php
    goto teste;


    require "./Conn.php";
    $email = 'tetigo@gmail.com';
    $usuario = 'tiago';
    $senha = '123';

    $conn = new Conn();
    $conn->getConn(); 

    try{
        $cadastrar = "insert into usuarios(email, usuario, senha, created) values(:email,:usuario,:senha, NOW());";
        $cadastrar = $conn->getConn()->prepare($cadastrar);
        $cadastrar->bindParam(':email', $email, PDO::PARAM_STR);
        $cadastrar->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $cadastrar->bindParam(':senha', $senha, PDO::PARAM_STR);
        $cadastrar->execute();
        if ($cadastrar->rowCount()):
            echo "Cadastrado Com Sucesso!";
        endif;
    }catch(Exception $e){
        echo "Mensagem: " . $e->getMessage();
        die;
    }
teste:    
    echo "<hr>";
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
    <h1>Cadastrar Usuario</h1>

<?php
    require 'Conn.php';

    $dados = filter_input_array(INPUT_POST, FILTER_SANITIZE_MAGIC_QUOTES);
    // var_dump($_POST, $dados);

    if(!empty($dados['sendCadUser'])):
        unset($dados['sendCadUser']);

        $conn = new Conn();
        $conn->getConn(); 
        if(!empty($dados['nome'])):
            try{
                $cadastrar = "insert into usuarios(nome, email, usuario, senha, created) values(:nome,:email,:usuario,:senha, NOW());";
                $cadastrar = $conn->getConn()->prepare($cadastrar);
                $cadastrar->bindParam(':nome',    $dados['nome'],    PDO::PARAM_STR);
                $cadastrar->bindParam(':email',   $dados['email'],   PDO::PARAM_STR);
                $cadastrar->bindParam(':usuario', $dados['usuario'], PDO::PARAM_STR);
                $cadastrar->bindParam(':senha',   $dados['senha'],   PDO::PARAM_STR);
                $cadastrar->execute();
                if ($cadastrar->rowCount()):
                    $_SESSION['msg'] = "Cadastrado Com Sucesso!";
                    unset($dados);
                    header('Location: teste004_read.php');
                endif;
            }catch(Exception $e){
                echo "Mensagem: " . $e->getMessage();
                die;
            }
        endif;
    endif;
?>

    <form action="" name="cadUsuario" method="POST">
        <label for="campo_nome">Nome:</label>
        <input type="text" id="campo_nome" name="nome" placeholder="Nome Completo"><br><BR>

        <label for="campo_email">Email:</label>
        <input type="email" id="campo_email" name="email" placeholder="Email"><br><BR>

        <label for="campo_usuario">Usuario:</label>
        <input type="text" id="campo_usuario" name="usuario" placeholder="Usuario para Acessar Sistema"><br><BR>

        <label for="campo_senha">Senha:</label>
        <input type="password" id="campo_senha" name="senha" placeholder="Senha"><br><BR>
            
        <input type="submit" id="campo_button" name="sendCadUser" value="Cadastrar"><br><BR>
    </form>
    <a href='teste004_read.php'>Voltar</a><br><br>

</body>
</html>