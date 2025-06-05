<?php
session_start();
require_once '../includes/conexao.php';
include_once('../includes/header.php');

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
    $titulo = htmlspecialchars(trim($_POST["titulo"]));
    $ingredientes = htmlspecialchars(trim($_POST["ingredientes"]));
    $modo_preparo = htmlspecialchars(trim($_POST["modo_preparo"]));
    $categoria_id = isset($_POST["categoria_id"]) ? intval($_POST["categoria_id"]) : null;
    $usuario_id = $_SESSION["usuario_id"];
    $imagem_caminho = null;

    // Upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $nomeOriginal = basename($_FILES['imagem']['name']);
        $tipo = $_FILES['imagem']['type'];
        $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);

        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array(strtolower($extensao), $tiposPermitidos)) {
            die("Tipo de arquivo não permitido.");
        }

        $nomeArquivo = uniqid("img_", true) . "." . $extensao;
        $caminho = "uploads/" . $nomeArquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
            $stmt_img = $conn->prepare("INSERT INTO imagens (nome, tipo, caminho) VALUES (?, ?, ?)");
            $stmt_img->bind_param("sss", $nomeOriginal, $tipo, $caminho);
            if ($stmt_img->execute()) {
                $imagem_caminho = $caminho;
            } else {
                die("Erro ao salvar imagem no banco de dados.");
            }
            $stmt_img->close();
        } else {
            die("Erro ao mover o arquivo de imagem.");
        }
    } else {
        die("Nenhum arquivo enviado ou erro no upload.");
    }

    // Inserção da receita
    $stmt = $conn->prepare("INSERT INTO receitas (titulo, ingredientes, modo_preparo, imagem, categoria_id, usuario_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssii", $titulo, $ingredientes, $modo_preparo, $imagem_caminho, $categoria_id, $usuario_id);

    if ($stmt->execute()) {
        header("Location: receitas.php?sucesso=1");
        exit();
    } else {
        echo "Erro ao adicionar receita: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Receita</title>
    <link rel="stylesheet" href="../assets/css/adicionar_receita.css">
</head>

<body class="pagina-adicionar-receita">
    <h2>Adicionar Receita</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="categoria">Categoria:</label><br>
        <select name="categoria_id" required>
            <option value="">Selecione uma categoria</option>
            <option value="1">Vegetariana</option>
            <option value="2">Vegana</option>
            <option value="3">Salgado</option>
            <option value="4">Massa</option>
            <option value="5">Pães</option>
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

            <label for="imagem">Imagem da Receita (até 5MB):</label><br>
            <input type="file" name="imagem" accept="image/*" required><br><br>

            <button type="submit">Salvar Receita</button>
        </div>
    </form>
</body>

</html>