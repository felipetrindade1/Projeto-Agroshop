<?php
session_start();
?>



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
        <h2>Cadastro</h2>


        <form method="POST" enctype="multipart/form-data">

            <div class="input-field">
                <input type="text" name="nome" id="nome" placeholder="Digite seu nome" required>
                <div class="underline"></div>
            </div>

            <div class="input-field">
                <input type="text" name="email" id="email" placeholder="Digite seu email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required>
                <div class="underline"></div>
            </div>


            <div class="input-field">
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required oninput="checkPasswordStrength()">
                <div class="underline"></div>
            </div>
            <div id="password-strength-meter">
                <div id="strength-bar"></div>
                <div id="strength-text"></div>
            </div>

            <div class="input-field">
                <input type="text" name="cpf" id="cpf" autocomplete="off" maxlength="14" minlength="14" placeholder="123.456.XXX-00" oninput="formatarCPF(this)">
                <div class="underline"></div>
            </div>

         

            <div class="input-field">
                <input type="text" name="telefone" id="telefone" placeholder="Tel (00) 0000-0000" maxlength="15">
                <div class="underline"></div>
            </div>
            <div class="input-field">
                <input type="text" name="cep" id="cep" placeholder="CEP XXXXX-XXX" required maxlength="9" autocomplete="off">
                <div class="underline"></div>
            </div>
            <div class="input-field">
                <input type="text" name="comp" id="comp" placeholder="Complemento">
                <div class="underline"></div>
            </div>
            <div class="input-field">
                <input type="text" name="num" id="num" placeholder="N°" required>
                <div class="underline"></div>
            </div>

            <input type="submit" id="submitBtn" value="Continue">
        </form>


        <p>
            <?php
            include_once "conexao.php";



            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $cpf = $_POST['cpf'];
                $telefone = $_POST['telefone'];
                $cep = $_POST['cep'];
                $comp = $_POST['comp'];
                $num = $_POST['num'];

                // Verificar se o CPF é válido



                try {
                    $sql = "INSERT INTO Usuario (Nome, Email, Senha, CPF, Telefone, CEP, Complemento, Num) 
                            VALUES (:nome, :email, :senha, :cpf, :telefone, :cep, :comp, :num)";

                    $stmt = $con->prepare($sql);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':senha', $senha);
                    $stmt->bindParam(':cpf', $cpf);
                    $stmt->bindParam(':telefone', $telefone);
                    $stmt->bindParam(':cep', $cep);
                    $stmt->bindParam(':comp', $comp);
                    $stmt->bindParam(':num', $num);


                    if ($stmt->execute()) {

                        ///////////////////////////////////


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

                        }

                        //////////////////////////////////

                        echo '<script type="text/javascript">
                                                window.location = "index.php?inicio";
                                            </script>';
                    } else {

                        echo "<p style='color: #FF0000;'>Erro ao cadastrar o usuario.</p>";
                    }
                } catch (PDOException $e) {
                    if ($e->getCode() == '23000' && strpos($e->getMessage(), 'Duplicate entry') !== false) {
                        echo "<p style='color: #FF0000;'>CPF já cadastrado.</p>";
                    } else {
                        echo "Erro: " . $e->getMessage();
                    }
                }
            }

            ?>





        </p>
        <br>
    </main>
    <script src="./assets/js/zxcvbn.js"></script>
    <script src="https://kit.fontawesome.com/1ab94d0eba.js" crossorigin="anonymous"></script>
    <script src="./assets/js/cpf.js"></script>




    <!-- Arquivos Bootstrap -->
    <script src="./assets/js/jquery.js"></script>
    <script src="./assets/js/popper.js"></script>
    <script src="./assets/js/bootstrap.js"></script>

    <!-- Facebook Plugin -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v8.0" nonce="WrKsa3W6"></script>
    <script>
        function checkPasswordStrength() {
            var password = document.getElementById('senha').value;
            var result = zxcvbn(password);
            var strengthBar = document.getElementById('strength-bar');
            var strengthText = document.getElementById('strength-text');

            // Defina os níveis de força conforme necessário
            var levels = ['Muito Fraca', 'Fraca', 'Média', 'Forte', 'Muito Forte'];

            // Atualize a largura da barra de força e o texto
            strengthBar.style.width = (result.score * 25) + '%';

            // Defina as cores com base na força da senha
            if (result.score <= 1) {
                strengthText.style.color = '#808080'; // Cinza para muito fraca e fraca
            } else if (result.score == 2) {
                strengthText.style.color = '#b0b800'; // Amarelo para média
            } else if (result.score == 3) {
                strengthText.style.color = '#FFA500'; // Laranja para forte
            } else {
                strengthText.style.color = '#4CAF50'; // Verde para muito forte
            }

            strengthText.innerHTML = '<strong style="color: #333;">Força da senha: </strong>' + levels[result.score];


            // Ative ou desative o botão de envio conforme necessário
            var submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = result.score < 2; // Exemplo: permitir apenas senhas médias ou mais fortes
        }



        function formatarCPF(input) {
            // Obter o valor atual do input
            let cpf = input.value;

            // Remover tudo que não é número
            cpf = cpf.replace(/\D/g, '');

            // Adicionar pontos e traço conforme o formato
            cpf = cpf.replace(/(\d{3})(\d{3})?(\d{3})?(\d{2})?/, function(match, p1, p2, p3, p4) {
                let result = p1;
                if (p2) result += '.' + p2;
                if (p3) result += '.' + p3;
                if (p4) result += '-' + p4;
                return result;
            });

            // Atualizar o valor do input
            input.value = cpf;

            // Validar o CPF (opcional)
            if (cpf.length === 11) {
                if (validarCPF(cpf)) {
                    console.log('CPF válido:', cpf);
                } else {
                    console.log('CPF inválido:', cpf);
                }
            }
        }

        function validarCPF(cpf) {
            // Remover tudo que não é número
            cpf = cpf.replace(/\D/g, '');

            // Verificar se o CPF tem 11 caracteres
            if (cpf.length !== 11) {
                return false;
            }

            // Calcular os dígitos verificadores
            for (let i = 9; i < 11; i++) {
                let soma = 0;
                for (let j = 0; j < i; j++) {
                    soma += parseInt(cpf[j]) * ((i + 1) - j);
                }
                let resto = soma % 11;
                let digito = (resto < 2) ? 0 : 11 - resto;
                if (digito !== parseInt(cpf[i])) {
                    return false;
                }
            }

            return true;
        }
    </script>
</body>

</html>