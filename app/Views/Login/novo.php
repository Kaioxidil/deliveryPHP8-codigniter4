<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="#">
    <meta name="description" content="#">
    <title><?php echo $titulo; ?></title>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="#">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="#">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="#">
    <link rel="apple-touch-icon-precomposed" href="#">
    <meta property="og:title" content="SeuDelivery - Seu delivery favorito" />
    <meta property="og:description" content="Peça sua comida favorita com rapidez e segurança." />
    <meta property="og:image" content="<?php echo site_url('web/') ?>assets/logo-mini.svg" />
    <meta property="og:url" content="<?php echo current_url(); ?>" />
    <meta property="og:type" content="website" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="SeuDelivery - Seu delivery favorito" />
    <meta name="twitter:description" content="Peça sua comida favorita com rapidez e segurança." />
    <meta name="twitter:image" content="<?php echo site_url('web/') ?>assets/logo-mini.svg" />
    <meta name="twitter:url" content="<?php echo current_url(); ?>" />
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <!-- Fav and touch icons -->
    <link href="<?php echo site_url('web/assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/font-awesome.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/font/flaticon.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/swiper.min.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/ion.rangeSlider.min.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/magnific-popup.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/nice-select.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/style.css') ?>" rel="stylesheet">
    <link href="<?php echo site_url('web/assets/css/responsive.css') ?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&amp;display=swap" rel="stylesheet">
    

    <style>

        .img-fluid{
            background-color: white;
        }

    </style>
</head>

<body>
    <div class="inner-wrapper">
        <div class="container-fluid no-padding">
            <div class="row no-gutters overflow-auto">
                <div class="col-md-6">
                    <div class="main-banner">
                        <img src="<?php echo site_url('web/assets/img/banner/banner-1.jpg') ?>" class="img-fluid full-width main-img" alt="banner">

                        <div class="overlay-2 main-padding" style="background-image: url('<?php echo site_url('web/assets/img/banner/seu-background.jpg'); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;">
                            <img src="<?php echo site_url('web/assets/logo.svg') ?>" class="img-fluid" alt="logo">
                        </div>

                        <img src="<?php echo site_url('web/assets/img/banner/burger.png') ?>" class="footer-img" alt="footer-img">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section-2 user-page main-padding">
                        <div class="login-sec">
                            <div class="login-box">

                                <?php if ($mensagem = session()->has('sucesso')) : ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= session('sucesso'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($mensagem = session()->has('info')) : ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <?= session('info'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($mensagem = session()->has('atencao')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Atenção!</strong> <?= session('atencao'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($mensagem = session()->has('error')) : ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Erro!</strong> <?= session('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php echo form_open('login/criar') ?>

                                <h4 class="text-light-black fw-600">Acesse sua conta</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="text-light-white fs-14">Email</label>
                                            <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-submit" placeholder="Digite seu e-mail" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="text-light-white fs-14">Senha</label>
                                            <input type="password" name="password" class="form-control form-control-submit" placeholder="Digite sua senha" required>
                                            <div data-name="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></div>
                                        </div>
                                        <div class="form-group checkbox-reset">
                                            <a href="<?php echo site_url('password/esqueci') ?>">Resetar senha</a>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn-second btn-submit full-width">
                                                Login
                                            </button>
                                        </div>
                                        <div class="form-group text-center mb-0">
                                            <a href="<?php echo site_url('registro') ?>">Criar sua conta</a>
                                        </div>
                                    </div>
                                </div>
                                <?php echo form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo site_url('web/assets/js/jquery.min.js') ?>"></script>
    <script src="<?php echo site_url('web/assets/js/popper.min.js') ?>"></script>
    <script src="<?php echo site_url('web/assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo site_url('web/assets/js/ion.rangeSlider.min.js') ?>"></script>
    <script src="<?php echo site_url('web/assets/js/swiper.min.js') ?>"></script>
    <script src="<?php echo site_url('web/assets/js/jquery.nice-select.min.js') ?>"></script>
    <script src="<?php echo site_url('web/assets/js/jquery.magnific-popup.min.js') ?>"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnd9JwZvXty-1gHZihMoFhJtCXmHfeRQg"></script>
    <script src="<?php echo site_url('web/assets/js/sticksy.js') ?>"></script>
    <script src="<?php echo site_url('web/assets/js/munchbox.js') ?>"></script>
    <script>
$(document).ready(function() {
    $('.toggle-password').click(function() {
        const input = $(this).prev('input');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
});
</script>

</body>

</html>