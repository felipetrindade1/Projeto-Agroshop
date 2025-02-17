<?php

include_once('protect.php');

?>

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
    font-weight: light;
    font-size: smaller;
  }

  .menu-item:hover {
    background-color: #d7dbdb;
  }

  .menu-item {
    cursor: pointer;
    flex: 1;
    margin: 5px;
    transition: background-color 0.3s;
  }


  .sair-da-esquerda {
    animation: sairEsquerda 0.5s forwards;
  }


  .entrar-da-direita {
    animation: entrarDireita 0.5s forwards;
  }

  @keyframes sairEsquerda {
    from {
      transform: translateX(0);
    }

    to {
      transform: translateX(-100%);
      display: none;
    }
  }

  @keyframes entrarDireita {
    from {
      transform: translateX(100%);
    }

    to {
      transform: translateX(0);
    }
  }
</style>

<?php
include_once "conexao.php";

// Consulta SQL para buscar as categorias
$query = "SELECT * FROM Categoria";
$stmt = $con->prepare($query);
$stmt->execute();
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section meta http-equiv="refresh" content="5">

  <?php
  $usuario_id = $_SESSION['id'];

  $stmt = $con->prepare("SELECT Produto.Produto_id, Produto.Nome AS NomeProduto, Produto.Preco, Produto.Quantidade, Produto.QuantidadeInicial, Produto.Descricao, Produto.imgPath, Categoria.Tipo AS Categoria, Usuario.Nome AS NomeVendedor FROM Produto 
                      INNER JOIN Categoria ON Produto.Categoria_id = Categoria.Categoria_id 
                      INNER JOIN Usuario ON Produto.Usuario_id = Usuario.Usuario_id
                      WHERE Produto.Usuario_id = :usuario_id");
  $stmt->bindParam(':usuario_id', $usuario_id);
  $stmt->execute();
  $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Calcular a soma total dos valores (preço * quantidade)
  $totalValores = 0;
  $diferencaQuantidade = 0; // Inicialize a variável fora do loop

  foreach ($produtos as $produto) {
    $totalValores += $produto['Preco'] * $produto['Quantidade'];

    // Calcular a diferença entre Quantidade e QuantidadeInicial
    $diferencaQuantidade += $produto['QuantidadeInicial'] - $produto['Quantidade'];
  }

  // Agora, $diferencaQuantidade contém a soma da diferença entre Quantidade e QuantidadeInicial para todos os produtos
  ?>



  <div class="menu-nav shadow-lg p-3 mb-3 bg-body-tertiary" onclick="alert('Clicou na Div')">
    <div class="menu-item" onclick="">Total de produtos a venda: <?php echo count($produtos); ?></div>
    <div class="menu-item" onclick="">Valor total de produtos à venda: R$ <?php echo number_format($totalValores, 2, '.', '');  ?></div>
    <div class="menu-item" onclick="">Vendidos (<?php echo $diferencaQuantidade; ?>)</div>
  </div>





  </div>
  <div class="menu-principal">
    <div class="container">
      <div class="row justify-content-center">
        <div class="">
          <div class="text-center">
            <div class="middle">
              <a href="" class="btn btn1 active" id="meus-produtos" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Meus produtos</a>

              <a href="" class="btn btn1" id="adicionar-produto" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Adicionar produto</a>
            </div>
            <hr>
            <br>
            <div class="meusprodutos" style="width: 100%" id="meusprodutos">

              <?php
              $usuario_id = $_SESSION['id'];

              $stmt = $con->prepare("SELECT Produto.Produto_id, Produto.Nome AS NomeProduto, Produto.Preco, Produto.Descricao, Produto.imgPath, Produto.Quantidade, Categoria.Tipo AS Categoria, Usuario.Nome AS NomeVendedor FROM Produto 
                      INNER JOIN Categoria ON Produto.Categoria_id = Categoria.Categoria_id 
                      INNER JOIN Usuario ON Produto.Usuario_id = Usuario.Usuario_id
                      WHERE Produto.Usuario_id = :usuario_id");
              $stmt->bindParam(':usuario_id', $usuario_id);
              $stmt->execute();
              $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);


              foreach ($produtos as $produto) {
                echo '<div class="row row-itens">';
                echo '<img src="' . $produto['imgPath'] . '" alt="" class="meusprodutos-imagem">';
                echo '<div class="meusprodutos-text">' . $produto['NomeProduto'] . '</div>';
                echo '<div class="meusprodutos-text">' . $produto['Descricao'] . '</div>';
                echo '<div class="meusprodutos-text">' . $produto['Categoria'] . '</div>';
                echo '<div class="meusprodutos-remove"><a href="">' . $produto['NomeVendedor'] . '</a></div>';
                echo '</div>';
              }




              ?>

            </div>


            <div class="container-cadastro" id="container-cadastro" style="display: none; text-align:left;">
              <h1>Cadastro de Produto</h1>
              <form method="POST" enctype="multipart/form-data">
                <label for="nome">Nome do Produto:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" maxlength="10" placeholder="Máximo 10 carácteres" required></textarea>

                <label for="categoria_id">Categoria:</label>
                <select name="categoria_id" id="categoria_id" required>
                  <option value="">Selecione uma categoria</option>
                  <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?= $categoria['Categoria_id'] ?>">
                      <?= $categoria['Tipo'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>

                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" step="0.01" required>

                <label for="unidade"> Unidade do produto:</label>
                <select name="unidade" id="unidade" required>
                  <option value="">Selecione uma categoria</option>
                  <option value="">Kg</option>
                  <option value="">Grama</option>
                  <option value="">Unidade</option>
                  <option value="">Duzia</option>
                  <option value="">Saca</option>
                </select>

                <label for="quantidade">Quantidade em estoque:</label>
                <input type="number" id="quantidade" name="qntd" placeholder="De acordo com a unidade do produto" required>

                <label for="parcelas">Parcelas:</label>
                <input type="text" id="parcelas" name="parcelas" required>

                <label for="imagem">Imagem do Produto:</label>
                <input type="file" id="imagem" name="imagem" required>

                <div class="">
                  <button class="btn btn-light col-md-12" type="submit" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Enviar</button>
                </div>


                <?php

                include_once "conexao.php";

                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES["imagem"])) {
                  $nome = $_POST['nome'];
                  $preco = $_POST['preco'];
                  $categoria_id = $_POST['categoria_id'];
                  $usuario_id = $_SESSION['id'];
                  $descricao = $_POST['descricao'];
                  $parcelas = $_POST['parcelas'];
                  $unidade = $_POST['unidade'];
                  $quantidade = $_POST['qntd'];


                  // Verificar se um arquivo foi enviado corretamente
                  if ($_FILES['imagem']['error'] === 0) {
                    $pasta = "arquivos/produtos/";
                    $nomeDoArquivo = $_FILES['imagem']['name'];
                    $novoNomeArq = uniqid();
                    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

                    // Verificar se a extensão do arquivo é permitida
                    $extensoesPermitidas = array("jpg", "png", "jpeg", "jfif");
                    if (in_array($extensao, $extensoesPermitidas)) {
                      $path = $pasta . $novoNomeArq . "." . $extensao;

                      // Mover o arquivo para a pasta de destino
                      if (move_uploaded_file($_FILES['imagem']['tmp_name'], $path)) {
                        try {
                          $sql = "INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade) 
                                    VALUES (:nome, :preco, :categoria_id, :usuario_id, :descricao, :parcelas, :path, :quantidade, :quantidadeinicial, :unidade)";

                          $stmt = $con->prepare($sql);
                          $stmt->bindParam(':nome', $nome);
                          $stmt->bindParam(':preco', $preco);
                          $stmt->bindParam(':categoria_id', $categoria_id);
                          $stmt->bindParam(':usuario_id', $usuario_id);
                          $stmt->bindParam(':descricao', $descricao);
                          $stmt->bindParam(':parcelas', $parcelas);
                          $stmt->bindParam(':path', $path);
                          $stmt->bindParam(':quantidade', $quantidade);
                          $stmt->bindParam(':quantidadeinicial', $quantidade);
                          $stmt->bindParam(':unidade', $unidade);

                          if ($stmt->execute()) {
                            echo '<p style="color: #2bc460;">Produto cadastrado com sucesso!</p>';
                            echo '<script type="text/javascript">
                                                window.location = "index.php?minhaLoja";
                                            </script>';
                          } else {

                            echo '<p style="color: #FF0000;">Erro ao cadastrar produto</p>';
                          }
                        } catch (PDOException $e) {
                          echo "Erro: " . $e->getMessage();
                        }
                      } else {
                        echo "Erro ao mover o arquivo para a pasta de destino.";
                      }
                    } else {
                      echo "Tipo de arquivo não aceito: $nomeDoArquivo";
                    }
                  } else {
                    echo '<p style="color: #FF0000;">Erro no upload do arquivo.</p>';
                  }
                }


                ?>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>
  </div>
</section>

<script src="./assets/js/vender.js"></script>