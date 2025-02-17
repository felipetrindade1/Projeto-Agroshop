<?php


include_once('protect.php');
include_once('conexao.php');

$erro = "";

if (isset($_SESSION['id'])) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM Usuario WHERE Usuario_id = :id");
        $stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            $nome = $usuario['Nome'];
            $email = $usuario['Email'];
            $senhaAtual = $usuario['Senha'];
            $cpf = $usuario['CPF'];
            $cnpj = $usuario['CNPJ'];
            $telefone = $usuario['Telefone'];
            $cep = $usuario['CEP'];
            $comp = $usuario['Complemento'];
            $num = $usuario['Num'];
            $img = $usuario['imgPath'];
        } else {
            $erro = "Usuário não encontrado.";
        }
    } catch (PDOException $e) {
        $erro = "Erro no banco de dados: " . $e->getMessage();
    }
} else {
    $erro = "Sessão não está definida. Por favor, faça login.";
}

if (!empty($erro)) {
    echo "<p>$erro</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $complemento = isset($_POST['complemento']) ? $_POST['complemento'] : '';
        $num = isset($_POST['num']) ? $_POST['num'] : '';
        $usuario_id = $_SESSION['id'];



        $queryUpdate = "UPDATE Usuario SET Nome = :nome, Complemento = :complemento, Num = :num WHERE Usuario_id = :usuario_id";
        $stmtUpdate = $pdo->prepare($queryUpdate);
        $stmtUpdate->bindParam(':nome', $nome);
        $stmtUpdate->bindParam(':complemento', $complemento);
        $stmtUpdate->bindParam(':num', $num);
        $stmtUpdate->bindParam(':usuario_id', $usuario_id);

        if ($stmtUpdate->execute()) {
            echo "";
        } else {
            echo "";
        }
    } catch (PDOException $e) {
        echo "Erro na execução da consulta: " . $e->getMessage();
    }
}


?>


<div class="container-perfil">
    <h1>Meu Perfil</h1>
    <div class="perfil-info">
        <div class="image-container">
            <img src="<?php echo $img ?>" alt="Imagem de Perfil">
            <form id="imagemUp" enctype="multipart/form-data" action="upimg.php" method="post">
            <label for="file-input" class="circlee border border-1 bg bg-light" id="circuloImagem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil svg-icon" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                </svg>
                <form action="">
                    <input type="file" id="file-input" name='imagem' style="display: none;">
                </form>
            </label>
            </form>
            <h2>
                <?php echo $nome ?>
            </h2>
            <p>Email:
                <?php echo $email ?>
            </p>
        </div>

    </div>


        <!-- Seus outros campos de formulário aqui -->
    


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Quando o arquivo é selecionado
            $('#file-input').change(function() {
                // Envie o formulário
                $('#imagemUp').submit();
            });
        });
    </script>

    <style>
        #circuloImagem {
            position: absolute;
            left: 65%;
        }
    </style>


    <button id="editButton" class="editButton5">Editar Perfil</button>

    <div id="perfil-form-container" style="display: none;">
        <h3>Editar Perfil</h3>
        <form method="post" enctype="multipart/form-data" id="perfil-form">
            <div class="input-field">
                <input type="text" name="nome" id="nome" class="input" placeholder="Digite seu nome" value="<?php echo $nome ?>">
                <div class="underline"></div>
            </div>

            <div class="input-field">
                <input type="text" name="complemento" id="complemento" class="input" placeholder="Digite seu complemento" value="<?php echo $comp ?>">
                <div class="underline"></div>
            </div>

            <div class="input-field">
                <input type="text" name="num" id="num" class="input" placeholder="Digite seu número" value="<?php echo $num ?>">
                <div class="underline"></div>
            </div>

            <input type="submit" value="Salvar" class="buttonOfAvatar">
        </form>


    </div>






    </section>
    <script src="./assets/js/avatar.js"></script>