<?php
session_start();
require_once '../includes/conexao.php';

// Verifica se é o admin logado
if (!isset($_SESSION["usuario_email"]) || $_SESSION["usuario_email"] !== "admin@retro.com") {
    header("Location: ../paginas/login.php");
    exit();
}

// Liberação de usuários
if (isset($_GET['liberar_id'])) {
    $liberar_id = intval($_GET['liberar_id']);
    $stmt = $conn->prepare("UPDATE usuarios SET status = 'liberado' WHERE id = ?");
    $stmt->bind_param("i", $liberar_id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// Liberação de receitas
if (isset($_GET['liberar_receita_id'])) {
    $liberar_receita_id = intval($_GET['liberar_receita_id']);
    $stmt = $conn->prepare("UPDATE receitas SET status = 'liberado' WHERE id = ?");
    $stmt->bind_param("i", $liberar_receita_id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// Busca todos os usuários
$resultado_usuarios = $conn->query("SELECT id, nome, email, status FROM usuarios ORDER BY status DESC");

// Busca receitas pendentes
$sql_receitas = "
    SELECT r.id, r.titulo, u.nome AS nome_usuario, u.email 
    FROM receitas r
    JOIN usuarios u ON r.usuario_id = u.id
    WHERE r.status = 'pendente'
    ORDER BY r.id DESC
";
$resultado_receitas = $conn->query($sql_receitas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="pagina-dashboard">
    <h2>Usuários Cadastrados</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php while ($usuario = $resultado_usuarios->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= $usuario['status'] ?></td>
                <td>
                    <?php if ($usuario['status'] == 'pendente') { ?>
                        <a href="?liberar_id=<?= $usuario['id'] ?>" onclick="return confirm('Deseja liberar este usuário?')">Liberar</a>
                    <?php } else { ?>
                        Liberado
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br><hr><br>

    <h2>Receitas Pendentes</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>Título da Receita</th>
            <th>Nome do Usuário</th>
            <th>E-mail do Usuário</th>
            <th>Ações</th>
        </tr>

        <?php while ($receita = $resultado_receitas->fetch_assoc()) { ?>
            <tr>
                <td><?= htmlspecialchars($receita['titulo']) ?></td>
                <td><?= htmlspecialchars($receita['nome_usuario']) ?></td>
                <td><?= htmlspecialchars($receita['email']) ?></td>
                <td>
                    <a href="?liberar_receita_id=<?= $receita['id'] ?>" onclick="return confirm('Deseja liberar esta receita?')">Liberar</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br><a href="../index.php">Sair</a>
</body>
</html>
