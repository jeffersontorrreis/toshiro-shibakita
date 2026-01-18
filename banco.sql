-- Criação do banco de dados (se não existir)
CREATE DATABASE IF NOT EXISTS meubanco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE meubanco;

-- Tabela de dados
CREATE TABLE IF NOT EXISTS dados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    AlunoID INT NOT NULL,
    Nome VARCHAR(50) NOT NULL,
    Sobrenome VARCHAR(50) NOT NULL,
    Endereco VARCHAR(150),
    Cidade VARCHAR(50),
    Host VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_aluno (AlunoID),
    INDEX idx_host (Host)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir dados de exemplo
INSERT INTO dados (AlunoID, Nome, Sobrenome, Endereco, Cidade, Host) VALUES
(1, 'João', 'Silva', 'Rua A, 123', 'São Paulo', 'container-init'),
(2, 'Maria', 'Santos', 'Rua B, 456', 'Rio de Janeiro', 'container-init'),
(3, 'Pedro', 'Oliveira', 'Rua C, 789', 'Belo Horizonte', 'container-init');

-- Mensagem de sucesso
SELECT 'Banco de dados inicializado com sucesso!' AS Status;
