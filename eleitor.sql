-- ============================================================
-- ATIVIDADE SAEP - CRUD PHP + MySQL
-- Banco de dados: eleitor
-- Tabelas: eleitor1 e candidato1
-- ============================================================

CREATE DATABASE IF NOT EXISTS eleitor
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE eleitor;

-- Permite executar o script novamente sem duplicar as tabelas.
-- A tabela eleitor1 é removida primeiro por não possuir dependências neste modelo.
DROP TABLE IF EXISTS eleitor1;
DROP TABLE IF EXISTS candidato1;

-- ============================================================
-- TABELA DE CANDIDATOS
-- ============================================================
CREATE TABLE candidato1 (
    id_candidato INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(120) NOT NULL,
    numero INT UNSIGNED NOT NULL,
    partido VARCHAR(60) NOT NULL,
    cargo VARCHAR(60) NOT NULL,
    data_nascimento DATE NULL,
    email VARCHAR(120) NULL,
    telefone VARCHAR(20) NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_candidato_numero UNIQUE (numero),
    CONSTRAINT uq_candidato_email UNIQUE (email)
) ENGINE=InnoDB;

-- ============================================================
-- TABELA DE ELEITORES
-- ============================================================
CREATE TABLE eleitor1 (
    id_eleitor INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(120) NOT NULL,
    cpf CHAR(11) NOT NULL,
    titulo_eleitor VARCHAR(20) NOT NULL,
    data_nascimento DATE NOT NULL,
    zona_eleitoral INT UNSIGNED NULL,
    secao_eleitoral INT UNSIGNED NULL,
    endereco VARCHAR(180) NULL,
    cidade VARCHAR(80) NULL,
    estado CHAR(2) NULL,
    email VARCHAR(120) NULL,
    telefone VARCHAR(20) NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT uq_eleitor_cpf UNIQUE (cpf),
    CONSTRAINT uq_eleitor_titulo UNIQUE (titulo_eleitor),
    CONSTRAINT uq_eleitor_email UNIQUE (email)
) ENGINE=InnoDB;

-- ============================================================
-- DADOS DE EXEMPLO
-- Substitua, remova ou acrescente dados conforme a necessidade.
-- CPF deve ser informado somente com números.
-- ============================================================

INSERT INTO candidato1
    (nome_completo, numero, partido, cargo, data_nascimento, email, telefone)
VALUES
    ('Ana Souza', 101, 'Partido Exemplo', 'Vereador', '1985-04-12', 'ana.souza@exemplo.com', '(11) 99999-0001'),
    ('Bruno Oliveira', 202, 'Partido Renovação', 'Prefeito', '1978-09-25', 'bruno.oliveira@exemplo.com', '(11) 99999-0002');

INSERT INTO eleitor1
    (nome_completo, cpf, titulo_eleitor, data_nascimento, zona_eleitoral, secao_eleitoral, endereco, cidade, estado, email, telefone)
VALUES
    ('Carlos Pereira', '12345678901', '000100010001', '2000-02-15', 101, 25, 'Rua das Flores, 100', 'São Paulo', 'SP', 'carlos.pereira@exemplo.com', '(11) 98888-0001'),
    ('Juliana Santos', '98765432100', '000200020002', '1998-11-30', 102, 18, 'Avenida Central, 250', 'São Paulo', 'SP', 'juliana.santos@exemplo.com', '(11) 98888-0002');

-- ============================================================
-- CONSULTAS PARA TESTAR O CRUD
-- ============================================================

-- READ: consultar todos os candidatos
SELECT * FROM candidato1 ORDER BY id_candidato;

-- READ: consultar todos os eleitores
SELECT * FROM eleitor1 ORDER BY id_eleitor;

-- READ: consultar um registro pelo ID
-- SELECT * FROM candidato1 WHERE id_candidato = 1;
-- SELECT * FROM eleitor1 WHERE id_eleitor = 1;

-- UPDATE: alterar um candidato
-- UPDATE candidato1
-- SET nome_completo = 'Ana Souza Atualizada', partido = 'Novo Partido'
-- WHERE id_candidato = 1;

-- UPDATE: alterar um eleitor
-- UPDATE eleitor1
-- SET telefone = '(11) 97777-0000', cidade = 'Campinas'
-- WHERE id_eleitor = 1;

-- DELETE: excluir um candidato
-- DELETE FROM candidato1 WHERE id_candidato = 1;

-- DELETE: excluir um eleitor
-- DELETE FROM eleitor1 WHERE id_eleitor = 1;

-- ============================================================
-- CONSULTAS ÚTEIS PARA O PHP
-- ============================================================

-- Busca por nome de eleitor:
-- SELECT * FROM eleitor1 WHERE nome_completo LIKE '%Carlos%';

-- Busca por nome de candidato:
-- SELECT * FROM candidato1 WHERE nome_completo LIKE '%Ana%';

-- Contagem de registros:
-- SELECT COUNT(*) AS total_eleitores FROM eleitor1;
-- SELECT COUNT(*) AS total_candidatos FROM candidato1;
