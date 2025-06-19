<?php date_default_timezone_set('America/Sao_Paulo'); ?>

<form id="form-filters">
  <div class="d-grid gap-3">
    <div class="col">
      <input type="text" class="form-control" name="address" id="address-input" placeholder="Digite um endereço">
      <small class="text-muted">Buscaremos lugares próximos a este</small>
    </div>

    <div class="col">
      <input type="date" class="form-control" name="date" id="date-input" value="<?= date('Y-m-d') ?>">
      <small class="text-muted">Data que você deseja ir</small>
    </div>

    <div class="col">
      <input type="time" class="form-control" name="time" id="time-input" value="<?= date('H:i') ?>">
      <small class="text-muted">Horário que você deseja ir</small>
    </div>


    <input type="text" id="latitude" name="latitude">
    <input type="text" id="longitude" name="longitude">

    <button type="button" class="toggle-filters-btn text-black bg-transparent border-0 text-center" id="adv-filter-btn">
      Mostrar filtros avançados <i class="bi bi-chevron-down ms-1"></i>
    </button>

    <div class="hidden-content" style="display: none; transition: all 0.3s ease;">
      <div class="d-grid gap-3">

        <div class="col">
          <small>Classificar por</small>
          <select class="form-select mt-2" name="order_by">
            <option value="distance">Distância</option>
            <option value="grade">Nota</option>
            <option value="price">Preço</option>
            <option value="faves">Favoritos</option>
            <option value="visits">Visitas</option>
          </select>
        </div>

        <small>Ordenação por</small>
        <select class="form-select" name="order_dir">
          <option value="asc">Mais próximo ou menor</option>
          <option value="desc">Mais distante ou maior</option>
        </select>

        <small>Mostrar locais</small>
        <select class="form-select" name="radius">
          <option value="5">Até 5 km</option>
          <option value="10" selected>Até 10 km</option>
          <option value="20">Até 20 km</option>
          <option value="50">Até 50 km</option>
        </select>

        <div class="form-control">
          <label class="form-control-label mb-3">Idades:</label>
          <div>
            <input type="checkbox" name="ages[]" value="0-2"> 0-2 anos<br>
            <input type="checkbox" name="ages[]" value="3-5"> 3-5 anos<br>
            <input type="checkbox" name="ages[]" value="6-8"> 6-8 anos<br>
            <input type="checkbox" name="ages[]" value="9-12"> 9-12 anos<br>
          </div>
        </div>

        <div class="form-control">
          <label class="form-control-label mb-3">Comodidades:</label>
          <div>
          </div>
        </div>

        <div class="form-control">
          <label class="form-control-label mb-3">Descontos:</label>
          <div>
          </div>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary form-control bg-gradient-1 border-0">Buscar lugares</button>
  </div>
</form>

<script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/renderPlayCard.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/authGuard.js"></script>
<!-- <script src="<?php echo BASE_URL ?>/scripts/localizator.js"></script> -->
<script src="<?php echo BASE_URL ?>/scripts/toggleHiddenContent.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/getCommodities.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/getDiscounts.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/getComNameByPlay.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/playPagination.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/apiGetPlays.js"></script>