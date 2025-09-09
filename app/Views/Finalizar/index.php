<?= $this->extend('layout/principal') ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="container mt-5 mb-5">
    
    <h2 class="text-center mb-4"><?= esc($titulo) ?></h2>

    <?php if (empty($carrinho)): ?>
        
        <div class="text-center">
            <div class="alert alert-info col-md-6 mx-auto" role="alert">
                <i class="fas fa-shopping-cart me-2"></i> Seu carrinho de compras está vazio.
            </div>
            <a href="<?= site_url('/') ?>" class="btn btn-primary">Voltar para o início</a>
        </div>

    <?php else: ?>

        <div class="row">
            <div class="col-lg-7">

                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title d-flex align-items-center mb-0">
                            <i class="fas fa-map-marker-alt me-3 text-primary"></i>
                            Endereço de Entrega
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="endereco_id" class="form-label">Selecione um endereço salvo</label>
                            <select class="form-control" name="endereco_id" id="endereco_id" required>
                                <option></option>
                                <?php foreach ($enderecos as $endereco): ?>
                                    <option
                                        value="<?= esc($endereco->id) ?>"
                                        data-bairro-id="<?= esc($endereco->bairro_id) ?>" >
                                        <?= esc($endereco->logradouro) ?>, <?= esc($endereco->numero) ?> - <?= esc($endereco->bairro_nome) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title d-flex align-items-center mb-0">
                            <i class="fas fa-credit-card me-3 text-primary"></i>
                            Pagamento
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="forma_pagamento_id" class="form-label">Escolha a forma de pagamento</label>
                            <select class="form-control" name="forma_pagamento_id" id="forma_pagamento_id" required>
                                <option></option>
                                <?php foreach ($formas_pagamento as $forma): ?>
                                    <option value="<?= esc($forma->id) ?>"><?= esc($forma->nome) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mt-3" id="campo-observacoes" style="display: none;">
                            <label for="observacoes" class="form-label">Precisa de troco?</label>
                            <textarea class="form-control" name="observacoes" id="observacoes" rows="2" placeholder="Ex: Troco para R$ 100,00"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-5">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header">
                        <h5 class="card-title d-flex align-items-center mb-0">
                            <i class="fas fa-receipt me-3 text-primary"></i>
                            Resumo do Pedido
                        </h5>
                    </div>
                    <div class="card-body">
                        
                        <?= form_open(site_url('finalizar/enviar')) ?>
                            
                            <input type="hidden" name="endereco_id" id="endereco_id_hidden">
                            <input type="hidden" name="forma_pagamento_id" id="forma_pagamento_id_hidden">
                            <input type="hidden" name="observacoes" id="observacoes_hidden">

                            <ul class="list-group list-group-flush">
                                <?php foreach ($carrinho as $item): ?>
                                    <li class="list-group-item px-0">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="fw-bold"><?= esc($item['produto']->nome) ?></span>
                                                <small class="d-block text-muted">Quantidade: <?= esc($item['quantidade']) ?></small>
                                                <?php if (!empty($item['customizacao'])): ?>
                                                    <small class="d-block text-danger">Obs: <?= esc($item['customizacao']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-nowrap">R$ <?= number_format($item['preco_total_item'], 2, ',', '.') ?></span>
                                        </div>
                                    </li>
                                <?php endforeach; ?>

                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <span>R$ <?= number_format($subtotal, 2, ',', '.') ?></span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between">
                                    <span>Taxa de Entrega</span>
                                    <span id="taxa-entrega-valor">Aguardando endereço...</span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between fw-bold fs-5">
                                    <strong>Total</strong>
                                    <strong id="total-final-valor">R$ <?= number_format($total, 2, ',', '.') ?></strong>
                                </li>
                            </ul>

                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" id="btn-finalizar" class="btn btn-success btn-lg">
                                    Finalizar Pedido
                                </button>
                            </div>

                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    
    // --- Inicialização dos Selects ---
    $('#endereco_id').select2({
        placeholder: "Selecione seu endereço",
        allowClear: true,
        width: '100%'
    });
    
    $('#forma_pagamento_id').select2({
        placeholder: "Selecione a forma de pagamento",
        allowClear: true,
        width: '100%'
    });

    // --- Lógica para o campo de Troco ---
    $('#forma_pagamento_id').on('change', function() {
        const textoSelecionado = $(this).find('option:selected').text().toLowerCase();
        $('#campo-observacoes').toggle(textoSelecionado.includes('dinheiro'));
    });
    
    // --- Dados dos Bairros (Vem do Controller PHP) ---
    const bairrosData = {
        <?php foreach($bairros as $bairro): ?>
            "<?= esc($bairro->id) ?>": "<?= esc($bairro->valor_entrega) ?>",
        <?php endforeach; ?>
    };

    const subtotal = parseFloat('<?= $subtotal; ?>');

    // --- Função para formatar valores em moeda BR ---
    function formatarMoeda(valor) {
        return valor.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    // --- Lógica principal para cálculo do total ---
    $('#endereco_id').on('change', function() {
        const option = $(this).find('option:selected');
        const bairroId = option.data('bairro-id');
        let taxaEntrega = 0;

        if (bairroId && bairrosData[bairroId] !== undefined) {
            taxaEntrega = parseFloat(bairrosData[bairroId]);
            $('#taxa-entrega-valor').text(formatarMoeda(taxaEntrega));
        } else {
            $('#taxa-entrega-valor').text('Aguardando endereço...');
        }
        
        const novoTotal = subtotal + taxaEntrega;
        $('#total-final-valor').text(formatarMoeda(novoTotal));
    });

    // --- Sincronizar os valores dos selects para o formulário de envio ---
    $('form').submit(function() {
        // Pega os valores dos selects visíveis e coloca nos inputs hidden dentro do form
        $('#endereco_id_hidden').val($('#endereco_id').val());
        $('#forma_pagamento_id_hidden').val($('#forma_pagamento_id').val());
        $('#observacoes_hidden').val($('#observacoes').val());

        // Desabilita o botão para evitar múltiplos cliques
        $('#btn-finalizar').prop('disabled', true).text('Enviando...');
    });
});
</script>
<?= $this->endSection() ?>