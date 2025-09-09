<!DOCTYPE html>
<html lang="pt-br">


<!-- munchbox/homepage-2.html  05 Dec 2019 10:14:51 GMT -->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="#">
    <meta name="description" content="#">
    <title>SeuDelivery | <?php echo $this->renderSection('titulo'); ?></title>

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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <!-- Bootstrap -->
    <link href="<?php echo site_url('web/') ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="<?php echo site_url('web/') ?>assets/css/font-awesome.css" rel="stylesheet">
    <!-- Flaticons -->
    <link href="<?php echo site_url('web/') ?>assets/css/font/flaticon.css" rel="stylesheet">
    <!-- Swiper Slider -->
    <link href="<?php echo site_url('web/') ?>assets/css/swiper.min.css" rel="stylesheet">
    <!-- Range Slider -->
    <link href="<?php echo site_url('web/') ?>assets/css/ion.rangeSlider.min.css" rel="stylesheet">
    <!-- magnific popup -->
    <link href="<?php echo site_url('web/') ?>assets/css/magnific-popup.css" rel="stylesheet">
    <!-- Nice Select -->
    <link href="<?php echo site_url('web/') ?>assets/css/nice-select.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="<?php echo site_url('web/') ?>assets/css/style.css" rel="stylesheet">
    <!-- Custom Responsive -->
    <link href="<?php echo site_url('web/') ?>assets/css/responsive.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&amp;display=swap" rel="stylesheet">
    <!-- place -->


    <style>
    .btn-full-width {
        /* Corrigido para ocupar 100% da largura, e não um valor fixo */
        width: 100px;
        margin-left: 90px;
    }

    /* Estilos específicos para dispositivos móveis (telas com até 991px de largura) */
    @media (max-width: 991px) {
        
        /* Garante que o nome do usuário apareça ao lado do ícone */
        .user-details a span {
            display: inline !important; /* Força a exibição do nome */
            vertical-align: middle; /* Alinha o texto com a imagem */
            margin-left: 8px; /* Adiciona um espaço entre a imagem e o nome */
        }

        /* Opcional: Oculta o texto "Minhas Ordens" para um visual mais limpo, mantendo só o ícone */
        .gem-points span {
            display: none;
        }

        /* Ajusta o menu suspenso (dropdown) de login/cadastro */
        .user-dropdown {
            left: auto;
            right: 0; /* Alinha o menu à direita da tela */
            width: 250px; /* Define uma largura ideal para os botões */
        }
        .user-dropdown ul li {
            padding: 15px; /* Adiciona espaçamento para os botões não ficarem colados */
        }
    }

    .user-dropdown {
        background: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        width: 200px;
        text-align: center;
    }

    .user-dropdown ul {
        list-style: none;
        padding: 0;
        margin: 0 0 10px;
    }

    .user-dropdown ul li {
        margin-bottom: 10px;
    }

    .user-dropdown a {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: #e4002b;
        text-decoration: none;
    }

    .user-dropdown .icon {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .user-dropdown .details {
        font-weight: 500;
    }

    .user-footer {
        border-top: 1px solid #ddd;
        padding-top: 10px;
        font-size: 14px;
        color: #555;
        display: flex;
        justify-content: center;
        gap: 5px;
    }

    .user-footer a {
        color: #e4002b;
        font-weight: 600;
        text-decoration: none;
    }

    .hover-red:hover {
         color: var(--bs-danger) !important;
    }



</style>


    <?php $this->renderSection('estilos'); ?>

</head>

<body>
    
    <!-- Navigation -->
    <div class="header">
    <div class="header">
    <header class="full-width">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mainNavCol">
                    <div class="logo mainNavCol">
                        <a href="<?php echo site_url('home') ?>">
                            <img src="<?php echo site_url('web/') ?>assets/logo-mini.svg" class="img-fluid" alt="Logo">
                        </a>
                    </div>
                    <div class="main-search mainNavCol">
                        <form class="main-search search-form full-width">
                            <div class="row">
                                <div class="col-lg-6 col-md-5">
                                    <a href=""> <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                        <span class="">Terra Roxa - Paraná
                                    </a>

                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="right-side fw-700 mainNavCol">
                        <div class="gem-points">
                            <a href="<?php echo site_url('conta/pedidos'); ?>"> <i class="fas fa-concierge-bell"></i>
                            
                            </a>
                        </div>

                        <div class="cart-btn">
                            <a href="<?php echo site_url('/carrinho')?>" class="text-light-green fw-700"> <i class="fas fa-shopping-bag"></i>
                         
                            </a>
                           
                        </div>


                        <div class="user-details p-relative">
                            <?php
                                $usuario = service('autenticacao')->pegaUsuarioLogado();
                            ?>
                            <?php if (!$usuario): ?>
                                <a href="#" class="text-light-white fw-500">
                                    <img src="<?php echo site_url('web/') ?>assets/seudelivery.png" class="rounded-circle" alt="userimg"  style="width: 30px; height: 30px;">
                                    <span>Olá, visitante</span>
                                </a>
                                <div class="user-dropdown">
                                    <ul>
                                        <li style="display: flex; flex-direction: column; align-items: center; justify-content: center;">

                                            <a href="<?= site_url('login') ?>" class="btn btn-first green-btn text-white fw-500 mb-2 btn-full-width hover-red">Entrar</a>
                                            <a href="<?= site_url('registro') ?>" class="btn btn-first green-btn text-white fw-500 btn-full-width hover-red">Cadastrar</a>


                                        </li>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <?php
                                    $primeiro_nome = explode(' ', $usuario->nome)[0];
                                ?>
                                   <a href="#" class="text-light-white fw-500">
                                    <?php
                                    // Verifica se o usuário tem uma foto de perfil
                                    if (!empty($usuario->foto_perfil)) {
                                        // Se tiver, exibe a foto de perfil do usuário
                                        $caminho_foto = site_url('uploads/usuarios/' . $usuario->foto_perfil);
                                    } else {
                                        // Se não tiver, exibe a imagem padrão
                                        $caminho_foto = site_url('web/assets/seudelivery.png');
                                    }
                                    ?>
                                    <img src="<?= esc($caminho_foto) ?>" class="rounded-circle" alt="Foto de perfil do usuário" style="width: 30px; height: 30px;">
                                    <span>Olá, <?= esc($primeiro_nome) ?></span>
                                </a>
                                <div class="user-dropdown">
                                    <ul>
                                        <li>
                                            <a href="<?php echo site_url('conta/pedidos') ?>">
                                                <div class="icon"><i class="flaticon-rewind"></i></div>
                                                <span class="details">Pedidos</span>
                                            </a>
                                        </li>
                                       
                                        <li>
                                            <a href="<?php echo site_url('conta') ?>">
                                                <div class="icon"><i class="flaticon-user"></i></div>
                                                <span class="details">Conta</span>
                                            </a>
                                        </li>
                                      
                                    </ul>
                                    <div class="user-footer">
                                        <span class="text-light-black">Não é o <?= esc($primeiro_nome) ?>?</span>
                                        <a href="<?= site_url('login/logout') ?>">Sair</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>



                        
                    </div>
                </div>

            </div>
        </div>
    </header>
</div>



</div>




   
        <?php $this->renderSection('conteudo'); ?>

    
<footer class="section-padding bg-light-theme pt-0 u-line">

    <div class="u-line instagram-slider swiper-container mb-5">
        <ul class="hm-list hm-instagram swiper-wrapper">
            <?php if (!empty($produtos) && is_iterable($produtos)): ?>
                <?php foreach ($produtos as $produto): ?>
                    <li class="swiper-slide">
                        <a href="<?= site_url("produto/$produto->slug") ?>">
                            <?php if ($produto->imagem): ?>
                                <img src="<?= site_url("home/imagemProduto/$produto->imagem") ?>" alt="<?= esc($produto->nome) ?>">
                            <?php else: ?>
                                <img src="<?= site_url('admin/images/sem-imagem.jpg') ?>" alt="Sem imagem">
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
 
</footer>
   <div class="copyright">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 text-center align-self-center">
                <p class="text-light-black mb-0">© <?php echo date("Y"); ?> SeuDeliveryBR. Todos os direitos reservados.</p>
            </div>
            <div class="col-lg-12 text-center align-self-center mt-2">
                <a href="http://seudeliverybr.com.br" target="_blank" class="text-light-black">seudeliverybr.com.br</a>
            </div>
        </div>
    </div>
</div>
    <!-- footer -->
    <
    <div class="modal fade" id="search-box">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="search-box p-relative full-width">
                        <input type="text" class="form-control" placeholder="Pizza, Burger, Chinese">
                    </div>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>



    <!-- Place all Scripts Here -->
    <!-- jQuery -->
    <script src="<?php echo site_url('web/') ?>assets/js/jquery.min.js"></script>
    <!-- Popper -->
    <script src="<?php echo site_url('web/') ?>assets/js/popper.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo site_url('web/') ?>assets/js/bootstrap.min.js"></script>
    <!-- Range Slider -->
    <script src="<?php echo site_url('web/') ?>assets/js/ion.rangeSlider.min.js"></script>
    <!-- Swiper Slider -->
    <script src="<?php echo site_url('web/') ?>assets/js/swiper.min.js"></script>
    <!-- Nice Select -->
    <script src="<?php echo site_url('web/') ?>assets/js/jquery.nice-select.min.js"></script>
    <!-- magnific popup -->
    <script src="<?php echo site_url('web/') ?>assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnd9JwZvXty-1gHZihMoFhJtCXmHfeRQg"></script>
    <!-- sticky sidebar -->
    <script src="<?php echo site_url('web/') ?>assets/js/sticksy.js"></script>
    <!-- Munch Box Js -->
    <script src="<?php echo site_url('web/') ?>assets/js/munchbox.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- /Place all Scripts Here -->

    <?php $this->renderSection('scripts'); ?>
</body>


</html>