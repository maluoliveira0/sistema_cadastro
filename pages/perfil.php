<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Incluir o arquivo de conexão
include '../includes/conexao.php';

// Buscar informações do usuário
$id = $_SESSION['id'];
$sql = "SELECT nome, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Atualizar informações do perfil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);

    // Validação básica
    if (empty($nome) || empty($email)) {
        echo "Nome e email são obrigatórios.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Endereço de email inválido.";
        exit();
    }

    // Atualizar dados no banco de dados
    $update_sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $nome, $email, $id);

    if ($stmt->execute()) {
        echo "Perfil atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar perfil: " . $stmt->error;
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
    <title>Perfil de Usuário</title>
</head>
<body>
    <h2>Perfil de Usuário</h2>
    <form action="perfil.php" method="POST">
        <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <button type="submit">Atualizar Perfil</button>
    </form>
    <a href="logout.php">Sair</a>
</body>
</html>