<?=$this->extend('Admin/layout/principal');?>

<?=$this->section('titulo');?>
<?=$titulo;?>
<?=$this->endSection();?>

<?=$this->section('estilos');?>
<link rel="stylesheet" href="<?=site_url();?>admin/vendors/auto-complete/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

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
                <div class="d-flex justify-content-end mb-3 gap-2">
                    <a href="<?= site_url("admin/usuarios/criar"); ?>" class="btn btn-success d-flex align-items-center px-3 py-2 fw-bold">
                        <i class="mdi mdi-plus me-2"></i> Cadastrar
                    </a>

                    


                </div>


                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Cpf</th>
                                <th>Status</th>
                                <th>Situação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <?php if ($usuario->id == 1) continue; ?>
                            <tr style="cursor:pointer" onclick="window.location='<?=site_url("admin/usuarios/show/$usuario->id");?>'">
                                <td>
                                    <?=$usuario->nome;?>
                                </td>
                                <td><?=$usuario->email;?></td>
                                <td><?=$usuario->cpf;?></td>
                                <td><?=($usuario->ativo && null == $usuario->deletado_em) ? '<span class="badge badge-primary">Ativo</span>' : '<span class="badge badge-danger">Inativo</span>';?>
                                </td>
                                <td>
                                    <?=(null == $usuario->deletado_em) ? '<span class="badge badge-primary">Disponível</span>' : '<span class="badge badge-danger">Excluído</span>';?>

                                    <?php if (null !== $usuario->deletado_em): ?>
                                  <a href="<?= site_url("admin/usuarios/desfazerexclusao/$usuario->id"); ?>"
                                        class="badge badge-secondary"
                                        onclick="event.stopPropagation();">
                                        <i class="mdi mdi-undo"></i> Desfazer
                                        </a>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <?=$pager->links();?>
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
                url: "<?=site_url('/admin/usuarios/procurar');?>",
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function(data) {
                    if (data.length < 1) {
                        var data = [{
                            label: 'Usuário não encontrado',
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
                window.location.href = "<?=site_url('admin/usuarios/show/');?>" + ui.item.id;
            }
        }
    }); // Fim auto-complete
});
</script>
<?=$this->endSection();?>