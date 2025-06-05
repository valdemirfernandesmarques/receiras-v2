<?php
require_once "../includes/conexao.php";
require_once('../includes/header.php');
echo '<link rel="stylesheet" href="../assets/css/buscar.css">';


$busca = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($busca)) {
    echo "<p>🔍 Nenhum termo de busca informado.</p>";
    exit;
}

$busca_escapada = $conn->real_escape_string($busca);

// Query com JOIN para buscar também pelo nome do usuário autor e categoria
$sql = "SELECT r.*, u.nome AS autor_nome, c.nome AS categoria_nome
        FROM receitas r
        LEFT JOIN usuarios u ON r.usuario_id = u.id
        LEFT JOIN categorias c ON r.categoria_id = c.id
        WHERE r.titulo LIKE '%$busca_escapada%'
           OR r.ingredientes LIKE '%$busca_escapada%'
           OR c.nome LIKE '%$busca_escapada%'
           OR u.nome LIKE '%$busca_escapada%'";

$resultado = $conn->query($sql);

if (!$resultado) {
    die("Erro na consulta: " . $conn->error);
}

if ($resultado->num_rows === 0) {
    echo "<p>❌ Nenhuma receita encontrada para: <strong>" . htmlentities($busca) . "</strong>.</p>";
    echo '<a href="../index.php">Página Inicial</a>';
    exit;
    
}

echo "<h2>🔎 Resultados para: <em>" . htmlentities($busca) . "</em></h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>Título</th><th>Ingredientes</th><th>Categoria</th><th>Autor</th><th>Data</th></tr>";

while ($row = $resultado->fetch_assoc()) {
    $titulo = htmlentities($row['titulo']);
    $ingredientes = htmlentities($row['ingredientes']);
    $categoria_nome = htmlentities($row['categoria_nome'] ?? 'Desconhecida');
    $autor_nome = htmlentities($row['autor_nome'] ?? 'Desconhecido');
    $data_formatada = date("d/m/Y H:i", strtotime($row['criado_em']));

    // Responsivo com data-labels
    echo "<tr>
            <td data-label='Título'>$titulo</td>
            <td data-label='Ingredientes'>$ingredientes</td>
            <td data-label='Categoria'>$categoria_nome</td>
            <td data-label='Autor'>$autor_nome</td>
            <td data-label='Data'>$data_formatada</td>
          </tr>";
}

echo "</table>";

// Botão de voltar
//echo '<a href="index.php" class="btn">Página Inicial</a>';
echo '<a href="../index.php" class="btn">Página Inicial</a>';

$conn->close();
?>