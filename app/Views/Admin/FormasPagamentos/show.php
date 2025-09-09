<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
<?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<div class="row">
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-primary pb-0 pt-4">
                <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
            </div>
            <div class="card-body">

                <?php if($forma->id == 1) :?>

                    <div class="alert alert-warning" role="alert">
                        A forma de pagamento <strong><?php echo esc($forma->nome); ?></strong>
                        não pode ser <strong><span class="text-danger">editada ou excluída</span></strong>, pois essa opção estará vinculada ou não o envio de
                        troco para o cliente quando o mesmo estiver no <strong>checkout</strong>
                    </div>

                    <?php endif; ?>

                <p class="card-text">
                    <span class="font-weight-bold">Nome: </span>
                    <?php echo esc($forma->nome); ?>
                </p>
               
                <p class="card-text">
                    <span class="font-weight-bold">Status: </span>
                    <?php echo ($forma->ativo) ? 'Ativo' : 'Inativo'; ?>
                </p>
                <p class="card-text">
                    <span class="font-weight-bold">Criado: </span>
                    <?php echo $forma->criado_em->humanize(); ?>
                </p>

                <?php if ($forma->deletado_em == null): ?>
                    <p class="card-text">
                        <span class="font-weight-bold">Atualizado: </span>
                        <?php echo $forma->atualizado_em->humanize(); ?>
                    </p>
                <?php else: ?>
                    <p class="card-text">
                        <span class="font-weight-bold text-danger">Excluído: </span>
                        <?php echo $forma->deletado_em->humanize(); ?>
                    </p>
                <?php endif; ?>

                <div class="mt-4">
                    <?php if ($forma->deletado_em == null): ?>

                       <?php if ($forma->id != 1): ?>

                        <a href="<?php echo site_url("admin/formas/editar/$forma->id"); ?>"
                        class="btn btn-dark btn-sm mr-2">
                            <i class="mdi mdi-pencil mdi-18px"></i> Editar
                        </a>

                        <a href="<?php echo site_url("admin/formas/excluir/$forma->id"); ?>"
                        class="btn btn-danger btn-sm mr-2">
                            <i class="mdi mdi-delete mdi-18px"></i> Excluir
                        </a>
                        <?php endif; ?>

                        <a href="<?php echo site_url("admin/formas/"); ?>"
                        class="btn btn-light text-dark btn-sm mr-2">
                            <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                        </a>

                        <?php else: ?>

                        <a href="<?php echo site_url("admin/formas/desfazerexclusao/$forma->id"); ?>"
                        class="btn btn-dark btn-sm mr-2">
                            <i class="mdi mdi-backup-restore mdi-18px"></i> Desfazer exclusão
                        </a>

                        <a href="<?php echo site_url("admin/formas/"); ?>"
                        class="btn btn-light text-dark btn-sm mr-2">
                            <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                        </a>

                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<?php echo $this->endSection(); ?>
