<?php
// ATENÇÃO: Proteção de sessão removida para contornar falhas de infraestrutura do host (InfinityFree)
session_start();
require_once '../config/conexao.php';

$stmt = $pdo->query('SELECT id, nome, preco, estoque FROM produtos ORDER BY id DESC');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$status = $_GET['status'] ?? '';
$mensagem = '';
if ($status == 'inserido') {
    $mensagem = '<p style="color: green;">✅ Produto cadastrado com sucesso!</p>';
} elseif ($status == 'atualizado') {
    $mensagem = '<p style="color: blue;">✅ Produto atualizado com sucesso!</p>';
} elseif ($status == 'deletado') {
    $mensagem = '<p style="color: orange;">✅ Produto excluído com sucesso!</p>';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Produtos</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Painel de Controle</h1>
    <p>
        <a href="dashboard.php">Dashboard</a> | 
        <a href="../index.php">Ver Loja</a> | 
        <a href="../login.php?logout=1">Sair</a>
    </p>
    <hr>
    
    <h2>Gerenciamento de Produtos</h2>
    <?= $mensagem ?>

    <p><a href="produto_formulario.php">▶ Cadastrar Novo Produto</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($produtos) > 0): ?>
                <?php foreach ($produtos as $p): ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= htmlspecialchars($p['nome']) ?></td>
                        <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                        <td><?= $p['estoque'] ?></td>
                        <td>
                            <a href="produto_formulario.php?id=<?= $p['id'] ?>">Editar</a> |
                            <a href="produto_acoes.php?acao=deletar&id=<?= $p['id'] ?>" onclick="return confirm('ATENÇÃO: Deseja realmente excluir este produto?')">Deletar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum produto cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
<?php
// Lógica de Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../login.php');
    exit;
}
?>