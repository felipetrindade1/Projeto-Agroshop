<?php

include_once('protect.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Agroshop</title>

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="57x57" href="./assets/images/favicon//apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="./assets/images/favicon//apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="./assets/images/favicon//apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/images/favicon//apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="./assets/images/favicon//apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="./assets/images/favicon//apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="./assets/images/favicon//apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="./assets/images/favicon//apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon//apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="./assets/images/favicon//android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon//favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="./assets/images/favicon//favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon//favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <!-- end Favicons -->

  <!-- Css -->
  <link rel="stylesheet" href="./assets/css/style.css">

</head>

<body>

  <style>
    .card:hover {
      /* Adicione os estilos desejados para o efeito hover */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transform: scale(1.05);
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }

    /* Estilos adicionais para o botão de entrega no hover */
    .card:hover .finalizar-button {
      background-color: #28a745;
      /* Cor de fundo ao passar o mouse */
      color: #fff;
      /* Cor do texto ao passar o mouse */
    }
  </style>

  <!-- header -->
  <header class="container-fluid">
    <!-- container -->
    <section class="container">
      <!-- row -->
      <article class="row d-flex align-items-center">

        <!-- logo -->
        <a href="index.php?inicio" class="col-md-1 d-flex justify-content-center">
          <img src="./arquivos/logotipos/logoIcone.svg" class="img-fluid" alt="Logo da empresa" style="margin-right: 5px">
        </a>

        <!-- buscador -->
        <form action="#" class="col-md-7 d-flex align-items-center" role="search">
          <input type="text" name="pesquisa" id="pesquisa" placeholder="Procure produtos aqui">

          <button class="d-flex align-items-center" type="submit">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
              <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
            </svg>
          </button>
        </form>


        <!-- administrativo do cliente -->
        <ul class="col-md-4 nav d-flex align-items-center justify-content-around">
          <li class="nav-item">
            <a href="index.php?avatar">



              <?php
              // Inclua o arquivo de conexão com o banco de dados
              include_once('conexao.php');

              // Variável que armazena a mensagem de erro, se houver
              $erro = "";

              // Verifique se a variável de sessão 'id' está definida
              if (isset($_SESSION['id'])) {
                try {
                  // Conectar ao banco de dados usando PDO
                  $pdo = new PDO("mysql:host=localhost;dbname=projeto", "root", "");
                  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  // Consulta SQL para selecionar os dados do usuário com base no 'Usuario_id'
                  $stmt = $pdo->prepare("SELECT * FROM Usuario WHERE Usuario_id = :id");
                  $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                  $stmt->execute();

                  // Verifique se há resultados
                  if ($stmt->rowCount() > 0) {
                    // Recupere os dados do usuário
                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Agora você pode acessar os dados do usuário
                    $nome = $usuario['Nome'];
                    $img = $usuario['imgPath'];

                    $user = strstr($nome, ' ', true);



                    // Você pode adicionar mais campos conforme necessário
                  } else {
                    $erro = "Usuário não encontrado.";
                  }
                } catch (PDOException $e) {
                  $erro = "Erro no banco de dados: " . $e->getMessage();
                }
              } else {
                $erro = "Sessão não está definida. Por favor, faça login.";
              }

              // Exiba qualquer mensagem de erro
              if (!empty($erro)) {
                echo "<p>$erro</p>";
              }
              ?>




              <div class="avatar-index">
                <img style="margin-right: 10px" src="<?php echo $img; ?>" alt="Imagem de Perfil">
                <?php echo $user; ?>

              </div>


            </a>
          </li>



          <li class="nav-item">
            <span class="notificacao d-flex align-items-center justify-content-center">
              <?php
              //////////////////////// QUANTIDADE DE ITENS NO CARRINHO

              // Suponha que $_SESSION["id"] contenha o valor com o qual você deseja comparar
              // Se 'valor1' for uma string, você pode comparar com $_SESSION["id"] como uma string

              if (isset($_COOKIE['carrinho'])) {
                $carrinho = unserialize($_COOKIE['carrinho']);
                $quantidadeItens = 0;

                foreach ($carrinho as $item) {
                  if ($item['valor1'] == $_SESSION["id"]) {
                    $quantidadeItens++;
                  }
                }

                echo $quantidadeItens;
              } else {
                echo 0;
              }
              ?>
            </span>
            <a href="index.php?carrinho">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm7 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
              </svg>
              Cesta
            </a>
          </li>



          <li class="nav-item">
            <a href="logout.php">
              Sair
            </a>
          </li>
        </ul>
        <!-- end administrativo do cliente -->

      </article>
      <!-- row -->
    </section>
    <!-- end container -->
  </header>
  <!-- end header -->

  <!-- menu do site -->
  <nav class="container-fluid nav-produtos">
    <!-- container -->
    <section class="container">
      <!-- menu -->
      <ul class="nav">
        <!-- lista de itens -->
        <li class="col-xl-2 col-lg-3 col-md-12 nav-item d-flex align-items-center">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
          </svg>
          Mais

          <!-- submenu -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="index.php?carrinho">
                Meu carrinho
              </a>
            </li>

            <li class="nav-item">
              <a href="index.php?avatar">
                Meu perfil
              </a>
            </li>

            <li class="nav-item">
              <a href="index.php?pedidos">
                Meus pedidos
              </a>
            </li>



            <li class="nav-item">
              <a href="index.php?quemsomos">
                Quem somos
              </a>
            </li>
          </ul>
          <!-- end submenu -->
        </li>

        <!-- lista de itens -->
        <li class="col-xl-2 col-lg-3 col-md-12 nav-item d-flex align-items-center">
          <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-list" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
          </svg>
          Produtos
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="produtos.php">
                Todos os produtos
              </a>
            </li>

            <li class="nav-item">
              <a href="#">
                Frutas
              </a>
            </li>

            <li class="nav-item">
              <a href="#">
                Verduras
              </a>
            </li>

            <li class="nav-item">
              <a href="#">
                Legumes
              </a>
            </li>

            <li class="nav-item">
              <a href="#">
                Grãos
              </a>
            </li>




          </ul>
        </li>

      </ul>
      <!-- menu -->
    </section>
    <!-- end container -->
  </nav>


  <?php



  ?>
  <!-- end menu do site -->
  <main class="container-pedidos">
    <section>
      <h1 class="text-center">Tela transportadora</h1>



      <?php
      try {
        // Conectar ao banco de dados usando PDO
        $pdo = new PDO("mysql:host=localhost;dbname=projeto", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta SQL para selecionar os dados do pedido, produto e usuário usando INNER JOIN
        $stmt = $pdo->prepare("SELECT Pedido.Pedido_id, Pedido.Quantidade, Pedido.Entregador, Pedido.DataEntrega,
                                  Produto.Produto_id, Produto.Nome, Produto.Preco, Produto.Categoria_id, Produto.Usuario_id, Produto.Descricao, 
                                  Produto.Parcelas, Usuario.CEP, Produto.imgPath AS ProdutoImgPath, Produto.Quantidade AS QuantidadeProduto, Produto.QuantidadeInicial, Produto.Unidade,
                                  Usuario.imgPath AS UsuarioImgPath
                           FROM Pedido
                           INNER JOIN Produto ON Pedido.Produto_id = Produto.Produto_id
                           INNER JOIN Usuario ON Produto.Usuario_id = Usuario.Usuario_id
                           WHERE Pedido.Entregador = :id AND Pedido.v1 != Pedido.v2");

        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        // Verifique se há resultados
        if ($stmt->rowCount() > 0) {
          // Recupere os dados do pedido, produto e usuário
          while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {


            try {
              $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
              $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

              $usuID = $dados['Usuario_id'];

              $queryUpdate = "SELECT * FROM Usuario WHERE Usuario_id = :usuario_id";
              $stmtUpdate = $pdo->prepare($queryUpdate);
              $stmtUpdate->bindParam(':usuario_id', $usuID);

              if ($stmtUpdate->execute()) {
                // Obtenha os resultados após a execução
                $usu = $stmtUpdate->fetch(PDO::FETCH_ASSOC);

                //echo "Select produto funcionou";
                //echo $prod['Quantidade'];
              } else {
                //echo "Select produto não funcionou";
              }
            } catch (PDOException $e) {
              echo "Erro na execução da consulta: " . $e->getMessage();
            }


            echo "<div class='d-flex justify-content-center'>
    <div class='card border border-0 p-2 mb-2' style='width: 70%;'>
        <div class='row g-0'>
            <div class='col-md-4'>
                <img src='{$dados['ProdutoImgPath']}' class='card-img' alt='Imagem do produto' style='width: 50%; padding-top: 10%;'>
            </div>
            <div class='col-md-8 d-flex align-items-center'>
                <div class='card-body'>
                    <h5 class='card-title text-left'>{$dados['Nome']}</h5>
                    <p class='card-text text-left'>Quantidade no Pedido: {$dados['Quantidade']}</p>
                    <p class='card-text text-left'>CEP: {$usu['CEP']} , {$usu['Complemento']}, Num: {$usu['Num']} </p>
                    <!-- Outros elementos do card -->
                </div>
                <button class='finalizar-button custom-submit-btn' onclick='exibirFormulario(\"form-{$dados['Pedido_id']}\")' style='margin-right: 5%; margin-bottom: 1%;'>Entregar</button>
            </div>
        </div>
    </div>
</div>";

            echo "<form id='form-{$dados['Pedido_id']}' class='entregar-form' style='display: none; width: 70%; position: relative; left: 15%;' method='post'>
    <div class='mb-3'>
        <label for='exampleInputPassword1' class='form-label'>Código de Entrega</label>
        <input type='number' class='form-control' id='exampleInputPassword1' name='validacao'><br>
        <input type='hidden' class='form-control' id='exampleInputPassword1' name='id' value='{$dados['Pedido_id']}'><br>

         <button type='submit' class='custom-submit-btn' >Validar</button>
   
    </div>
</form>";

            echo "<br>";
            echo "<br>";
            echo "<br>";

            //echo $dados['Pedido_id'];
          }

          // Você pode adicionar mais campos conforme necessário
        } else {
          $erro = "Nenhum produto encontrado para este usuário.";
        }
      } catch (PDOException $e) {
        $erro = "Erro no banco de dados: " . $e->getMessage();
      }




      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['validacao'])) {
        $v2 = $_POST['validacao'];
        $pedidoid = $_POST['id'];

        try {
          $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          $queryUpdate = "SELECT * FROM Pedido WHERE Pedido_id = :pedido_id";
          $stmtUpdate = $pdo->prepare($queryUpdate);
          $stmtUpdate->bindParam(':pedido_id', $pedidoid);

          if ($stmtUpdate->execute()) {
            $ped = $stmtUpdate->fetch(PDO::FETCH_ASSOC);

            if ($ped['v1'] == $v2) {
              // Update existing record instead of inserting
              $sql = "UPDATE Pedido SET v2 = :v2 WHERE Pedido_id = :pedido_id";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':v2', $v2);
              $stmt->bindParam(':pedido_id', $pedidoid);

              if ($stmt->execute()) {
                echo '<p style="color: #2bc460;">Produto entregue com sucesso!</p>';
              } else {
                // Log the error instead of exposing it to the user
                error_log("Erro ao entregar produto: " . implode(", ", $stmt->errorInfo()));
                echo '<p style="color: #FF0000;">Erro ao entregar produto</p>';
              }
            } else {
              echo '<p style="color: #FF0000;">Código incorreto</p>';
            }
          } else {
            echo "Select produto não funcionou";
          }
        } catch (PDOException $e) {
          // Log the error instead of exposing it to the user
          error_log("Erro na execução da consulta: " . $e->getMessage());
          echo "Erro na execução da consulta.";
        } finally {
          // Close the database connection
          $pdo = null;
        }
      }
      ?>




      <style>
        .custom-submit-btn {
          background-color: #007bff;
          /* Cor de fundo */
          color: #ffffff;
          /* Cor do texto */
          padding: 10px 20px;
          /* Espaçamento interno */
          border: none;
          /* Remover a borda */
          border-radius: 5px;
          /* Borda arredondada */
          cursor: pointer;
          /* Cursor de apontar */
          font-size: 16px;
          /* Tamanho da fonte */
        }

        .custom-submit-btn:hover {
          background-color: #0056b3;
          /* Cor de fundo ao passar o mouse */
        }
      </style>

      <script>
        // JavaScript para exibir/ocultar o formulário
        function exibirFormulario(formId) {
          var form = document.getElementById(formId);
          form.style.display = (form.style.display === 'none' || form.style.display === '') ? 'block' : 'none';
        }
      </script>
      <!-- Adicione mais blocos de card conforme necessário -->
    </section>
  </main>







  <!-- Arquivos Bootstrap -->
  <script src="./assets/js/jquery.js"></script>
  <script src="./assets/js/popper.js"></script>
  <script src="./assets/js/bootstrap.js"></script>
</body>

</html>