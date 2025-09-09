<?= $this->extend('Admin/layout/principal'); ?>

<?= $this->section('titulo'); ?>
PDV - Ponto de Venda
<?= $this->endSection(); ?>

<?= $this->section('estilos'); ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --ifood-red: #ea1d2c;
        --ifood-red-dark: #c01622;
        --ifood-gray: #4d4d4d;
        --ifood-light-gray: #f7f7f7;
        --ifood-border-color: #e0e0e0;
    }
    body {
        background-color: var(--ifood-light-gray);
        font-family: 'Roboto', sans-serif;
    }
    .ifood-bg-red { background-color: var(--ifood-red); }
    .ifood-text-red { color: var(--ifood-red); }
    .btn-ifood {
        background-color: var(--ifood-red);
        color: white;
        border: none;
        transition: background-color 0.2s;
    }
    .btn-ifood:hover {
        background-color: var(--ifood-red-dark);
        color: white;
    }
    .pdv-sidebar {
        background-color: #fff;
        box-shadow: 0 0 25px rgba(0,0,0,0.05);
        border-radius: 12px;
        position: sticky;
        top: 2rem;
        align-self: flex-start;
        max-height: calc(95vh - 4rem);
    }
    .pdv-sidebar-body {
        flex-grow: 1;
        overflow-y: auto;
        padding-right: 10px;
        margin-right: -10px;
    }
    .pdv-sidebar-body::-webkit-scrollbar { width: 8px; }
    .pdv-sidebar-body::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .pdv-sidebar-body::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    .pdv-sidebar-body::-webkit-scrollbar-thumb:hover { background: #aaa; }
    .product-card-ifood {
        border: 1px solid var(--ifood-border-color);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        height: 100%;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .product-card-ifood:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .product-card-ifood .card-img-top { height: 100px; object-fit: cover; }
    .product-card-ifood .card-body { padding: 0.75rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .product-name-clamp {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 2.5em;
        line-height: 1.25em;
    }
    .pdv-cart-list { list-style: none; padding: 0; }
    .pdv-cart-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .pdv-cart-item:last-child { border-bottom: none; }
    .pdv-cart-item-info { flex-grow: 1; margin-right: 10px; }
    .pdv-cart-item-actions {
        flex-shrink: 0;
        display: flex;
        align-items: center;
    }
    .pdv-main-content {
        max-height: 90vh; 
        overflow-y: auto; 
    }
    .pdv-main-content::-webkit-scrollbar { width: 8px; }
    .pdv-main-content::-webkit-scrollbar-track { background: transparent; }
    .pdv-main-content::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
    .pdv-main-content::-webkit-scrollbar-thumb:hover { background: #aaa; }
    .input-group.input-search-cliente,
    .search-input-group {
        border: 1px solid var(--ifood-border-color);
        border-radius: 8px;
        overflow: hidden;
        background-color: #fff;
    }
    .input-group.input-search-cliente .form-control { border: none; cursor: pointer; }
    .search-input-group .form-control { border: none; }
    .search-input-group .input-group-text { background-color: #fff; border: none; }
    .ifood-title {
        color: var(--ifood-red);
        font-weight: 700;
        font-size: 1.5rem;
    }
    .section-title {
        color: var(--ifood-gray);
        font-weight: 500;
        border-bottom: 2px solid var(--ifood-red);
        display: inline-block;
        padding-bottom: 5px;
    }
    .status-option {
        border: 2px solid var(--ifood-border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    .status-option:hover {
        border-color: #d1d1d1;
        background-color: #fcfcfc;
    }
    .status-option.selected {
        border-color: var(--ifood-red);
        background-color: #fff8f8;
        box-shadow: 0 0 0 2px rgba(234, 29, 44, 0.1);
    }
    .status-option input[type="radio"] { display: none; }
    .status-option.selected .form-check-label {
        color: var(--ifood-red);
        font-weight: bold;
    }
    .status-option.selected .form-check-label .bi { transform: scale(1.1); }
    .pos-venda-icon { font-size: 4rem; color: #198754; }
    .modal-produto-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .modal-produto-header img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
    }
    .modal-produto-header h4 { margin: 0; font-weight: 700; color: var(--ifood-gray); }
    .modal-section-title {
        font-weight: 500;
        color: var(--ifood-gray);
        margin-bottom: 1rem;
        font-size: 1.1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    .option-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.8rem 1rem;
        border: 2px solid var(--ifood-border-color);
        border-radius: 8px;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }
    .option-card:hover { border-color: #d1d1d1; background-color: #fcfcfc; }
    .option-card.selected {
        border-color: var(--ifood-red);
        background-color: #fff8f8;
        box-shadow: 0 0 0 2px rgba(234, 29, 44, 0.1);
    }
    .option-card .form-check-input { display: none; }
    .option-card .option-info { font-weight: 500; }
    .option-card.selected .option-info { font-weight: 700; color: var(--ifood-red); }
    .option-card .option-price { font-weight: bold; }
    .modal-footer.action-bar {
        background-color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-top: 1px solid var(--ifood-border-color);
    }
    .quantity-selector { display: flex; align-items: center; gap: 0.75rem; }
    .quantity-selector .btn { width: 38px; height: 38px; border-radius: 50%; font-size: 1.2rem; padding: 0; }
    .quantity-selector .quantity { font-size: 1.2rem; font-weight: bold; }
    .action-bar .btn-add-to-cart { flex-grow: 1; margin-left: 1rem; }
    
    @media (min-width: 1200px) { .row.row-cols-lg-5 > * { flex: 0 0 auto; width: 20%; } }
    @media (min-width: 1400px) { .row.row-cols-xxl-6 > * { flex: 0 0 auto; width: 16.66666667%; } }
</style>
<?= $this->endSection(); ?>

<?= $this->section('conteudo'); ?>
<div class="container-fluid">
    <div class="row">

        <div class="col-xl-4 col-lg-5 pdv-sidebar p-4 d-flex flex-column">
            <div>
                <div class="d-flex align-items-center mb-4">
                    <svg width="40" height="40" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="45" fill="var(--ifood-red)" /><text x="50%" y="58%" text-anchor="middle" font-family="Roboto, sans-serif" font-size="55" fill="#fff" font-weight="700" dy=".3em">P</text></svg>
                    <h5 class="mb-0 ifood-title ms-3">Ponto de Venda</h5>
                </div>
                <hr class="mt-0">
                <div class="mb-4">
                    <label for="cliente" class="form-label fw-bold">Cliente</label>
                    <div class="input-group input-search-cliente">
                        <input type="text" id="cliente" class="form-control" placeholder="Clique para selecionar ou cadastrar" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="consumidor-final-btn" title="Consumidor Final"><i class="bi bi-person-fill-gear"></i></button>
                    </div>
                    </div>
                <div class="mb-4">
                    <label for="observacoes" class="form-label fw-bold">Observações do Pedido</label>
                    <textarea id="observacoes" class="form-control" rows="3" placeholder="Ex: Sem cebola, com mais queijo..."></textarea>
                </div>
            </div>

            <div class="pdv-sidebar-body">
                <h5 class="section-title mb-3">Itens do Pedido</h5>
                <ul class="pdv-cart-list" id="cart-items">
                    <li class="text-center text-muted">O carrinho está vazio.</li>
                </ul>
            </div>

            <div class="mt-auto">
                <hr>
                <div class="mb-3">
                    <div class="d-flex justify-content-between"><span class="fw-bold">Total de Itens:</span><span id="total-itens" class="fw-bold">0</span></div>
                    <div class="d-flex justify-content-between fw-bold mt-2"><span class="fs-4">Total:</span><span id="cart-total" class="ifood-text-red fs-4">R$ 0,00</span></div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-lg btn-ifood" id="checkout-btn" disabled><i class="bi bi-cash me-2"></i> Finalizar Venda (F10)</button>
                    <button class="btn btn-outline-danger" id="cancel-btn"><i class="bi bi-x-circle me-2"></i> Cancelar Pedido</button>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 p-4 pdv-main-content">
            <div class="d-flex justify-content-between align-items-center mb-4 sticky-top  pt-2 pb-2" style="top: -25px; z-index: 10; background-color: #F3F3F3;">
                <h2 class="mb-0 text-secondary">Cardápio</h2>
                <div class="input-group w-50 search-input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="search-products" placeholder="Buscar produtos...">
                </div>
            </div>

            <div class="product-grid">
                <?php if (empty($categorias)): ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">Nenhum produto encontrado.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <div class="col-12 mt-4 mb-3" data-category-title>
                            <h4 class="section-title"><?= esc($categoria->nome) ?></h4>
                        </div>
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 row-cols-xxl-6 g-3" data-category-container>
                            <?php foreach ($categoria->produtos as $produto): ?>
                                <div class="col product-col">
                                    <div class="card product-card-ifood shadow-sm text-center" data-id="<?= $produto->id ?>">
                                        <?php if ($produto->imagem): ?>
                                            <img src="<?= site_url("admin/produtos/imagem/$produto->imagem") ?>" class="card-img-top" alt="<?= esc($produto->nome); ?>">
                                        <?php else: ?>
                                            <img src="<?= site_url('assets/admin/images/sem-imagem.jpg'); ?>" class="card-img-top" alt="Produto sem imagem">
                                        <?php endif; ?>
                                        <div class="card-body">
                                            <h6 class="card-title mb-1 fw-bold product-name-clamp" title="<?= esc($produto->nome) ?>"><?= esc($produto->nome) ?></h6>
                                            <?php if ($produto->preco_minimo !== null): ?>
                                                <p class="card-text ifood-text-red fw-bold mb-0 mt-auto">R$ <?= number_format($produto->preco_minimo, 2, ',', '.') ?></p>
                                            <?php else: ?>
                                                <p class="card-text text-muted fw-bold mb-0 mt-auto">Consultar</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProduto" tabindex="-1" aria-labelledby="modalProdutoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ifood-bg-red text-white">
                <h5 class="modal-title" id="modalProdutoLabel"><i class="bi bi-card-list me-2"></i> Detalhes do Produto</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="modal-produto-header">
                    <img id="modal-produto-imagem" src="" class="img-fluid" alt="Imagem do Produto">
                    <div>
                        <h4 id="modal-produto-nome"></h4>
                        <p id="modal-produto-ingredientes" class="text-muted small mb-0"></p>
                    </div>
                </div>
                <div id="modal-especificacoes" class="mb-4 d-none"></div>
                <div id="modal-extras" class="mb-4 d-none"></div>
            </div>
            <div class="modal-footer action-bar">
                <div class="quantity-selector">
                    <button class="btn btn-outline-secondary" id="btn-quantidade-menos">-</button>
                    <span id="quantidade-produto" class="quantity">1</span>
                    <button class="btn btn-outline-secondary" id="btn-quantidade-mais">+</button>
                </div>
                <button type="button" class="btn btn-ifood btn-lg btn-add-to-cart" id="btn-adicionar-carrinho">
                    <span>Adicionar</span>
                    <span id="modal-total" class="ms-2">R$ 0,00</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalStatusVenda" tabindex="-1" aria-labelledby="modalStatusVendaLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ifood-bg-red text-white">
                <h5 class="modal-title" id="modalStatusVendaLabel"><i class="bi bi-check-circle-fill me-2"></i> Confirmar e Definir Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light" role="alert">
                    <div class="d-flex justify-content-between">
                        <strong><i class="bi bi-person-circle me-2"></i>Cliente:</strong>
                        <span id="modal-status-cliente">Consumidor Final</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between">
                        <strong class="fs-5"><i class="bi bi-tags-fill me-2"></i>Valor Total:</strong>
                        <strong id="modal-status-total" class="fs-5 ifood-text-red">R$ 0,00</strong>
                    </div>
                </div>
                
                <h6 class="mt-4 mb-3">Selecione o Status do Pedido:</h6>
                
                <div class="status-option selected">
                    <input class="form-check-input" type="radio" name="status-pedido" id="status-finalizado" value="finalizado" checked>
                    <label class="form-check-label w-100" for="status-finalizado">
                        <i class="bi bi-bag-check-fill me-2"></i> Finalizado (Venda Balcão, Entregue)
                    </label>
                </div>
                <div class="status-option">
                    <input class="form-check-input" type="radio" name="status-pedido" id="status-preparando" value="preparando">
                    <label class="form-check-label w-100" for="status-preparando">
                        <i class="bi bi-egg-fried me-2"></i> Em Preparação
                    </label>
                </div>
                <div class="status-option">
                    <input class="form-check-input" type="radio" name="status-pedido" id="status-pendente" value="pendente">
                    <label class="form-check-label w-100" for="status-pendente">
                        <i class="bi bi-clock-history me-2"></i> Pendente (Aguardando pagamento/retirada)
                    </label>
                </div>
            </div>
            <div class="modal-footer d-grid gap-2">
                <button type="button" class="btn btn-lg btn-ifood" id="btn-confirmar-venda">
                    <i class="bi bi-cart-check me-2"></i> Confirmar Venda
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="posVendaModal" tabindex="-1" aria-labelledby="posVendaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header ifood-bg-red text-white">
                <h5 class="modal-title" id="posVendaModalLabel">Venda Finalizada com Sucesso!</h5>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="pos-venda-icon mb-3">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <h4>Excelente!</h4>
                <p class="text-muted">O que deseja fazer a seguir?</p>
                <input type="hidden" id="pedidoIdInput">
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
                <button type="button" class="btn btn-outline-secondary" id="nova-venda-btn" data-bs-dismiss="modal">Nova Venda</button>
                <button type="button" id="imprimirReciboBtn" class="btn btn-primary"><i class="bi bi-printer me-2"></i> Imprimir Recibo</button>
                <button type="button" id="enviarEmailBtn" class="btn btn-info text-white"><i class="bi bi-envelope-check me-2"></i> Enviar por E-mail</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="modalClienteLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header ifood-bg-red text-white">
                <h5 class="modal-title" id="modalClienteLabel"><i class="bi bi-person-plus-fill me-2"></i> Gerenciar Cliente</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="clienteTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="buscar-tab" data-bs-toggle="tab" data-bs-target="#buscar-cliente-pane" type="button" role="tab" aria-controls="buscar-cliente-pane" aria-selected="true">Buscar Cliente</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="cadastrar-tab" data-bs-toggle="tab" data-bs-target="#cadastrar-cliente-pane" type="button" role="tab" aria-controls="cadastrar-cliente-pane" aria-selected="false">Cadastrar Novo</button>
                    </li>
                </ul>
                <div class="tab-content" id="clienteTabContent">
                    <div class="tab-pane fade show active p-3" id="buscar-cliente-pane" role="tabpanel" aria-labelledby="buscar-tab" tabindex="0">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="search-cliente-modal" placeholder="Buscar por nome ou CPF...">
                        </div>
                        <div id="lista-clientes-modal" class="list-group" style="max-height: 300px; overflow-y: auto;">
                            <p class="text-muted text-center mt-3">Digite para buscar um cliente.</p>
                        </div>
                    </div>
                    <div class="tab-pane fade p-3" id="cadastrar-cliente-pane" role="tabpanel" aria-labelledby="cadastrar-tab" tabindex="0">
                        <form id="form-novo-cliente">
                            <div id="cadastro-cliente-errors" class="alert alert-danger d-none"></div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="novo-cliente-nome" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control" id="novo-cliente-nome" name="nome" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="novo-cliente-cpf" class="form-label">CPF</label>
                                    <input type="text" class="form-control" id="novo-cliente-cpf" name="cpf">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="novo-cliente-email" class="form-label">E-mail (para envio de recibo)</label>
                                    <input type="email" class="form-control" id="novo-cliente-email" name="email">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="novo-cliente-telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control" id="novo-cliente-telefone" name="telefone">
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-ifood" id="btn-salvar-cliente">
                                    <i class="bi bi-check-lg me-2"></i> Salvar e Selecionar Cliente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // =================================================================
    // ELEMENTOS DO DOM
    // =================================================================
    const productGrid = document.querySelector('.product-grid');
    const cartItemsList = document.querySelector('#cart-items');
    const cartTotalElement = document.querySelector('#cart-total');
    const totalItensElement = document.querySelector('#total-itens');
    const checkoutBtn = document.querySelector('#checkout-btn');
    const clienteInput = document.querySelector('#cliente');
    const consumidorFinalBtn = document.querySelector('#consumidor-final-btn');
    const cancelBtn = document.querySelector('#cancel-btn');
    const observacoesInput = document.querySelector('#observacoes');
    const searchProductsInput = document.getElementById('search-products');
    const modalProdutoEl = document.getElementById('modalProduto');
    const modalStatusVendaEl = document.getElementById('modalStatusVenda');

    // Modais
    const modalProduto = new bootstrap.Modal(modalProdutoEl);
    const posVendaModal = new bootstrap.Modal(document.getElementById('posVendaModal'));
    const modalStatusVenda = new bootstrap.Modal(modalStatusVendaEl);
    const modalCliente = new bootstrap.Modal(document.getElementById('modalCliente'));

    // Elementos do Modal de Produto
    const modalProdutoNome = document.getElementById('modal-produto-nome');
    const modalProdutoImagem = document.getElementById('modal-produto-imagem');
    const modalProdutoIngredientes = document.getElementById('modal-produto-ingredientes');
    const modalEspecificacoesContainer = document.getElementById('modal-especificacoes');
    const modalExtrasContainer = document.getElementById('modal-extras');
    const quantidadeProdutoSpan = document.getElementById('quantidade-produto');
    const btnQuantidadeMenos = document.getElementById('btn-quantidade-menos');
    const btnQuantidadeMais = document.getElementById('btn-quantidade-mais');
    const modalTotalSpan = document.getElementById('modal-total');
    const btnAdicionarCarrinho = document.getElementById('btn-adicionar-carrinho');
    
    // Elementos dos Modais de Venda
    const pedidoIdInput = document.getElementById('pedidoIdInput');
    const imprimirReciboBtn = document.getElementById('imprimirReciboBtn');
    const enviarEmailBtn = document.getElementById('enviarEmailBtn');
    const btnConfirmarVenda = document.getElementById('btn-confirmar-venda');
    const novaVendaBtn = document.getElementById('nova-venda-btn');

    // Elementos do Modal de Cliente
    const searchClienteModalInput = document.getElementById('search-cliente-modal');
    const listaClientesModal = document.getElementById('lista-clientes-modal');
    const formNovoCliente = document.getElementById('form-novo-cliente');
    const btnSalvarCliente = document.getElementById('btn-salvar-cliente');
    const cadastroClienteErrors = document.getElementById('cadastro-cliente-errors');
    let clienteSearchTimeout;

    // Variáveis de estado
    let cart = {};
    let total = 0;
    let clienteSelecionado = null;
    let produtoModal = {};

    // Dados do backend
    const allEspecifacoes = <?= json_encode($especificacoes ?? []) ?>;
    const allExtras = <?= json_encode($extras ?? []) ?>;
    const allProdutos = <?= json_encode($produtos ?? []) ?>;

    const formatCurrency = (value) => `R$ ${parseFloat(value).toFixed(2).replace('.', ',')}`;
    
    // =================================================================
    // LÓGICA DO MODAL DE CLIENTE (BUSCA E CADASTRO)
    // =================================================================
    
    function abrirModalCliente() {
        cadastroClienteErrors.classList.add('d-none');
        formNovoCliente.reset();
        listaClientesModal.innerHTML = '<p class="text-muted text-center mt-3">Digite para buscar um cliente.</p>';
        searchClienteModalInput.value = '';
        modalCliente.show();
    }
    
    document.getElementById('modalCliente').addEventListener('shown.bs.modal', () => {
        searchClienteModalInput.focus();
    });

    function selecionarCliente(cliente) {
        clienteSelecionado = cliente;
        clienteInput.value = cliente.nome;
        modalCliente.hide();
    }

    clienteInput.addEventListener('click', abrirModalCliente);

    searchClienteModalInput.addEventListener('keyup', function () {
        const termo = this.value.trim();
        if (termo.length < 2) {
            listaClientesModal.innerHTML = '<p class="text-muted text-center mt-3">Digite ao menos 2 caracteres.</p>';
            return;
        }
        clearTimeout(clienteSearchTimeout);
        clienteSearchTimeout = setTimeout(() => {

            // @ALTERADO: A requisição foi ajustada para enviar JSON.
            fetch('<?= site_url('admin/pdv/buscarusuarios') ?>', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    "X-Requested-With": "XMLHttpRequest" 
                },
                body: JSON.stringify({ termo: termo }) // Envia o termo dentro de um objeto JSON
            })
            .then(res => res.json())
            .then(data => {
                listaClientesModal.innerHTML = '';
                if (data.length > 0) {
                    data.forEach(user => {
                        const a = document.createElement('a');
                        a.href = '#';
                        a.className = 'list-group-item list-group-item-action';
                        a.innerHTML = `<strong>${user.nome}</strong><br><small class="text-muted">CPF: ${user.cpf || 'Não informado'}</small>`;
                        a.addEventListener('click', e => {
                            e.preventDefault();
                            selecionarCliente(user);
                        });
                        listaClientesModal.appendChild(a);
                    });
                } else {
                    listaClientesModal.innerHTML = '<p class="text-muted text-center mt-3">Nenhum cliente encontrado.</p>';
                }
            })
            .catch(err => {
                console.error("Erro ao buscar clientes:", err);
                listaClientesModal.innerHTML = '<p class="text-danger text-center mt-3">Erro de comunicação. Tente novamente.</p>';
            });

        }, 300);
    });

    formNovoCliente.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        btnSalvarCliente.disabled = true;
        btnSalvarCliente.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Salvando...';
        
        fetch('<?= site_url('admin/pdv/cadastrarcliente') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', "X-Requested-With": "XMLHttpRequest" },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                selecionarCliente(res.cliente);
            } else {
                let errorMessages = '<ul>';
                for (const field in res.errors) {
                    errorMessages += `<li>${res.errors[field]}</li>`;
                }
                errorMessages += '</ul>';
                cadastroClienteErrors.innerHTML = errorMessages;
                cadastroClienteErrors.classList.remove('d-none');
            }
        })
        .catch(err => {
            cadastroClienteErrors.innerHTML = 'Ocorreu um erro de comunicação. Tente novamente.';
            cadastroClienteErrors.classList.remove('d-none');
        })
        .finally(() => {
            btnSalvarCliente.disabled = false;
            btnSalvarCliente.innerHTML = '<i class="bi bi-check-lg me-2"></i> Salvar e Selecionar Cliente';
        });
    });

    consumidorFinalBtn.addEventListener('click', (e) => {
        e.preventDefault();
        selecionarCliente({id: '0', nome: 'Consumidor Final', email: null});
    });

    // =================================================================
    // LÓGICA DO PRODUTO E CARRINHO (CÓDIGO ORIGINAL, SEM ALTERAÇÕES)
    // =================================================================

    function updateModalTotal() {
        let precoBase = 0;
        const especificacaoSelecionada = modalEspecificacoesContainer.querySelector('.option-card.selected');
        
        if (especificacaoSelecionada) {
            precoBase = parseFloat(especificacaoSelecionada.dataset.preco);
        } else if (produtoModal.preco_minimo) {
            precoBase = parseFloat(produtoModal.preco_minimo);
        }

        modalExtrasContainer.querySelectorAll('.option-card.selected').forEach(card => {
            precoBase += parseFloat(card.dataset.preco);
        });

        const quantidade = parseInt(quantidadeProdutoSpan.textContent);
        modalTotalSpan.textContent = formatCurrency(precoBase * quantidade);
    }
    
    function handleOptionClick(e) {
        const card = e.target.closest('.option-card');
        if (!card) return;
        const input = card.querySelector('.form-check-input');
        
        if (input.type === 'radio') {
            const container = card.parentElement;
            container.querySelectorAll('.option-card').forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            input.checked = true;
            
            const customizavel = card.dataset.customizavel == '1';
            const produtoExtras = allExtras.filter(ex => ex.produto_id == produtoModal.id);

            if (produtoExtras.length > 0) {
                if (customizavel) {
                    modalExtrasContainer.classList.remove('d-none');
                } else {
                    modalExtrasContainer.classList.add('d-none');
                    modalExtrasContainer.querySelectorAll('.option-card.selected').forEach(c => c.classList.remove('selected'));
                    modalExtrasContainer.querySelectorAll('input[type="checkbox"]').forEach(i => i.checked = false);
                }
            }
        } else if (input.type === 'checkbox') {
            card.classList.toggle('selected');
            input.checked = !input.checked;
        }

        updateModalTotal();
    }

    productGrid.addEventListener('click', function (e) {
        const target = e.target.closest('.product-card-ifood');
        if (!target) return;

        const produtoId = target.dataset.id;
        produtoModal = allProdutos.find(p => p.id == produtoId);
        if (!produtoModal) {
            alert('Erro ao carregar detalhes do produto.');
            return;
        }

        const produtoEspecifacoes = allEspecifacoes.filter(e => e.produto_id == produtoId);
        const produtoExtras = allExtras.filter(e => e.produto_id == produtoId);

        modalProdutoNome.textContent = produtoModal.nome;
        modalProdutoIngredientes.innerHTML = produtoModal.ingredientes || '';
        modalProdutoImagem.src = produtoModal.imagem ? `<?= site_url("admin/produtos/imagem/") ?>${produtoModal.imagem}` : `<?= site_url('assets/admin/images/sem-imagem.jpg'); ?>`;
        quantidadeProdutoSpan.textContent = '1';

        modalEspecificacoesContainer.innerHTML = '';
        modalEspecificacoesContainer.classList.add('d-none');
        let temCustomizavelInicial = false;

        if (produtoEspecifacoes.length > 0) {
            let html = '<h6 class="modal-section-title">Escolha o tamanho</h6>';
            produtoEspecifacoes.forEach((espec, index) => {
                const isSelected = index === 0 ? 'selected' : '';
                const isChecked = index === 0 ? 'checked' : '';
                if (isSelected) {
                    temCustomizavelInicial = espec.customizavel == '1';
                }
                html += `<div class="option-card ${isSelected}" data-preco="${espec.preco}" data-nome="${espec.medida}" data-id="${espec.id}" data-customizavel="${espec.customizavel}"><input class="form-check-input" type="radio" name="especificacao" id="espec-${espec.id}" value="${espec.id}" ${isChecked}><span class="option-info">${espec.medida}</span><span class="option-price">${formatCurrency(espec.preco)}</span></div>`;
            });
            modalEspecificacoesContainer.innerHTML = html;
            modalEspecificacoesContainer.classList.remove('d-none');
        }

        modalExtrasContainer.innerHTML = '';
        modalExtrasContainer.classList.add('d-none');
        if (produtoExtras.length > 0) {
            let html = '<h6 class="modal-section-title">Deseja adicionais?</h6>';
            produtoExtras.forEach(extra => {
                html += `<div class="option-card" data-preco="${extra.preco}" data-nome="${extra.nome}" data-id="${extra.id}"><input class="form-check-input" type="checkbox" id="extra-${extra.id}"><span class="option-info">${extra.nome}</span><span class="option-price">+ ${formatCurrency(extra.preco)}</span></div>`;
            });
            modalExtrasContainer.innerHTML = html;
            if (produtoEspecifacoes.length === 0 || temCustomizavelInicial) {
                modalExtrasContainer.classList.remove('d-none');
            }
        }

        updateModalTotal();
        modalProduto.show();
    });
    
    modalProdutoEl.addEventListener('click', handleOptionClick);

    btnAdicionarCarrinho.addEventListener('click', function () {
        const especificacaoCard = modalEspecificacoesContainer.querySelector('.option-card.selected');
        const extrasCards = Array.from(modalExtrasContainer.querySelectorAll('.option-card.selected'));
        
        if (modalEspecificacoesContainer.querySelectorAll('.option-card').length > 0 && !especificacaoCard) {
            alert('Por favor, selecione um tamanho/especificação.'); return;
        }

        const itemUnico = {
            id: produtoModal.id,
            nome: produtoModal.nome,
            preco_minimo: produtoModal.preco_minimo,
            quantidade: parseInt(quantidadeProdutoSpan.textContent),
            especificacao: especificacaoCard ? { id: especificacaoCard.dataset.id, nome: especificacaoCard.dataset.nome, preco: parseFloat(especificacaoCard.dataset.preco) } : null,
            extras: extrasCards.map(card => ({ id: card.dataset.id, nome: card.dataset.nome, preco: parseFloat(card.dataset.preco) })).sort((a,b) => a.id - b.id)
        };
        
        const key = JSON.stringify({ id: itemUnico.id, esp_id: itemUnico.especificacao?.id, ext_ids: itemUnico.extras?.map(e => e.id) });
        cart[key] ? cart[key].quantidade += itemUnico.quantidade : cart[key] = itemUnico;
        
        updateCart();
        modalProduto.hide();
    });
    
    btnQuantidadeMenos.addEventListener('click', () => { if(parseInt(quantidadeProdutoSpan.textContent) > 1) { quantidadeProdutoSpan.textContent--; updateModalTotal(); } });
    btnQuantidadeMais.addEventListener('click', () => { quantidadeProdutoSpan.textContent++; updateModalTotal(); });

    function updateCart() {
        cartItemsList.innerHTML = '';
        total = 0;
        let totalItemsCount = 0;
        if (Object.keys(cart).length === 0) {
            cartItemsList.innerHTML = '<li class="text-center text-muted mt-3">O carrinho está vazio.</li>';
            checkoutBtn.disabled = true;
        } else {
            for (const key in cart) {
                const item = cart[key];
                let precoItem = 0;
                let descricaoExtra = '';
                if (item.especificacao) {
                    precoItem += parseFloat(item.especificacao.preco);
                    descricaoExtra += ` (${item.especificacao.nome})`;
                } else if (item.preco_minimo) {
                    precoItem += parseFloat(item.preco_minimo);
                }
                if (item.extras && item.extras.length > 0) {
                    item.extras.forEach(extra => {
                        precoItem += parseFloat(extra.preco);
                        descricaoExtra += ` + ${extra.nome}`;
                    });
                }
                const subtotalItem = precoItem * item.quantidade;
                const li = document.createElement('li');
                li.className = 'pdv-cart-item';
                li.innerHTML = `<div class="pdv-cart-item-info"><span class="fw-bold">${item.nome}</span><br><small class="text-muted">${descricaoExtra.trim()} (${formatCurrency(precoItem)} x ${item.quantidade})</small></div><div class="pdv-cart-item-actions"><span class="fw-bold ifood-text-red me-3">${formatCurrency(subtotalItem)}</span><button class="btn btn-sm btn-outline-danger btn-remove-item" data-key='${key}'><i class="bi bi-x"></i></button></div>`;
                cartItemsList.appendChild(li);
                total += subtotalItem;
                totalItemsCount += item.quantidade;
            }
            checkoutBtn.disabled = false;
        }
        cartTotalElement.textContent = formatCurrency(total);
        totalItensElement.textContent = `${totalItemsCount}`;
    }

    cartItemsList.addEventListener('click', (e) => { 
        const removeButton = e.target.closest('.btn-remove-item');
        if(removeButton) { 
            const key = removeButton.dataset.key;
            delete cart[key]; 
            updateCart(); 
        } 
    });

    searchProductsInput.addEventListener('keyup', function () {
        const termo = this.value.toLowerCase().trim();
        document.querySelectorAll('.product-col').forEach(col => {
            const cardTitle = col.querySelector('.card-title').textContent.toLowerCase();
            col.style.display = cardTitle.includes(termo) ? '' : 'none';
        });
        document.querySelectorAll('[data-category-container]').forEach(container => {
            const produtosVisiveis = Array.from(container.children).some(col => col.style.display !== 'none');
            const titulo = container.previousElementSibling;
            if (titulo && titulo.hasAttribute('data-category-title')) {
                titulo.style.display = produtosVisiveis ? '' : 'none';
            }
        });
    });
    
    function prepararFinalizacao() {
        if (checkoutBtn.disabled) { return; }
        if (clienteSelecionado === null) {
            selecionarCliente({ id: '0', nome: 'Consumidor Final', email: null });
            modalCliente.hide();
        }
        document.getElementById('modal-status-cliente').textContent = clienteSelecionado.nome;
        document.getElementById('modal-status-total').textContent = formatCurrency(total);
        modalStatusVenda.show();
    }

    modalStatusVendaEl.addEventListener('click', function(e) {
        const statusOption = e.target.closest('.status-option');
        if (!statusOption) return;
        this.querySelectorAll('.status-option').forEach(opt => opt.classList.remove('selected'));
        statusOption.classList.add('selected');
        statusOption.querySelector('input[type="radio"]').checked = true;
    });

    function initializeStatusOptions() {
        modalStatusVendaEl.querySelectorAll('.status-option').forEach(opt => opt.classList.remove('selected'));
        const firstOption = modalStatusVendaEl.querySelector('.status-option');
        if (firstOption) {
            firstOption.classList.add('selected');
            firstOption.querySelector('input[type="radio"]').checked = true;
        }
    }
    
    function resetarPedido() {
        cart = {};
        clienteSelecionado = null;
        clienteInput.value = '';
        observacoesInput.value = '';
        updateCart();
        initializeStatusOptions();
    }

    btnConfirmarVenda.addEventListener('click', function() {
        const statusSelecionado = document.querySelector('input[name="status-pedido"]:checked').value;
        if (!statusSelecionado) { alert('Por favor, selecione um status para o pedido.'); return; }
        
        const itens = Object.values(cart).map(item => {
            let precoUnitario = 0;
            let nomeFinal = item.nome;
            if (item.especificacao) {
                precoUnitario += parseFloat(item.especificacao.preco);
                nomeFinal += ` (${item.especificacao.nome})`;
            } else if (item.preco_minimo) {
                precoUnitario += parseFloat(item.preco_minimo);
            }
            if (item.extras?.length > 0) {
                item.extras.forEach(extra => {
                    precoUnitario += parseFloat(extra.preco);
                    nomeFinal += ` + ${extra.nome}`;
                });
            }
            return { produto_id: item.id, nome: nomeFinal.trim(), quantidade: item.quantidade, preco_unitario: precoUnitario };
        });
        
        const data = {
            usuario_id: clienteSelecionado.id,
            valor_total: total,
            itens: itens,
            observacoes: observacoesInput.value,
            status: statusSelecionado
        };
        
        btnConfirmarVenda.disabled = true;
        btnConfirmarVenda.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Salvando...';
        
        fetch('<?= site_url('admin/pdv/salvarvenda') ?>', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: JSON.stringify(data) })
        .then(response => response.json())
        .then(res => {
            if (res.pedido_id) {
                pedidoIdInput.value = res.pedido_id;
                modalStatusVenda.hide();
                posVendaModal.show();
            } else { alert('Erro ao finalizar a venda: ' + (res.messages?.error || 'Erro desconhecido.')); }
        })
        .catch(error => { console.error('Erro na requisição:', error); alert('Ocorreu um erro de comunicação ao salvar a venda.'); })
        .finally(() => { btnConfirmarVenda.disabled = false; btnConfirmarVenda.innerHTML = '<i class="bi bi-cart-check me-2"></i> Confirmar Venda'; });
    });

    checkoutBtn.addEventListener('click', prepararFinalizacao);
    document.addEventListener('keydown', (e) => { if (e.key === 'F10') { e.preventDefault(); prepararFinalizacao(); } });
    
    cancelBtn.addEventListener('click', () => { if (confirm('Tem certeza que deseja cancelar e limpar o pedido atual?')) { resetarPedido(); } });
    
    novaVendaBtn.addEventListener('click', resetarPedido);
    
    imprimirReciboBtn.addEventListener('click', () => window.open(`<?= site_url('admin/pedidos/imprimir/') ?>${pedidoIdInput.value}`, '_blank'));
    
    enviarEmailBtn.addEventListener('click', function () {
        if (!clienteSelecionado || clienteSelecionado.id === '0' || !clienteSelecionado.email) {
            alert('Não é possível enviar e-mail. Cliente é "Consumidor Final" ou não possui e-mail cadastrado.'); 
            return;
        }
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Enviando...';

        fetch(`<?= site_url('admin/pedidos/enviar_email/') ?>${pedidoIdInput.value}`, { method: 'POST', headers: {'X-Requested-With': 'XMLHttpRequest'} })
            .then(res => res.json()).then(res => alert(res.message || res.error))
            .catch(err => alert('Erro ao enviar e-mail.'))
            .finally(() => {
                this.disabled = false;
                this.innerHTML = '<i class="bi bi-envelope-check me-2"></i> Enviar por E-mail';
                posVendaModal.hide();
                resetarPedido();
            });
    });
    
    document.getElementById('posVendaModal').addEventListener('hidden.bs.modal', event => {
        resetarPedido();
    });

    // Inicializações
    updateCart();
    initializeStatusOptions();
});
</script>
<?= $this->endSection(); ?>