<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./assets/images/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="./assets/images/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- end Favicons -->

    <!-- Css -->
    <link rel="stylesheet" href="./assets/css/style2.css" />
</head>

<body>
    <main class="container">
        <h2>Login</h2>
        <form action="" method="post">
            <div class="input-field">
                <input type="text" name="email" id="email" placeholder="Digite seu email">
                <div class="underline"></div>
            </div>
            <div class="input-field">
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                <div class="underline"></div>
            </div>

            <input type="submit" value="Continue">
        </form>

        <br>
        <p>
            Não tem uma conta? <a href="logincriar.php">Criar</a>
        </p>
        <?php
        include('conexao.php');

        // OK !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        if (isset($_POST['email']) || isset($_POST['senha'])) {

            if (strlen($_POST['email']) == 0) {
                echo '<p style="color: #FF0000;">Preencha seu e-mail</p>';
            } else if (strlen($_POST['senha']) == 0) {
                echo '<p style="color: #FF0000;">Preencha sua senha</p>';
            } else {

                $email = $_POST['email'];
                $senha = $_POST['senha'];

                $query = "SELECT * FROM Usuario WHERE Email = :email AND Senha = :senha";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
                $stmt->execute();

                $quantidade = $stmt->rowCount();

                if ($quantidade == 1) {

                    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (!isset($_SESSION)) {
                        session_start();
                    }

                    $_SESSION['id'] = $usuario['Usuario_id']; // Substitui 'id' pelo nome da coluna correta na tabela "usuarios"
                    $_SESSION['nome'] = $usuario['Nome']; // Substitui 'nome' pelo nome da coluna correta na tabela "usuarios"

                    header("Location: index.php?inicio");

                    echo '<script type="text/javascript">
                            window.location = "index.php?inicio";
                            </script>';
                    
                } else {

                    echo '<p style="color: #FF0000;">E-mail ou senha incorretos!</p>';
                }
            }
        }
        ?>
    </main>
    <script src="https://kit.fontawesome.com/1ab94d0eba.js" crossorigin="anonymous"></script>

    <!-- Arquivos Bootstrap -->
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/popper.js"></script>
    <script src="./assets/js/bootstrap.js"></script>

    <!-- Facebook Plugin -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v8.0" nonce="WrKsa3W6"></script>
</body>

</html>