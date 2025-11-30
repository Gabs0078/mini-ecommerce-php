<?php
// ATENÇÃO: Proteção de sessão removida para contornar falhas de infraestrutura do host (InfinityFree)
session_start();
require_once '../config/conexao.php';

$id_produto = $_GET['id'] ?? 0;
// Inicializa o array do produto para evitar erros se estiver criando um novo
$produto = [
    'nome' => '', 
    'preco' => 0.00, 
    'estoque' => 0, 
    'descricao' => '',
    'imagem_url' => ''
];
$titulo = "Cadastrar Novo Produto";
$acao = "inserir";

// Lógica para EDIÇÃO (UPDATE)
if ($id_produto > 0) {
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
    $stmt->execute([$id_produto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($produto) {
        $titulo = "Editar Produto ID: " . $id_produto;
        $acao = "editar";
    } else {
        // Redireciona se o ID for inválido
        header('Location: produtos.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; margin: 5px 0 15px 0; display: inline-block; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <h1><?= $titulo ?></h1>
    <p>
        <a href="dashboard.php">Dashboard</a> | 
        <a href="produtos.php">← Voltar para a Lista</a>
    </p>
    <hr>
    
    <form action="produto_acoes.php" method="POST">
        <input type="hidden" name="acao" value="<?= $acao ?>">
        <?php if ($id_produto > 0): ?>
            <input type="hidden" name="id" value="<?= $id_produto ?>">
        <?php endif; ?>

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>

        <label for="preco">Preço:</label>
        <input type="number" id="preco" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required>

        <label for="estoque">Estoque:</label>
        <input type="number" id="estoque" name="estoque" value="<?= $produto['estoque'] ?>" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea>
        
        <label for="imagem_url">URL da Imagem:</label>
        <input type="text" id="imagem_url" name="imagem_url" value="<?= htmlspecialchars($produto['imagem_url']) ?>">

        <button type="submit"><?= ($acao == 'inserir' ? 'Cadastrar Produto' : 'Salvar Alterações') ?></button>
    </form>
</body>
</html>