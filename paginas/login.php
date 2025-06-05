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
                header("Location: ../index.php");
            } else {
                echo "<script>alert('Seu cadastro está pendente. Aguarde aprovação do administrador.'); window.location.href='login.php';</script>";
            }
            exit();
        }
    }

    echo "<script>alert('E-mail ou senha incorretos.'); window.location.href='login.php';</script>";
}
?>

<?php include_once('../includes/header.php'); ?>

<main class="login-container">
    <section class="login-box">
        <h2>Entrar na sua conta</h2>
        <form method="post" action="">
            <label for="email">E-mail:</label>
            <input type="email" name="email" required>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>

            <button type="submit">Entrar</button>
        </form>

        <p><a href="../index.php">← Voltar à página inicial</a></p>
    </section>
</main>

<?php include_once('../includes/footer.php'); ?>