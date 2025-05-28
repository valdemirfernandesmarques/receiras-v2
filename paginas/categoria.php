<?php
include_once '../includes/conexao.php';
include_once '../includes/header.php';

// Verifica se a categoria foi passada via GET
if (isset($_GET['cat'])) {
    $categoria = $_GET['cat'];

    // Consulta para obter o ID da categoria
    $stmtCategoria = $conn->prepare("SELECT id FROM categorias WHERE nome = ?");
    $stmtCategoria->bind_param("s", $categoria);
    $stmtCategoria->execute();
    $resultCategoria = $stmtCategoria->get_result();

    if ($resultCategoria->num_rows > 0) {
        $categoriaRow = $resultCategoria->fetch_assoc();
        $categoriaId = $categoriaRow['id'];

        // Consulta com JOIN para trazer o nome do autor
        $stmtReceitas = $conn->prepare("SELECT r.*, u.nome AS autor_nome 
                                        FROM receitas r 
                                        JOIN usuarios u ON r.usuario_id = u.id 
                                        WHERE r.categoria_id = ?");
        $stmtReceitas->bind_param("i", $categoriaId);
        $stmtReceitas->execute();
        $resultReceitas = $stmtReceitas->get_result();
    } else {
        echo "<p style='padding:20px;'>Categoria não encontrada.</p>";
        exit;
    }
} else {
    echo "<p style='padding:20px;'>Categoria não especificada.</p>";
    exit;
}
?>
<body class="pagina-categoria">

<main class="container">
    <h2 class="titulo-categoria">Receitas: <?php echo ucfirst($categoria); ?></h2>

    <div class="grid-receitas">
        <?php while ($receita = $resultReceitas->fetch_assoc()) { ?>
            <fieldset class="card-receita">
                <legend class="receita-titulo"><?php echo htmlspecialchars($receita['titulo']); ?></legend>
                
                <p class="autor-receita">Escrito por: <strong><?php echo htmlspecialchars($receita['autor_nome']); ?></strong></p>

                <img src="<?php echo $receita['imagem']; ?>" alt="Imagem da receita <?php echo htmlspecialchars($receita['titulo']); ?>">

                <section class="receita-conteudo">
                    <div class="receita-bloco">
                        <h4>Ingredientes</h4>
                        <ul class="lista-ingredientes">
                            <?php
                            $ingredientes = explode("\n", $receita['ingredientes']);
                            foreach ($ingredientes as $item) {
                                echo "<li>" . htmlspecialchars(trim($item)) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="receita-bloco">
                        <h4>Modo de Preparo</h4>
                        <ol class="lista-preparo">
                            <?php
                            $preparo = explode("\n", $receita['modo_preparo']);
                            foreach ($preparo as $passo) {
                                echo "<li>" . htmlspecialchars(trim($passo)) . "</li>";
                            }
                            ?>
                        </ol>
                    </div>
                </section>

                <a href="index.php?id=<?php echo $receita['id']; ?>" class="btn">Página Inicial</a>
            </fieldset>
        <?php } ?>
    </div>
</main>

</body>

<?php include_once('../includes/footer.php'); ?>
</body>