<?= $this->extend('Admin/layout/principal'); ?>

<?= $this->section('titulo'); ?>
<?= $titulo; ?>
<?= $this->endSection(); ?>

<?= $this->section('estilos'); ?>
<link rel="stylesheet" href="<?= site_url(); ?>admin/vendors/auto-complete/jquery-ui.css">
<?= $this->endSection(); ?>

<?= $this->section('conteudo'); ?>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?= $titulo; ?></h4>

                <div class="ui-widget mb-4">
                    <input id="query" name="query" placeholder="Pesquisar" class="form-control bg-light">
                </div>

                <div class="d-flex justify-content-end mb-2">
                    <a href="<?= site_url("admin/bairros/criar"); ?>" class="btn btn-success d-flex align-items-center px-3 py-2 fw-bold">
                        <i class="mdi mdi-plus me-1"></i> Cadastrar
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Valor de Entrega</th> <th>Data de criação</th>
                                <th>Status</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bairros as $bairro): ?>
                                <tr style="cursor:pointer" onclick="window.location='<?= site_url("admin/bairros/show/$bairro->id"); ?>'">
                                    <td><?= esc($bairro->nome); ?></td>
                                    <td>R$ <?= esc(number_format($bairro->valor_entrega, 2, ',', '.')); ?></td>
                                    <td>
                                        <?= is_object($bairro->criado_em) 
                                            ? $bairro->criado_em->humanize() 
                                            : esc($bairro->criado_em); ?>
                                    </td>

                                    <td>
                                        <?= ($bairro->ativo && $bairro->deletado_em === null) 
                                            ? '<span class="badge badge-primary">Ativo</span>' 
                                            : '<span class="badge badge-danger">Inativo</span>'; ?>
                                    </td>
                                    <td>
                                        <?= ($bairro->deletado_em === null) 
                                            ? '<span class="badge badge-primary">Disponível</span>' 
                                            : '<span class="badge badge-danger">Excluído</span>'; ?>

                                        <?php if ($bairro->deletado_em !== null): ?>
                                            <a href="<?= site_url("admin/bairros/desfazerexclusao/$bairro->id"); ?>"
                                               class="badge badge-secondary"
                                               onclick="event.stopPropagation();">
                                                <i class="mdi mdi-undo"></i> Desfazer
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <?= $pager->links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="<?= site_url(); ?>admin/vendors/auto-complete/jquery-ui.js"></script>
<script>
$(function() {
    $("#query").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= site_url('/admin/bairros/procurar'); ?>",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    if (!data.length) {
                        data = [{
                            label: 'Bairro não encontrado',
                            value: -1
                        }];
                    }
                    response(data);
                }
            });
        },
        minLength: 1,
        select: function(event, ui) {
            if (ui.item.value === -1) {
                $(this).val("");
                return false;
            } else {
                window.location.href = "<?= site_url('admin/bairros/show/'); ?>" + ui.item.id;
            }
        }
    });
});
</script>
<?= $this->endSection(); ?>