<div class="row">
    <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">
                    <i class="mdi mdi-tag"></i>
                </span>
            </div>
            <input 
                type="text" 
                class="form-control" 
                name="nome" 
                id="nome"
                placeholder="Digite o nome da medida"
                value="<?php echo old('nome', esc($medida->nome)); ?>">
        </div>
    </div>

    <div class="form-group col-md-2 d-flex align-items-center mt-3">
        <div class="form-check form-check-flat form-check-primary mt-4">
            <label for="ativo" class="form-check-label">
                <input type="hidden" name="ativo" value="0">
                <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1"
                    <?php if (old('ativo', $medida->ativo)): ?> checked <?php endif; ?>>
                Ativo
            </label>
        </div>
    </div>

<div class="form-group col-md-12">
    <label for="descricao">Descrição</label>
    <div class="input-group">
        <input 
            type="text" 
            class="form-control" 
            name="descricao" 
            id="descricao" 
            placeholder="Digite a descrição do medida" 
            value="<?php echo old('descricao', esc($medida->descricao)); ?>">
    </div>
</div>
 
</div>

    <button type="submit" class="btn btn-primary btn-sm mr-2">
        <i class="mdi mdi-content-save"></i> Salvar
    </button>

