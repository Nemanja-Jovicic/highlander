<?php
$navigation = getMenu();
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="<?= $navigation['home'] ?>$">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <!-- deo za admina -->
         <?php
          foreach($navigation['pages'] as $page):?>
        <li class="nav-item">
          <a class="nav-link active" href="<?= $page->path?>"><?=$page->name?></a>
        </li>
        <?php endforeach;?>

      </ul>
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <?php if (!isset($_SESSION['user'])): ?>
          <li class="nav-item"><a href="index.php?page=prijava" class="nav-link <?= isset($_GET['page']) && $_GET['page'] === 'prijava' ? 'active border-bottom' : '' ?>">Prijava</a></li>
          <li class="nav-item"><a href="index.php?page=registracija" class="nav-link <?= isset($_GET['page']) && $_GET['page'] === 'registracija' ? 'active border-bottom' : ''  ?>">Registracija</a></li>
        <?php else: ?>
          <li class="nav-item"><a href="models/auth/logout.php" class="nav-link">Odjava</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>