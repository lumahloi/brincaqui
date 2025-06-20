<header class="mb-5 d-flex align-items-center <?php echo ($isAuthenticated == 1 && $headerType) ? 'justify-content-end' : 'justify-content-center'; ?> ps-4 pe-4 mt-3">
  <a href="/" class="text-center <?php echo ($isAuthenticated == 1 && $headerType) ? 'pe-5' : ''; ?>"><img src="<?php echo BASE_URL; ?>/img/logo.png" alt="BrincAqui" style="max-width: 150px;"></a>
  
  <?php if ($isAuthenticated == 1 && $headerType): ?>
    <div class="d-flex gap-3">
      <i class="bi bi-bell-fill fs-5"></i>
      <i class="bi bi-gear-fill fs-5" style="cursor:pointer;" onclick="window.location.href='/configuracao'"></i>
    </div>
  <?php endif; ?>
</header>