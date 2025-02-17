<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inserir Código de Verificação</title>
    <link rel="stylesheet" href="./assets/css/style2.css">
    <!-- Adicione seus estilos CSS e outros cabeçalhos necessários aqui -->
</head>

<body>
    <main class="container">
        <h2>Inserir Código de Verificação</h2>

        <form method="POST" action="verificar_codigo.php">
            <div class="input-field">
                <input type="text" name="codigo" id="codigo" placeholder="Digite o código recebido" required>
                <div class="underline"></div>
            </div>

            <!-- Adicione outros campos ou estilos conforme necessário -->

            <input type="submit" value="Verificar Código">
        </form>

        <!-- Adicione outros elementos HTML conforme necessário -->
    </main>

    <!-- Adicione seus scripts JavaScript e outros scripts conforme necessário -->
</body>

</html>