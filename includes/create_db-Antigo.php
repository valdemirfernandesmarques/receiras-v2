///<?php
//$host = 'localhost';         // Altere se necessário
//$dbname = 'receitas_retro'; // Nome do banco que será criado
//$user = 'root';              // Usuário do banco
//$pass = '';                  // Senha

//try {
    // Conecta ao MySQL sem selecionar banco (para poder criar o banco)
  //  $pdo = new PDO("mysql:host=$host", $user, $pass);
  //  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria o banco de dados
   // $pdo->exec("CREATE DATABASE IF NOT EXISTS receitas_retro CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;");
   // echo "Banco de dados criado com sucesso.<br>";

    // Seleciona o banco de dados
   // $pdo->exec("USE receitas_retro");

    // Criação das tabelas
    //$sql = "
   // DROP TABLE IF EXISTS avaliacoes;
   // DROP TABLE IF EXISTS receitas;
   // DROP TABLE IF EXISTS categorias;
   // DROP TABLE IF EXISTS usuarios;

    //CREATE TABLE usuarios (
      //  id INT AUTO_INCREMENT PRIMARY KEY,
       // nome VARCHAR(100) NOT NULL,
       // email VARCHAR(80) NOT NULL UNIQUE,
       // telefone VARCHAR(25) NOT NULL,
        //senha VARCHAR(25) NOT NULL,
        //criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    //);

    //INSERT INTO usuarios (nome, email, telefone, senha)
    /*VALUES ('Administrador', 'admin@retro.com', '(48)99685-9855', '123456');

    CREATE TABLE categorias (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL UNIQUE
    );

    INSERT INTO categorias (nome) VALUES
    ('Vegetarianas'),
    ('Veganas'),
    ('Salgados'),
    ('Massas'),
    ('Pães'),
    ('Bolos'),
    ('Doces');

    CREATE TABLE receitas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(200) NOT NULL,
        descricao TEXT NOT NULL,
        ingredientes TEXT NOT NULL,
        modo_preparo TEXT NOT NULL,
        imagem VARCHAR(255),
        id_categoria INT,
        id_usuario INT,
        data_publicacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_categoria) REFERENCES categorias(id),
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
    );

    CREATE TABLE avaliacoes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_receita INT NOT NULL,
        id_usuario INT,
        estrelas INT CHECK(estrelas BETWEEN 1 AND 5),
        comentario TEXT,
        data_avaliacao DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (id_receita) REFERENCES receitas(id) ON DELETE CASCADE,
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE SET NULL
    );
    ";

    $pdo->exec($sql);
    echo "Tabelas criadas e dados inseridos com sucesso.<br>";

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>*/