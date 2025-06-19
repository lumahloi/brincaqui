<header class="mb-5 d-flex align-items-center justify-content-end ps-4 pe-4 mt-3">
  <a href="/" class="text-center <?php echo (isset($isAuthenticated) && $isAuthenticated && $headerType) ? 'ps-5' : ''; ?>"><img src="<?php echo BASE_URL; ?>/img/logo.png" id="logo-header" alt="BrincAqui"></a>
  
  <?php if ((isset($isAuthenticated) && $isAuthenticated) && $headerType): ?>
    <div class="d-flex gap-3">
      <i class="bi bi-bell-fill fs-5"></i>
      <i class="bi bi-gear-fill fs-5"></i>
    </div>
  <?php endif; ?>
</header>