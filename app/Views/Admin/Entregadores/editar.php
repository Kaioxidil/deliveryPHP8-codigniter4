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
                <?php if (session()->has('errors_model')): ?>
                    <ul>
                        <?php foreach (session('errors_model') as $error): ?>
                            <li class="text-danger"><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?= form_open("admin/entregadores/atualizar/$entregador->id"); ?>
                    <?= $this->include('Admin/Entregadores/form'); ?>
                    <a href="<?= site_url("admin/entregadores/show/$entregador->id"); ?>" class="btn btn-light text-dark btn-sm mr-2">
                        <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar
                    </a>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="<?= site_url(); ?>admin/vendors/mask/jquery.mask.min.js"></script>
<script src="<?= site_url(); ?>admin/vendors/mask/app.js"></script>
<?php echo $this->endSection(); ?>
