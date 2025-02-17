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
  <style>
    main {
      transition: opacity 0.5s ease;
      opacity: 0;
    }

    main.loaded {
      opacity: 1;
    }

    .produtos-container:hover {
      /* Adicione os estilos desejados para o efeito hover */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transform: scale(1.05);
      transition: box-shadow 0.3s ease, transform 0.3s ease;
    }
  </style>

</head>

<body>
  <script>
    window.addEventListener('DOMContentLoaded', (event) => {
      // Adiciona a classe 'loaded' à main para iniciar a transição
      document.querySelector('main').classList.add('loaded');
    });
  </script>
  <!-- header -->
  <header class="container-fluid" style=" height: 05%;">
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

  <!-- main -->
  <main style="min-height: 1000px; ">
    <?php



    /////////////// Apaga os produtos com quantidade igual à zero /////////////
/*
    try {
      $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
      // Corrija a cláusula DELETE e use = em vez de ==
      $queryUpdate = "DELETE FROM Produto WHERE Quantidade = 0";
      $stmtUpdate = $pdo->prepare($queryUpdate);
  
      if ($stmtUpdate->execute()) {
          echo "Delete executado com sucesso";
      } else {
          echo "Delete não executado";
      }
  } catch (PDOException $e) {
      echo "Erro na execução da consulta: " . $e->getMessage();
  }
  */



    /////////////////////////////////////////////////  CONTEÚDO GERAL DA PAGINA DE ACORDO COM CADA URL /////////////////////////////////////////////////////////
    // Verifica se o parâmetro view está presente na URL e é igual a index

    // Verifica se o parâmetro carrinho está presente na URL
    if (isset($_GET['inicio'])) {
      include('inicio.php');
    } elseif (isset($_GET['avatar'])) {
      include('avatar.php');
    } elseif (isset($_GET['minhaLoja'])) {
      include('minhaLoja.php');
    } elseif (isset($_GET['pedidos'])) {
      include('pedidos.php');
    } elseif (isset($_GET['produtos'])) {
      include('produtos.php');
    } elseif (isset($_GET['quemSomos'])) {
      include('quemSomos.php');
    } else {
      echo '<script type="text/javascript">
                            window.location = "index.php?inicio";
                            </script>';
    }
    ?>
  </main>
  <!-- end main -->

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
              <a href="index.php?minhaLoja">contato@sualoja.com.br</a>
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
              <a href="index.php?avatar">Minha conta</a>
            </li>

            <li class="nav-item">
              <a href="index.php?pedidos">Meus pedidos</a>
            </li>

            <li class="nav-item">
              <a href="index.php?pedidos">Rastrear meus pedidos</a>
            </li>

            <li class="nav-item">
              <a href="#">Reclamações</a>
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
              <a href="index.php?quemSomos">Sobre a loja</a>
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


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
  $(document).ready(function() { //ao terminar de carregar a página
    $('#resultado-pesquisa').load('filtro.php'); //Carregar conteúdo da página filtro.php

    $('#pesquisa').on('input', function() { //Evento de digitar conteúdo no campo pesquisa

      var conteudoDigitado = $('#pesquisa').val(); //Pego valor digitado

      if (conteudoDigitado) { //Verifico se existe valor

        $.ajax({ //requisição http
          url: 'filtro.php', //arquivo requisitado
          method: 'GET', //metodo GET
          data: {
            pesquisa: conteudoDigitado //valor do campo pesquisa
          },
          success: function(resposta) { //resposta se tudo der certo
            $('#resultado-pesquisa').html(resposta); // insere conteúdo da resposta no div
          },
          error: function() {
            $('#resultado-pesquisa').html("Erro ao buscar"); // se der erro
          },
        });

      }

    });

  });
</script>
</div>
</body>

</html>