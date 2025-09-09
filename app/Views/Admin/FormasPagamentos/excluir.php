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
                    <?php if (session()->has('errors_model')): ?>
                        <ul>
                            <?php foreach (session('errors_model') as $error): ?>
                                <li class="text-danger"><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php echo form_open("admin/formas/excluir/$forma->id"); ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Atenção!</strong> Tem certeza da exclusão da forma de pagemento
                        <strong> <?php echo esc($forma->nome) ?>?</strong>
                    </div>
                    <button type="submit" class="btn btn-danger btn-sm mr-2">Excluir</button>
                    <a href="<?php echo site_url("admin/formas/show/$forma->id"); ?>"
                       class="btn btn-light text-dark btn-sm mr-2">Voltar</a>
                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>
    </div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
    <script src="<?php echo site_url(); ?>admin/vendors/mask/jquery.mask.min.js"></script>
    <script src="<?php echo site_url(); ?>admin/vendors/mask/app.js"></script>
<?php echo $this->endSection(); ?>