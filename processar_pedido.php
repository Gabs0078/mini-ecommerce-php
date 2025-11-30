<?php
// processar_pedido.php

// 1. Inclui a Conexão com o BD (necessária para as funções)
require_once 'config/conexao.php'; 

// 2. Inclui as Funções de Estoque
require_once 'utils/estoque_utils.php'; 

echo "<h2>Simulação de Processamento de Pedido</h2>";

// --- Dados de Teste (Simulam o que viria de um formulário ou do carrinho) ---
$id_do_item = 1; // ID de um produto que você deve cadastrar no painel admin!
$quantidade_pedido = 3; 

if ($id_do_item && $quantidade_pedido) {
    echo "Tentativa de compra do Produto ID: $id_do_item, Quantidade: $quantidade_pedido...<br>";

    // --- CHAMA A FUNÇÃO DE VERIFICAÇÃO (Substitui a Stored Function) ---
    if (verificarEstoque($pdo, $id_do_item, $quantidade_pedido)) {
        
        echo "<p style='color: green;'>✅ **Verificação de Estoque:** OK. Estoque disponível!</p>";

        // --- Simulação de Transação e Dedução do Estoque ---
        if (deduzirEstoque($pdo, $id_do_item, $quantidade_pedido)) {
            
            // AQUI OCORRERIA O COMANDO PARA INSERIR NA TABELA 'pedidos'
            echo "<p style='color: blue;'>➡️ **Pedido Registrado:** O pedido seria criado na tabela 'pedidos' e o estoque foi deduzido com sucesso.</p>";
            
        } else {
            echo "<p style='color: red;'>❌ **Erro:** Falha ao deduzir estoque (pode ter esgotado no milissegundo da compra).</p>";
        }

    } else {
        echo "<p style='color: red;'>❌ **Verificação de Estoque:** FALHOU. Não há estoque suficiente para $quantidade_pedido unidades.</p>";
    }

} else {
    echo "Dados do pedido ausentes.";
}

// Opcional: Link para conferir o estoque atual no painel (após o login)
echo "<br><a href='login.php'>Ir para o Painel Administrativo</a>";

?>