<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?>
<?= esc($titulo) ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<style>
/* Estilos Gerais do Produto */
.produto-detalhes-img {
    width: 100%;
    border-radius: 16px;
    object-fit: cover;
    max-height: 500px;
}
.produto-info h2 {
    font-weight: bold;
    color: #333;
}
.produto-preco {
    font-size: 2.2rem;
    font-weight: bold;
    color: #28a745;
    margin-top: 10px;
}
.produto-descricao {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
}

/* Estilos de Botões e Acordeão */
.accordion-button:not(.collapsed) {
    color: #dc3545;
    font-weight: bold;
}
.accordion-button {
    font-size: 1.1rem;
    font-weight: bold;
}
.btn-adicionar {
    background-color: #3c6303;
    color: #fff;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1.1rem;
    width: 100%;
    margin-top: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}
.btn-adicionar:hover {
    background-color: #2e4d02;
}

/* Estilos para o Controle de Quantidade Principal */
.qtd-control {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 1rem;
    margin-bottom: 1rem;
}
.qtd-btn {
    width: 40px;
    height: 40px;
    border: 1px solid #ddd;
    border-radius: 50%;
    background-color: #fff;
    font-size: 1.5rem;
    font-weight: 300;
    color: #555;
    cursor: pointer;
    transition: background-color 0.3s;
}
.qtd-btn:hover {
    background-color: #f0f0f0;
}
.qtd-display {
    min-width: 40px;
    text-align: center;
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0 15px;
}

/* Estilos para a Seção de Especificações */
.form-check {
    padding-left: 2.5em;
    margin-bottom: 1rem;
}
.form-check-input[type="radio"] {
    display: none;
}
.form-check-label {
    position: relative;
    cursor: pointer;
    padding-left: 10px;
}
.form-check-label::before {
    content: '';
    position: absolute;
    left: -2em;
    top: 50%;
    transform: translateY(-50%);
    width: 1.2em;
    height: 1.2em;
    border-radius: 50%;
    border: 2px solid #ccc;
    background-color: #fff;
}
.form-check-input[type="radio"]:checked + .form-check-label::before {
    border-color: #28a745;
    background-color: #28a745;
}
.form-check-input[type="radio"]:checked + .form-check-label::after {
    content: '';
    position: absolute;
    left: -1.3em;
    top: 50%;
    transform: translateY(-50%);
    width: 0.6em;
    height: 0.6em;
    border-radius: 50%;
    background-color: #fff;
}

/* Estilos para os Extras e Customização (Cartões e Botões) */
.extra-card, .customizacao-card {
    background-color: #f9f9f9;
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: border-color 0.3s;
}
.extra-card:has(input[type="checkbox"]:checked) {
    border-color: #28a745;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.2);
}
.customizacao-card {
    flex-direction: column;
    align-items: flex-start;
}
.customizacao-card .form-label {
    margin-bottom: 10px;
    font-weight: bold;
    color: #333;
}
.customizacao-card .form-control {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    font-size: 0.95rem;
    resize: vertical;
}
.customizacao-card .form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.extra-info {
    display: flex;
    align-items: center;
}
.extra-info input[type="checkbox"] {
    display: none;
}
.extra-label {
    position: relative;
    cursor: pointer;
    padding-left: 30px;
    font-weight: bold;
    color: #333;
}
.extra-label::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    border: 2px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
}
.extra-info input[type="checkbox"]:checked + .extra-label::before {
    background-color: #28a745;
    border-color: #28a745;
}
.extra-info input[type="checkbox"]:checked + .extra-label::after {
    content: '\2713'; /* Símbolo de check */
    position: absolute;
    left: 3px;
    top: 50%;
    transform: translateY(-50%);
    color: #fff;
    font-size: 1.2em;
}

.extra-price {
    font-weight: normal;
    color: #555;
    margin-left: 10px;
}

.extra-qtd-control {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
.extra-qtd-control .qtd-btn {
    width: 30px;
    height: 30px;
    font-size: 1.2rem;
}
.extra-qtd-control .qtd-display {
    min-width: 30px;
    font-size: 1.2rem;
}

/* Media Queries para Responsividade */
@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }
    .col-lg-6 {
        width: 100%;
    }
    .produto-detalhes-img {
        max-height: 300px;
        margin-bottom: 1.5rem;
    }
    .back-btn {
        top: 20px;
        left: 20px;
    }
    .tag-share {
        top: 20px;
        right: 20px;
    }
    .page-banner {
        height: auto;
    }
    .section-padding {
        padding: 1.5rem 0;
    }
    .container {
        padding: 0 1rem;
    }
    .qtd-control {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<br><br><br>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="<?= $produto->imagem ? site_url('home/imagemProduto/' . $produto->imagem) : site_url('admin/images/sem-imagem.jpg') ?>" 
                    alt="<?= esc($produto->nome) ?>" 
                    class="produto-detalhes-img">
            </div>
           <div class="col-lg-6 produto-info">
                <form id="form-adicionar" action="<?= site_url('carrinho/adicionar') ?>" method="post">
                    <?= csrf_field() ?>

                    <h2><?= esc($produto->nome) ?></h2>
                    <hr>
                    <p class="produto-descricao"><strong>Descrição:</strong> <?= esc($produto->descricao) ?></p>
                    <hr>

                    <?php if (isset($produto->preco)): ?>
                        <p class="produto-preco" id="preco-base" data-preco-base="<?= $produto->preco ?>">R$ <?= number_format($produto->preco ?? 0, 2, ',', '.') ?></p>
                    <?php endif; ?>

                    <hr>

                    <div class="accordion mt-4" id="accordionDetalhes">

                        <?php if (!empty($especificacoes)): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEspecificacoes">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEspecificacoes" aria-expanded="false" aria-controls="collapseEspecificacoes">
                                        Escolha o Tamanho
                                    </button>
                                </h2>
                                <div id="collapseEspecificacoes" class="accordion-collapse collapse" aria-labelledby="headingEspecificacoes" data-bs-parent="#accordionDetalhes">
                                    <div class="accordion-body" id="form-especificacoes">
                                        <?php foreach ($especificacoes as $i => $esp): ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" 
                                                    name="especificacao_id" 
                                                    id="esp<?= $esp->id ?>" 
                                                    value="<?= $esp->id ?>" 
                                                    data-preco="<?= $esp->preco ?>"
                                                    data-customizavel="<?= $esp->customizavel ?>" <?= ($i === 0 ? 'checked' : '') ?>>
                                                <label class="form-check-label" for="esp<?= $esp->id ?>">
                                                    <?= esc($esp->descricao) ?> — R$ <?= number_format($esp->preco, 2, ',', '.') ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->ingredientes)): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingIngredientes">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIngredientes" aria-expanded="false" aria-controls="collapseIngredientes">
                                        Ingredientes
                                    </button>
                                </h2>
                                <div id="collapseIngredientes" class="accordion-collapse collapse" aria-labelledby="headingIngredientes" data-bs-parent="#accordionDetalhes">
                                    <div class="accordion-body">
                                        <?= $produto->ingredientes ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($extras)): ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingExtras">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtras" aria-expanded="false" aria-controls="collapseExtras">
                                        Adicionar Extras
                                    </button>
                                </h2>
                                <div id="collapseExtras" class="accordion-collapse collapse" aria-labelledby="headingExtras" data-bs-parent="#accordionDetalhes">
                                    <div class="accordion-body" id="form-extras">
                                        <?php foreach ($extras as $extra): ?>
                                            <div class="extra-card">
                                                <div class="extra-info">
                                                    <input type="checkbox" name="extras[<?= $extra->id ?>]" id="extra-<?= $extra->id ?>" value="<?= $extra->id ?>" data-preco="<?= $extra->preco ?>">
                                                    <label class="extra-label" for="extra-<?= $extra->id ?>">
                                                        <?= esc($extra->nome) ?> <span class="extra-price">— R$ <?= number_format($extra->preco, 2, ',', '.') ?></span>
                                                    </label>
                                                </div>
                                                <div class="extra-qtd-control">
                                                    <button class="qtd-btn" type="button" onclick="alterarExtraQtd(this, -1)">-</button>
                                                    <span class="qtd-display" id="extra-qtd-<?= $extra->id ?>">0</span>
                                                    <button class="qtd-btn" type="button" onclick="alterarExtraQtd(this, 1)">+</button>
                                                </div>
                                                <input type="hidden" name="extras_quantidade[<?= $extra->id ?>]" id="extra-quantidade-<?= $extra->id ?>" value="0">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div id="div-customizacao" style="display: none;">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCustomizacao">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomizacao" aria-expanded="false" aria-controls="collapseCustomizacao">
                                        Observações
                                    </button>
                                </h2>
                                <div id="collapseCustomizacao" class="accordion-collapse collapse" aria-labelledby="headingCustomizacao" data-bs-parent="#accordionDetalhes">
                                    <div class="accordion-body">
                                        <textarea name="customizacao" class="form-control" id="customizacao" rows="3" style="height: 100px; resize: none;" placeholder="Ex: Metade Calabresa, Metade Quatro Queijos"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div> <hr>
                    <input type="hidden" name="produto_id" value="<?= esc($produto->id) ?>">

                    <div class="qtd-control">
                        <button class="qtd-btn" type="button" onclick="alterarQtd(-1)">-</button>
                        <span class="qtd-display" id="qtd">1</span>
                        <button class="qtd-btn" type="button" onclick="alterarQtd(1)">+</button>
                    </div>
                    <input type="hidden" name="quantidade_produto" id="quantidade_produto_input" value="1">
                    
                    <button class="btn-adicionar" type="submit">
                        Adicionar • <span id="preco-final">R$ <?= number_format($produto->preco ?? 0, 2, ',', '.') ?></span>
                    </button>
                </form>
                
                </div>
            </div>
        </div>

        <?php if (!empty($produto->categoria)): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-3">Categoria: <?= esc($produto->categoria) ?></h3>
                    <p>Veja mais produtos semelhantes em nossa <a href="<?= site_url('/Vizualizar#category-' . $produto->categoria_id) ?>" class="text-danger">página de categorias</a>.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
    /**
     * Altera a quantidade principal do produto.
     * @param {number} change - O valor a ser adicionado ou subtraído (1 ou -1).
     */
    function alterarQtd(change) {
        const qtdDisplay = document.getElementById('qtd');
        // Lê a quantidade atual diretamente da tela, garantindo que temos o valor real
        let qtdAtual = parseInt(qtdDisplay.innerText, 10);
        
        qtdAtual += change;
        
        // Garante que a quantidade nunca seja menor que 1
        if (qtdAtual < 1) {
            qtdAtual = 1;
        }
        
        qtdDisplay.innerText = qtdAtual;
        document.getElementById('quantidade_produto_input').value = qtdAtual;
        
        atualizarPreco();
    }

    /**
     * Altera a quantidade de um item extra.
     * @param {HTMLElement} button - O botão clicado (+ ou -).
     * @param {number} change - O valor a ser alterado (1 ou -1).
     */
    function alterarExtraQtd(button, change) {
        const extraCard = button.closest('.extra-card');
        const extraCheckbox = extraCard.querySelector('input[type="checkbox"]');
        const extraQtdDisplay = extraCard.querySelector('.qtd-display');
        const extraQtdInputHidden = extraCard.querySelector('input[type="hidden"]');

        let extraQtd = parseInt(extraQtdDisplay.innerText, 10) || 0;
        extraQtd += change;
        if (extraQtd < 0) {
            extraQtd = 0;
        }

        extraQtdDisplay.innerText = extraQtd;
        extraQtdInputHidden.value = extraQtd;
        extraCheckbox.checked = extraQtd > 0;
        
        atualizarPreco();
    }

    /**
     * Recalcula e atualiza todos os preços na tela com base nas seleções do usuário.
     */
    function atualizarPreco() {
        // Lê o preço base de um atributo 'data-preco-base'
        const precoBaseEl = document.getElementById('preco-base');
        const precoBase = parseFloat(precoBaseEl.getAttribute('data-preco-base')) || 0;

        // Calcula o preço com base na especificação selecionada
        let precoEspecificacao = 0;
        const espRadio = document.querySelector('input[name="especificacao_id"]:checked');
        if (espRadio) {
            precoEspecificacao = parseFloat(espRadio.getAttribute('data-preco')) || 0;
        }

        // O preço exibido será o da especificação, ou o base se nenhuma for escolhida
        const precoDisplay = precoEspecificacao > 0 ? precoEspecificacao : precoBase;
        precoBaseEl.innerText = 'R$ ' + precoDisplay.toFixed(2).replace('.', ',');

        // Lógica de customização
        const divCustomizacao = document.getElementById('div-customizacao');
        if (divCustomizacao) {
            const inputCustomizacao = document.getElementById('customizacao');
            if (espRadio && espRadio.getAttribute('data-customizavel') == '1') {
                divCustomizacao.style.display = 'block';
            } else {
                divCustomizacao.style.display = 'none';
                if (inputCustomizacao) inputCustomizacao.value = '';
            }
        }

        // Calcula o preço total de um item, incluindo os extras
        let precoTotalItem = precoDisplay;
        const extrasSelecionados = document.querySelectorAll('#form-extras input[type="checkbox"]:checked');
        extrasSelecionados.forEach(extra => {
            const precoExtra = parseFloat(extra.getAttribute('data-preco')) || 0;
            const extraQtd = parseInt(document.getElementById(`extra-quantidade-${extra.value}`).value, 10) || 0;
            precoTotalItem += precoExtra * extraQtd;
        });
        
        // Lê a quantidade principal direto da tela para o cálculo final
        const qtdFinal = parseInt(document.getElementById('qtd').innerText, 10) || 1;
        const precoFinalBotao = precoTotalItem * qtdFinal;

        document.getElementById('preco-final').innerText = 'R$ ' + precoFinalBotao.toFixed(2).replace('.', ',');
    }

    /**
     * Adiciona os "escutadores" de eventos quando a página termina de carregar.
     */
    document.addEventListener('DOMContentLoaded', () => {
        // Escutadores de eventos para mudanças nos formulários
        const formEspecificacoes = document.getElementById('form-especificacoes');
        if (formEspecificacoes) {
            formEspecificacoes.addEventListener('change', atualizarPreco);
        }
        
        const formExtras = document.getElementById('form-extras');
        if (formExtras) {
            formExtras.addEventListener('change', atualizarPreco);
        }
        
        // Garante que o valor inicial da quantidade seja 1
        document.getElementById('quantidade_produto_input').value = 1;
        document.getElementById('qtd').innerText = 1;

        // Chama a função uma vez para garantir que os preços sejam exibidos corretamente
        atualizarPreco();
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $this->endSection(); ?>