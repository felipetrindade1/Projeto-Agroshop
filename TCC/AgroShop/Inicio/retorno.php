<?php

session_start();
// Imprime os dados recebidos via requisição (GET ou POST)
print_r($_REQUEST);

// Obtém o valor 'rt' da URL
$rtValue = isset($_GET['rt']) ? $_GET['rt'] : null;

// Exibe o valor 'rt'
echo "<br><br><br>";
echo $rtValue;

// Verifique se a variável 'rt' está definida e possui o valor 'success'
if ($rtValue == 'success') {

  $carrinho = array();

  // Remove o cookie do carrinho
  setcookie('carrinho', '', time() - 3600);



  // Se 'rt' for 'success', exiba os produtos do carrinho
  if (isset($_SESSION['carrinhoProdutos']) && !empty($_SESSION['carrinhoProdutos'])) {
    echo "<h2>Produtos no Carrinho:</h2>";
    echo "<ul>";
    foreach ($_SESSION['carrinhoProdutos'] as $produto) {
      echo "<li>{$produto['nome']} - Quantidade: {$produto['quantidade']} - Preço: R$ {$produto['preco']}</li>";

      $numeroSorteado = mt_rand(6, 7); // Gera um número aleatório entre 1 e 100
      echo "Número sorteado: $numeroSorteado";

      $v1 = mt_rand(1, 9999); // Gera um número aleatório entre 1 e 100
      echo "Número sorteado: $v1";

      $usuario_id = $_SESSION['id'];

      ///////// Criando pedido no banco
      try {
        include_once "conexao.php";

        $sql = "INSERT INTO Pedido (Produto_id, Usuario_id, Quantidade, Entregador, v1) 
                    VALUES (:produto_id, :usuario_id, :quantidade, :entregador, :v1)";

        $stmt = $con->prepare($sql);
        $stmt->bindParam(':produto_id', $produto['id']);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':quantidade', $produto['quantidade']);
        $stmt->bindParam(':entregador', $numeroSorteado);
        $stmt->bindParam(':v1', $v1);

        if ($stmt->execute()) {
          echo '<p style="color: #2bc460;">Produto cadastrado com sucesso!</p>';
        } else {

          echo '<p style="color: #FF0000;">Erro ao cadastrar produto</p>';
        }
      } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
      }
      //////// FIM ////////



      //////// Selecionando o produto para pegar a quantidade
      try {
        $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Defina $produto['id'] antes de usar
        $produto_id = $produto['id'];
    
        $queryUpdate = "SELECT * FROM Produto WHERE Produto_id = :produto_id";
        $stmtUpdate = $pdo->prepare($queryUpdate);
        $stmtUpdate->bindParam(':produto_id', $produto_id);
    
        if ($stmtUpdate->execute()) {
            // Obtenha os resultados após a execução
            $prod = $stmtUpdate->fetch(PDO::FETCH_ASSOC);
    
            echo "Select produto funcionou";
            //echo $prod['Quantidade'];
        } else {
            echo "Select produto não funcionou";
        }
    } catch (PDOException $e) {
        echo "Erro na execução da consulta: " . $e->getMessage();
    }

      //////// Diminuindo a quintidade do produto diponivel
      $qntdAtual = $prod['Quantidade'] - $produto['quantidade']; 
      try {
        $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $queryUpdate = "UPDATE Produto SET Quantidade = :quantidade WHERE Produto_id = :produto_id";
        $stmtUpdate = $pdo->prepare($queryUpdate);
        $stmtUpdate->bindParam(':quantidade', $qntdAtual);
        $stmtUpdate->bindParam(':produto_id', $produto['id']);

        if ($stmtUpdate->execute()) {
          echo "";
        } else {
          echo "";
        }
      } catch (PDOException $e) {
        echo "Erro na execução da consulta: " . $e->getMessage();
      }
      //////// FIM  /////////

      

      
    }
    echo "</ul>";
  } else {
    echo "<p>Carrinho vazio.</p>";
  }
} else {
  // Se 'rt' não for 'success', exiba uma mensagem adequada
  echo "<p>Ocorreu um erro ou a transação está pendente.</p>";
}
?>

<script>
  // Aguarda 1 segundo antes de redirecionar
  setTimeout(function() {
    // Redireciona para index.php com o parâmetro 'pedidos'
    window.location.href = 'index.php?pedidos';
  } /*,1000*/ ); // 1000 milissegundos = 1 segundo
</script>