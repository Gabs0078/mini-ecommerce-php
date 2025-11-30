<?php
// ATENÇÃO: Proteção de sessão removida para contornar falhas de infraestrutura do host (InfinityFree)
session_start();
require_once '../config/conexao.php';

// --- CONSULTAS SQL PARA INDICADORES ---

// 1. Total de Produtos Cadastrados
$stmt_total = $pdo->query("SELECT COUNT(id) AS total FROM produtos");
$total_produtos = $stmt_total->fetchColumn();

// 2. Produtos com Estoque Baixo (Estoque < 5)
$stmt_baixo_estoque = $pdo->query("SELECT COUNT(id) FROM produtos WHERE estoque < 5");
$baixo_estoque = $stmt_baixo_estoque->fetchColumn();

// 3. Valor Médio dos Produtos
$stmt_valor_medio = $pdo->query("SELECT AVG(preco) AS media FROM produtos");
$valor_medio = number_format($stmt_valor_medio->fetchColumn(), 2, '.', '');

// 4. Total de Pedidos - Requer a tabela 'pedidos'
try {
    $stmt_total_pedidos = $pdo->query("SELECT SUM(valor_total) AS total_vendas FROM pedidos");
    $total_vendas = number_format($stmt_total_pedidos->fetchColumn(), 2, '.', '');
} catch (PDOException $e) {
    $total_vendas = 0.00; // Caso a tabela pedidos não tenha sido criada.
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Indicadores</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { display: flex; flex-wrap: wrap; gap: 20px; }
        .card { border: 1px solid #ccc; padding: 15px; flex: 1 1 200px; text-align: center; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); }
        .graph-container { width: 45%; max-width: 500px; }
    </style>
</head>
<body>
    <h1>📊 Dashboard de Indicadores</h1>
    <p>
        <a href="produtos.php">Gerenciar Produtos</a> | 
        <a href="../index.php">Ver Loja</a> | 
        <a href="../login.php?logout=1">Sair</a>
    </p>
    <hr>

    <h2>Resumo Financeiro e de Estoque</h2>
    <div class="container">
        <div class="card" style="background-color: #e0f7fa;">
            <h3>Produtos Totais</h3>
            <p style="font-size: 2em;"><?= $total_produtos ?></p>
        </div>
        <div class="card" style="background-color: #fffde7;">
            <h3>Estoque Baixo (< 5)</h3>
            <p style="font-size: 2em; color: red;"><?= $baixo_estoque ?></p>
        </div>
        <div class="card" style="background-color: #e8f5e9;">
            <h3>Valor Médio (R$)</h3>
            <p style="font-size: 2em;">R$ <?= $valor_medio ?></p>
        </div>
        <div class="card" style="background-color: #fce4ec;">
            <h3>Total de Vendas (Simulado)</h3>
            <p style="font-size: 2em;">R$ <?= $total_vendas ?></p>
        </div>
    </div>

    <hr>

    <h2>Visualização Gráfica</h2>
    <div class="container">
        <div class="graph-container">
            <h3>Situação de Estoque</h3>
            <canvas id="estoqueChart"></canvas>
        </div>
    </div>

    <script>
        // Dados vindos do PHP para o gráfico
        const totalProdutos = <?= $total_produtos ?>; 
        const baixoEstoque = <?= $baixo_estoque ?>;

        const estoqueChartCtx = document.getElementById('estoqueChart').getContext('2d');
        new Chart(estoqueChartCtx, {
            type: 'pie', 
            data: {
                labels: ['Estoque Suficiente', 'Estoque Crítico (< 5)'],
                datasets: [{
                    label: 'Produtos',
                    data: [totalProdutos - baixoEstoque, baixoEstoque],
                    backgroundColor: ['#4BC0C0', '#FF6384'],
                    hoverOffset: 4
                }]
            },
            options: { responsive: true, }
        });
    </script>
</body>
</html>