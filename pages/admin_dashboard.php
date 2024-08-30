<?php
session_start();

// Verificar se o usuário está logado e é um administrador
if (!isset($_SESSION['id']) || $_SESSION['perfil'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <p>Bem-vindo, Administrador!</p>
    <!-- Adicione funcionalidades administrativas aqui -->
    <a href="perfil.php">Gerenciar Perfil</a>
    <a href="logout.php">Sair</a>
</body>
</html>