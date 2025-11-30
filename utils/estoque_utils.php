<?php
// utils/estoque_utils.php

/**
 * Verifica se um produto tem a quantidade desejada em estoque.
 */
function verificarEstoque($pdo, $produto_id, $quantidade_desejada) {
    if ($quantidade_desejada <= 0) {
        return false;
    }
    
    $stmt = $pdo->prepare("SELECT estoque FROM produtos WHERE id = ?");
    $stmt->execute([$produto_id]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        return false;
    }

    $estoque_atual = (int) $resultado['estoque'];
    return $estoque_atual >= $quantidade_desejada;
}

/**
 * Simula a atualização do estoque após uma compra bem-sucedida.
 */
function deduzirEstoque($pdo, $produto_id, $quantidade_comprada) {
    $stmt = $pdo->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id = ? AND estoque >= ?");
    $stmt->execute([$quantidade_comprada, $produto_id, $quantidade_comprada]);

    return $stmt->rowCount() > 0;
}
?>