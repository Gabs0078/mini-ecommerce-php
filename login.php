<?php
session_start();
require_once 'config/conexao.php';
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $stmt = $pdo->prepare('SELECT id, senha FROM usuarios WHERE email = ?');
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['admin_logado'] = true;
        header('Location: admin/produtos.php');
        exit;
    } else {
        $mensagem = 'Email ou senha inválidos.';
    }
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Login Admin</title></head>
<body>
    <h2>Acesso ao Painel de Controle</h2>
    <?php if ($mensagem): ?><p style="color: red;"><?= $mensagem ?></p><?php endif; ?>
    <form method="POST">
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Senha:</label><input type="password" name="senha" required><br>
        <button type="submit">Entrar</button>
    </form>
</body></html>