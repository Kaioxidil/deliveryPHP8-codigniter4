<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
<?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-primary pb-0 pt-4">
                <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- COLUNA ESQUERDA: IMAGEM + AÇÕES -->
                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <!-- IMAGEM -->
                        <?php if ($entregador->imagem): ?>
                            <img src="<?php echo site_url("admin/entregadores/imagem/$entregador->imagem") ?>" class="img-fluid rounded  mb-3" style="max-height: 280px;" alt="<?php echo esc($entregador->nome); ?>">
                        <?php else: ?>
                            <img src="<?php echo site_url('admin/images/user-sem-imagem.jpg'); ?>" class="img-fluid rounded  mb-3" style="max-height: 280px;" alt="entregador sem imagem">
                        <?php endif; ?>

                        <!-- BOTÕES DE IMAGEM -->
                        <a href="<?= site_url("admin/entregadores/editarimagem/$entregador->id") ?>" class="btn btn-success w-100 mb-2">
                            <i class="mdi mdi-image btn-icon-prepend"></i> Editar Imagem
                        </a>

                        <a href="<?= site_url("admin/entregadores/excluirimagem/$entregador->id") ?>" class="btn btn-danger w-100 mb-3">
                            <i class="mdi mdi-image-off btn-icon-prepend"></i> Excluir Imagem
                        </a>

                        <div class="d-flex flex-wrap justify-content-center">
                            <?php if ($entregador->deletado_em == null): ?>
                                <a href="<?php echo site_url("admin/entregadores/editar/$entregador->id"); ?>" class="btn btn-dark btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-pencil mdi-18px"></i> Editar
                                </a>

                                <a href="<?php echo site_url("admin/entregadores/excluir/$entregador->id"); ?>" class="btn btn-danger btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-delete mdi-18px"></i> Excluir
                                </a>
                            <?php else: ?>
                                <a href="<?php echo site_url("admin/entregadores/desfazerexclusao/$entregador->id"); ?>" class="btn btn-dark btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-backup-restore mdi-18px"></i> Desfazer exclusão
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo site_url("admin/entregadores/"); ?>" class="btn btn-light text-dark btn-sm mb-2">
                                <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <!-- COLUNA DIREITA: DADOS -->
                    <div class="col-md-8">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" value="<?= esc($entregador->nome); ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control" value="<?= esc($entregador->telefone); ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label>Veículo</label>
                                    <input type="text" class="form-control" value="<?= esc($entregador->veiculo); ?>" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label>Placa</label>
                                    <input type="text" class="form-control" value="<?= esc($entregador->placa); ?>" disabled>
                                </div>
                            </div>

                            <!-- Endereço em linha inteira -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label>Endereço</label>
                                    <input type="text" class="form-control" value="<?= $entregador->endereco ?>" disabled>
                                </div>
                            </div>

                            <!-- Status, Criado e Atualizado na mesma linha -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label>Status</label>
                                    <input type="text" class="form-control" value="<?= $entregador->ativo ? 'Ativo' : 'Inativo'; ?>" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label>Criado</label>
                                    <input type="text" class="form-control" value="<?= $entregador->criado_em->humanize(); ?>" disabled>
                                </div>
                                <div class="col-md-4">
                                    <label><?= $entregador->deletado_em ? 'Excluído' : 'Atualizado'; ?></label>
                                    <input type="text" class="form-control <?= $entregador->deletado_em ? 'text-danger' : ''; ?>" value="<?= $entregador->deletado_em ? $entregador->deletado_em->humanize() : $entregador->atualizado_em->humanize(); ?>" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script>
    document.querySelector('.btn-danger[href*="excluirimagem"]').addEventListener('click', function(e) {
        if (!confirm('Tem certeza de que deseja excluir a imagem deste entregador?')) {
            e.preventDefault();
        }
    });
</script>
<?php echo $this->endSection(); ?>
