<div class="row">

    <div class="form-group col-md-5">
        <label for="nome">Nome do Bairro</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-city"></i>
                </span>
            </div>
            <input 
                type="text" 
                class="form-control" 
                name="nome" 
                id="nome"
                placeholder="Digite o nome do bairro"
                value="<?= old('nome', esc($bairro->nome)); ?>">
        </div>
    </div>

    <div class="form-group col-md-4">
        <label for="valor_entrega">Valor de Entrega</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-cash-multiple"></i> </span>
            </div>
            <input 
                type="text" 
                class="form-control" 
                name="valor_entrega" 
                id="valor_entrega"
                placeholder="Ex: 10.50"
                value="<?= old('valor_entrega', esc($bairro->valor_entrega)); ?>">
        </div>
    </div>

    <div class="form-group col-md-3 d-flex align-items-end">
        <div class="form-check form-check-flat form-check-primary">
            <label for="ativo" class="form-check-label">
                <input type="hidden" name="ativo" value="0">
                <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1"
                    <?= old('ativo', $bairro->ativo) ? 'checked' : ''; ?>>
                Ativo
            </label>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary btn-sm mr-2">
    <i class="mdi mdi-content-save"></i> Salvar
</button>