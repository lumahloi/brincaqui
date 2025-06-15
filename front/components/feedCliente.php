<form id="form-filters" class="mb-4">
  <div class="row g-2">
    <div class="col-md-3">
      <input type="text" class="form-control" name="commodities" placeholder="Comodidades">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="discounts" placeholder="Descontos">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="ages" placeholder="Idades">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="address" id="address-input" placeholder="Digite um endereço">
      <small class="text-muted">O sistema buscará brinquedos próximos a este local</small>
    </div>
    <input type="hidden" id="latitude" name="latitude">
    <input type="hidden" id="longitude" name="longitude">
    
    <div class="col-md-3">
      <select class="form-select" name="order_by">
        <option value="distance">Distância</option>
        <option value="name">Nome</option>
        <option value="grade">Nota</option>
        <option value="faves">Favoritos</option>
        <option value="visits">Visitas</option>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" name="order_dir">
        <option value="asc">Mais próximo</option>
        <option value="desc">Mais distante</option>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" name="radius">
        <option value="5">Até 5 km</option>
        <option value="10" selected>Até 10 km</option>
        <option value="20">Até 20 km</option>
        <option value="50">Até 50 km</option>
      </select>
    </div>
    <div class="col-md-3">
      <button type="submit" class="btn btn-primary form-control">Buscar Lugares</button>
    </div>
  </div>
</form>

<div id="results"></div>

<script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/localizator.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/apiGetPlay.js"></script>