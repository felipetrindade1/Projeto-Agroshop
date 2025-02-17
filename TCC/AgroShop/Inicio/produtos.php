<?php

use function PHPSTORM_META\type;

include_once('protect.php');

?>

<!DOCTYPE html>
<html lang="pt-br">


<body>




  <!-- container produtos -->
  <section class="container produtos">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?inicio">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Produtos</li>
        <li class="breadcrumb-item active" aria-current="page"><?php
                                                                if (isset($_GET['produtos'])) {
                                                                  // Recupera e sanitiza o valor
                                                                  $titulo = htmlspecialchars($_GET['produtos']);
                                                                  echo $titulo;
                                                                } ?></li>
      </ol>
    </nav>

    <!-- title -->
    <h1>Veja todos os nosso produtos mais vendidos</h1>

    <div class="middle">

      <?php
      include_once "conexao.php";

      // Consulta SQL para buscar as categorias
      $query = "SELECT * FROM Categoria";
      $stmt = $con->prepare($query);
      $stmt->execute();
      $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>

      <div class="categoria-links">
        <a href='index.php?produtos=Todos' class='btn btn1 active' style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          Todos
        </a>
        <?php foreach ($categorias as $categoria) : ?>
          <a href='index.php?produtos=<?= $categoria['Tipo'] ?>' class='btn btn1 active' style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
            <?= $categoria['Tipo'] ?>
          </a>
        <?php endforeach; ?>
      </div>

    </div>



    <!-- listagem dos produtos -->
    <article class="row" id="">

      <!-- TODOS OS CARDS DE PRODUTO FICAM CONTIDO NESSE ARTICLE -->

      <?php

      include_once "conexao.php";


// Verifica se o parâmetro "produtos" está definido na URL
if (isset($_GET['produtos']) !== 'Todos') {
    // Recupera e sanitiza o valor
    $valorProdutos = htmlspecialchars($_GET['produtos']);

    if ($valorProdutos == 'Todos') {
        $query = "SELECT Produto.*, Categoria.Tipo as CategoriaTipo, Usuario.Nome as NomeVendedor
              FROM Produto 
              INNER JOIN Categoria ON Produto.Categoria_id = Categoria.Categoria_id
              INNER JOIN Usuario ON Produto.Usuario_id = Usuario.Usuario_id
              WHERE Produto.Quantidade > 0"; // Adiciona a condição para Quantidade > 0

        $stmt = $con->prepare($query);
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($valorProdutos !== 'Todos') {
        $query = "SELECT Produto.*, Categoria.Tipo as CategoriaTipo, Usuario.Nome as NomeVendedor
              FROM Produto 
              INNER JOIN Categoria ON Produto.Categoria_id = Categoria.Categoria_id
              INNER JOIN Usuario ON Produto.Usuario_id = Usuario.Usuario_id
              WHERE Categoria.Tipo = :tipoCategoria AND Produto.Quantidade > 0"; // Adiciona a condição para Quantidade > 0

        $stmt = $con->prepare($query);
        $stmt->bindParam(':tipoCategoria', $valorProdutos);
        $stmt->execute();
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Consulta SQL para selecionar os produtos com a categoria correspondente

    if (count($produtos) == 0) {
        echo "<b>Nenhum produto encontrado</b>";
    }



        // Exibe os produtos
        foreach ($produtos as $x) {
          // Seu código HTML para exibir os detalhes do produto aqui
          echo '<div class="produtos-container" style="padding: 01.5%; margin-bottom: 2%; margin: 1%;">
    <a href="teladecompra.php?produto=' . $x['Produto_id'] . '">
        <!-- imagem do produto -->
        <img style="height: 150px; width: 220px; float: left; margin-bottom: 3%;" src="' . $x['imgPath'] . '" class="img-fluid" alt="' . $x['Descricao'] . '">

        <!-- itens do produto -->
        <article class="produtos-itens">
            <!-- title produto -->
            <h2>' . $x['Nome'] . '</h2>
            <!--<button value="' . $x['Produto_id'] . '" id="del" class="btn btn-danger" action=""><i class="bi bi-trash"></i> -->

            <!-- stars -->
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
            </div>

            <p style="font-weight: lighter;">Loja ' . $x['NomeVendedor'] . ' </p>
            <hr>
            <b style="color: brown; margin-top: 0%;">' . '<br> R$ ' . $x['Preco'] . '</b>
            <p>' . $x['Unidade'] . '</p>
        </article>

        <i class="bi bi-cart2"></i>
        <!-- end itens do produto -->
    </a>
</div>';
        }
      } 
      ?>

      

    </article>