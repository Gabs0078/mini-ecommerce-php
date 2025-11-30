<?php
session_start();
require_once 'config/conexao.php';

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        $mensagem = 'Todos os campos são obrigatórios.';
    } else {
        // Hash da Senha para segurança (para clientes)
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        try {
            // Insere o novo usuário com tipo 'cliente'
            $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nome, $email, $senha_hash, 'cliente']); 
            
            $mensagem = '<p style="color: green;">✅ Cadastro realizado com sucesso! Você pode fazer login.</p>';
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Erro de chave duplicada (e-mail já existe)
                 $mensagem = '<p style="color: red;">Este e-mail já está cadastrado.</p>';
            } else {
                 $mensagem = '<p style="color: red;">Erro ao cadastrar. Tente novamente.</p>';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
    <style> body { font-family: Arial, sans-serif; padding: 20px; } </style>
</head>
<body>
    <h2>Crie sua Conta</h2>
    <?= $mensagem ?>
    <form method="POST">
        <label>Nome:</label><input type="text" name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"><br><br>
        <label>Email:</label><input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br><br>
        <label>Senha:</label><input type="password" name="senha" required><br><br>
        <button type="submit">Cadastrar</button>
    </form>
    <p>Já tem conta? <a href="login.php">Fazer Login</a></p>
    <p><a href="index.php">Voltar para a Loja</a></p>
</body>
</html>