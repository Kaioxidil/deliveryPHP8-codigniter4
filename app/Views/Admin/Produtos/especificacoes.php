<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
    <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
    <link rel="stylesheet" href="<?php echo site_url('admin/vendors/select2/select2.min.css'); ?>">

    <style>
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-selection--single {
            width: 100%;
            height: 2.875rem;
            padding: 0.875rem 1.375rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: #495057;
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 2px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 18px;
        }
    </style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<div class="row">
    <div class="col-lg-10 grid-margin stretch-card">
        <div class="card shadow-sm">
            <div class="card-header bg-primary pb-0 pt-4">
                <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
            </div>

            <div class="card-body">
                <!-- Mensagens -->
                <?php if (session()->has('errors_model')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors_model') as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo form_open("admin/produtos/cadastrarespecificacoes/$produto->id"); ?>
                    <input type="hidden" name="especificacao_id" id="especificacao_id" value="">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="medida_id" class="font-weight-bold text-dark mb-2">
                                Escolha a especificação do produto
                                <a href="javascript:void" data-toggle="popover" title="Especificação" data-content="Ex: Pizza 4 pedaços"><i class="mdi mdi-help-circle-outline tooltip-icon"></i></a>
                            </label>
                            <select name="medida_id" class="form-control js-example-basic-single" id="medida_id">
                                <option value="">Selecione a especificação</option>
                                <?php foreach ($medidas as $medida): ?>
                                    <option value="<?php echo $medida->id; ?>" <?php echo set_select('medida_id', $medida->id); ?>>
                                        <?php echo esc($medida->nome); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="preco" class="font-weight-bold text-dark mb-2">
                                Preço
                                <a href="javascript:void" data-toggle="popover" title="Preço" data-content="Esse produto pode ter um preço diferente dependendo da sua personalização"><i class="mdi mdi-help-circle-outline tooltip-icon"></i></a>
                            </label>
                            <input type="text" class="form-control" name="preco" id="preco" placeholder="Ex: 10,50 " value="<?= old('preco'); ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <label class="font-weight-bold text-dark mb-2">
                                Produto customizável?
                                <a href="javascript:void" data-toggle="popover" title="Meio a Meio" data-content="Esse produto pode ser meia pizza de um sabor e meia de outro"><i class="mdi mdi-help-circle-outline tooltip-icon"></i></a>
                            </label>
                            <select name="customizavel" class="form-control">
                                <option value="">Escolha</option>
                                <option value="0" <?= set_select('customizavel', '0'); ?>>Não</option>
                                <option value="1" <?= set_select('customizavel', '1'); ?>>Sim</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-sm" id="btn-salvar">
                            <i class="mdi mdi-content-save"></i> Salvar medida
                        </button>
                        <a href="<?php echo site_url("admin/produtos/show/$produto->id"); ?>" class="btn btn-light text-dark btn-sm mr-2">
                            <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                        </a>
                    </div>
                <?php echo form_close(); ?>

                <hr class="my-4">

                <div class="col-md-12">
                    <?php if (empty($produtoEspecificacoes)): ?>
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Atenção!</h4>
                            <p>Esse produto não possui especificações até o momento. Portanto ele <strong>não será exibido</strong> como opção de compra para o usuário.</p>
                            <hr>
                            <p class="mb-0">Cadastre pelo menos uma especificação para <strong><?php echo esc($produto->nome); ?></strong></p>
                        </div>
                    <?php else: ?>
                        <h4 class="card-title">Especificações do produto</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th>Customizável</th>
                                        <th class="text-right pr-3">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtoEspecificacoes as $especificaco): ?>
                                        <tr>
                                            <td><?php echo esc($especificaco->medida); ?></td>
                                            <td>R$ <?php echo number_format($especificaco->preco, 2, ',', '.'); ?></td>
                                            <td>
                                                <?php if ($especificaco->customizavel): ?>
                                                    <span class="badge badge-success">Sim</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">Não</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-right pr-3">

                                                <button type="button"
                                                    class="badge badge-warning text-white border-0 btn-editar-especificacao ml-1"
                                                    data-id="<?= $especificaco->id ?>"
                                                    data-medida_id="<?= $especificaco->medida_id ?>"
                                                    data-preco="<?= number_format($especificaco->preco, 2, ',', '.') ?>"
                                                    data-customizavel="<?= $especificaco->customizavel ?>"
                                                    title="Editar medida">
                                                    <i class="mdi mdi-pencil"></i> Editar
                                                </button>

                                                 <?php echo form_open("admin/produtos/excluirmedida/$especificaco->id/$especificaco->produto_id", ['class' => 'd-inline']); ?>
                                                    <button type="submit" class="badge badge-danger text-white border-0 ml-1" title="Remover medida" onclick="return confirm('Tem certeza que deseja remover essa medida?')">
                                                        <i class="mdi mdi-close"></i>
                                                    </button>
                                                <?php echo form_close(); ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <?= $pager->links(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
    <script src="<?php echo site_url('admin/vendors/select2/select2.min.js'); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
    $(document).ready(function () {
        // Select2
        $('.js-example-basic-single').select2({
            placeholder: 'Selecione a medida',
            allowClear: false,
            language: {
                noResults: function () {
                    return "Nenhuma medida encontrada&nbsp;&nbsp;<a href='<?php echo site_url('admin/medidas/criar'); ?>' class='btn btn-primary btn-sm'>Cadastrar medida</a>";
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        });

        // Popover
        $('[data-toggle="popover"]').popover({
            trigger: 'hover'
        });

        // Máscara no campo de preço
        $('#preco').mask('#.##0,00', {reverse: true});

        // Submit: transforma valor para float antes de enviar
        $("form").submit(function () {
            let preco = $('#preco').val();

            if (preco) {
                preco = preco.replace(/\./g, '').replace(',', '.'); // 1.234,56 → 1234.56
                $('#preco').val(preco);
            }

            return true;
        });

        // Botão editar: preencher os campos
        $('.btn-editar-especificacao').on('click', function () {
            $('#especificacao_id').val($(this).data('id'));
            $('#medida_id').val($(this).data('medida_id')).trigger('change');

            // Preço com ponto decimal → máscara aplica ao exibir
            var preco = $(this).data('preco');
            $('#preco').val(preco);

            $('select[name="customizavel"]').val($(this).data('customizavel'));
            $('#btn-salvar').html('<i class="mdi mdi-content-save-edit"></i> Atualizar medida');

            $('html, body').animate({
                scrollTop: $("form").offset().top
            }, 500);
        });
    });
    </script>
<?php echo $this->endSection(); ?>
