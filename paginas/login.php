<?php
session_start();
require_once '../includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];

    $stmt = $conn->prepare("SELECT id, email, senha, status FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario["senha"])) {
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_email"] = $usuario["email"];
            $_SESSION["usuario_status"] = $usuario["status"];

            if ($email === "admin@retro.com") {
                header("Location: ../admin/dashboard.php");
            } elseif ($usuario["status"] === "liberado") {
                header("Location: ../paginas/index.php");
            } else {
                echo "<script>alert('Seu cadastro está pendente. Aguarde aprovação do administrador.'); window.location.href='login.php';</script>";
            }
            exit();
        }
    }

    echo "<script>alert('E-mail ou senha incorretos.'); window.location.href='login.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="pagina-login">
    
    <h2>Login</h2>
    <form method="post" action="">
        <label for="email">E-mail:</label><br>
        <input type="email" name="email" required><br><br>
        <label for="senha">Senha:</label><br>
        <input type="password" name="senha" required><br><br>
        <button type="submit">Entrar</button> <br>
        
        <br><a href="../paginas/index.php">Sair</a>
    </form>
</body>
</html>