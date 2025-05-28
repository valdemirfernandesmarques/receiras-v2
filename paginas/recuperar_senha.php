<?php include_once('../includes/header.php'); ?>

<main class="container">
<link rel="stylesheet" href="../assets/css/style.css">
    <section class="recuperar-senha">
        <h2>Recuperar Senha</h2>
        <p>Informe seu e-mail cadastrado para receber o link de redefinição de senha.</p>

        <form action="../includes/processa_recuperar_senha.php" method="POST" class="form-recuperar">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Enviar Link</button>
        </form>

        <p class="voltar-login">
            <a href="login.php">Voltar para o login</a>
        </p>
    </section>
</main>

<?php include_once('../includes/footer.php'); ?>