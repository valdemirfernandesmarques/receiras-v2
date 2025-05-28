<?php
$host = 'localhost';
$dbname = 'receitas_retro';
$user = 'root';
$pass = '';

try {
    // Conecta ao MySQL
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cria o banco se não existir
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "Banco de dados verificado/criado com sucesso.<br>";

    // Usa o banco
    $pdo->exec("USE $dbname");

    // Cria tabela usuarios
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            telefone VARCHAR(20) DEFAULT NULL,
            senha VARCHAR(255) NOT NULL,
            tipo ENUM('usuario','admin') DEFAULT 'usuario',
            ativo TINYINT(1) DEFAULT 0,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status VARCHAR(20) DEFAULT 'pendente'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Cria tabela categorias
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categorias (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(50) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Cria tabela receitas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS receitas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(150) NOT NULL,
            descricao TEXT NOT NULL,
            ingredientes TEXT NOT NULL,
            modo_preparo TEXT NOT NULL,
            imagem VARCHAR(255) DEFAULT NULL,
            categoria_id INT DEFAULT NULL,
            usuario_id INT DEFAULT NULL,
            aprovado TINYINT(1) DEFAULT 0,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            status ENUM('pendente','liberado') DEFAULT 'pendente',
            FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Cria tabela imagens
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS imagens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            tipo VARCHAR(100),
            caminho VARCHAR(255) NOT NULL,
            receita_id INT,
            FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Cria tabela avaliacoes
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS avaliacoes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT DEFAULT NULL,
            receita_id INT DEFAULT NULL,
            estrelas INT DEFAULT NULL,
            comentario TEXT,
            criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Cria tabela compartilhamentos
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS compartilhamentos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            receita_id INT DEFAULT NULL,
            plataforma ENUM('WhatsApp','Facebook','Instagram') DEFAULT NULL,
            compartilhado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (receita_id) REFERENCES receitas(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    // Cria tabela tokens_recuperacao
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS tokens_recuperacao (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            token VARCHAR(255) NOT NULL,
            expira_em DATETIME NOT NULL,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");

    echo "Tabelas criadas/verificadas com sucesso.<br>";

    // Insere categorias padrão
    $categorias = ['Vegetarianas', 'Veganas', 'Salgados', 'Massas', 'Pães', 'Bolos', 'Doces'];
    foreach ($categorias as $cat) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categorias WHERE nome = ?");
        $stmt->execute([$cat]);
        if ($stmt->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO categorias (nome) VALUES (?)");
            $stmt->execute([$cat]);
        }
    }
    echo "Categorias inseridas/verificadas com sucesso.<br>";

    // Insere administrador padrão se não existir
    $emailAdmin = 'admin@retro.com';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
    $stmt->execute([$emailAdmin]);

    if ($stmt->fetchColumn() == 0) {
        $senhaHash = '$2y$10$VzY5Fe7wmA8Z8EORlQPGuedXr7rY3hzylTJmsTX8Kaif/Skm1Dv0G'; // senha: 123456
        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nome, email, telefone, senha, tipo, ativo, status, criado_em)
            VALUES ('Administrador', ?, '(48)99685-9855', ?, 'admin', 1, 'liberado', NOW())
        ");
        $stmt->execute([$emailAdmin, $senhaHash]);
        echo "Usuário administrador criado com sucesso.<br>";
    } else {
        echo "Usuário administrador já existe.<br>";
    }

} catch (PDOException $e) {
    die("Erro ao criar banco: " . $e->getMessage());
}
?>