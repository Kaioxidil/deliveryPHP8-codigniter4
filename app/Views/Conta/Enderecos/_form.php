<?php if(session()->has('errors')): ?>
    <div class="alert alert-danger">
        <?php foreach(session('errors') as $error): ?>
            <p><?php echo esc($error); ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="row">
    <div class="form-group col-md-6">
        <label for="titulo">Título (Ex: Casa)</label>
        <input type="text" class="form-control" required name="titulo" value="<?php echo old('titulo', esc($endereco->titulo)); ?>">
    </div>
    <div class="form-group col-md-6">
        <label for="cep">CEP</label>
        <input type="text" class="form-control" required name="cep" value="<?php echo old('cep', esc($endereco->cep)); ?>">
    </div>
</div>

<div class="form-group">
    <label for="logradouro">Rua / Logradouro</label>
    <input type="text" class="form-control" name="logradouro" required value="<?php echo old('logradouro', esc($endereco->logradouro)); ?>">
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="numero">Número</label>
        <input type="text" class="form-control" name="numero" required value="<?php echo old('numero', esc($endereco->numero)); ?>">
    </div>
    <div class="form-group col-md-8">
        <label for="complemento">Complemento</label>
        <input type="text" class="form-control" name="complemento" value="<?php echo old('complemento', esc($endereco->complemento)); ?>">
    </div>
</div>

<div class="row">
    <div class="form-group col-md-5">
        <label for="bairro">Bairro</label>
        <select class="form-control" name="bairro" id="bairro" required>
            <option value="">-- Selecione o bairro --</option>
            <?php foreach ($bairros as $bairro): ?>
                <option value="<?php echo esc($bairro->id); ?>"
                    <?php echo set_select('bairro', esc($bairro->id), (old('bairro', $endereco->bairro ?? '') == $bairro->id)); ?>>
                    <?php echo esc($bairro->nome); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group col-md-5">
        <label for="cidade">Cidade</label>
        <input required type="text" class="form-control" name="cidade" id="cidade" 
               value="<?php echo old('cidade', esc($endereco->cidade)); ?>">
    </div>
    <div class="form-group col-md-2">
        <label for="estado">Estado</label>
        <input required type="text" class="form-control" name="estado" id="estado" maxlength="2" 
               value="<?php echo old('estado', esc($endereco->estado)); ?>">
    </div>
</div>


<div class="form-group">
    <label for="referencia">Ponto de Referência</label>
    <textarea class="form-control" name="referencia"><?php echo old('referencia', esc($endereco->referencia)); ?></textarea>
</div>
<hr>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery e Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#bairro').select2({
        placeholder: "-- Selecione o bairro --",
        allowClear: true,
        width: '100%'
    });
});
</script>
