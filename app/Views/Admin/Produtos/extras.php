<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
    <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
    <link rel="stylesheet" href="<?php echo site_url('admin/vendors/select2/select2.min.css'); ?>">

    <style>
        .select2-container{
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
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 2px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 18px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow  b{
            top: 80%;
        }

    </style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<div class="row">
    <div class="col-lg-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-primary pb-0 pt-4">
                <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
            </div>

            <div class="card-body">

                <!-- Erros de validação -->
                <?php if (session()->has('errors_model')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session('errors_model') as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php echo form_open("admin/produtos/cadastrarextras/$produto->id"); ?>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="extra_id" class="font-weight-bold text-dark mb-2">Escolha o extra do produto <span class="form-tooltip">
                                    <a href="javascript:void" data-toggle="popover" title="Extra" data-content="Ex: Calabresa"><i class="mdi mdi-help-circle-outline tooltip-icon"></i></a>
                                </span></label>
                        <div>
                            <select name="extra_id" class="form-control js-example-basic-single" id="extra_id">
                                <option value="">Selecione o extra</option>
                                <?php foreach ($extras as $extra): ?>
                                    <option value="<?php echo $extra->id; ?>" <?php echo set_select('extra_id', $extra->id); ?>>
                                        <?php echo esc($extra->nome); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-content-save"></i> Inserir extra
                    </button>
                    <a href="<?php echo site_url("admin/produtos/show/$produto->id"); ?>" class="btn btn-light text-dark btn-sm mr-2">
                        <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                    </a>
                <?php echo form_close(); ?>

                <hr class="my-4">

                <div class="col-md-10">
                    <?php if (empty($produtosExtras)): ?>
                         <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Atenção!</h4>
                            <p>Esse produto não possui extras até o momento. Portanto ele <strong>não será exibido</strong> como opção de compra para o usuário.</p>
                            <hr>
                            <p class="mb-0">Aproveite para cadastar pelo menos um extra para esse produto <strong><?php echo esc($produto->nome); ?></strong></p>
                        </div>
                    <?php else: ?>
                        <h4 class="card-title">Extras do produto</h4>
                        <p class="card-description">
                            Aproveite para gerenciar os extras do produto. Você pode adicionar ou remover os extras conforme necessário.
                        </p>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Preço</th>
                                        <th>Descrição</th>
                                        <th class="text-right pr-3">Ações</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php foreach($produtosExtras as $extraProduto): ?>
                                        <tr>
                                            <td><?php echo esc($extraProduto->extra) ?></td>
                                            <td>R$ <?php echo esc(number_format($extraProduto->preco, 2)) ?></td>
                                            <td><?php echo esc($extraProduto->descricao) ?></td>
                                            
                                            <td class="text-right pr-3">

                                                <div class="d-inline-block ml-1">
                                                    <a href="<?php echo site_url("admin/extras/editar/{$extraProduto->extra_id}") ?>" class="badge badge-warning text-white" style="font-size: 14px;">
                                                        <i class="mdi mdi-pencil"></i> Editar
                                                    </a>
                                                </div>

                                                <div class="d-inline-block">
                                                    <?php echo form_open("admin/produtos/excluirextra/$extraProduto->id/$extraProduto->produto_id") ?>
                                                        <button type="submit" class="badge badge-danger text-white border-0" style="font-size: 14px; cursor: pointer;">
                                                            <i class="mdi mdi-close"></i>
                                                        </button>
                                                    <?php echo form_close(); ?>
                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>


                            </table>
                            <div class="mt-3">
                                <?=$pager->links();?>
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
    <script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js'); ?>"></script>
    <script src="<?php echo site_url('admin/vendors/mask/app.js'); ?>"></script>
    <script src="<?php echo site_url('admin/vendors/select2/select2.min.js'); ?>"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                placeholder: 'Selecione o extra',
                allowClear: false,
                language: {
                    noResults: function() {
                        return "Nenhum extra encontrado&nbsp;&nbsp;<a href='<?php echo site_url('admin/extras/criar'); ?>' class='btn btn-primary btn-sm'>Cadastrar extra</a>";
                    },
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
            });
        });

        $(function () {
            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            });
        });
    </script>
<?php echo $this->endSection(); ?>
