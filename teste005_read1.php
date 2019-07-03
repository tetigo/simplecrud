<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Info Usuario</h1>
    <!-- <form action="" method="POST">
        <label for="id"></label>
        <input type="text" id="id" name="id" placeholder="ID do Usuario">
        <button name="enviar" value="enviar">Enviar</button>
    </form> -->
<?php
    require 'Conn.php';
    $conn = new Conn();
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    // var_dump($_POST, $dados['id']);
    $consulta = "select * from usuarios where id=:id;";

    $result = $conn->getConn()->prepare($consulta);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    
    $user = $result->fetch(PDO::FETCH_ASSOC);
    echo "<hr>";
    echo "ID:".$user['id']."<br>";
    echo "NOME:".$user['nome']??'vazio';echo"<br>";
    echo "EMAIL:".$user['email']."<br>";
    echo "USER:".$user['usuario']."<br>";
    echo "CRE:". date('d-m-Y h:i:s', strtotime($user['created']))."<br>";
    if(!empty($user['modified'])):
        echo "ALT:". date('d-m-Y h:i:s', strtotime($user['modified']))."<br>";
    endif;
    echo "<hr>";
    echo "<a href='teste004_read.php'>Voltar</a>"
?>
</body>
</html>