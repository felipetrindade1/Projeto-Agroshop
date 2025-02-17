<?php

//Carrega Biblioteca do Mercado Pago
require_once 'vendor/autoload.php';

// Configure suas credenciais
MercadoPago\SDK::setAccessToken('TEST-1498989923657863-070317-4fcc5d26a2d176d7bfe5e186736aba9d-22727655');

// Verifique se a requisição é para selecionar números da rifa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numeros_rifa'])) {
    // Obtenha os números selecionados pelo usuário
    $numerosSelecionados = $_POST['numeros_rifa'];

    // Defina o valor fixo por número
    $valorPorNumero = 10.00;

    // Calcule o valor total do carrinho
    $valorTotal = count($numerosSelecionados) * $valorPorNumero;

    // Crie uma instância do carrinho de compras
    $items = [];
    foreach ($numerosSelecionados as $numero) {
        $items[] = new MercadoPago\Item([
            'id' => $numero,
            'title' => "Número da rifa: $numero",
            'quantity' => 1,
            'unit_price' => $valorPorNumero
        ]);
    }

    // Crie uma instância da preferência de pagamento
    $preference = new MercadoPago\Preference();
    $preference->items = $items;
    $preference->back_urls = [
        "success" => "https://personalizepapel.com.br/rifa/retorno.php?rt=success",
        "failure" => "https://personalizepapel.com.br/rifa/retorno.php?rt=error",
        "pending" => "https://personalizepapel.com.br/rifa/retorno.php?rt=pending"
    ];
    $preference->auto_return = 'approved';
    $preference->save();

    // Redireciona o usuário para a página de pagamento do Mercado Pago
    header('Location: ' . $preference->init_point);
    exit;
} else {
    //formulário para selecionar os números da rifa
    $quantidadeNumeros = 100; // quantidade de números disponíveis na rifa

    echo '<form method="post" action="">';
    for ($i = 1; $i <= $quantidadeNumeros; $i++) {
        echo "<input type='checkbox' name='numeros_rifa[]' value='$i'> Número $i<br>";
    }
    echo '<input type="submit" value="Pagar">';
    echo '</form>';
}