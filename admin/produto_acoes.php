<?php
// ATENÇÃO: Proteção de sessão removida para contornar falhas de infraestrutura do host (InfinityFree)
session_start();
require_once '../config/conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
$id = $_POST['id'] ?? $_GET['id'] ?? 0;
$status = 'erro';

try {
    if ($acao == 'inserir') {
        $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, estoque, descricao, imagem_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST['nome'], $_POST['preco'], $_POST['estoque'], $_POST['descricao'], $_POST['imagem_url']]);
        $status = 'inserido';

    } elseif ($acao == 'editar') {
        // Ação de edição (UPDATE)
        $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, estoque = ?, descricao = ?, imagem_url = ? WHERE id = ?");
        $stmt->execute([$_POST['nome'], $_POST['preco'], $_POST['estoque'], $_POST['descricao'], $_POST['imagem_url'], $id]);
        $status = 'atualizado';

    } elseif ($acao == 'deletar' && $id > 0) {
        // Ação de exclusão (DELETE)
        $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
        $stmt->execute([$id]);
        $status = 'deletado';

    } else {
        $status = 'erro_acao';
    }
} catch (PDOException $e) {
    // Em caso de erro do banco de dados (ex: chave estrangeira, etc.)
    // Para fins de debug: $status .= "&error=" . urlencode($e->getMessage());
    $status = 'erro_bd';
}

// Redireciona de volta para a lista de produtos com a mensagem de status
header('Location: produtos.php?status=' . $status);
exit;
?>