<?=$this->extend('Admin/layout/principal');?>

<?=$this->section('titulo');?>
<?=$titulo;?>
<?=$this->endSection();?>

<?=$this->section('estilos');?>
<link rel="stylesheet" href="<?=site_url();?>admin/vendors/auto-complete/jquery-ui.css">
<?=$this->endSection();?>

<?=$this->section('conteudo');?>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?=$titulo;?></h4>
                <div class="ui-widget">
                    <input id="query" name="query" placeholder="Pesquisar" class="form-control bg-light" mb-5>
                </div>

                <br />
                <div class="d-flex justify-content-end mb-2">
                    <a href="<?= site_url("admin/medidas/criar"); ?>" class="btn btn-success d-flex align-items-center px-3 py-2" style="font-weight: bold;">
                        <i class="mdi mdi-plus me-1"></i> Cadastrar
                    </a>
                </div>


                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Data de criação</th>
                                <th>Status</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($medidas as $medida): ?>
                            <tr style="cursor:pointer" onclick="window.location='<?=site_url("admin/medidas/show/$medida->id");?>'">
                                <td>
                                    <?=$medida->nome;?>
                                </td>
                                <td>
                                    <?=$medida->descricao;?>
                                </td>
                                <td><?=$medida->criado_em->humanize();?></td>
                                <td><?=($medida->ativo && null == $medida->deletado_em) ? '<span class="badge badge-primary">Ativo</span>' : '<span class="badge badge-danger">Inativo</span>';?>
                                </td>
                                <td>
                                    <?=(null == $medida->deletado_em) ? '<span class="badge badge-primary">Disponível</span>' : '<span class="badge badge-danger">Excluído</span>';?>

                                    <?php if (null !== $medida->deletado_em): ?>
                                    <a href="<?=site_url("admin/medidas/desfazerexclusao/$medida->id");?>"
                                        class="badge badge-secondary" onclick="event.stopPropagation();"><i class="mdi mdi-undo"></i> Desfazer
                                        </a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?=$this->endSection();?>

<?=$this->section('scripts');?>
<script src="<?=site_url();?>admin/vendors/auto-complete/jquery-ui.js"></script>
<script>
$(function() {
    $("#query").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?=site_url('/admin/medidas/procurar');?>",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    if (data.length < 1) {
                        var data = [{
                            label: 'medida não encontrado',
                            value: -1
                        }];
                    }
                    response(data); // Aqui temos valor no data
                },
            }) // Fim ajax
        },
        minLength: 1,
        select: function(event, ui) {
            if (ui.item.value == -1) {
                $(this).val("");
                return false;
            } else {
                window.location.href = "<?=site_url('admin/medidas/show/');?>" + ui.item.id;
            }
        }
    }); // Fim auto-complete
});
</script>
<?=$this->endSection();?>