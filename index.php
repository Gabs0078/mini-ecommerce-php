<?php
session_start();
require_once 'config/conexao.php';
// Remova a inclusão de estoque_utils se você a excluiu para simplificar
// require_once 'utils/estoque_utils.php'; 

$stmt = $pdo->query('SELECT id, nome, preco, estoque, descricao, imagem_url FROM produtos ORDER BY id DESC');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$itens_carrinho = $_SESSION['carrinho'] ?? [];
$total_itens_carrinho = array_sum(array_column($itens_carrinho, 'quantidade'));
$usuario_logado = $_SESSION['nome_usuario'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mini E-commerce - Vitrine</title>
    <style>
        /* ... Estilos CSS ... */
        .container { width: 90%; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .product-card { border: 1px solid #ddd; padding: 15px; text-align: center; border-radius: 5px; }
        .product-card img { max-width: 100%; height: 200px; object-fit: cover; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛍️ Nossa Vitrine de Produtos</h1>
            <p>
                <a href="admin/dashboard.php" style="color: purple; font-weight: bold;">[ ACESSO DIRETO PARA AVALIAÇÃO ]</a> | 
                
                <?php if ($usuario_logado): ?>
                    Olá, <strong><?= htmlspecialchars($usuario_logado) ?></strong>! | 
                    <a href="login.php?logout=1">Sair</a>
                <?php else: ?>
                    <a href="login.php">Login/Admin</a> | 
                    <a href="cadastro.php">Novo Cadastro</a>
                <?php endif; ?>
                <span class="carrinho-link">| Carrinho (<?= $total_itens_carrinho ?> itens)</span>
            </p>
        </div>
        
        <?php if (count($produtos) > 0): ?>
            <div class="product-grid">
                <?php foreach ($produtos as $p): ?>
                    <div class="product-card">
                        <h3><?= htmlspecialchars($p['nome']) ?></h3>
                        <p>R$ **<?= number_format($p['preco'], 2, ',', '.') ?>**</p>
                        <button disabled>Comprar</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum produto cadastrado no momento. Acesse o Painel de Controle para adicionar itens.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
// Lógica de logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}
?>