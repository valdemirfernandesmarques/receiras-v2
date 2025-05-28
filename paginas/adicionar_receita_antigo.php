<?php
session_start();
require_once '../includes/conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php?sucesso=1");
    exit();
}

// Verifica se o status do usuário permite adicionar receita
if ($_SESSION["usuario_status"] !== "liberado") {
    echo "<script>alert('Você ainda não tem permissão para adicionar receitas. Aguarde liberação do administrador.'); window.location.href='login.php';</script>";
    exit();
}

// Se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitiza os dados
    $titulo = htmlspecialchars(trim($_POST["titulo"]));
    $ingredientes = htmlspecialchars(trim($_POST["ingredientes"]));
    $modo_preparo = htmlspecialchars(trim($_POST["modo_preparo"]));
    $imagem = htmlspecialchars(trim($_POST["imagem"]));
    $categoria_id = isset($_POST["categoria_id"]) ? intval($_POST["categoria_id"]) : null;
    $usuario_id = $_SESSION["usuario_id"];

    // Prepara e executa a inserção
    $stmt = $conn->prepare("INSERT INTO receitas (titulo, ingredientes, modo_preparo, imagem, categoria_id, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiii", $titulo, $ingredientes, $modo_preparo, $imagem, $categoria_id, $usuario_id);
    if ($stmt->execute()) {
        header("Location: receitas.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao adicionar receita: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Receita</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="pagina-adicionar-receita">
    <textarea class="nao-redimensionar" ...></textarea>
    <h2>Adicionar Receita</h2>
    <form method="post" action="">
        <label for="categoria">Categoria:</label><br>
        <select name="categoria_id" required>
            <option value="">Selecione uma categoria</option>
            <option value="1">Vegetariana</option>
            <option value="2">Vegana</option>
            <option value="3">Salgado</option>
            <option value="4">Massa</option>
            <option value="5">Pão</option>
            <option value="6">Bolo</option>
            <option value="7">Doce</option>
        </select><br><br>

        <div class="container">
            <label for="titulo">Título:</label><br>
            <input type="text" name="titulo" required><br><br>
            <label for="ingredientes">Ingredientes:</label><br>
            <textarea name="ingredientes" rows="5" required></textarea><br><br>
            <label for="modo_preparo">Modo de Preparo:</label><br>
            <textarea name="modo_preparo" rows="6" required></textarea><br><br>
            <label for="imagem">Imagem da Receita (até 5MB):</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required><br><br>

            <button type="submit">Salvar Receita</button>
        </div>
    </form>
</body>
</html>