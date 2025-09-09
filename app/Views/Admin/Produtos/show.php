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
                <div class="row align-items-start">

                    <div class="col-md-4 d-flex flex-column align-items-center">
                        <?php if($produto->imagem): ?>
                            <img src="<?php echo site_url("admin/produtos/imagem/$produto->imagem") ?>" class="img-fluid rounded mb-3" alt="<?php echo esc($produto->nome); ?>">
                        <?php else: ?>
                            <img src="<?php echo site_url('admin/images/sem-imagem.jpg'); ?>" class="img-fluid rounded mb-3" alt="Produto sem imagem">
                        <?php endif; ?>
                        

                        <a href="<?php echo site_url("admin/produtos/editarimagem/$produto->id")?>" class="btn btn-success btn-block ">
                            <i class="mdi mdi-image btn-icon-prepend"></i> 
                            Editar Imagem
                        </a>

                        <a href="<?php echo site_url("admin/produtos/excluirimagem/$produto->id")?>" class="btn btn-danger btn-block mb-3">
                            <i class="mdi mdi-image-off btn-icon-prepend"></i> 
                            Excluir Imagem
                        </a>

                        <div class="d-flex flex-wrap justify-content-center">
                            <?php if ($produto->deletado_em == null): ?>
                                <a href="<?php echo site_url("admin/produtos/editar/$produto->id"); ?>" class="btn btn-dark btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-pencil mdi-18px"></i> Editar
                                </a>

                                <a href="<?php echo site_url("admin/produtos/extras/$produto->id"); ?>" class="btn btn-warning btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-pencil mdi-18px"></i> Extras
                                </a>
                                <a href="<?php echo site_url("admin/produtos/especificacoes/$produto->id"); ?>" class="btn btn-warning btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-pencil mdi-18px"></i> Especificações
                                </a>

                                <a href="<?php echo site_url("admin/produtos/excluir/$produto->id"); ?>" class="btn btn-danger btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-delete mdi-18px"></i> Excluir
                                </a>
                            <?php else: ?>
                                <a href="<?php echo site_url("admin/produtos/desfazerexclusao/$produto->id"); ?>" class="btn btn-dark btn-sm mr-2 mb-2">
                                    <i class="mdi mdi-backup-restore mdi-18px"></i> Desfazer exclusão
                                </a>
                            <?php endif; ?>

                            <a href="<?php echo site_url("admin/produtos/"); ?>" class="btn btn-light text-dark btn-sm mb-2">
                                <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <form>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome</label>
                                    <input type="text" id="nome" class="form-control" value="<?php echo esc($produto->nome); ?>" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="slug">Slug</label>
                                    <input type="text" id="slug" class="form-control" value="<?php echo esc($produto->slug); ?>" disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="categoria">Categoria</label>
                                    <input type="text" id="categoria" class="form-control" value="<?php echo esc($produto->categoria); ?>" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="status">Status</label>
                                    <input type="text" id="status" class="form-control" value="<?php echo ($produto->ativo) ? 'Ativo' : 'Inativo'; ?>" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea id="descricao" class="form-control" rows="3" disabled><?php echo esc($produto->descricao); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="criado">Criado</label>
                                    <input type="text" id="criado" class="form-control" value="<?php echo $produto->criado_em->humanize(); ?>" disabled>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="atualizado"><?php echo $produto->deletado_em == null ? 'Atualizado' : 'Excluído'; ?></label>
                                    <input type="text" id="atualizado" class="form-control <?php echo $produto->deletado_em ? 'text-danger' : ''; ?>" value="<?php echo $produto->deletado_em ? $produto->deletado_em->humanize() : $produto->atualizado_em->humanize(); ?>" disabled>
                                </div>
                            </div>

                            <div class="form-group">
                             <label for="ingredientes-display">Ingredientes</label>
                                <div id="ingredientes-display" class="form-control" style="min-height: 140px; padding: 6px 12px; overflow-y: auto; background-color: #E9ECEF;  border-radius: 4px;">
                                    <?php echo $produto->ingredientes; ?>
                                </div>
                            </div>
                        </form>
                    </div>

                </div> </div>

        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>


<?php echo $this->section('scripts'); ?>

<script>
    document.querySelector('.btn-danger[href*="excluirimagem"]').addEventListener('click', function(e) {
        if (!confirm('Tem certeza de que deseja excluir a imagem deste produto?')) {
            e.preventDefault();
        }
    });
</script>
<?php echo $this->endSection(); ?>