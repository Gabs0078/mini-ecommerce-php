<?php
session_start();
require_once 'config/conexao.php';
require_once 'utils/estoque_utils.php';

// Redireciona de volta para a vitrine
$retorno = 'index.php';

if (isset($_POST['produto_id']) && isset($_POST['quantidade'])) {
    $produto_id = (int)$_POST['produto_id'];
    $quantidade = (int)$_POST['quantidade'];
    $retorno = 'index.php?status=erro_estoque'; // Mensagem de erro padrão

    // 1. Verifica se o ID é válido e se há estoque suficiente antes de adicionar
    $stmt = $pdo->prepare("SELECT nome, preco, estoque FROM produtos WHERE id = ?");
    $stmt->execute([$produto_id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto && verificarEstoque($pdo, $produto_id, $quantidade)) {
        
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
        
        // 2. Adiciona/Atualiza o item no carrinho
        if (isset($_SESSION['carrinho'][$produto_id])) {
            $_SESSION['carrinho'][$produto_id]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$produto_id] = [
                'nome' => $produto['nome'],
                'preco' => $produto['preco'],
                'quantidade' => $quantidade,
            ];
        }
        $retorno = 'index.php?status=adicionado'; // Sucesso
    }
}

header("Location: $retorno"); 
exit;
?>