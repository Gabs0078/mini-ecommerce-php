<?php
require_once 'config/conexao.php';

// LEITURA (READ) dos produtos para exibição na vitrine
$stmt = $pdo->query('SELECT nome, preco, descricao, imagem_url FROM produtos ORDER BY id DESC');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Mini E-commerce - Vitrine</title>
    <style>
        .container { width: 80%; margin: 0 auto; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .product-card { border: 1px solid #ccc; padding: 15px; text-align: center; }
        .product-card img { max-width: 100%; height: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛍️ Nossa Vitrine de Produtos</h1>
        <p><a href="login.php">Acesso ao Painel Admin</a></p>
        <hr>

        <?php if (count($produtos) > 0): ?>
            <div class="product-grid">
                <?php foreach ($produtos as $p): ?>
                    <div class="product-card">
                        <h3><?= htmlspecialchars($p['nome']) ?></h3>
                        <p>R$ **<?= number_format($p['preco'], 2, ',', '.') ?>**</p>
                        <p><small><?= htmlspecialchars($p['descricao']) ?></small></p>
                        <button disabled>Adicionar ao Carrinho (Futuro)</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Nenhum produto cadastrado no momento. Por favor, acesse o painel administrativo para adicionar itens.</p>
        <?php endif; ?>
    </div>
</body>
</html>