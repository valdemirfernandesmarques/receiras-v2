<?php
// Inicia a sessão caso ainda não tenha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui o cabeçalho com o menu de navegação
include_once('includes/header.php');
include_once('includes/create_db.php');
?>
<body class="pagina-index">

<!-- Conteúdo principal da Página Inicial -->
<main class="container">
    <section class="hero">
        <h1 class="titulo">Bem-vindo ao Receitas Retrô 🍰</h1>
        <p class="descricao">Explore receitas nostálgicas, compartilhe sabores e reviva memórias da cozinha da vovó!</p>
        <a href="paginas/receitas.php" class="btn">Explorar Receitas</a>
    </section>

    <section class="destaques">
        <h2>Receitas em Destaque</h2>
        <div class="cards">
            <!-- Exemplo de card de receita -->
            <div class="card">
                <img src="assets/img/bolo-caseiro.jpg" alt="Bolo Caseiro">
                <h3>Bolo Caseiro de Fubá</h3>
                <p>Clássico da tarde com café, direto da cozinha da vovó!</p>
                <a href="paginas/receitas.php" class="btn-pequeno">Ver Receita</a>
            </div>

            <div class="card">
                <img src="assets/img/pao-caseiro.jpg" alt="Pão Caseiro">
                <h3>Pão Caseiro Quentinho</h3>
                <p>Feito com carinho e tradição, perfeito para o café da manhã.</p>
                <a href="paginas/receitas.php" class="btn-pequeno">Ver Receita</a>
            </div>
        </div>
    </section>
</main>

</body>
<?php
// Inclui o rodapé
include_once('includes/footer.php');

?>
