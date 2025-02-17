<?php

include_once('protect.php');


?>


<!-- Css -->
<link rel="stylesheet" href="./assets/css/style.css">
<style>
  .menu-nav {
    cursor: pointer;
    display: flex;
    justify-content: space-between;

    color: black;
    text-align: center;
    padding: 20px;
    transition: background-color 0.3s;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    letter-spacing: 2px;
    font-weight: lighter;
    font-size: smaller;
  }

  .menu-item {
    cursor: pointer;
    flex: 1;
    margin: 5px;
    transition: background-color 0.3s;
  }

  #menu-item1 {
    cursor: pointer;
    flex: 1;
    margin: 5px;
    transition: background-color 0.3s;
    font-weight: bold;
  }
</style>


<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto";
$id = $_SESSION['id'];

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $sql = "
    SELECT
        Pedido.Pedido_id,
        Pedido.Quantidade,
        Pedido.DataEntrega,
        Usuario.Nome AS ClienteNome,
        Produto.Nome AS ProdutoNome,
        Produto.imgPath AS ProdutoImagem,
        Produto.Unidade AS ProdutoUnidade
    FROM
    Pedido  
    INNER JOIN Usuario ON Pedido.Usuario_id = Usuario.Usuario_id
    INNER JOIN Produto ON Pedido.Produto_id = Produto.Produto_id WHERE Pedido.Usuario_id = :id;
";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();

  $totalProdutos = 0;
  // Exibir os resultados
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $totalProdutos++;
  }
} catch (PDOException $e) {
  echo "Erro: " . $e->getMessage();
}

$conn = null;

?>

<div class="menu-nav shadow-lg p-3 mb-5 bg-body-tertiary">
  <div class="menu-item" id="menu-item1"> MEUS PEDIDOS <img src="https://cdn.icon-icons.com/icons2/2518/PNG/512/point_icon_151143.png" style="width: 15px; height: 15px;"></div>
  <div class="menu-item" onclick="alert('O código de entrega deve ser apresentado ao entregador para validar a entrega.')">Código do pedido <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
      <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
    </svg></div>
  <div class="menu-item">EM ANDAMENTO: <?php echo $totalProdutos; ?></div>
</div>
 



<style>
  /* ALERTA PERSONALIZADO */
  /* ALERTA PERSONALIZADO */
  /* Adicione algum estilo ao seu alerta, se necessário */
  #myAlert {
    display: none;
    padding: 10px;
    color: black;
    opacity: 0;
    /* Inicialmente, o alerta é transparente */
    transition: opacity 0.5s ease-in-out;
    /* Adiciona um efeito de transição */
    position: fixed;
    bottom: 05%;
    right: 5%;
    transform: translateX(-50%);
    z-index: 999;
  }

  /* Estilo para o botão (opcional) */
  #myButton {
    margin-top: 20px;
    padding: 10px;
  }
</style>
<!-- Botão
<button id="myButton">Mostrar Alerta</button>
 -->
<!-- Alerta -->
<div id="myAlert" class="shadow-lg p-3 mb-5 bg-body-light rounded border border-2">Este é um alerta!</div>

<script>
  // Adicionar um ouvinte de evento ao botão
  document.getElementById('myButton').addEventListener('click', function() {
    // Chamar a função showAlert quando o botão for clicado
    showAlert();
  });

  // Função para mostrar o alerta
  function showAlert() {
    var alertDiv = document.getElementById('myAlert');

    // Mostrar o alerta definindo a opacidade para 1
    alertDiv.style.display = 'block';
    alertDiv.style.opacity = '1';

    // Definir um tempo para ocultar o alerta
    setTimeout(function() {
      // Ocultar o alerta definindo a opacidade para 0
      alertDiv.style.opacity = '0';

      // Ocultar o alerta após a transição
      setTimeout(function() {
        alertDiv.style.display = 'none';
      }, 500); // Tempo de transição (0.5 segundo)
    }, 1000); // Tempo em milissegundos (1 segundo no exemplo)
  }
</script>


<section>

  <?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "projeto";
  $id = $_SESSION['id'];

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $sql = "
    SELECT
        Pedido.Pedido_id,
        Pedido.v1,
        Pedido.Quantidade,
        Pedido.DataEntrega,
        Usuario.Nome AS ClienteNome,
        Produto.Nome AS ProdutoNome,
        Produto.imgPath AS ProdutoImagem,
        Produto.Unidade AS ProdutoUnidade
    FROM
    Pedido  
    INNER JOIN Usuario ON Pedido.Usuario_id = Usuario.Usuario_id
    INNER JOIN Produto ON Pedido.Produto_id = Produto.Produto_id WHERE Pedido.Usuario_id = :id;
";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $totalProdutos = 0;
    // Exibir os resultados
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $totalProdutos++;


      echo '<div class="d-flex justify-content-center mb-3">
    <div class="card" style="width: 50%;">
      <div class="row g-0">
        <div class="col-md-4">
          <img src="' . $row['ProdutoImagem'] . '" class="card-img" alt="Imagem do produto" style="width: 100%; padding: 10%;">
        </div>
        <div class="col-md-8 d-flex align-items-center">
          <div class="card-body">
            <h5 class="card-title text-left">' . $row['ProdutoNome'] . '</h5>
            <p class="card-text text-left">Quantidade: ' . $row['Quantidade'] . $row['ProdutoUnidade'] . '</p>
            <p class="card-text text-left">Data de entegra: 7 dias a partir de ' . $row['DataEntrega'] . '</p>
            <p class="card-text text-left">Código de entrega:  ' . $row['v1'] . '</p>
            <!-- Outros elementos do card 2 -->
          </div>
          <!-- <button class="finalizar-button" style="margin-right: 05%; margin-bottom: 01%;">Finalizar</button> -->
        </div>
      </div>
    </div>
 </div>';
    }
  } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
  }

  //echo $totalProdutos;

  // Fechar a conexão
  $conn = null;

  ?>

</section>