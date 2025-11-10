<?php
// config/conexao.php

// DADOS DO INFINITYFREE:
$host = 'sql109.infinityfree.com'; 
$dbname = 'if0_40385648_dbprodutos'; // Usando o nome fornecido: if0_40385648_dbprodutos
$user = 'if0_40385648'; 
$password = 'Z9TGa20dZi1eUL'; 

// Porta 3306 é a padrão, não precisa ser explicitada na string DSN, mas a conexão é feita via host.

try {
    // String de Conexão PDO (PHP Data Objects)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    
    // Configura o PDO para lançar exceções em caso de erro, facilitando o debug
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    // Mensagem de erro se a conexão falhar
    // O erro mais comum aqui é senha, usuário ou host incorretos
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>