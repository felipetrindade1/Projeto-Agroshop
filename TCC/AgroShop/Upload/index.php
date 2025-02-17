<?php
include_once("conexao.php");
session_start();


// Cadastra as imagens
if (isset($_FILES['arquivos']) && is_array($_FILES['arquivos']['name'])) {
    // Processar o upload das imagens aqui
    //echo "Arquivo(s) enviado(s)";
    
    $pasta = "arquivos/";

    $uploadStatus = array();

    foreach ($_FILES['arquivos']['name'] as $key => $nomeDoArquivo) {
        $novoNomeArq = uniqid();
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

        // Verificar se a extensão do arquivo é permitida
        $extensoesPermitidas = array("jpg", "png");
        if (!in_array($extensao, $extensoesPermitidas)) {
            $uploadStatus[] = "Tipo de arquivo não aceito: $nomeDoArquivo";
            continue;
        }

        $path = $pasta . $novoNomeArq . "." . $extensao;
        // Mover o arquivo para a pasta de destino
        $funcionou = move_uploaded_file($_FILES['arquivos']['tmp_name'][$key], $path);

        if ($funcionou) {
            try {
                // Conectar ao banco de dados usando PDO
                $pdo = new PDO("mysql:host=localhost;dbname=projeto", "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Preparar e executar a consulta SQL para inserir o arquivo na tabela 'arquivos'
                $stmt = $pdo->prepare("INSERT INTO arquivos (path) VALUES (:path)");
                $stmt->bindParam(':path', $path);
            } catch (PDOException $e) {
                $uploadStatus[] = "Erro no banco de dados ao inserir $nomeDoArquivo: " . $e->getMessage();
            }
        } else {
            $uploadStatus[] = "Falha ao enviar arquivo: $nomeDoArquivo";
        }
    }

    if (count($uploadStatus) > 0) {
        foreach ($uploadStatus as $status) {
            echo "<p>$status</p>";
        }
    } else {
        echo "<p>Todos os arquivos foram enviados com sucesso.</p>";
    }
}




// Busca as imagnens
try {
    // Conectar ao banco de dados usando PDO
    $pdo = new PDO("mysql:host=localhost;dbname=projeto", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Preparar e executar a consulta SQL para selecionar os registros da tabela 'arquivos' do usuário atual
    $stmt = $pdo->prepare("SELECT * FROM arquivos WHERE Usuario_id = :usuario_id");
    $stmt->bindParam(':usuario_id', $_SESSION['id'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro no banco de dados: " . $e->getMessage();
}


// Deleta do banco de dados

if (isset($_GET["deletar"])) {
    $id = intval($_GET["deletar"]);

    try {
        // Conectar ao banco de dados usando PDO
        $pdo = new PDO("mysql:host=localhost;dbname=projeto", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparar e executar a consulta SQL para selecionar o arquivo pelo ID e usuário atual
        $stmt = $pdo->prepare("SELECT * FROM arquivos WHERE Id = :id AND Usuario_id = :usuario_id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':usuario_id', $_SESSION['id'], PDO::PARAM_INT);
        $stmt->execute();
        $arquivo = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($arquivo) {
            $path = $arquivo['path'];

            // Excluir o arquivo do servidor
            if (unlink($path)) {
                // Excluir o registro da tabela
                $stmt = $pdo->prepare("DELETE FROM arquivos WHERE Id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                if ($stmt->execute()) {
                    // Após a exclusão bem-sucedida, redirecione para a página atual para atualizar a lista de arquivos
                    header("Location: ".$_SERVER['PHP_SELF']);
                    exit;
                } else {
                    echo "Erro ao excluir o registro do banco de dados";
                }
            } else {
                echo "Erro ao excluir o arquivo do servidor";
            }
        } else {
            echo "Arquivo não encontrado no banco de dados";
        }
    } catch (PDOException $e) {
        echo "Erro no banco de dados: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Arquivos</title>
</head>
<body>
    <form enctype="multipart/form-data" action="" method="POST">
        <label for="arquivos">Selecione um ou mais arquivos:</label><br>
        <input type="file" name="arquivos[]" multiple><br>
        <button type="submit" name="upload">Enviar</button>
    </form>
    <br>

    <h1>Lista de Imagens</h1>
    <br> 
    <table  cellpadding="10">
        <thead>
            <th>Preview</th>
            <th>Arquivos</th>
            <th>Data de envio</th>
            <th></th>
        </thead>
        <tbody>
            <?php
            try {
                foreach($result as $arquivo){
                ?>
                <tr>
                    <td><img height="100" src="<?php echo $arquivo['path']; ?>" alt=""></td>
                    <td><a href="<?php echo $arquivo['path']; ?>"><?php echo $arquivo['path']; ?></a></td>
                    <td><?php echo date("d/m/y H:i", strtotime($arquivo['data_upload'])); ?></td>
                    <td><a href="index.php?deletar=<?php echo $arquivo['Id']; ?>">Deletar</a></td>
                </tr>
                <?php 
                }
            } catch (PDOException $e) {
                echo "Erro no banco de dados: " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
</body>
</html>
