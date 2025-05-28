<?php
session_start();
require_once('../includes/auth.php'); // Verifica se o admin está logado
include_once('../includes/db_connect.php');
include_once('../includes/header.php');

// Buscar todos os usuários cadastrados
$sql = "SELECT id, nome, email, telefone, data_cadastro, aprovado FROM usuarios ORDER BY data_cadastro DESC";
$resultado = $conn->query($sql);
?>

<main class="container">
<link rel="stylesheet" href="../assets/css/style.css">
    <h2>Usuários Cadastrados</h2>

    <table class="tabela-usuarios">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Data Cadastro</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($usuario = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $usuario['id'] ?></td>
                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= htmlspecialchars($usuario['telefone']) ?></td>
                <td><?= date('d/m/Y', strtotime($usuario['data_cadastro'])) ?></td>
                <td><?= $usuario['aprovado'] ? 'Aprovado' : 'Pendente' ?></td>
                <td>
                    <?php if (!$usuario['aprovado']): ?>
                        <a href="aprovar_usuario.php?id=<?= $usuario['id'] ?>" class="btn-aprovar">Aprovar</a>
                    <?php endif; ?>
                    <a href="excluir_usuario.php?id=<?= $usuario['id'] ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include_once('../includes/footer.php'); ?>