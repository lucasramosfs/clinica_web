-- Script SQL para criação das tabelas do banco de dados da clínica médica

-- Criação da tabela Contato
CREATE TABLE Contato (
    Codigo INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Telefone VARCHAR(20) NOT NULL,
    Mensagem TEXT NOT NULL,
    Datahora DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Criação da tabela Funcionario
CREATE TABLE Funcionario (
    Codigo INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) UNIQUE NOT NULL,
    Senhahash VARCHAR(255) NOT NULL,
    EstadoCivil VARCHAR(20),
    DataNascimento DATE,
    Funcao VARCHAR(50) NOT NULL
);

-- Criação da tabela Medico
CREATE TABLE Medico (
    Codigo INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Especialidade VARCHAR(100) NOT NULL,
    CRM VARCHAR(20) UNIQUE NOT NULL
);

-- Criação da tabela Paciente
CREATE TABLE Paciente (
    Codigo INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Sexo ENUM('M', 'F') NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Telefone VARCHAR(20) NOT NULL
);

-- Criação da tabela Agendamento
CREATE TABLE Agendamento (
    Codigo INT AUTO_INCREMENT PRIMARY KEY,
    Datahora DATETIME NOT NULL,
    CodigoMedico INT NOT NULL,
    CodigoPaciente INT NOT NULL,
    FOREIGN KEY (CodigoMedico) REFERENCES Medico(Codigo),
    FOREIGN KEY (CodigoPaciente) REFERENCES Paciente(Codigo)
);

-- Inserção de dados de exemplo para funcionários (senhas hash para 'admin123')
INSERT INTO Funcionario (Nome, Email, Senhahash, EstadoCivil, DataNascimento, Funcao) VALUES
('João Silva', 'joao@vitacare.com.br', '$2y$10$F249ut4\/4Vokvgw5FPshy.0yPfzvroptEiZeWCKSbQv4Vz8rgwSkW', 'Solteiro', '1985-03-15', 'Administrador'),
('Maria Santos', 'maria@vitacare.com.br', '$2y$10$F249ut4\/4Vokvgw5FPshy.0yPfzvroptEiZeWCKSbQv4Vz8rgwSkW', 'Casada', '1990-07-22', 'Recepcionista');

-- Inserção de dados de exemplo para médicos
INSERT INTO Medico (Nome, Especialidade, CRM) VALUES
('Dr. Lucas Ramos', 'Cardiologia', 'CRM12345'),
('Dr. Mateu Xauan', 'Dermatologia', 'CRM67890'),
('Dr. Victor Nogueira', 'Ortopedia', 'CRM11111'),
('Dra. Lucia Ferreira', 'Pediatria', 'CRM22222'),
('Dr. Roberto Alves', 'Neurologia', 'CRM33333');

