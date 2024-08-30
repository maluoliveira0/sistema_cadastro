<?php
// Incluir o arquivo de conexão
include '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber dados do formulário e validar
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $perfil = $_POST['perfil'];

    // Validação básica
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Todos os campos são obrigatórios.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Endereço de email inválido.";
        exit();
    }

    if (strlen($senha) < 6) {
        echo "A senha deve ter pelo menos 6 caracteres.";
        exit();
    }

    // Preparar a query para evitar SQL Injection
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $senhaHash, $perfil);

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT); // Criptografar a senha

    // Executar a query e verificar o sucesso
    if ($stmt->execute()) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Usuário</h2>
        <form action="cadastro.php" method="POST">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <select name="perfil" required>
                <option value="usuario">Usuário</option>
                <option value="admin">Administrador</option>
            </select>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
