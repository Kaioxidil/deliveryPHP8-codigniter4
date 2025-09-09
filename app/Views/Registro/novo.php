<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="#">
    <meta name="description" content="#">
    <title><?php echo $titulo; ?></title>
    <!-- Fav and touch icons -->
    <meta name="twitter:title" content="SeuDelivery - Seu delivery favorito" />
    <meta name="twitter:description" content="Peça sua comida favorita com rapidez e segurança." />
    <meta name="twitter:image" content="<?php echo site_url('web/') ?>assets/logo-mini.svg" />
    <meta name="twitter:url" content="<?php echo current_url(); ?>" />
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="<?php echo site_url('web/assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="<?php echo site_url('web/assets/css/font-awesome.css') ?>" rel="stylesheet">
    <!-- Flaticons -->
    <link href="<?php echo site_url('web/assets/css/font/flaticon.css') ?>" rel="stylesheet">
    <!-- Swiper Slider -->
    <link href="<?php echo site_url('web/assets/css/swiper.min.css') ?>" rel="stylesheet">
    <!-- Range Slider -->
    <link href="<?php echo site_url('web/assets/css/ion.rangeSlider.min.css') ?>" rel="stylesheet">
    <!-- magnific popup -->
    <link href="<?php echo site_url('web/assets/css/magnific-popup.css') ?>" rel="stylesheet">
    <!-- Nice Select -->
    <link href="<?php echo site_url('web/assets/css/nice-select.css') ?>" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="<?php echo site_url('web/assets/css/style.css') ?>" rel="stylesheet">
    <!-- Custom Responsive -->
    <link href="<?php echo site_url('web/assets/css/responsive.css') ?>" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&amp;display=swap" rel="stylesheet">
    <!-- place -->

    <style>
        .img-fluid {
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
                                <!-- Mensagens de sessão -->
                                <?php if (session()->has('sucesso')): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?= session('sucesso'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->has('info')): ?>
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <?= session('info'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->has('atencao')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Atenção!</strong> <?= session('atencao'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->has('errors')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Erro de Validação!</strong>
                                        <ul>
                                            <?php foreach (session('errors') as $error): ?>
                                                <li><?= esc($error) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <?php if (session()->has('error')): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Erro!</strong> <?= session('error'); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Formulário de Registro -->
                                <?php echo form_open('registro/criar') ?>
                                    <h4 class="text-light-black fw-600">Crie sua conta</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-light-white fs-14">Nome Completo</label>
                                                <input type="text" name="nome" class="form-control form-control-submit" placeholder="Seu Nome Completo" value="<?= old('nome') ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-light-white fs-14">E-mail</label>
                                                <input type="email" name="email" class="form-control form-control-submit" placeholder="Seu E-mail" value="<?= old('email') ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-light-white fs-14">CPF</label>
                                                <input type="text" name="cpf" id="cpf" class="form-control form-control-submit" placeholder="000.000.000-00" value="<?= old('cpf') ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-light-white fs-14">Telefone</label>
                                                <input type="text" name="telefone" id="telefone" class="form-control form-control-submit" placeholder="(00) 00000-0000" value="<?= old('telefone') ?>">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-light-white fs-14">Senha (mínimo 6 caracteres)</label>
                                                <input type="password" id="password-field" name="password" class="form-control form-control-submit" placeholder="Sua Senha" required>
                                                <div data-name="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="text-light-white fs-14">Confirme a Senha</label>
                                                <input type="password" name="password_confirmation" class="form-control form-control-submit" placeholder="Confirme sua Senha" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn-second btn-submit full-width">Criar sua conta</button>
                                            </div>
                                            
                                            <div class="form-group text-center">
                                                <p class="text-light-black mb-0">Já tem uma conta? <a href="<?php echo site_url('login') ?>">Acesse aqui</a></p>
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
    <!-- Place all Scripts Here -->
    <!-- jQuery -->
    <script src="<?php echo site_url('web/assets/js/jquery.min.js') ?>"></script>
    <!-- Popper -->
    <script src="<?php echo site_url('web/assets/js/popper.min.js') ?>"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url('web/assets/js/bootstrap.min.js') ?>"></script>
    <!-- Range Slider -->
    <script src="<?php echo site_url('web/assets/js/ion.rangeSlider.min.js') ?>"></script>
    <!-- Swiper Slider -->
    <script src="<?php echo site_url('web/assets/js/swiper.min.js') ?>"></script>
    <!-- Nice Select -->
    <script src="<?php echo site_url('web/assets/js/jquery.nice-select.min.js') ?>"></script>
    <!-- magnific popup -->
    <script src="<?php echo site_url('web/assets/js/jquery.magnific-popup.min.js') ?>"></script>
    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnd9JwZvXty-1gHZihMoFhJtCXmHfeRQg"></script>
    <!-- sticky sidebar -->
    <script src="<?php echo site_url('web/assets/js/sticksy.js') ?>"></script>
    <!-- Munch Box Js -->
    <script src="<?php echo site_url('web/assets/js/munchbox.js') ?>"></script>
    <!-- Script para formatar CPF e Telefone -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            if (cpfInput) {
                cpfInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
                    if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos
                    if (value.length > 9) {
                        value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
                    } else if (value.length > 6) {
                        value = value.replace(/^(\d{3})(\d{3})(\d{3})$/, '$1.$2.$3');
                    } else if (value.length > 3) {
                        value = value.replace(/^(\d{3})(\d{3})$/, '$1.$2');
                    } else if (value.length > 0) {
                        value = value.replace(/^(\d{3})$/, '$1');
                    }
                    e.target.value = value;
                });
            }

            const telefoneInput = document.getElementById('telefone');
            if (telefoneInput) {
                telefoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
                    if (value.length > 11) value = value.slice(0, 11); // Limita a 11 dígitos
                    if (value.length > 10) {
                        value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
                    } else if (value.length > 6) {
                        value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
                    } else if (value.length > 2) {
                        value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
                    } else if (value.length > 0) {
                        value = value.replace(/^(\d{0,2})$/, '($1');
                    }
                    e.target.value = value;
                });
            }
        });
    </script>
</body>

</html>
