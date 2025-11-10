<?php
// ... (Verificação de sessão) ...
require_once '../config/conexao.php';

$id_produto = $_GET['id'] ?? 0;
$produto = ['nome' => '', 'preco' => 0.00, 'estoque' => 0, 'descricao' => '', 'imagem_url' => ''];
$titulo = "Cadastrar Novo Produto";
$acao = "inserir";

// Preenche o formulário para EDIÇÃO
if ($id_produto > 0) {
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
    $stmt->execute([$id_produto]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($produto) { $titulo = "Editar Produto ID: " . $id_produto; $acao = "editar"; }
}
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title><?= $titulo ?></title></head>
<body>
    <h1><?= $titulo ?></h1>
    <a href="produtos.php">← Voltar para a Lista</a>
    <form action="produto_acoes.php" method="POST">
        <input type="hidden" name="acao" value="<?= $acao ?>">
        <?php if ($id_produto > 0): ?><input type="hidden" name="id" value="<?= $id_produto ?>"><?php endif; ?>
        <label>Nome:</label><input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required><br><br>
        <label>Preço:</label><input type="number" step="0.01" name="preco" value="<?= $produto['preco'] ?>" required><br><br>
        <label>Estoque:</label><input type="number" name="estoque" value="<?= $produto['estoque'] ?>" required><br><br>
        <label>Descrição:</label><textarea name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea><br><br>
        <label>URL da Imagem:</label><input type="text" name="imagem_url" value="<?= htmlspecialchars($produto['imagem_url']) ?>"><br><br>
        <button type="submit"><?= ($acao == 'inserir' ? 'Cadastrar' : 'Salvar Alterações') ?></button>
    </form>
</body></html>