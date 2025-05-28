<?php
include_once '../includes/header.php';

?>

<section class="banner">
    <div class="container">
        <h1>Bem-vindo ao <span class="highlight">Receitas Retrô</span> 🍰</h1>
        <p>Explore receitas nostálgicas, compartilhe sabores e reviva memórias da cozinha da vovó!</p>
        <a href="receitas.php" class="btn-destaque">Explorar Receitas</a>
    </div>
</section>

<section class="destaques">
    <div class="container">
        <h2>Receitas em Destaque</h2>
        <div class="receitas-grid">
            <div class="receita-card">
                <img src="assets/img/bolo-caseiro.jpg" alt="Bolo de Fubá1">
                <h3>Bolo Caseiro de Fubá1</h3>
                <p>Clássico da tarde com café, direto da cozinha da vovó!</p>
                <a href="#" class="btn">Ver Receita</a>
            </div>
            <div class="receita-card">
                <img src="assets/img/pao-caseiro-facil1.webp" alt="Pão Caseiro">
                <h3>Pão Caseiro Quentinho</h3>
                <p>Feito com carinho e tradição, perfeito para o café da manhã.</p>
                <a href="#" class="btn">Ver Receita</a>
            </div>
        </div>
    </div>
</section>

<?php
include_once '../includes/footer.php';
?>