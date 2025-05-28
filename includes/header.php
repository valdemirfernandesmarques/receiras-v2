<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
  <link rel="stylesheet" href="/receitasretro/assets/css/style.css">
  <nav class="navbar">
    <div class="logo">
      <a href="/receitasretro/index.php">Receitas Retrô</a>
    </div>

    <div class="search-bar">
      <form action="/receitasretro/paginas/buscar.php" method="GET">
        <input type="text" name="q" placeholder="Buscar receitas...">
        <button type="submit">🔍</button>
      </form>
    </div>

    <ul class="menu">
      <li><a href="/receitasretro/index.php">Início</a></li>
      <li class="dropdown">
        <a href="#">Receitas ▼</a>
        <ul class="dropdown-content">
          <li><a href="/receitasretro/paginas/categoria.php?cat=vegetarianas">Vegetarianas</a></li>
          <li><a href="/receitasretro/paginas/categoria.php?cat=veganas">Veganas</a></li>
          <li><a href="/receitasretro/paginas/categoria.php?cat=salgados">Salgados</a></li>
          <li><a href="/receitasretro/paginas/categoria.php?cat=massas">Massas</a></li>
          <li><a href="/receitasretro/paginas/categoria.php?cat=paes">Pães</a></li>
          <li><a href="/receitasretro/paginas/categoria.php?cat=bolos">Bolos</a></li>
          <li><a href="/receitasretro/paginas/categoria.php?cat=doces">Doces</a></li>
        </ul>
      </li>
      <li><a href="/receitasretro/paginas/adicionar_receita.php">Adicionar Receita</a></li>
      <li><a href="/receitasretro/paginas/saude.php">Saúde</a></li>
      <li><a href="/receitasretro/paginas/sobre.php">Sobre</a></li>
      <li><a href="/receitasretro/paginas/contato.php">Contato</a></li>
      
      <!-- Sempre mostrar Login e Cadastrar -->
      <li><a href="/receitasretro/paginas/login.php">Login</a></li>
      <li><a href="/receitasretro/paginas/cadastro.php">Cadastrar</a></li>

      <!-- Mostrar Sair apenas se estiver logado -->
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <li><a href="index.php">Sair</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>