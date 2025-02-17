<?php


include_once('protect.php');
include_once('conexao.php');

/////////////////////////////////////////////////////// PERFIL USUARIO //////////////////////////////////////////////////////////////////////////

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
};





/////////////////////////////////////////////////////////////  CARRINHO DE COMPRAS  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['limpar_carrinho'])) {
    // Lógica para limpar o carrinho

    // Define o cookie 'carrinho' para um valor vazio e com um tempo no passado para expirar
    setcookie('carrinho', '', time() - 3600);


    // Redirecione para a mesma página para atualizar a exibição do carrinho
    echo '<script type="text/javascript">
 window.location = "carrinho.php";
 </script>';
    // Recupere o carrinho do cookie (se existir)
    if (isset($_COOKIE['carrinho'])) {
      $carrinho = unserialize($_COOKIE['carrinho']);
    }
  } elseif (isset($_POST['removerDoCarrinho'])) {
    if (isset($_COOKIE['carrinho'])) {
      $carrinho = unserialize($_COOKIE['carrinho']);

      $valor1Form = $_POST['valor1Form'];

      foreach ($carrinho as $indice => $item) {
        if ($item['valor2'] == $valor1Form) {
          unset($carrinho[$indice]);
        }
      }

      $carrinho = array_values($carrinho);

      setcookie('carrinho', serialize($carrinho), time() + 3600);


      // Redirecione para a mesma página para atualizar a exibição do carrinho
      echo '<script type="text/javascript">
                window.location = "carrinho.php";
            </script>';
    }
  }
}


///////////////////////////////////////////////////////////// EXCLUIR ITEM CARRINHO /////////////////////////////////////////////////////////////////




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
  <style>
    #carrinhoh:hover {
      /* Adicione os estilos desejados para o efeito hover */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transform: scale(1.05);
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
  </style>

</head>

<body>

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
            <a href="carrinho.php">
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
              <a href="carrinho.php">
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
              <a href="index.php?quemSomos">
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
              <a href="index.php?produtos=Todos">
                Todos os produtos
              </a>
            </li>


            <?php

            include_once "conexao.php";

            // Consulta SQL para buscar as categorias
            $query = "SELECT * FROM Categoria";
            $stmt = $con->prepare($query);
            $stmt->execute();
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categorias as $categoria) {
              echo "<li class='nav-item'>
                        <a href='index.php?produtos=" . $categoria['Tipo'] . "'>" . $categoria['Tipo'] . "</a>
                    </li>";
            }

            ?>

          </ul>
        <li class="col-xl-2 col-lg-3 col-md-12 nav-item d-flex align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop-window" viewBox="0 0 16 16">
            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zm2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5z" />
          </svg>
          <a href="index.php?minhaLoja">
            Minha loja
          </a>

        </li>
        </li>

      </ul>
      <!-- menu -->
    </section>
    <!-- end container -->
  </nav>
  <!-- end menu do site -->




  <main class="carrinho-geral" style="min-height: 540px;">
    <div class="container">
      <!-- <h1>Não há produtos</h1> -->
      <div class="row">
        <div class="col-md-8" style="padding: 10px;">
          <section class="container produtos">
          </section>

          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Carrinho de compras</li>
            </ol>
          </nav>

          <form method="post">
            <button type="submit" class="btn btn-outline-success" name="limpar_carrinho" style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">Limpar carrinho</button>
          </form>
          <br>
          <br>



          <?php
          ///////////////////////////////////////////////////////////// CARRINHO DE COMPRAS //////////////////////////////////////////////////////////////////          


          // Verifique se o carrinho está vazio
          if (isset($_COOKIE['carrinho']) && isset($_SESSION["id"])) {
            $carrinho = unserialize($_COOKIE['carrinho']);

            // Inclua a conexão com o banco de dados (conexão.php)
            include_once "conexao.php";

            // Inicialize o array valorTotal
            $valorTotal = array();

            // Itere pelo carrinho de compras
            foreach ($carrinho as $item) {
              if ($item['valor1'] == $_SESSION["id"]) {
                $valor2 = $item['valor2'];

                // Consulta SQL para selecionar produtos com base no valor2 (Produto_id)
                $sql = "SELECT *
                      FROM Produto
                      WHERE Produto_id = :valor2";

                $select = $con->prepare($sql);
                $select->bindParam(':valor2', $valor2, PDO::PARAM_INT);
                $select->execute();

                if ($select->rowCount() > 0) {
                  while ($produto = $select->fetch(PDO::FETCH_ASSOC)) {

                    echo "<div class='card mb-3 border-1' id='carrinhoh' style='max-width: 540px;'>
                    <div class='row g-0 pl-5'>
                      <div class='col-md-4 d-flex align-items-center' style='border-radius: 10%;'>
                        <img src='" . $produto['imgPath'] . "' class='img-fluid rounded-start' alt='...' width='110%' height='100%'>
                      </div>
                      <div class='col-md-8'>
                        <div class='card-body'>
                          <h5 class='card-title'>" . $produto['Nome'] . "</h5>
                          <p id='preco-produto-" . $produto['Produto_id'] . "' class='card-text' style='color: brown;'>R$ " . $produto['Preco'] . "<b style='color: black;'>  " . $produto['Unidade']  . "</b></p>
            
                          <div class='d-flex justify-content-between align-items-center'>
                            <input type='text' class='form-control quantidade-produto col-md-9' aria-label='' onfocus='this.select();' placeholder='Quantidade (max: " . $produto['Quantidade'] . ")' name='quantidadeProduto' data-produto-id='" . $produto['Produto_id'] . "'  max=" . $produto['Quantidade'] . " value='1'  min='0' oninput='ajustarValorMaximo(this)'>
              
                            <form method='post'>
                                <input type='hidden' name='valor1Form' id='valor1Form' value='" . $produto['Produto_id'] . "'>
                                <button type='submit' name='removerDoCarrinho' class='btn btn-danger '>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                        <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z'/>
                                        <path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z'/>
                                    </svg>
                                </button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>";
                  }
                } else {
                  echo "Nenhum produto encontrado para o valor2: $valor2";
                }
              }
            }
          }



          ?>

          <!-- FIM TAGS DO CARD -->
          <!-- FIM TAGS DO CARD -->
          </section>
        </div>
        <div class="col-md-4" style="margin-top: 30px;">
          <aside id="carrinho-aside" class="bg bg-light">
            <form method="post" action="mp.php" onsubmit="return validarFormulario()">
              <h4>Valor Total</h4>
              <hr>
              <!-- Adicione um campo de input oculto para enviar o carrinhoProdutos como JSON -->
              <input type="hidden" name="carrinhoProdutos" id="carrinhoProdutosInput" value="">
              <div id="preco-final"></div>
              <button class="finalizar-compra">Finalizar Compra</button>
            </form>
          </aside>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
          $(document).ready(function() {
            var carrinhoProdutos = []; // Array para armazenar as informações dos produtos

            // Função para adicionar um produto ao carrinhoProdutos
            function adicionarProdutoAoCarrinho(produtoId, quantidade, nome, preco) {
              var produtoInfo = {
                id: produtoId,
                nome: nome,
                quantidade: quantidade,
                preco: preco
              };

              console.log(carrinhoProdutos);

              var index = carrinhoProdutos.findIndex(p => p.id === produtoInfo.id);
              if (index !== -1) {
                carrinhoProdutos[index] = produtoInfo;
              } else {
                carrinhoProdutos.push(produtoInfo);
              }

              // Atualizar o valor do campo de input com a string JSON do carrinhoProdutos
              $("#carrinhoProdutosInput").val(JSON.stringify(carrinhoProdutos));
            }

            // Iterar sobre os produtos já presentes na página
            $(".card").each(function() {
              var produtoId = $(this).find(".quantidade-produto").data("produto-id");
              var quantidade = $(this).find(".quantidade-produto").val();
              var nome = $(this).find(".card-title").text();
              var preco = parseFloat($(this).find(".card-text").text().replace("R$ ", ""));

              adicionarProdutoAoCarrinho(produtoId, quantidade, nome, preco);
            });

            // Função para atualizar o carrinho e o valor total
            function atualizarCarrinho() {
              var valorTotal = carrinhoProdutos.reduce(function(total, produto) {
                return total + produto.quantidade * produto.preco;
              }, 0);

              $("#preco-final").text("R$ " + valorTotal.toFixed(2));
              $("input[name='valorT']").val(valorTotal.toFixed(2));
            }



            // Evento ao alterar a quantidade de um produto
            $(".quantidade-produto").on("input", function() {
              var produtoId = $(this).data("produto-id");
              var quantidade = $(this).val();
              var nome = $(this).closest(".card-body").find(".card-title").text();
              var preco = parseFloat($(this).closest(".card-body").find(".card-text").text().replace("R$ ", ""));

              adicionarProdutoAoCarrinho(produtoId, quantidade, nome, preco);
              atualizarCarrinho(); // Atualize a div 'preco-final'
            });

            // Chame a função para calcular o valor total inicialmente
            atualizarCarrinho();
          });



          ////////////// Valor Quantidade //////////////
          function ajustarValorMaximo(input) {
            var valorAtual = parseInt(input.value);
            var valorMaximo = parseInt(input.max);

            if (valorAtual > valorMaximo) {
              input.value = valorMaximo;
            } else if (valorAtual < 0) {
              input.value = 1;
            } else if (valorAtual == 0) {
              input.value = 1;
            } else if (valorAtual === null) {
              input.value = 1;
            }
          }


          /////////// Validação de Valor igual a zero ////////////
          function validarFormulario() {
            // Obtenha o valor total
            var valorTotal = parseFloat(document.getElementById("preco-final").innerText.replace("R$ ", ""));

            // Verifique se o valor total é maior que 0
            if (valorTotal <= 0) {
              alert("O valor total não pode ser 0. Adicione produtos ao carrinho.");
              return false; // Impede o envio do formulário
            }


            return true;
          }
        </script>

  </main>
  <!-- end main -->
  <br>
  <!-- Footer -->
  <footer class="container-fluid" style="position: relative;">
    <!-- container -->
    <section class="container">
      <!-- menus -->
      <section class="row">
        <!-- atendimento -->
        <article class="col-md-4">
          <h4>
            Atendimento
          </h4>
          <!-- links -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="tel:+5511999999999">(11) 9 9999 9999</a>
            </li>

            <li class="nav-item">
              <a href="mailto:contato@sualoja.com.br">contato@sualoja.com.br</a>
            </li>

            <li class="nav-item">
              Horário de atendimento on-line: Segunda à sexta das 9:00 até as 17:30h
            </li>
          </ul>
        </article>
        <!-- end atendimento -->

        <!-- acesso rápido -->
        <article class="col-md-3">
          <h4>
            Acesso rápido
          </h4>
          <!-- links -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="#">Minha conta</a>
            </li>

            <li class="nav-item">
              <a href="#">Meus pedidos</a>
            </li>

            <li class="nav-item">
              <a href="#">Rastrear meus pedidos</a>
            </li>

            <li class="nav-item">
              <a href="#">Troca e devoluções</a>
            </li>
          </ul>
        </article>
        <!-- end acesso rápido -->

        <!-- institucional -->
        <article class="col-md-3">
          <h4>
            Institucional
          </h4>
          <!-- links -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="#">Sobre a loja</a>
            </li>

            <li class="nav-item">
              <a href="#">Politica e privacidade</a>
            </li>
          </ul>
        </article>
        <!-- end institucional -->

        <!-- mais acessadas -->
        <article class="col-md-2">
          <h4>
            Mais acessados
          </h4>
          <!-- links -->
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="#">Cafe</a>
            </li>

            <li class="nav-item ellipsis">
              <a href="#">Laranja</a>
            </li>

            <li class="nav-item">
              <a href="#">Tomate</a>
            </li>

            <li class="nav-item">
              <a href="#">Pepino</a>
            </li>
          </ul>
        </article>
        <!-- end mais acessadas -->
      </section>
      <!-- end menus -->
    </section>
    <!-- end container -->

  </footer>
  <!-- end Footer-->

  <!-- Arquivos Bootstrap -->
  <script src="./assets/js/jquery.js"></script>
  <script src="./assets/js/popper.js"></script>
  <script src="./assets/js/bootstrap.js"></script>
</body>

</html>