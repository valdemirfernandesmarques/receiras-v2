CREATE DATABASE IF NOT EXISTS receitas_retro;
USE receitas_retro;

-- --------------------------------------------------------
-- Tabela: usuarios
-- --------------------------------------------------------

DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  telefone VARCHAR(20) DEFAULT NULL,
  senha VARCHAR(255) NOT NULL,
  tipo ENUM('usuario','admin') DEFAULT 'usuario',
  ativo TINYINT(1) DEFAULT 0,
  criado_em TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  status VARCHAR(20) DEFAULT 'pendente',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: categorias
-- --------------------------------------------------------

DROP TABLE IF EXISTS categorias;
CREATE TABLE categorias (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL UNIQUE,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: receitas
-- --------------------------------------------------------

DROP TABLE IF EXISTS receitas;
CREATE TABLE receitas (
  id INT NOT NULL AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT NOT NULL,
  ingredientes TEXT NOT NULL,
  modo_preparo TEXT NOT NULL,
  imagem VARCHAR(255) DEFAULT NULL,
  categoria_id INT DEFAULT NULL,
  usuario_id INT DEFAULT NULL,
  aprovado TINYINT(1) DEFAULT 0,
  criado_em TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  status ENUM('pendente','liberado') DEFAULT 'pendente',
  PRIMARY KEY (id),
  KEY (categoria_id),
  KEY (usuario_id),
  CONSTRAINT fk_receitas_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
  CONSTRAINT fk_receitas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: imagens
-- --------------------------------------------------------

DROP TABLE IF EXISTS imagens;
CREATE TABLE imagens (
  id INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  tipo VARCHAR(100),
  caminho VARCHAR(255) NOT NULL,
  receita_id INT,
  PRIMARY KEY (id),
  FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: avaliacoes
-- --------------------------------------------------------

DROP TABLE IF EXISTS avaliacoes;
CREATE TABLE avaliacoes (
  id INT NOT NULL AUTO_INCREMENT,
  usuario_id INT DEFAULT NULL,
  receita_id INT DEFAULT NULL,
  estrelas INT DEFAULT NULL,
  comentario TEXT,
  criado_em TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY (usuario_id),
  KEY (receita_id),
  CONSTRAINT fk_avaliacoes_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  CONSTRAINT fk_avaliacoes_receita FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: compartilhamentos
-- --------------------------------------------------------

DROP TABLE IF EXISTS compartilhamentos;
CREATE TABLE compartilhamentos (
  id INT NOT NULL AUTO_INCREMENT,
  receita_id INT DEFAULT NULL,
  plataforma ENUM('WhatsApp','Facebook','Instagram') DEFAULT NULL,
  compartilhado_em TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY (receita_id),
  CONSTRAINT fk_compartilhamentos_receita FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Tabela: tokens_recuperacao
-- --------------------------------------------------------

DROP TABLE IF EXISTS tokens_recuperacao;
CREATE TABLE tokens_recuperacao (
  id INT NOT NULL AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  token VARCHAR(255) NOT NULL,
  expira_em DATETIME NOT NULL,
  PRIMARY KEY (id),
  KEY (usuario_id),
  CONSTRAINT fk_tokens_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Inserts iniciais
-- --------------------------------------------------------

INSERT INTO categorias (id, nome) VALUES
(1, 'Vegetarianas'), (2, 'Veganas'), (3, 'Salgados'),
(4, 'Massas'), (5, 'Pães'), (6, 'Bolos'), (7, 'Doces');

INSERT INTO usuarios (id, nome, email, telefone, senha, tipo, ativo, criado_em, status) VALUES
(1, 'Administrador', 'admin@retro.com', '(48)99685-9855', '$2y$10$VzY5Fe7wmA8Z8EORlQPGuedXr7rY3hzylTJmsTX8Kaif/Skm1Dv0G', 'admin', 1, NOW(), 'liberado'),
(2, 'maria', 'maria@gmail.com', NULL, '$2y$10$pS/zOn32w.Ik/qwNSznyi.lN4x7QoBtO1UYKnwQ3uW3mGAClRG0Ka', 'usuario', 1, NOW(), 'liberado'),
(3, 'tito', 'tito@gmail.com', NULL, '$2y$10$ECUlGeHRgdoloCDE4V0DGuaY2kCmKKqCaDl05ORnBFTNrU3Jkrvji', 'usuario', 0, NOW(), 'liberado'),
(4, 'zeca', 'zeca@gmail.com', NULL, '$2y$10$J97D5CLv4wLMbhCeVYWa6eYZDek1wi4aEF1b2NM5CsV7Eh3Kn.A1e', 'usuario', 0, NOW(), 'liberado'),
(5, 'roberto', 'robrto@gmail.com', NULL, '$2y$10$8hlH2SS21HOwkLgWpGaJdeJw6LNkdxsLs1uZcaIHoGvME9Q6y3Qiq', 'usuario', 0, NOW(), 'liberado'),
(6, 'maricota', 'maricota@gmail.com', NULL, '$2y$10$aVyp2xxLaxQ8VhbXAdISMuf30KvEcWPDEaEEGUxB/ZJw7kAIf/IEC', 'usuario', 0, NOW(), 'liberado');

INSERT INTO receitas (id, titulo, descricao, ingredientes, modo_preparo, imagem, categoria_id, usuario_id, aprovado, criado_em, status) VALUES
(27, 'macarronada', '', 'teste', 'teste', 'uploads/68251d91540b9_Macarronada Italiana.jpg', 3, 4, 1, NOW(), 'liberado'),
(42, 'Bolo', '', 'Ingredientes\r\n 1 porção\r\n1/2 xícara óleo\r\n4 ovos\r\n150 gramas cenoura\r\n1 e 1/2 xícara de açúcar\r\n2 xícaras farinha de trigo', 'Instruções de cozinha\r\n 1hora\r\n1\r\nEm um liquidificador bata a cenoura, os ovos, o açúcar e o óleo, até tudo ficar homogêneo. Em seguida, em um bol acrescente a mistura do liquidificador com a farinha peneirada. Quando tiver tudo homogêneo acrescente o fermento em pó. Leve para assar em uma forma untada em forno pré aquecido a 180 graus até que doure. Faça o teste do palito.', '0', 6, 3, 0, NOW(), 'liberado'),
(43, 'bolo', '', 'hahahtes', 'teste', '0', 6, 6, 0, NOW(), 'liberado');
