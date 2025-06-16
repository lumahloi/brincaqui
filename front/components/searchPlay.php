<form id="form-filters">
  <div class="d-grid gap-3">
    <div class="row">
      <input type="text" class="form-control" name="address" id="address-input" placeholder="Digite um endereço">
      <small class="text-muted">Buscaremos locais próximos a este local</small>
    </div>

    <input type="text" id="latitude" name="latitude">
    <input type="text" id="longitude" name="longitude">

    <button type="button" class="toggle-filters-btn" id="adv-filter-btn">
      Mostrar filtros avançados <i class="bi bi-chevron-down"></i>
    </button>

    <div class="hidden-content">
      <div class="d-grid gap-3">
        <div class="row">
          <select class="form-select" name="order_by">
            <option value="distance">Distância</option>
            <option value="name">Nome</option>
            <option value="grade">Nota</option>
            <option value="faves">Favoritos</option>
            <option value="visits">Visitas</option>
          </select>
        </div>
        <div class="row">
          <select class="form-select" name="order_dir">
            <option value="asc">Mais próximo ou menor</option>
            <option value="desc">Mais distante ou maior</option>
          </select>
        </div>
        <div class="row">
          <select class="form-select" name="radius">
            <option value="5">Até 5 km</option>
            <option value="10" selected>Até 10 km</option>
            <option value="20">Até 20 km</option>
            <option value="50">Até 50 km</option>
          </select>
        </div>

        <div class="row">
          <div class="form-control">
            <label class="form-control-label">Idades:</label>
            <div>
              <input type="checkbox" name="ages[]" value="0-2"> 0-2 anos<br>
              <input type="checkbox" name="ages[]" value="3-5"> 3-5 anos<br>
              <input type="checkbox" name="ages[]" value="6-8"> 6-8 anos<br>
              <input type="checkbox" name="ages[]" value="9-12"> 9-12 anos<br>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-control">
            <label class="form-control-label">Comodidades:</label>
            <div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="form-control">
            <label class="form-control-label">Descontos:</label>
            <div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary form-control">Buscar lugares</button>
  </div>
</form>

<!-- <script src="<?php echo BASE_URL ?>/scripts/localizator.js"></script> -->
<script src="<?php echo BASE_URL ?>/scripts/toggleHiddenContent.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/getCommodities.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/getDiscounts.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/getComNameByPlay.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/apiGetPlay.js"></script>