<form id="form-filters" class="mb-4">
  <div class="row g-2">
    <div class="col-md-3">
      <input type="text" class="form-control" name="commodities" placeholder="Commodities">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="discounts" placeholder="Discounts">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="ages" placeholder="Ages">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="cep" placeholder="CEP">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="city" placeholder="City">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="neighborhood" placeholder="Neighborhood">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="state" placeholder="State">
    </div>
    <div class="col-md-3">
      <input type="text" class="form-control" name="country" placeholder="Country">
    </div>
    <div class="col-md-3">
      <select class="form-select" name="order_by">
        <option value="name">Nome</option>
        <option value="grade">Nota</option>
        <option value="faves">Favoritos</option>
        <option value="visits">Visitas</option>
      </select>
    </div>
    <div class="col-md-3">
      <select class="form-select" name="order_dir">
        <option value="asc">Ascendente</option>
        <option value="desc">Descendente</option>
      </select>
    </div>
    <div class="col-md-3">
      <input type="number" class="form-control" name="per_page" placeholder="Resultados por página" value="10">
    </div>
    <div class="col-md-3">
      <input type="number" class="form-control" name="page" placeholder="Página" value="0">
    </div>
    <div class="col-md-12">
      <button type="submit" class="btn btn-primary form-control">Procurar</button>
    </div>
  </div>
</form>

<div id="results"></div>

<script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
<script src="<?php echo BASE_URL ?>/apikey.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/localizator.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/apiGetPlay.js"></script>