<?php
// ... (Verificação de sessão) ...
require_once '../config/conexao.php';

$stmt = $pdo->query('SELECT * FROM produtos ORDER BY id DESC');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Gestão de Produtos</title></head>
<body>
    <h1>Painel de Controle</h1>
    <p><a href="?logout=1">Sair</a></p>
    <h2>Gerenciamento de Produtos</h2>
    <a href="produto_formulario.php">▶ Cadastrar Novo Produto</a>
    <table border="1" width="100%">
        <thead><tr><th>ID</th><th>Nome</th><th>Preço</th><th>Ações</th></tr></thead>
        <tbody>
            <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td>
                        <a href="produto_formulario.php?id=<?= $p['id'] ?>">Editar</a> |
                        <a href="produto_acoes.php?acao=deletar&id=<?= $p['id'] ?>" onclick="return confirm('Confirmar exclusão?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../login.php');
    exit;
}
?>