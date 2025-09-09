<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
    <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>

<div class="row">
    <div class="col-lg-6">
        <div class="card">

            <div class="card-header bg-primary pb-0 pt-4">
                <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <!-- Imagem à esquerda -->
                    <div class="col-md-4 text-center mb-3">
                        <?php if ($categoria->imagem): ?>
                            <img src="<?php echo site_url("admin/categorias/imagem/$categoria->imagem") ?>" 
                                 class="rounded" 
                                 style="width: 100%; height: 240px; object-fit: cover;" 
                                 alt="<?php echo esc($categoria->nome); ?>">
                        <?php else: ?>
                            <img src="<?php echo site_url('admin/images/sem-foto.jpg'); ?>" 
                                 class="rounded" 
                                 style="width: 100%; height: 240px; object-fit: cover;" 
                                 alt="Categoria sem imagem">
                        <?php endif; ?>
                    </div>

                    <!-- Botões à direita da imagem -->
                    <div class="col-md-4 d-flex flex-column justify-content-center mg">
                        <a href="<?= site_url("admin/categorias/editarimagem/$categoria->id") ?>" class="btn btn-success w-100 mb-2">
                            <i class="mdi mdi-image btn-icon-prepend"></i> Editar Imagem
                        </a>

                        <a href="<?= site_url("admin/categorias/excluirimagem/$categoria->id") ?>" class="btn btn-danger w-100">
                            <i class="mdi mdi-image-off btn-icon-prepend"></i> Excluir Imagem
                        </a>
                    </div>
                </div>

                <!-- Informações da categoria -->
                <hr>
                <p class="card-text"><strong>Nome:</strong> <?php echo esc($categoria->nome); ?></p>
                <p class="card-text"><strong>Slug:</strong> <?php echo esc($categoria->slug); ?></p>
                <p class="card-text"><strong>Status:</strong> <?php echo ($categoria->ativo ? 'Ativo' : 'Inativo'); ?></p>
                <p class="card-text"><strong>Criado:</strong> <?php echo $categoria->criado_em->humanize(); ?></p>

                <?php if ($categoria->deletado_em === null): ?>
                    <p class="card-text"><strong>Atualizado:</strong> <?php echo $categoria->atualizado_em->humanize(); ?></p>
                <?php else: ?>
                    <p class="card-text text-danger"><strong>Excluído:</strong> <?php echo $categoria->deletado_em->humanize(); ?></p>
                <?php endif; ?>

                <!-- Botões finais -->
                <div class="mt-4">
                    <?php if ($categoria->deletado_em === null): ?>
                        <a href="<?php echo site_url("admin/categorias/editar/$categoria->id"); ?>" class="btn btn-dark btn-sm mr-2">
                            <i class="mdi mdi-pencil mdi-18px"></i> Editar
                        </a>
                        <a href="<?php echo site_url("admin/categorias/excluir/$categoria->id"); ?>" class="btn btn-danger btn-sm mr-2">
                            <i class="mdi mdi-delete mdi-18px"></i> Excluir
                        </a>
                    <?php else: ?>
                        <a href="<?php echo site_url("admin/categorias/desfazerexclusao/$categoria->id"); ?>" class="btn btn-dark btn-sm mr-2">
                            <i class="mdi mdi-backup-restore mdi-18px"></i> Desfazer exclusão
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo site_url("admin/categorias/"); ?>" class="btn btn-light text-dark btn-sm">
                        <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<?php echo $this->endSection(); ?>