<?php
require_once '../includes/auth.php'; // Verifica se o admin está autenticado
require_once '../includes/header.php';
require_once '../includes/db_connect.php';

// Consulta receitas cadastradas
$sql = "SELECT r.id, r.titulo, r.categoria, r.data_criacao, u.nome AS autor
        FROM receitas r
        JOIN usuarios u ON r.usuario_id = u.id
        ORDER BY r.data_criacao DESC";
$result = $conn->query($sql);
?>

<div class="container">
<link rel="stylesheet" href="../assets/css/style.css">
    <h2>Gerenciar Receitas</h2>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Categoria</th>
                <th>Data</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($receita = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($receita['titulo']) ?></td>
                    <td><?= htmlspecialchars($receita['categoria']) ?></td>
                    <td><?= date('d/m/Y', strtotime($receita['data_criacao'])) ?></td>
                    <td><?= htmlspecialchars($receita['autor']) ?></td>
                    <td>
                        <a href="editar_receita.php?id=<?= $receita['id'] ?>">Editar</a> |
                        <a href="excluir_receita.php?id=<?= $receita['id'] ?>" onclick="return confirm('Deseja realmente excluir esta receita?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php require_once '../includes/footer.php'; ?>