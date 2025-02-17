<?php
session_start();
$usuario_id = $_SESSION['id'];



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

            echo $usuario['imgPath'];
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_FILES['imagem']['error'] === 0) {
        $pasta = "arquivos/usuarios/";
        $nomeDoArquivo = $_FILES['imagem']['name'];
        $novoNomeArq = uniqid();
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

        // Verificar se a extensão do arquivo é permitida
        $extensoesPermitidas = array("jpg", "png", "jpeg", "jfif");
        if (in_array($extensao, $extensoesPermitidas)) {
            $path = $pasta . $novoNomeArq . "." . $extensao;

            // Mover o arquivo para a pasta de destino
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $path)) {

                // ...

                if ($usuario['imgPath'] !== "arquivos/usuarios/userPadrao.jpg" && file_exists($usuario['imgPath'])) {
                    unlink($usuario['imgPath']);
                }

                // ...

                try {
                    $pdo = new PDO('mysql:host=localhost;dbname=projeto', 'root', '');
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $queryUpdate = "UPDATE Usuario SET imgPath = :img WHERE Usuario_id = :usuario_id";
                    $stmtUpdate = $pdo->prepare($queryUpdate);
                    $stmtUpdate->bindParam(':img', $path); // Corrigido para :img
                    $stmtUpdate->bindParam(':usuario_id', $usuario_id);

                    if ($stmtUpdate->execute()) {
                        //echo "Atualização bem-sucedida";
                        echo '<script type="text/javascript">
                window.location = "index.php?avatar";
            </script>';
                    } else {
                        echo "Erro na execução da consulta";
                    }
                } catch (PDOException $e) {
                    echo "Erro na execução da consulta: " . $e->getMessage();
                }
            } else {
                echo "<p style='color: #FF0000;'>Erro ao mover o arquivo para a pasta de destino.</p>";
            }
        } else {
            echo "<p style='color: #FF0000;'>Tipo de arquivo não aceito: $nomeDoArquivo</p>";
        }
    } else {
        echo '<p style="color: #FF0000;">Apenas imagens jpeg e png!</p>';
    }
}
