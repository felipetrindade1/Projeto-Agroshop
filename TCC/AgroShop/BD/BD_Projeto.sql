DROP DATABASE IF EXISTS Projeto;
CREATE DATABASE Projeto;
USE Projeto;

CREATE TABLE Categoria (
  Categoria_id INT PRIMARY KEY AUTO_INCREMENT,
  Tipo VARCHAR(150)
);


CREATE TABLE Usuario (
  Usuario_id INT PRIMARY KEY AUTO_INCREMENT,
  Nome VARCHAR(150) NOT NULL,
  Email VARCHAR(100) NOT NULL,
  Senha VARCHAR(30) NOT NULL,
  CPF VARCHAR(14) UNIQUE NOT NULL,
  CNPJ VARCHAR(14),
  Telefone INT NOT NULL,
  CEP INT NOT NULL,
  Complemento VARCHAR(150),
  Num INT NOT NULL,
  imgPath varchar(100) DEFAULT 'arquivos/usuarios/userPadrao.jpg'
);


CREATE TABLE Produto (
  Produto_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
  Nome VARCHAR(250) NOT NULL,
  Preco DECIMAL(10, 2) NOT NULL,
  Categoria_id INT NOT NULL,
  Usuario_id INT NOT NULL,
  Descricao VARCHAR(250),
  Parcelas INT NOT NULL,
  imgPath varchar(100),
  Quantidade INT NOT NULL,
  QuantidadeInicial INT,
  Unidade VARCHAR(20) NOT NULL,
  FOREIGN KEY (Usuario_id) REFERENCES Usuario(Usuario_id), -- O usuario aqui é um endedor
  FOREIGN KEY (Categoria_id) REFERENCES Categoria(Categoria_id)
);


-- Trasportadoras são cadastradas por Vendedores (eles estão com os clintes na tabela usuários)

CREATE TABLE Transportadora (
  Transportadora_id INT PRIMARY KEY AUTO_INCREMENT,
  CNPJ VARCHAR(14) UNIQUE NOT NULL,
  Nome VARCHAR(150) NOT NULL,
  Email VARCHAR(100) NOT NULL,
  Senha VARCHAR(30) NOT NULL,
  Telefone INT NOT NULL,
  CEP INT NOT NULL,
  Num INT NOT NULL
);


-- Talvez seja necessário adicionar uma coluna "Validacao" na tabela pedido e na tabela transportadora e na tabela Usuario


CREATE TABLE Pedido (
  Pedido_id INT PRIMARY KEY AUTO_INCREMENT,
  Produto_id INT,
  Usuario_id INT,
  Quantidade INT,
  Entregador INT NOT NULL,
  v1 INT(4),
  v2 INT(4),
  DataEntrega datetime NOT NULL DEFAULT current_timestamp(),
  FOREIGN KEY (Produto_id) REFERENCES Produto(Produto_id),
  FOREIGN KEY (Usuario_id) REFERENCES Usuario(Usuario_id),
  FOREIGN KEY (Entregador) REFERENCES Usuario(Usuario_id)
);


CREATE TABLE comentarios (
  Id int(11) NOT NULL  PRIMARY KEY AUTO_INCREMENT,
  data_comentario datetime NOT NULL DEFAULT current_timestamp(),
  conteudo VARCHAR(255) NOT NULL,
  Usuario_id INT, 
  Produto_id INT, 
  FOREIGN KEY (Usuario_id) REFERENCES Usuario(Usuario_id), -- O usuário aqui é um cliente
  FOREIGN KEY (Produto_id) REFERENCES Produto(Produto_id)
);



-- Inserir uma categoria de eletrônicos
INSERT INTO Categoria (Tipo) VALUES ('Frutas');

-- Inserir uma categoria de roupas
INSERT INTO Categoria (Tipo) VALUES ('Verduras');

-- Inserir uma categoria de alimentos
INSERT INTO Categoria (Tipo) VALUES ('Legumes');

-- Inserir uma categoria de móveis
INSERT INTO Categoria (Tipo) VALUES ('Cereais');

-- Inserir uma categoria de livros
INSERT INTO Categoria (Tipo) VALUES ('Grãos');



-- Inserir um usuário pessoa física



INSERT INTO Usuario (Nome, Email, Senha, CPF, CNPJ, Telefone, CEP, Complemento, Num, imgPath)
VALUES ('João da Silva', 'joao@email.com', 'senha123', '12345678901', '12345678901234', 55555555, 12345, 'Complemento 1', 42, 'arquivos/usuarios/user1.jpeg');

INSERT INTO Usuario (Nome, Email, Senha, CPF, CNPJ, Telefone, CEP, Complemento, Num, imgPath)
VALUES ('Carlos Ferreira', 'carlos@email.com', 'senha123', '56789012345', '56789012345678', 55555555, 67890, 'Complemento 2', 101, 'arquivos/usuarios/user2.jpeg');

INSERT INTO Usuario (Nome, Email, Senha, CPF, CNPJ, Telefone, CEP, Complemento, Num, imgPath)
VALUES ('Luiz Santos', 'luiz@email.com', 'senha123', '88765432109', '98765432109000', 55555555, 98765, 'Complemento 3', 24, 'arquivos/usuarios/user3.jpg');

INSERT INTO Usuario (Nome, Email, Senha, CPF, CNPJ, Telefone, CEP, Complemento, Num, imgPath)
VALUES ('Maria Souza', 'maria@email.com', 'senha123', '98765432109', '98765432109876', 55555555, 54321, 'Apto 301', 7, 'arquivos/usuarios/user4.jpeg');

INSERT INTO Usuario (Nome, Email, Senha, CPF, CNPJ, Telefone, CEP, Complemento, Num, imgPath)
VALUES ('Ana Pereira', 'ana@email.com', 'senha123', '11223344556', '11223344556677', 55555555, 54321, 'Bloco B, Apt 202', 10, 'arquivos/usuarios/user5.jpg');

INSERT INTO Usuario (Nome, Email, Senha, CPF, CNPJ, Telefone, CEP, Complemento, Num, imgPath)
VALUES ('Marcos Andrade', 'marcos@entregador.com', 'senha123', '124865487963', '32556232109876', 55555555, 54321, 'Apto 301', 7, 'arquivos/usuarios/user4.jpeg');

INSERT INTO Usuario (Nome, Email, Senha, CPF, CNPJ, Telefone, CEP, Complemento, Num, imgPath)
VALUES ('Robson Ferreira', 'robson@entregador.com', 'senha123', '88823344556', '11223994556677', 55555555, 54321, 'Bloco B, Apt 202', 10, 'arquivos/usuarios/user5.jpg');


-- Inserir um produto FRUTAS

INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Maçã', 2.50, 1, 1, 'Maçãs frescas e suculentas', 3, 'arquivos/produtos/maca.jpg', 50, 50, 'Kg');

-- Inserindo Banana na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Banana', 1.75, 1, 1, 'Bananas maduras e saborosas', 2, 'arquivos/produtos/banana.jpg', 70, 70, 'kg');

-- Inserindo Morango na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Morango', 3.99, 1, 1, 'Morangos frescos colhidos localmente', 4, 'arquivos/produtos/morango.jpeg', 40, 40, 'Gramas');



-- Inserir um produto GRÃOS 
-- Inserindo Arroz na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Arroz', 5.99, 5, 2, 'Arroz integral de alta qualidade', 3, 'arquivos/produtos/arroz.jpg', 100, 100, 'Kg');

-- Inserindo Quinoa na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Quinoa', 12.50, 5, 2, 'Quinoa orgânica rica em proteínas', 4, 'arquivos/produtos/quinoa.jpeg', 50, 50, 'Gramas');



-- Inserir um produto VERDURAS --
-- Inserindo Alface na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Alface', 1.99, 2, 3, 'Alface fresca e crocante', 3, 'arquivos/produtos/alface.jpeg', 30, 30, 'Maço');

-- Inserindo Espinafre na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Espinafre', 2.75, 2, 3, 'Espinafre orgânico e nutritivo', 2, 'arquivos/produtos/espinafre.jpeg', 25, 25, 'Maço');

-- Inserindo Brócolis na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Brócolis', 3.49, 2, 3, 'Brócolis frescos e saudáveis', 4, 'arquivos/produtos/brocolis.jpeg', 20, 20, 'Maço');


-- Inserir um produto LEGUMES
-- Inserindo Cenoura na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Cenoura', 1.25, 3, 4, 'Cenouras frescas e nutritivas', 3, 'arquivos/produtos/cenoura.jpeg', 40, 40, 'Kg');

-- Inserindo Abobrinha na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Abobrinha', 2.00, 3, 4, 'Abobrinhas orgânicas de alta qualidade', 2, 'arquivos/produtos/abobrinha.jpeg', 35, 35, 'Kg');

-- Inserindo Batata na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Batata', 1.50, 3, 4, 'Batatas frescas e ideais para diversos pratos', 4, 'arquivos/produtos/batata.jpeg', 30, 30, 'Kg');


-- Inserir um produto CEREAIS
-- Inserindo Aveia na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Aveia', 4.99, 4, 5, 'Aveia integral para um café da manhã saudável', 3, 'arquivos/produtos/aveia.jpeg', 40, 40, 'Grama');

-- Inserindo Granola na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Granola', 6.50, 4, 5, 'Granola com frutas secas e nuts', 4, 'arquivos/produtos/granola.png', 25, 25, 'Grama');

-- Inserir um produto GRÃOS
-- Inserindo Milho na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Milho', 2.25, 5, 1, 'Milho doce e fresco', 3, 'arquivos/produtos/milho.jpg', 60, 60, 'Kg');

-- Inserindo Cevada na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Café', 4.99, 5, 3, 'Café forte', 4, 'arquivos/produtos/cafe.jpg', 40, 40, 'Kg');

-- Inserindo Amaranto na tabela Produto
INSERT INTO Produto (Nome, Preco, Categoria_id, Usuario_id, Descricao, Parcelas, imgPath, Quantidade, QuantidadeInicial, Unidade)
VALUES ('Amaranto', 6.75, 5, 5, 'Amaranto em grãos para uma dieta saudável', 2, 'arquivos/produtos/amaranto.jpeg', 30, 30, 'Grama');


-- Inserir uma transportadora
-- 1. Inserir uma transportadora
INSERT INTO Transportadora (CNPJ, Nome, Email, Senha, Telefone, CEP, Num)
VALUES ('12345678901234', 'Transportadora A', 'transportadoraA@example.com', 'senha123', 55555555, 12345, 42);

-- 2. Inserir outra transportadora
INSERT INTO Transportadora (CNPJ, Nome, Email, Senha, Telefone, CEP, Num)
VALUES ('98765432109876', 'Transportadora B', 'transportadoraB@example.com', 'senha456', 55555555, 54321, 7);

-- 3. Inserir mais uma transportadora
INSERT INTO Transportadora (CNPJ, Nome, Email, Senha, Telefone, CEP, Num)
VALUES ('55555555555555', 'Transportadora C', 'transportadoraC@example.com', 'senha789', 55555555, 67890, 101);

-- 4. Inserir outra transportadora
INSERT INTO Transportadora (CNPJ, Nome, Email, Senha, Telefone, CEP, Num)
VALUES ('22222222222222', 'Transportadora D', 'transportadoraD@example.com', 'senhaABC', 55555555, 54321, 10);

-- 5. Inserir mais uma transportadora
INSERT INTO Transportadora (CNPJ, Nome, Email, Senha, Telefone, CEP, Num)
VALUES ('99999999999999', 'Transportadora E', 'transportadoraE@example.com', 'senhaXYZ', 55555555, 98765, 24);



-- Exemplo 1
INSERT INTO Pedido (Produto_id, Usuario_id, Quantidade, Entregador, v1) VALUES (1, 1, 30, 1, 3030);

-- Exemplo 2
INSERT INTO Pedido (Produto_id, Usuario_id, Quantidade, Entregador, v1) VALUES (2, 2, 50, 2, 3040);

-- Exemplo 3
INSERT INTO Pedido (Produto_id, Usuario_id, Quantidade, Entregador, v1) VALUES (3, 3, 10, 3, 3050);

-- Exemplo 4
INSERT INTO Pedido (Produto_id, Usuario_id, Quantidade, Entregador, v1) VALUES (1, 4, 70, 4, 3060);

-- Exemplo 5
INSERT INTO Pedido (Produto_id, Usuario_id, Quantidade, Entregador, v1) VALUES (2, 5, 84, 5, 3070);

