<?php
session_start();
// ... (Verificação de sessão) ...
require_once '../config/conexao.php';

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
$id = $_POST['id'] ?? $_GET['id'] ?? 0;

if ($acao == 'inserir') {
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, preco, estoque, descricao, imagem_url) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['nome'], $_POST['preco'], $_POST['estoque'], $_POST['descricao'], $_POST['imagem_url']]);
    $status = 'inserido';

} elseif ($acao == 'editar') {
    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, estoque = ?, descricao = ?, imagem_url = ? WHERE id = ?");
    $stmt->execute([$_POST['nome'], $_POST['preco'], $_POST['estoque'], $_POST['descricao'], $_POST['imagem_url'], $id]);
    $status = 'atualizado';

} elseif ($acao == 'deletar' && $id > 0) {
    $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
    $stmt->execute([$id]);
    $status = 'deletado';

} else {
    $status = 'erro_acao';
}

header('Location: produtos.php?status=' . $status);
exit;
?>