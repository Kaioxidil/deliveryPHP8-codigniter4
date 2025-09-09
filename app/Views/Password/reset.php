
<?php echo $this->extend('Admin/layout/principal_autenticacao'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<!-- Aqui enviamos para o template principal os estilos --> <?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-5 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                             <?php if ($mensagem = session()->has('sucesso')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?=session('sucesso');?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif;?>

                    <?php if ($mensagem = session()->has('info')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?=session('info');?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif;?>

                    <?php if ($mensagem = session()->has('atencao')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Atenção!</strong> <?=session('atencao');?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif;?>

                    <!-- Captura os erros de CSRF - Ação não permitida -->
                    <?php if ($mensagem = session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erro!</strong> <?=session('error');?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif;?>
                            <div class="brand-logo">
                                <img src="<?php echo site_url('admin/') ?>images/logo.svg" alt="logo">
                            </div>
                            <h4>Redefina sua senha</h4>
                            <h6 class="font-weight-light mb-4">Adicione a sua nova senha no campos abaixo</h6>

                        <?php if (session()->has('errors_model')): ?>
                            <ul>
                                <?php foreach (session('errors_model') as $error): ?>
                                    <li class="text-danger"><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>



                            <?php echo form_open("password/processareset/$token") ?>

                                <div class="form-group">
                                    <label for="password">Nova senha</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmação da nova senha</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                                </div>
    
                                <div class="mt-3">
                                    <input type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="Redefinir senha">
                                </div>

                            <?php echo form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>



<?php echo $this->endSection(); ?>


