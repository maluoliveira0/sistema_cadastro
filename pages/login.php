<?php
session_start();

// Incluir o arquivo de conexão
include '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber dados do formulário e validar
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Validação básica
    if (empty($email) || empty($senha)) {
        echo "Email e senha são obrigatórios.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Endereço de email inválido.";
        exit();
    }

    // Preparar a query para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verificar a senha
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['id'] = $user['id'];
            header("Location: perfil.php");
            exit();
        } else {
            echo "Senha incorreta.";
        }
    } else {
        echo "Nenhum usuário encontrado com esse email.";
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
    <title>Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
