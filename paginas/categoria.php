<?php
// Inclui o arquivo de conexão com o banco de dados
include_once '../includes/conexao.php';

// Inclui o cabeçalho da página (head, abertura do body, etc.)
include_once '../includes/header.php';


// Verifica se a categoria foi passada via parâmetro GET
if (isset($_GET['cat'])) {
    $categoria = $_GET['cat'];

    // Consulta para obter o ID da categoria pelo nome
    $stmtCategoria = $conn->prepare("SELECT id FROM categorias WHERE nome = ?");
    $stmtCategoria->bind_param("s", $categoria);
    $stmtCategoria->execute();
    $resultCategoria = $stmtCategoria->get_result();

    // Se a categoria existe, continua o processo
    if ($resultCategoria->num_rows > 0) {
        $categoriaRow = $resultCategoria->fetch_assoc();
        $categoriaId = $categoriaRow['id'];

        // Consulta as receitas da categoria, incluindo o nome do autor com JOIN
        $stmtReceitas = $conn->prepare("SELECT r.*, u.nome AS autor_nome 
                                        FROM receitas r 
                                        JOIN usuarios u ON r.usuario_id = u.id 
                                        WHERE r.categoria_id = ?");
        $stmtReceitas->bind_param("i", $categoriaId);
        $stmtReceitas->execute();
        $resultReceitas = $stmtReceitas->get_result();

    } else {
        // Caso a categoria não exista
        echo "<p style='padding:20px;'>Categoria não encontrada.</p>";
        exit;
    }
} else {
    // Caso nenhum parâmetro de categoria seja passado
    echo "<p style='padding:20px;'>Categoria não especificada.</p>";
    exit;
}
?>

<!-- 
    A classe "pagina-categoria" pode ser usada no CSS 
    para estilização específica desta página 
-->

    
<body>
<main class="container pagina-categoria">
    
    <!-- Título principal da categoria -->
    <h2 class="titulo-categoria">Receitas: <?php echo ucfirst($categoria); ?></h2>

    <!-- Grid de receitas da categoria -->
    <div class="grid-receitas">

        <?php while ($receita = $resultReceitas->fetch_assoc()) { ?>
            <fieldset class="card-receita">
                <legend class="receita-titulo">
                    <?php echo htmlspecialchars($receita['titulo']); ?>
                </legend>
                

                <!-- Informações do autor e data da publicação -->
                <p class="autor-receita">
                    Escrito por: <strong><?php echo htmlspecialchars($receita['autor_nome']); ?></strong><br>
                    Publicado em: <strong><?php echo date('d/m/Y \à\s H:i', strtotime($receita['criado_em'])); ?></strong>
                </p>

                <!-- Imagem da receita -->
                <img src="<?php echo $receita['imagem']; ?>" 
                     alt="Imagem da receita <?php echo htmlspecialchars($receita['titulo']); ?>">

                <!-- Conteúdo da receita: ingredientes e preparo -->
                <section class="receita-conteudo">
                    
                    <!-- Lista de ingredientes -->
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

                    <!-- Lista do modo de preparo -->
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

                <!-- Link de volta para a página inicial -->
                <a href="index.php?id=<?php echo $receita['id']; ?>" class="btn">Página Inicial</a>
            </fieldset>
        <?php } ?>

    </div>
    
</main>
 
</body>
<?php
// Inclui o rodapé da página (encerramento do body e html)
include_once('../includes/footer.php');
