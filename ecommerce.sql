-- Removido: CREATE DATABASE IF NOT EXISTS mini_ecommerce;
-- Removido: USE mini_ecommerce;

-- Tabela de Produtos (CRUD)
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    estoque INT NOT NULL DEFAULT 0,
    descricao TEXT,
    imagem_url VARCHAR(255)
);

-- Tabela de Usuários (Login)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(100)
);

-- Usuário Admin: admin@email.com / Senha: 123456
INSERT INTO usuarios (nome, email, senha) VALUES
('Admin', 'admin@email.com', '$2y$10$Q7i.xY31QnZ5D2tG2DkF5eN4V8tJzVp3J.iGf6r/2mO4g3l.cQ.kQ');