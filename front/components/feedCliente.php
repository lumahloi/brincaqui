<form>
  <div class="mb-3">
    <label for="form-place" class="form-label">Lugar</label>
    <input type="text" class="form-control" id="form-place" placeholder="Rua das Palmeiras">
  </div>
  <div class="mb-3">
    <button type="button" class="btn btn-primary form-control" id="form-submit">Procurar</button>
  </div>
</form>

<div id="results">

</div>

<script src="<?php echo BASE_URL ?>/scripts/errorValidation.js"></script>
<script src="<?php echo BASE_URL ?>/apikey.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/localizator.js"></script>
<script src="<?php echo BASE_URL ?>/scripts/apiGetPlay.js"></script>