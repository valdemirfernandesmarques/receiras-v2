<?php
require_once '../includes/db_connect.php'; // Conexão com o banco
include_once '../includes/header.php';
?>

<main class="container">
<link rel="stylesheet" href="../assets/css/style.css">
    <section class="intro">
        <h1>🍲 Receitas Retrô</h1>
        <form action="busca.php" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Buscar receitas..." required>
            <button type="submit">🔍</button>
        </form>
    </section>

    <section class="receitas-lista">
        <h2>Receitas em Destaque</h2>
        <div class="receita-cards">
            <?php
            try {
                $stmt = $pdo->prepare("SELECT id, titulo, imagem, categoria FROM receitas ORDER BY id DESC LIMIT 6");
                $stmt->execute();
                $receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($receitas) > 0) {
                    foreach ($receitas as $receita) {
                        echo '<div class="card">';
                        if (!empty($receita['imagem'])) {
                            echo '<img src="../uploads/' . htmlspecialchars($receita['imagem']) . '" alt="' . htmlspecialchars($receita['titulo']) . '">';
                        } else {
                            echo '<img src="../assets/img/placeholder.png" alt="Sem imagem">';
                        }
                        echo '<h3>' . htmlspecialchars($receita['titulo']) . '</h3>';
                        echo '<p>Categoria: ' . htmlspecialchars($receita['categoria']) . '</p>';
                        echo '<a href="receita_detalhe.php?id=' . $receita['id'] . '" class="btn">Ver Receita</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>⚠️ Nenhuma receita encontrada.</p>';
                }
            } catch (PDOException $e) {
                echo '<p>Erro ao carregar receitas: ' . $e->getMessage() . '</p>';
            }
            ?>
        </div>
    </section>
</main>

<?php include_once '../includes/footer.php'; ?>