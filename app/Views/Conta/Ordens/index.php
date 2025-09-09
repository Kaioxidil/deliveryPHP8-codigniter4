<?= $this->extend('layout/principalView') ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?= $this->section('conteudo') ?>

<style>
    /* Estilos do menu lateral */
    .menu-lateral .list-group-item {
        border: none;
        border-left: 4px solid transparent;
        border-radius: 0;
        padding: 15px 20px;
        font-weight: 500;
        color: #555;
    }
    .menu-lateral .list-group-item:hover,
    .menu-lateral .list-group-item:focus {
        background-color: #e9ecef;
        color: #000;
    }
    .menu-lateral .list-group-item.active {
        border-left: 4px solid #EA1D2C;
        background-color: #f7f7f7;
        font-weight: 700;
        color: #EA1D2C;
    }
    .menu-lateral .list-group-item i {
        margin-right: 12px;
        width: 20px;
    }

    /* Lista de Pedidos */
    .lista-pedidos {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .pedido-card {
        display: flex;
        align-items: center;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.25rem;
        transition: box-shadow 0.2s ease-in-out;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
    }
    .pedido-card:hover {
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    }

    .pedido-card .card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        background-color: #f7f7f7;
        border-radius: 50%;
        margin-right: 1rem;
        font-size: 1.5rem;
        color: #555;
        flex-shrink: 0; /* Impede que o ícone encolha */
    }

    .pedido-card .card-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .card-content .content-header {
        font-size: 0.9rem;
        color: #777;
    }

    .card-content .pedido-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }
    .pedido-status i {
        font-size: 1.2rem;
    }

    .icon-success { color: #28a745; }
    .icon-primary { color: #007bff; }
    .icon-info { color: #17a2b8; }
    .icon-warning { color: #ffc107; }
    .icon-danger { color: #dc3545; }
    .icon-secondary { color: #6c757d; }

    .card-content .pedido-valor {
        font-size: 0.95rem;
        color: #555;
    }

    .pedido-card .card-action .btn-detalhes {
        background: none;
        border: none;
        color: #EA1D2C;
        font-size: 1.8rem;
        padding: 0 0.5rem;
        flex-shrink: 0; /* Impede que o botão encolha */
    }

    /* Modal de Detalhes */
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    .modal-body .detalhe-secao {
        padding-bottom: 1rem;
        margin-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }
    .modal-body .detalhe-secao:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }
    .lista-itens-pedido .list-group-item {
        border: none;
        padding-left: 0;
        padding-right: 0;
    }

    /* --- Ajustes para Mobile --- */
    @media (max-width: 768px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        /* Menu lateral em telas menores */
        .col-lg-3 {
            margin-bottom: 30px; /* Espaçamento abaixo do menu lateral */
        }
        .menu-lateral {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Sombra mais sutil */
        }
        .menu-lateral .list-group-item {
            padding: 12px 15px; /* Menor padding */
            font-size: 0.95rem; /* Fonte ligeiramente menor */
        }

        /* Formulário de Busca e Filtro */
        .row.g-3.mb-4 {
            flex-direction: column; /* Colunas empilham em telas pequenas */
            gap: 10px; /* Espaçamento entre os campos */
        }
        .row.g-3.mb-4 .col-md-6,
        .row.g-3.mb-4 .col-md-4,
        .row.g-3.mb-4 .col-md-2 {
            width: 100%; /* Ocupam toda a largura */
        }

        /* Cards de Pedidos */
        .pedido-card {
            flex-direction: column; /* Ícone, conteúdo e botão empilham */
            align-items: flex-start; /* Alinha o conteúdo à esquerda */
            padding: 1rem; /* Padding ligeiramente menor */
        }
        .pedido-card .card-icon {
            margin-right: 0; /* Remove margem lateral */
            margin-bottom: 0.75rem; /* Adiciona margem abaixo */
        }
        .pedido-card .card-content {
            width: 100%; /* Ocupa toda a largura disponível */
            margin-bottom: 1rem; /* Espaço antes do botão de detalhes */
        }
        .pedido-card .card-action {
            width: 100%; /* Faz o botão ocupar a largura total */
            text-align: right; /* Alinha o botão à direita */
        }
        .pedido-card .card-action .btn-detalhes {
            font-size: 1.5rem; /* Reduz ligeiramente o tamanho do ícone do botão */
            padding: 0; /* Remove padding extra */
        }

        /* Modal de Detalhes */
        .modal-dialog {
            margin: 0.5rem; /* Margem menor para o modal */
        }
        .modal-body {
            padding: 1rem; /* Menor padding no corpo do modal */
        }
        .modal-body .detalhe-secao {
            padding-bottom: 0.75rem; /* Menor padding */
            margin-bottom: 0.75rem; /* Menor margem */
        }
        .lista-itens-pedido .list-group-item {
            font-size: 0.95rem; /* Reduz o tamanho da fonte dos itens */
        }
    }
</style>

<br><br><br>

<?php
function formatarStatus($status)
{
    $statusMap = [
        'pendente'          => ['texto' => 'Aguardando confirmação', 'icone' => 'bi-hourglass-split', 'icone_classe' => 'icon-warning'],
        'em_preparacao'     => ['texto' => 'Pedido em preparo', 'icone' => 'bi-gear-fill', 'icone_classe' => 'icon-primary'],
        'saiu_para_entrega' => ['texto' => 'Pedido a caminho', 'icone' => 'bi-truck', 'icone_classe' => 'icon-info'],
        'entregue'          => ['texto' => 'Pedido entregue', 'icone' => 'bi-check-circle-fill', 'icone_classe' => 'icon-success'],
        'cancelado'         => ['texto' => 'Pedido cancelado', 'icone' => 'bi-x-circle-fill', 'icone_classe' => 'icon-danger'],
    ];
    return $statusMap[$status] ?? [
        'texto' => ucwords(str_replace('_', ' ', $status)),
        'icone' => 'bi-question-circle-fill',
        'icone_classe' => 'icon-secondary'
    ];
}
?>

<div class="container mt-5 mb-5" style="min-height: 400px;">
    <div class="row">
        <div class="col-lg-3">
            <div class="menu-lateral bg-white rounded shadow-sm">
                <div class="list-group list-group-flush">
                    <a href="<?= site_url('conta') ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-person-circle"></i> Meu Perfil
                    </a>
                    <a href="<?= site_url('conta/pedidos') ?>" class="list-group-item list-group-item-action active">
                        <i class="bi bi-box-seam"></i> Meus Pedidos
                    </a>
                    <a href="<?= site_url('conta/enderecos') ?>" class="list-group-item list-group-item-action">
                        <i class="bi bi-geo-alt"></i> Meus Endereços
                    </a>
                    <a href="<?= site_url('login/logout') ?>" class="list-group-item list-group-item-action text-danger">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
           <h2 class="mb-4"><?= esc($titulo) ?></h2>

            <form method="get" class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text" name="busca" value="<?= esc($busca ?? '') ?>" class="form-control" placeholder="Buscar por código do pedido...">

                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <option value="pendente" <?= ($status ?? '') === 'pendente' ? 'selected' : '' ?>>Pendente</option>
                        <option value="em_preparacao" <?= ($status ?? '') === 'em_preparacao' ? 'selected' : '' ?>>Em preparo</option>
                        <option value="saiu_para_entrega" <?= ($status ?? '') === 'saiu_para_entrega' ? 'selected' : '' ?>>A caminho</option>
                        <option value="entregue" <?= ($status ?? '') === 'entregue' ? 'selected' : '' ?>>Entregue</option>
                        <option value="cancelado" <?= ($status ?? '') === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-danger w-100" type="submit">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                </div>
            </form>

            <?php if (empty($pedidos)): ?>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle-fill"></i> Você ainda não realizou nenhum pedido. Que tal começar agora?
                </div>
            <?php else: ?>
                <div class="lista-pedidos">
                    <?php foreach ($pedidos as $pedido): ?>
                        <?php $statusFormatado = formatarStatus($pedido->status); ?>
                        
                        <div class="pedido-card">
                            <div class="card-icon"><i class="bi bi-receipt"></i></div>
                            <div class="card-content">
                                <span class="content-header">Pedido #<?= esc($pedido->id) ?></span>
                                <div class="pedido-status">
                                    <i class="<?= $statusFormatado['icone'] ?> <?= $statusFormatado['icone_classe'] ?>"></i>
                                    <strong><?= $statusFormatado['texto'] ?></strong>
                                </div>
                                <span class="pedido-valor">
                                    <?= $pedido->criado_em->toLocalizedString('dd MMMM, yyyy') ?> • R$ <?= number_format($pedido->valor_total, 2, ',', '.') ?>
                                </span>
                            </div>
                            <div class="card-action">
                                <button type="button" class="btn-detalhes btn-ver-detalhes"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#pedidoModal"
                                        data-pedido-id="<?= $pedido->id ?>">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pedidoModalLabel">Detalhes do Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body" id="modal-conteudo"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<br><br><br>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('.btn-ver-detalhes').on('click', function() {
        const pedidoId = $(this).data('pedido-id');
        $('#pedidoModalLabel').text('Detalhes do Pedido #' + pedidoId);
        
        const loaderHtml = `<div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Carregando...</span>
                                </div>
                            </div>`;
        $('#modal-conteudo').html(loaderHtml);

        $.ajax({
            url: '<?= site_url('conta/pedidos/detalhes/') ?>' + pedidoId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const dataPedido = new Date(response.pedido.criado_em.date).toLocaleDateString('pt-BR', {
                    year: 'numeric', month: 'long', day: 'numeric'
                });

                let itensHtml = '';
                response.itens.forEach(function(item) {
                    const totalItem = parseFloat(item['preco_unitario'] * item['quantidade']).toFixed(2).replace('.', ',');
                    
                    // Lógica para extras
                    let extrasHtml = '';
                    if (item.extras && item.extras.length > 0) {
                        item.extras.forEach(function(extra) {
                            extrasHtml += `<p class="text-muted mb-0 small">+ ${extra.quantidade}x ${extra.nome}</p>`;
                        });
                    }

                    // Lógica para observações
                    let observacaoHtml = '';
                    if (item.observacoes) {
                        observacaoHtml = `<p class="text-info mb-0 small">Obs: ${item.observacoes}</p>`;
                    }

                    itensHtml += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                ${item['quantidade']}x <strong>${item['produto_nome']}</strong>
                                <small class="text-muted d-block">${item['medida_nome'] || ''}</small>
                                ${extrasHtml}
                                ${observacaoHtml}
                            </div>
                            <span class="fw-bold">R$ ${totalItem}</span>
                        </li>`;
                });

                let entregadorHtml = '';
                if (response.pedido.entregador_nome) {
                    entregadorHtml = `
                        <div class="detalhe-secao">
                            <h6 class="text-muted"><i class="bi bi-person-badge me-2"></i>ENTREGADOR</h6>
                            <strong>${response.pedido.entregador_nome}</strong>
                        </div>`;
                }

                // LÓGICA DE ENDEREÇO ATUALIZADA
                let enderecoHtml = '';
                if (response.pedido.logradouro) {
                    const rua = response.pedido.logradouro;
                    const numero = response.pedido.numero || 'S/N';
                    const bairro = response.pedido.bairro;
                    const cidade = response.pedido.cidade;
                    const estado = response.pedido.estado;
                    const referencia = response.pedido.referencia ? `<p class="text-muted mb-0 small">Referência: ${response.pedido.referencia}</p>` : '';
                    const complemento = response.pedido.complemento ? `<p class="text-muted mb-0 small">Complemento: ${response.pedido.complemento}</p>` : '';

                    enderecoHtml = `
                        <h6 class="text-muted"><i class="bi bi-geo-alt-fill me-2"></i>ENDEREÇO DE ENTREGA</h6>
                        <address class="mb-0" style="font-style: normal; line-height: 1.6;">
                            <strong>${rua}, ${numero}</strong><br>
                            ${bairro}<br>
                            ${cidade} - ${estado}<br>
                            ${referencia}
                            ${complemento}
                        </address>
                    `;
                } else {
                    enderecoHtml = `
                        <h6 class="text-muted"><i class="bi bi-geo-alt-fill me-2"></i>ENDEREÇO DE ENTREGA</h6>
                        <strong>Endereço não informado no pedido.</strong>
                    `;
                }
                
                // Montagem do corpo do Modal
                const conteudoHtml = `
                    <div class="detalhe-secao">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted"><i class="bi bi-card-checklist me-2"></i>STATUS</h6>
                                <strong>${response.pedido.status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</strong>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted"><i class="bi bi-calendar-event me-2"></i>DATA DO PEDIDO</h6>
                                <strong>${dataPedido}</strong>
                            </div>
                        </div>
                    </div>

                    ${entregadorHtml}

                    <div class="detalhe-secao">
                        <h6 class="text-muted"><i class="bi bi-basket-fill me-2"></i>ITENS DO PEDIDO</h6>
                        <ul class="list-group list-group-flush lista-itens-pedido">${itensHtml}</ul>
                    </div>

                    <div class="detalhe-secao">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <h6 class="text-muted"><i class="bi bi-credit-card me-2"></i>PAGAMENTO</h6>
                                <strong>${response.pedido.forma_pagamento}</strong>
                                <p class="text-muted small mt-1 mb-0">${response.pedido.observacoes || 'Nenhuma observação.'}</p>
                            </div>
                            <div class="col-md-6">
                                ${enderecoHtml}
                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <p class="mb-1">Subtotal: R$ ${parseFloat(response.pedido.valor_produtos).toFixed(2).replace('.', ',')}</p>
                        <p class="mb-2">Taxa de Entrega: R$ ${parseFloat(response.pedido.valor_entrega).toFixed(2).replace('.', ',')}</p>
                        <h4 class="mt-1 fw-bold">Total: R$ ${parseFloat(response.pedido.valor_total).toFixed(2).replace('.', ',')}</h4>
                    </div>
                `;
                
                $('#modal-conteudo').html(conteudoHtml);
            },
            error: function() {
                $('#modal-conteudo').html('<div class="alert alert-danger text-center">Não foi possível carregar os detalhes do pedido. Tente novamente.</div>');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>