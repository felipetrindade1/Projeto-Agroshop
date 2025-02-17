<?php
include_once "conexao.php";

$pesquisa = $_GET['pesquisa'] ?? "";

$sql = "SELECT Produto.*, Categoria.Tipo AS NomeCategoria, Usuario.Nome AS NomeVendedor
        FROM Produto
        INNER JOIN Categoria ON Produto.Categoria_id = Categoria.Categoria_id
        INNER JOIN Usuario ON Produto.Usuario_id = Usuario.Usuario_id";

// Adiciona a condição geral Produto.Quantidade > 0
$sql .= " WHERE Produto.Quantidade > 0";

if ($pesquisa) {
    // Adiciona a condição específica da pesquisa
    $sql .= " AND (Produto.Nome LIKE :pesquisa OR Produto.Preco LIKE :pesquisa OR Categoria.Tipo LIKE :pesquisa)";
}

$select = $con->prepare($sql);

if ($pesquisa) {
    $select->bindValue(':pesquisa', '%' . $pesquisa . '%', PDO::PARAM_STR);
}

$select->execute();

if ($select->rowCount() > 0) {
    $i = 0;
    while ($x = $select->fetch(PDO::FETCH_ASSOC)) {
        // Restante do código para exibição dos resultados
?>

        <div class="produtos-container" style="padding: 01.5%; margin-bottom: 2%; margin: 1%;">
            <a href="teladecompra.php?produto=<?= $x['Produto_id'] ?>">
                <!-- imagem do produto -->
                <img style="height: 150px; width: 220px; float: left; margin-bottom: 3%;" src="<?= $x['imgPath'] ?>" class="img-fluid" alt="<?= $x['Descricao'] ?>">


                <!-- itens do produto -->
                <article class="produtos-itens">
                    <!-- title produto -->
                    <h2><?= $x['Nome'] ?></h2>
                    <!--<button value="<?= $x['Produto_id'] ?>" id="del<?= $i ?>" class="btn btn-danger" action=""><i class="bi bi-trash"></i> -->

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
                    <p style="font-weight: lighter;">Loja <?= $x['NomeVendedor'] ?> </p>
                    <hr>
                    <b style="color: brown; margin-top: 0%;"><?php echo "<br> R$ " . $x['Preco']; ?></b>
                    <p><?php echo $x['Unidade']; ?></p>

                </article>


                <i class="bi bi-cart2"></i>
                <!-- end itens do produto -->
            </a>
        </div>
<?php
        $i++;
    }
} else {
    echo '<p>Nenhum resultado encontrado.</p>';
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Esta função é executada quando um botão dentro do elemento button com id "deletar" é clicado.
    $("#deletar button").click(function() {
        // Captura o valor do atributo "value" do botão clicado (corresponde ao ID do contato).
        var id = $(this).attr("value");

        // Exibe um diálogo de confirmação para o usuário.
        const confirma = window.confirm("Deseja deletar esse produto?");

        // Verifica se o usuário confirmou a ação.
        if (confirma) {
            // Envia uma requisição GET para o arquivo 'excluir.php' com o parâmetro 'id'.
            $.get('excluir.php', {
                id: id
            }, function(resp) {
                // Atualiza o conteúdo do elemento com id 'result' com a resposta do servidor.
                $('#result').html(resp);

                // Carrega o conteúdo do arquivo 'filtro.php' no elemento com id 'resultado-pesquisa'.
                $('#resultado-pesquisa').load('filtro.php');

                // Faz o elemento com id 'result' desaparecer gradualmente ao longo de 3 segundos.
                $('#result').fadeOut(3000);
            }).fail(function() {
                // Caso a requisição falhe, exibe uma mensagem de erro no elemento com id 'result'.
                $('#result').html('Erro ao deletar.');
            });
        }
    });
</script>