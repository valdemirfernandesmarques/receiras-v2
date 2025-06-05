 <?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function getCurrentPageName() {
    return basename($_SERVER['PHP_SELF']);
}

$currentPage = getCurrentPageName();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receitas Retrô</title>

  <!-- CSS principal -->
  <link rel="stylesheet" href="/receitasretro/assets/css/style.css">
  <link rel="stylesheet" href="/receitasretro/assets/css/header.css">
  <link rel="stylesheet" href="/receitasretro/assets/css/footer.
css">
  <?php
  $cssMap = [
      'index.php' => 'index.css',
      'categoria.php' => 'categoria.css',
      'adicionar_receita.php' => 'adicionar_receita.css',
      'sobre.php' => 'sobre.css',
      'contato.php' => 'contato.css',
      'cadastro.php' => 'cadastro.css',
      'login.php' => 'login.css',
      'dashboard.php' => 'dashboard.css',
      'buscar.php' => 'buscar.css'
  ];

  if (array_key_exists($currentPage, $cssMap)) {
      echo '<link rel="stylesheet" href="/receitasretro/assets/css/' . $cssMap[$currentPage] . '">' . "\n";
  }
  ?>
</head>
<body>

<!-- INÍCIO DO CABEÇALHO -->
<header class="site-header">
  <nav class="navbar">
    <div class="logo">
      <a href="/receitasretro/index.php">Receitas <span>Retrô</span></a>
    </div>

    <!-- Botão de menu responsivo: estilo do botão hamburguer -->
    <!--<button class="menu-toggle" onclick="document.querySelector('.menu').classList.toggle('active')">☰</button> -->

    <!-- Barra de pesquisa -->
    <div class="search-bar">
      <form action="/receitasretro/paginas/buscar.php" method="GET">
        <input type="text" name="q" placeholder="Buscar receitas...">
        <button type="submit">🔍</button>
      </form>
    </div>

    <!-- Menu principal -->
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
      <li><a href="/receitasretro/paginas/login.php">Login</a></li>
      <li><a href="/receitasretro/paginas/cadastro.php">Cadastrar</a></li>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
      <link rel="stylesheet" href="css/header.css">

      <?php if (isset($_SESSION['usuario_id'])): ?>
        <li><a href="/receitasretro/index.php">Sair</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
<!-- FIM DO CABEÇALHO -->