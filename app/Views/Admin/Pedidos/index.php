<?= $this->extend('Admin/layout/principal'); ?>

<?= $this->section('titulo'); ?><?= $titulo; ?><?= $this->endSection(); ?>

<?= $this->section('estilos'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>
    /* Estilos gerais da página */
    .navbar { z-index: 1040 !important; }
    #toast-container { z-index: 1060 !important; }
    .modal { z-index: 1050 !important; }

    /* Estilos para a comanda de impressão */
    .cupom-impressao { 
        font-family: 'Courier New', Courier, monospace; 
        color: #000; 
        width: 300px; 
        padding: 5px; 
        margin: 0 auto; 
        display: block; 
    }
    .cupom-impressao .header { text-align: center; margin-bottom: 10px; }
    .cupom-impressao .header h5 { font-size: 16px; font-weight: bold; margin: 0; }
    .cupom-impressao .header p { font-size: 12px; margin: 2px 0; }
    .cupom-impressao .header strong { font-size: 12px; }
    .cupom-impressao .titulo-secao { 
        text-transform: uppercase; 
        font-weight: bold; 
        border-top: 1px dashed #000; 
        border-bottom: 1px dashed #000; 
        padding: 4px 0; 
        margin: 8px 0; 
        text-align: center; 
        font-size: 16px; 
    }
    .cupom-impressao .info-pedido p,
    .cupom-impressao .info-entrega p { margin: 2px 0; font-size: 18px; }
    .cupom-impressao .info-pedido strong,
    .cupom-impressao .info-entrega strong { min-width: 302px; display: inline-block; }
    .cupom-impressao .itens-lista { list-style: none; padding: 0; font-size: 16px; }
    .cupom-impressao .itens-lista li { display: flex; justify-content: space-between; margin-bottom: 3px; }
    .cupom-impressao .itens-lista .item-principal { font-weight: bold; }
    .cupom-impressao .itens-lista .extras-lista { list-style: none; padding-left: 15px; font-size: 16px; margin: 0; }
    .cupom-impressao .total-final { font-size: 16px; font-weight: bold; text-align: right; margin-top: 8px; }
    .cupom-impressao .footer { text-align: center; margin-top: 10px; font-size: 16px; }

   /* Estilos para a impressão ajustados para 80mm x 210mm */
    @media print {
        @page {
            size: 0mm 210mm; /* largura x altura */
            margin: 0;
        }

        html, body {
            width: 80mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            font-size: 16px; /* fonte maior para melhor leitura */
        }

        body * {
            visibility: hidden;
            
        }

        #modalCupom, #modalCupom * {
            visibility: visible;
        }

        #modalCupom {
            position: absolute;
            left: 0;
            top: 0;
            width: 80mm;
            height: 210mm;
            margin: 0;
            padding: 10px;
            background: white;
            overflow: visible;
            font-size: 14px;
        }

        .modal-dialog {
            max-width: 80mm !important;
            width: 80mm !important;
            margin: 0 auto !important;
        }

        .modal-content {
            border: none !important;
            box-shadow: none !important;
            padding: 0;
            margin: 0;
            width: 80mm;
            height: 210mm;
        }

        .modal-header,
        .modal-footer {
            display: none !important;
        }

        .modal-body {
            padding: 0 !important;
            margin: 0 !important;
            height: 100%;
        }

        .cupom-impressao {
            width: 80mm;
            margin: 0 auto;
            padding: 0;
            font-size: 16px;
            height: 100%;
        }
    }
</style>
<?= $this->endSection(); ?>


<?= $this->section('conteudo'); ?>
<div class="main">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"><?= $titulo; ?></h4>

                        <?= csrf_field(); ?>

                        <form action="<?= site_url('admin/pedidos'); ?>" method="get" class="mb-4">
                            <div class="form-row">
                                <div class="col-md-8"><input type="text" name="busca" class="form-control" placeholder="Pesquisar por código do pedido" value="<?= esc($filtros['busca']); ?>"></div>
                                <div class="col-md-2">
                                    <select name="status" class="form-control">
                                        <option value="">Todos os status</option>
                                        <?php foreach ($statusDisponiveis as $status): ?><option value="<?= $status; ?>" <?= ($status == $filtros['status']) ? 'selected' : ''; ?>><?= ucfirst(str_replace('_', ' ', $status)); ?></option><?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2"><button type="submit" class="btn btn-primary btn-block">Filtrar</button></div>
                            </div>
                            <?php if (!empty($filtros['busca']) || !empty($filtros['status'])): ?><a href="<?= site_url('admin/pedidos'); ?>" class="btn btn-outline-secondary btn-sm mt-2">Limpar filtros</a><?php endif; ?>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th><th>Cliente</th><th>Data</th><th>Status</th><th>Entregador</th><th>Valor Total</th><th>Pagamento</th><th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="tabela-pedidos-body">
                                    <?php if (empty($pedidos)): ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Nenhum pedido encontrado no momento.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($pedidos as $pedido): ?>
                                            <tr>
                                                <form action="<?= site_url('admin/pedidos/processaracao'); ?>?<?= http_build_query($filtros); ?>" method="post">
                                                    <?= csrf_field(); ?>
                                                    <input type="hidden" name="pedido_id" value="<?= $pedido->id ?>">

                                                    <td><?php echo $pedido->id; ?></td>
                                                    <td><?php echo esc($pedido->cliente_nome); ?></td>
                                                    <td><?php echo $pedido->criado_em->humanize(); ?></td>
                                                    
                                                    <td>
                                                        <select class="form-control form-control-sm select-status" name="status">
                                                            <?php foreach ($statusDisponiveis as $status): ?>
                                                                <option value="<?php echo $status; ?>" <?php echo ($status == $pedido->status ? 'selected' : ''); ?>>
                                                                    <?php echo ucfirst(str_replace('_', ' ', $status)); ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>

                                                    <td>
                                                        <div class="entregador-container" style="display: <?php echo in_array($pedido->status, ['saiu_para_entrega', 'entregue']) ? 'block' : 'none'; ?>;">
                                                            <select class="form-control form-control-sm select-entregador" name="entregador_id">
                                                                <option value="">Selecione...</option>
                                                                <?php foreach ($entregadores as $entregador): ?>
                                                                    <option value="<?php echo $entregador->id; ?>" <?php echo ($entregador->id == $pedido->entregador_id ? 'selected' : ''); ?>>
                                                                        <?php echo esc($entregador->nome); ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>R$ <?= number_format((float) ($pedido->valor_total ?? 0), 2, ',', '.'); ?></td>
                                                    <td><?php echo esc($pedido->forma_pagamento_nome); ?></td>

                                                    <td>
                                                        <button type="submit" class="btn btn-sm btn-success" title="Salvar este pedido">
                                                            <i class="mdi mdi-content-save"></i> 
                                                        </button>

                                                        <button type="button" class="btn btn-sm btn-outline-primary imprimir-cupom" 
                                                                data-id="<?php echo $pedido->id; ?>"
                                                                data-pedido-json='<?= esc(json_encode($pedido)); ?>' title="Imprimir este pedido">
                                                            <i class="mdi mdi-printer"></i> 
                                                        </button>
                                                    </td>
                                                </form>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <?= $pager->links(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCupom" tabindex="-1" role="dialog" aria-labelledby="modalCupomLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCupomLabel">Cupom do Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="conteudoCupom"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" onclick="window.print();">Imprimir</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>


<?= $this->section('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {
    <?php if (session()->has('imprimir_cupom')): ?>
        $(document).ready(function() {
            const pedidoIdParaImprimir = '<?= session()->getFlashdata('imprimir_cupom'); ?>';
            $(`button.imprimir-cupom[data-id="${pedidoIdParaImprimir}"]`).trigger('click');
        });
    <?php endif; ?>

    $(document).on('change', '.select-status', function() {
        const status = $(this).val();
        const entregadorContainer = $(this).closest('tr').find('.entregador-container');
        if (status === 'saiu_para_entrega' || status === 'entregue') {
            entregadorContainer.show();
        } else {
            entregadorContainer.hide();
            entregadorContainer.find('.select-entregador').val('');
        }
    });

    $(document).on('click', '.imprimir-cupom', function() {
        const botao = $(this);
        try {
            const pedido = JSON.parse(botao.attr('data-pedido-json'));
            let htmlItens = '';

            if (pedido.itens_impressao && pedido.itens_impressao.length > 0) {
                pedido.itens_impressao.forEach(function(item) {
                    const medida = item.medida_nome ? ` (${item.medida_nome})` : '';
                    const observacao = item.observacao ? `<br/>&nbsp;&nbsp;&nbsp;** ${item.observacao}` : '';
                    
                    htmlItens += `<li class="item-principal">
                                      <span>${item.quantidade}x ${item.produto_nome}${medida}</span>
                                  </li>`;
                                  
                    // Adiciona a observação do item, se existir
                    if (item.observacao) {
                        htmlItens += `<li>&nbsp;&nbsp;* ${item.observacao}</li>`;
                    }
                                  
                    if (item.extras && item.extras.length > 0) {
                        htmlItens += '<ul class="extras-lista">';
                        item.extras.forEach(function(extra) {
                            // Formata o preço do extra
                            const precoExtra = parseFloat(extra.preco).toFixed(2).replace('.', ',');
                            const quantidadeExtra = extra.quantidade;
                            
                            htmlItens += `<li>&nbsp;&nbsp;+ ${quantidadeExtra}x ${extra.nome} (R$ ${precoExtra})</li>`;
                        });
                        htmlItens += '</ul>';
                    }
                });
            } else {
                htmlItens = '<li>Nenhum item encontrado.</li>';
            }

            const dataPedido = new Date(pedido.criado_em.date).toLocaleString('pt-BR');

            let htmlPagamentoObservacao = `
                <div class="info-pagamento-observacao">
                    <p><strong>Forma de Pagamento:</strong> ${pedido.forma_pagamento_nome}</p>
                    ${pedido.observacoes ? `<p class="observacao-pedido"><strong>Obs/Troco:</strong> ${pedido.observacoes}</p>` : ''}
                </div>`;

            let htmlEnderecoEntrega = '';
            if ((pedido.status === 'saiu_para_entrega' || pedido.status === 'entregue') && pedido.endereco_impressao) {
                htmlEnderecoEntrega = `
                    <div class="titulo-secao">Dados de Entrega</div>
                    <div class="info-entrega">
                        <p><strong>Endereço:</strong> ${pedido.endereco_impressao.logradouro}, ${pedido.endereco_impressao.numero}</p>
                        ${pedido.endereco_impressao.complemento ? `<p><strong>Comp.:</strong> ${pedido.endereco_impressao.complemento}</p>` : ''}
                        ${pedido.endereco_impressao.referencia ? `<p><strong>Ref.:</strong> ${pedido.endereco_impressao.referencia}</p>` : ''}
                        <p><strong>Bairro:</strong> ${pedido.endereco_impressao.bairro}</p>
                        <p><strong>Cidade:</strong> ${pedido.endereco_impressao.cidade} - ${pedido.endereco_impressao.estado}</p>
                        <p><strong>CEP:</strong> ${pedido.endereco_impressao.cep}</p>
                    </div>`;
            } else {
                htmlEnderecoEntrega = '<div class="titulo-secao">delivery</div>';
            }

            const htmlFinal = `
                <div class="cupom-impressao">
                    <div class="header">
                        <h5>${pedido.empresa_nome || 'Nome da Sua Loja'}</h5>
                        <p>${pedido.empresa_endereco || 'Rua Exemplo, 123'}</p>
                        <p><strong>Telefone:</strong> ${pedido.empresa_telefone || '(99) 99999-9999'}</p>
                    </div>
                    <div class="titulo-secao">Comprovante de Pedido</div>
                    <div class="info-pedido">
                        <p><strong>Pedido:</strong> ${pedido.id}</p>
                        <p><strong>Data:</strong> ${dataPedido}</p>
                        <p><strong>Cliente:</strong> ${pedido.cliente_nome}</p>
                        ${htmlPagamentoObservacao}
                    </div>
                    <div class="titulo-secao">Itens</div>
                    <ul class="itens-lista">${htmlItens}</ul>
                    <div class="titulo-secao">Total</div>
                    <p class="total-final">R$ ${parseFloat(pedido.valor_total).toFixed(2).replace('.', ',')}</p>
                    ${htmlEnderecoEntrega}
                    <div class="footer">Obrigado pela preferência!</div>
                </div>`;

            $('#conteudoCupom').html(htmlFinal);
            $('#modalCupom').modal('show');
        } catch (e) {
            console.error("Erro ao processar dados do pedido para impressão:", e);
            exibirAlerta('error', 'Não foi possível ler os dados para impressão. Verifique o console para mais detalhes.');
        }
    });

    // Funções auxiliares (manter se já existirem)
    function exibirAlerta(tipo, mensagem) {
        toastr[tipo](mensagem);
    }
});
</script>
<?= $this->endSection(); ?>
