<?php
try {
    $user = "root";
    $pass = "";
    $con = new PDO('mysql:host=localhost;dbname=projeto', $user, $pass);
    // Definir o modo de erro do PDO para Exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erro na conexão com o banco de dados: " . $e->getMessage();
}
?>
