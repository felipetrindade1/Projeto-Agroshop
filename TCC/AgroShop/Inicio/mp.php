<?php
session_start();
// Carrega a Biblioteca do Mercado Pago
require_once 'vendor/autoload.php';

// Configure suas credenciais
MercadoPago\SDK::setAccessToken('TEST-1498989923657863-070317-4fcc5d26a2d176d7bfe5e186736aba9d-22727655');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carrinhoProdutos'])) {
    // Limpe a sessão atual antes de salvar os novos dados
    $_SESSION['carrinhoProdutos'] = array();

    // Salve os novos dados na SESSION
    $_SESSION['carrinhoProdutos'] = json_decode($_POST['carrinhoProdutos'], true);

    /*
    // Exiba os dados do carrinho salvos na SESSION
    echo "<h2>Dados do Carrinho salvos na SESSION:</h2>";
    echo "<pre>";
    print_r($_SESSION['carrinhoProdutos']);
    echo "</pre>";
    */
}

// Verifique se a requisição é para selecionar números da rifa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha a string JSON dos itens do carrinho
    $carrinhoProdutosJSON = $_POST['carrinhoProdutos'];

    // Decodifique a string JSON para obter o array de itens do carrinho
    $carrinhoProdutos = json_decode($carrinhoProdutosJSON, true);

    // Se a decodificação for bem-sucedida e $carrinhoProdutos for um array
    if (is_array($carrinhoProdutos)) {
        // Defina o valor total do carrinho

        // Crie uma instância do carrinho de compras
        $items = [];
        foreach ($carrinhoProdutos as $produto) {
            $items[] = new MercadoPago\Item([
                'id' => $produto['id'], // Id do produto
                'title' => $produto['nome'], // Nome do produto
                'quantity' => $produto['quantidade'], // Quantidade do produto
                'unit_price' => $produto['preco'] // Preço unitário do produto
            ]);
        }

        // Crie uma instância da preferência de pagamento fora do loop
        $preference = new MercadoPago\Preference();
        $preference->items = $items;
        $preference->back_urls = [
            "success" => "http://localhost/AgroShop/Inicio/retorno.php?rt=success",
            // Se a compra for concluida o usuario será direcionado para pedidos, onde o pedido sera adicionado ao banco de dados.
            // Os dados do carrinho serão salvos (javascript), e o carrinho será esvaziado.
            "failure" => "http://localhost/AgroShop/Inicio/carrinho.php?rt=error",
            // O usuário será redirecionado para o carrinho de compras, onde todos os itens permanecerão caso haja uma nova tentativa de compra.
            // Uma notificação será exibida ao usuário - Erro 
            "pending" => "http://localhost/AgroShop/Inicio/carrinho.php?rt=pending"
            // O usuário será redirecionado para o carrinho de compras, onde todos os itens permanecerão caso haja uma nova tentativa de compra.
            // Uma notificação será exibida ao usuário - Compra não finalizada
        ];
        $preference->auto_return = 'approved';
        $preference->save();

        // Redirecione o usuário para a página de pagamento do Mercado Pago
        header('Location: ' . $preference->init_point);
        exit;
    }
}
