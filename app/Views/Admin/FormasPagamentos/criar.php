<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
<?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<?php   echo $this->endSection(); ?>

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
                    <?php endforeach;?>
                </ul>
                <?php endif;?>

                <?php echo form_open("admin/formas/cadastrar"); ?>
                <?php echo $this->include('Admin/FormasPagamentos/form'); ?>
                <a href="<?php echo site_url("admin/formas"); ?>"
                    class="btn btn-light text-dark btn-sm mr-2">
                    <i class="mdi mdi-arrow-left mdi-18px"></i> Voltar</a>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="<?php echo site_url(); ?>admin/vendors/mask/jquery.mask.min.js"></script>
<script src="<?php echo site_url(); ?>admin/vendors/mask/app.js"></script>
<script>
           $(document).ready(function(){
        $('#preco').mask('000.000.000,00', {reverse: true});

        $('#preco').on('blur', function() {
            let valor = $(this).val();
            if (valor && !valor.startsWith('R$')) {
                $(this).val('R$ ' + valor);
            }
        });

        $('#preco').on('focus', function() {
            let valor = $(this).val();
            if (valor.startsWith('R$ ')) {
                $(this).val(valor.replace('R$ ', ''));
            }
        });
    });
</script>
<?php echo $this->endSection(); ?>