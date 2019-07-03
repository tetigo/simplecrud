<?php
    session_start();
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
    <a href="teste003_create.php">Novo</a>
    <h1>Listar Usuarios</h1>
    <hr>
<?php
    require 'Conn.php';
    $conn = new Conn();
    $nome = 'Tiago2';
    //$consulta = "select * from usuarios where nome=:nome;";
    $consulta = "select * from usuarios";

    $result = $conn->getConn()->prepare($consulta);
    // $result->bindParam(':nome', $nome, PDO::PARAM_STR);
    $result->execute();
    
    if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])):
        echo "<h3>{$_SESSION['msg']}</h3>";
        unset($_SESSION['msg']);
    endif;

    while($user = $result->fetch(PDO::FETCH_ASSOC)):
        echo "ID:".$user['id']."<br>";
        echo "NOME:".$user['nome']??'vazio';echo"<br>";
        echo "EMAIL:".$user['email']."<br>";
        echo "USER:".$user['usuario']."<br>";
        echo "CRE:". date('d-m-Y h:i:s', strtotime($user['created']))."<br>";
        if(!empty($user['modified'])):
            echo "ALT:". date('d-m-Y h:i:s', strtotime($user['modified']))."<br>";
        endif;
        echo "<a href='teste005_read1.php?id={$user['id']}'>Detalhes</a><br><br>";
        echo "<a href='teste006_update.php?id={$user['id']}'>Editar</a><br><br>";
        echo "<a href='teste007_delete.php?id={$user['id']}'>Apagar</a><br><br>";
        echo "<hr>";
    endwhile;
?>
</body>
</html>