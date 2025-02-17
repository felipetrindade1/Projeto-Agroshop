<?php

include_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Recupera o ID do registro a ser excluído
    $id = $_GET['id'] ?? 0;

    // Prepara e executa a instrução SQL de exclusão
    if ($id > 0) {
        $stmt = $con->prepare("DELETE FROM Produto WHERE Produto_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Mensagem de retorno
        echo 'Registro ' . $id . ' excluído com sucesso';
    }
}
?>
