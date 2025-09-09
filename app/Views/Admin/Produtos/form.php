<div class="form">
    <div class="form-row">
        <!-- Nome -->
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
                    placeholder="Digite o nome do produto"
                    value="<?= old('nome', esc($produto->nome)); ?>">
            </div>
        </div>

        <!-- Categoria -->
        <div class="form-group col-md-3">
            <label for="categoria_id">Categoria</label>
            <select class="form-control" name="categoria_id" id="categoria_id" >
                <option value="">Selecione a categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria->id; ?>" <?= ($categoria->id == $produto->categoria_id ? "selected" : ""); ?>>
                        <?= esc($categoria->nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Ativo ao lado -->
        <div class="col-md-2 d-flex align-items-center mt-2">
            <div class="form-check form-check-flat form-check-primary ">
                <label for="ativo" class="form-check-label">
                    <input type="hidden" name="ativo" value="0">
                    <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1"
                        <?= old('ativo', $produto->ativo) ? 'checked' : ''; ?>>
                    Ativo
                </label>
            </div>
        </div>
    </div>

    <!-- Descrição -->
    <div class="form-group">
        <label for="descricao">Descrição</label>
        <input 
            type="text" 
            class="form-control" 
            name="descricao" 
            id="descricao" 
            placeholder="Digite a descrição do produto" 
            value="<?= old('descricao', esc($produto->descricao)); ?>">
    </div>

    <!-- Ingredientes com editor -->
    <div class="form-group">
        <label for="ingredientes">Ingredientes</label>
        <textarea 
            name="ingredientes" 
            class="form-control" 
            id="ingredientes" 
            rows="8"><?= old('ingredientes', esc($produto->ingredientes)); ?></textarea>
    </div>
</div>

<!-- Botão -->
<button type="submit" class="btn btn-primary btn-sm">
    <i class="mdi mdi-content-save"></i> Salvar
</button>

<!-- TinyMCE com sua chave API -->
<script src="https://cdn.tiny.cloud/1/9i0qciw9kbqw4dibm8qdpcj0xnvrycrg83snwur19sryo0mv/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#ingredientes',
        menubar: false,
        plugins: 'lists link',
        toolbar: 'undo redo | bold italic underline | bullist numlist | link',
        height: 300
    });
</script>
