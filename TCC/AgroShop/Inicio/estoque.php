<?php
// Inclua o arquivo de conexão com o banco de dados
include_once "conexao.php";
include_once('protect.php');

session_start();

try {
    // Consulta SQL com INNER JOIN para selecionar informações de Estoque, Produto e Usuario
    // Utilize bindParam para evitar injeções de SQL
    $sql = "SELECT Estoque.Estoque_id, Produto.Nome AS NomeProduto, Usuario.Nome AS NomeUsuario, Estoque.Quantidade
            FROM Estoque
            INNER JOIN Produto ON Estoque.Produto_id = Produto.Produto_id
            INNER JOIN Usuario ON Estoque.Usuario_id = Usuario.Usuario_id
            WHERE Estoque.Usuario_id = :usuario_id";

    // Prepara a consulta SQL
    $stmt = $con->prepare($sql);

    // Vincula o valor da variável de sessão "id" à consulta SQL
    $usuario_id = $_SESSION['id'];
    $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

    // Executa a consulta
    $stmt->execute();

    // Obtém os resultados em um array associativo
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verifica se há resultados
    if ($resultados) {
        echo "<h1>Valores na tabela Estoque com informações de Produto e Usuario:</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Estoque_id</th><th>Nome do Produto</th><th>Nome do Usuario</th><th>Quantidade</th></tr>";

        // Loop através dos resultados
        foreach ($resultados as $row) {
            echo "<tr>";
            echo "<td>" . $row['Estoque_id'] . "</td>";
            echo "<td>" . $row['NomeProduto'] . "</td>";
            echo "<td>" . $row['NomeUsuario'] . "</td>";
            echo "<td>" . $row['Quantidade'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "Nenhum registro encontrado na tabela Estoque para o usuário atual.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
