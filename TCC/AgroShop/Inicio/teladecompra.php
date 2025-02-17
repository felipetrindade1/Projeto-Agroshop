<?php

include_once('protect.php');

//////////////////////////////////////////////////////////////////////  CARRINHO DE COMPRAS  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// PEGA O VALOR ID DO PRODUTO NA URL //
$id = intval($_GET['produto']) ?? 0;
//echo $id;



/////////////// ADICIONAR AO CARRINHO ///////////////
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['addAoCarrinho'])) {
    // Lógica para o primeiro formulário
    $carrinho = array(); // Crie um array vazio para o carrinho


    if (isset($_SESSION['id']) && isset($id)) {
      // Converta os valores dos campos para inteiros
      $valor1 = $_SESSION['id'];
      $valor2 = $id;

      $tresValores = array("valor1" => $valor1, "valor2" => $valor2);

      // Verifique se o carrinho já existe como um cookie
      if (isset($_COOKIE['carrinho'])) {
        $carrinho = unserialize($_COOKIE['carrinho']); // Recupere o carrinho do cookie
      }

      // Verifique se o item com o mesmo valor de $valor2 já existe no carrinho
      $itemJaExiste = false;

      foreach ($carrinho as $item) {
        if ($item['valor2'] === $valor2) {
          $itemJaExiste = true;
          break;
        }
      }

      // Se o item não existe, adicione-o ao carrinho
      if (!$itemJaExiste) {
        $carrinho[] = $tresValores;
      }

      // Serializar o carrinho e configurá-lo como um cookie válido por 1 hora
      if (setcookie('carrinho', serialize($carrinho), time() + 3600)) {

        $url = "?produto=" . $id;

        // Redirecione para a mesma página para atualizar a exibição do carrinho
        header('Location: ' . $_SERVER['PHP_SELF'] . $url);
        exit;
      }
    }

    if (isset($_COOKIE['carrinho'])) {
      $carrinho = unserialize($_COOKIE['carrinho']);
    }
  }  //elseif (isset($_POST['comprar'])) {
  //header('Location: ' . "https://www.youtube.com/"); /// url de exemplo

  //}
}




////////////////////////////////////////////////////////////////////////  PERFIL USUARIO   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
      $usuario['imgPath'];
      $userNome = strstr($nome, ' ', true); // Formata o nome
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




////////////////////////////////////////////////////////////////////////  PRODUTOS   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////   BUSACA OS DADOS DO PRODUTO NO BANCO  ///////////////////
include_once "conexao.php";
try {
  $sql = "SELECT * FROM Produto WHERE Produto_id = :id";

  $stmt = $con->prepare($sql);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Use PDO::PARAM_INT para valores inteiros

  $stmt->execute();

  // Recupere os dados do produto
  $produto = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($produto) {
    // Aqui você pode acessar os campos do produto, por exemplo:
    $idProd = $produto['Produto_id'];
    $nome = $produto['Nome'];
    $preco = $produto['Preco'];
    $descricao = $produto['Descricao'];
    $parcelas = $produto['Parcelas'];
    $imagem = $produto['imgPath'];

    //echo "Nome do Produto: $nome<br>";
    //echo "Preço: $preco<br>";
    // ... continue acessando os outros campos conforme necessário
  } else {
    echo "Nenhum produto encontrado com o id: $id";
  }
} catch (PDOException $e) {
  echo "Erro: " . $e->getMessage();
}


////////////////////////////////////////////////////////////////////////  PRODUTOS   ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



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




  <main style="min-height: 540px;">

    <!-- container produto -->
    <section class="container">

      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php?inicio">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Compra do produto</li>
        </ol>
      </nav>

      <?php /*if (isset($_SESSION["valorTotal"])) {
        print_r($_SESSION["valorTotal"]);
      }; */ ?>

      <article class="row produtos-compra">
        <figure class="col-md-7 mb-3">
          <img width="90%" src="<?php echo $produto['imgPath']; ?>" class="img-fluid" alt="Camiseta manga Comprida">
        </figure>

        <section class="col-md-5 mb-3 d-flex flex-column justify-content-around">
          <article class="produtos-conteudo">
            <h1>
              <?php echo $produto['Nome']; ?>
            </h1>
            <p>
              <?php echo $produto['Descricao']; ?>
            </p>
          </article>

          <article class="produtos-preco">
            <div class="produtos-stars">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>

              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>

              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>

              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-star-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.283.95l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>
            </div>

            <strong style="color: brown;">
              <?php echo $produto['Preco']; ?>


            </strong>
            <p>Kg<?php // echo $x['Unidade']; 
                  ?></p>
            <b class="d-block">Em até
              <?php echo $produto['Parcelas']; ?>x sem Juros
            </b>


            <form method="post" action="mp.php">
              <div class="form-group">
                <label for="produtos-quantidade-itens">Quantidade  - Max: <?php echo $produto['Quantidade']; ?></label>
                <input type="hidden" class="form-control" name="id" value="<?php echo $produto['Produto_id'] ?>"></input>
                <input type="hidden" class="form-control" name="nome" value="<?php echo $produto['Nome'] ?>"></input>
                <input type="number" class="form-control" id="produtos-quantidade-itens" placeholder="Digite a quantidade" name="qntd" max="<?php echo $produto['Quantidade']; ?>" oninput="ajustarValorMaximo(this)" value="1"></input>
                <input type="hidden" class="form-control" name="preco" value="<?php echo $produto['Preco'] ?>"></input>
                <input type="hidden" name="carrinhoProdutos" id="carrinhoProdutosInput" value="">
                <button type="submit" class="btn btn-success col-md-12" id="carrinho" name="comprar">Comprar</button>
                <?php // echo $produto['Quantidade'] * 2; 
                ?>
              </div>
            </form>
            <form method="post">
              <button type="submit" class="btn btn-success col-md-12" name="addAoCarrinho">Adicionar ao carrinho</button><br><br>
            </form>
            <br>
          </article>
        </section>
      </article>
      <br>


      <div class="comment-container border-0">
        <form method="post">
          <input type="text" name="conteudo" class="conteudo" placeholder="Digite seu comentário..." required>
          <input type="submit" class="botaoz1" name="Enviar" value="Enviar">
        </form>
      </div>

      <br>
      <br>


      <!-- ////////////////   COMENTÁRIOS  /////////////////// -->
      <?php
      ////////////////   ADICIONA COMENTÁRIOS  ///////////////////
      if (isset($_POST['Enviar'])) {
        try {
          $pdo = new PDO("mysql:host=localhost;dbname=projeto", "root", "");

          if (isset($_GET['produto'])) {
            $id = intval($_GET['produto']);
            //echo $id;
          }

          // Dados para inserir
          $conteudo = $_POST['conteudo'];
          $Usuario_id = $_SESSION['id']; // Substitua pelo ID do usuário
          $Produto_id = $id; // Substitua pelo ID do produto

          // Preparar a consulta SQL
          $stmt = $pdo->prepare("INSERT INTO comentarios (conteudo, Usuario_id, Produto_id) VALUES (:conteudo, :Usuario_id, :Produto_id)");

          // Vincular os parâmetros
          $stmt->bindParam(':conteudo', $conteudo, PDO::PARAM_STR);
          $stmt->bindParam(':Usuario_id', $Usuario_id, PDO::PARAM_INT);
          $stmt->bindParam(':Produto_id', $Produto_id, PDO::PARAM_INT);

          // Executar a consulta
          $stmt->execute();
        } catch (PDOException $e) {
          echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
        }
      }
      ?>

      <h5>Feedback de outros usuarios</h5>
      <hr>
      <br>


      <?php
      // Inclua a conexão com o banco de dados (conexão.php)
      include_once "conexao.php";

      // ID do produto a ser exibido (substitua pelo ID desejado)


      // Consulta SQL para selecionar os comentários de um produto específico
      $sql = "SELECT c.Id AS ComentarioID, c.data_comentario, c.conteudo, c.Usuario_id, u.Nome AS NomeUsuario, p.Nome AS NomeProduto
    FROM comentarios c
    INNER JOIN Usuario u ON c.Usuario_id = u.Usuario_id
    INNER JOIN Produto p ON c.Produto_id = p.Produto_id
    WHERE p.Produto_id = :id";

      $select = $con->prepare($sql);
      $select->bindParam(':id', $id, PDO::PARAM_INT);
      $select->execute();

      if ($select->rowCount() > 0) {
        while ($x = $select->fetch(PDO::FETCH_ASSOC)) {
          $usuarioId = $x['Usuario_id'];

          // Consulta SQL para selecionar o valor de "imgPath" para um usuário específico
          $sql = "SELECT imgPath FROM Usuario WHERE Usuario_id = :usuarioId";

          $selectImg = $con->prepare($sql);
          $selectImg->bindParam(':usuarioId', $usuarioId, PDO::PARAM_INT);
          $selectImg->execute();

          if ($selectImg->rowCount() > 0) {
            $row = $selectImg->fetch(PDO::FETCH_ASSOC);
            $imgPath = $row['imgPath'];
          } else {
            $imgPath = 'arquivos/usuarios/userPadrao.png'; // Imagem padrão se não for encontrada
          }
      ?>
          <div class="card mb-3" style="border:none;">
            <div class="row g-1">
              <div class="col-md-1">
                <img src="<?php echo $imgPath; ?>" class="img-fluid rounded-start" alt="..." width="100" height="100">
              </div>
              <div class="col-md-9">
                <div class="card-body">
                  <h5 class="card-title">
                    <?php echo $x['NomeUsuario']; ?>
                  </h5>
                  <p class="card-text">
                    <?php echo $x['conteudo']; ?>
                  </p>
                  <p class="card-text"><small class="text-body-secondary">
                      <?php echo $x['data_comentario']; ?>
                    </small></p>
                </div>
              </div>
            </div>
          </div>

      <?php
        }
      } else {
        echo '<p>Nenhum comentário encontrado para este produto.</p>';
      }
      ?>

    </section>
    <!-- container produto -->
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
              <a href="#">cafe</a>
            </li>

            <li class="nav-item ellipsis">
              <a href="#">Tomate</a>
            </li>

            <li class="nav-item">
              <a href="#">Laranja</a>
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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>


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

      // Evento ao clicar no botão de compra
      $("#carrinho").on("click", function(event) {
        event.preventDefault();

        var form = $(this).closest("form");
        var produtoId = form.find('[name="id"]').val();
        var quantidade = form.find('[name="qntd"]').val();
        var nome = form.find('[name="nome"]').val();
        var preco = parseFloat(form.find('[name="preco"]').val());

        adicionarProdutoAoCarrinho(produtoId, quantidade, nome, preco);

        // Adicione qualquer lógica adicional necessária antes de enviar o formulário
        form.submit();
      });

      // Chame a função para calcular o valor total inicialmente
      atualizarCarrinho();

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
    });




    ////////////// Valor maximo Quantidade //////////////
    function ajustarValorMaximo(input) {
      var valorAtual = parseInt(input.value);
      var valorMaximo = parseInt(input.max);

      if (valorAtual > valorMaximo) {
        input.value = valorMaximo;
      } else if (valorAtual < 0) {
        input.value = 1;
      } else if (valorAtual == 0) {
        input.value = 1;
      } else if (valorAtual = null) {
        input.value = 1;
      }
    }
  </script>






</body>

</html>