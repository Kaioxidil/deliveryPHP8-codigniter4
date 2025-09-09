<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SeuDelivery | <?=$this->renderSection('titulo')?></title>

    <link rel="shortcut icon" href="<?=site_url('admin/')?>images/favicon.png" />
    <link rel="stylesheet" href="<?=site_url('admin/')?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=site_url('admin/')?>vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=site_url('admin/')?>vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="<?=site_url('admin/')?>css/style.css">
    <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">


    <?=$this->renderSection('estilos')?>


    
</head>

<body>
    <div class="container-scroller">

        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" href="<?=site_url('admin/home')?>"><img src="<?=site_url('admin/')?>images/logo.svg" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="<?=site_url('admin/home')?>">
                        <img src="<?=site_url('admin/')?>images/logo-mini.svg" alt="logo" />
                    </a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

               <div id="relogio-data" class="me-3 text-dark" style="font-weight: 500;"></div>
               
                <ul class="navbar-nav navbar-nav-right">
                    <!-- <li class="nav-item dropdown me-1">
                        <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                            id="messageDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-message-text mx-0"></i>
                            <span class="count"></span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="messageDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <img src="<?=site_url('admin/')?>images/faces/face4.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="item-content flex-grow">
                                    <h6 class="ellipsis font-weight-normal">David Grey</h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        The meeting is cancelled
                                    </p>
                                </div>
                                
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <img src="<?=site_url('admin/')?>images/faces/face2.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="item-content flex-grow">
                                    <h6 class="ellipsis font-weight-normal">Tim Cook</h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        New product launch
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <img src="<?=site_url('admin/')?>images/faces/face3.jpg" alt="image" class="profile-pic">
                                </div>
                                <div class="item-content flex-grow">
                                    <h6 class="ellipsis font-weight-normal"> Johnson</h6>
                                    <p class="font-weight-light small-text text-muted mb-0">
                                        Upcoming board meeting
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li> -->
                    <!-- <li class="nav-item dropdown me-4">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown"
                            id="notificationDropdown" href="#" data-toggle="dropdown">
                            <i class="mdi mdi-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notificações</p>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-success">
                                        <i class="mdi mdi-information mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Just now
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-warning">
                                        <i class="mdi mdi-settings mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">Configurações</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        Private message
                                    </p>
                                </div>
                            </a>
                            <a class="dropdown-item">
                                <div class="item-thumbnail">
                                    <div class="item-icon bg-info">
                                        <i class="mdi mdi-account-box mx-0"></i>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <h6 class="font-weight-normal">New user registration</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted">
                                        2 days ago
                                    </p>
                                </div>
                            </a>
                        </div>
                    </li> -->
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="<?=site_url('admin/')?>images/faces/seudelivery.png" alt="profile" />
                            <span class="nav-profile-name">
                            <?php
                                $autenticacao = service('autenticacao');
                                $usuarioLogado = $autenticacao->pegaUsuarioLogado();

                                if ($usuarioLogado) {
                                    echo esc($usuarioLogado->nome);
                                } else {
                                    echo 'Visitante';
                                }
                            ?>
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="<?php echo site_url("admin/empresa/detalhes/1") ?>">
                                <i class="mdi mdi-settings text-primary"></i>
                                Configurações
                            </a>
                            <a class="dropdown-item" href="<?php echo site_url("login/logout") ?>">
                                <i class="mdi mdi-logout text-primary"></i>
                                Sair
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>


        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas sidebar-fixed" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/home") ?>">
                            <i class="mdi mdi-home menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/pedidos") ?>">
                            <i class="mdi mdi-cart menu-icon"></i>
                            <span class="menu-title">Pedidos</span>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/pdv") ?>">
                            <i class="mdi mdi-cash-register menu-icon"></i>
                            <span class="menu-title">Pdv</span>
                        </a>
                    </li> -->

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/usuarios") ?>">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Usuarios</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/categorias") ?>">
                            <i class="mdi mdi-shape menu-icon"></i>
                            <span class="menu-title">Categorias</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#produtos-submenu" aria-expanded="false" aria-controls="produtos-submenu">
                            <i class="mdi mdi-food menu-icon"></i> <span class="menu-title">Produtos</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="produtos-submenu">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo site_url("admin/produtos") ?>">
                                        <i class="mdi mdi-food-variant menu-icon"></i>
                                        Todos os Produtos
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo site_url("admin/extras") ?>">
                                        <i class="mdi mdi-pencil-plus-outline menu-icon"></i>
                                        Extras
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo site_url("admin/medidas") ?>">
                                        <i class="mdi mdi-tape-measure menu-icon"></i>
                                        Medidas
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/formas") ?>">
                            <i class="mdi mdi-credit-card-settings-outline menu-icon"></i>
                            <span class="menu-title">Formas de Pagamento</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/entregadores") ?>">
                            <i class="mdi mdi-account-tie menu-icon"></i>
                            <span class="menu-title">Entregadores</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url("admin/bairros") ?>">
                            <i class="mdi mdi-map-marker-radius menu-icon"></i>
                            <span class="menu-title">Bairros</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="abrirEntregadorEExtensao(event)">
                            <i class="mdi mdi-truck-delivery menu-icon"></i>
                            <span class="menu-title">App do Entregador</span>
                            <i class="mdi mdi-open-in-new menu-icon" style="margin-left: auto;"></i>
                        </a>
                    </li>

                    <script>
                    function abrirEntregadorEExtensao(e) {
                        e.preventDefault();

                        const isMobile = /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|Mobile/i.test(navigator.userAgent) || window.innerWidth < 768;

                        const urlApp = "<?php echo site_url('entregador') ?>";
                        const urlExtensao = "https://chromewebstore.google.com/detail/simulador-m%C3%B3vel-ferrament/ckejmhbmlajgoklhgbapkiccekfoccmk";

                        if (isMobile) {
                            // Dispositivo móvel: abre apenas o app
                            window.open(urlApp, "_blank");
                        } else {
                            // Desktop: abre o app E a extensão (duas abas)
                            const novaAba1 = window.open(urlApp, "_blank");
                            const novaAba2 = window.open(urlExtensao, "_blank");
                             alert("⚠️ Este app é feito para celulares.\n\nVamos abrir o app e também a extensão Mobile Simulator para você instalar.");

                            if (!novaAba1 || !novaAba2) {
                                alert("⚠️ Seu navegador bloqueou a abertura automática das abas.\n\nPor favor, permita pop-ups ou clique novamente.");
                            }
                        }
                    }
                    </script>



                    
                </ul>
            </nav>


            <div class="main-panel">
                <div class="content-wrapper">

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

                    <?php if ($mensagem = session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Erro!</strong> <?=session('error');?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif;?>

                    <?=$this->renderSection('conteudo')?>

                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a
                                href="https://seudeliverybr.com.br" target="_blank">seudeliverybr.com.br </a><?php echo date("Y"); ?></span>
                      
                    </div>
                </footer>
                </div>
            </div>
        </div>
    <script src="<?=site_url('admin/')?>vendors/base/vendor.bundle.base.js"></script>
    <script src="<?=site_url('admin/')?>vendors/chart.js/Chart.min.js"></script>
    <script src="<?=site_url('admin/')?>vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="<?=site_url('admin/')?>vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="<?=site_url('admin/')?>js/off-canvas.js"></script>
    <script src="<?=site_url('admin/')?>js/hoverable-collapse.js"></script>
    <script src="<?=site_url('admin/')?>js/template.js"></script>
    <script src="<?=site_url('admin/')?>js/dashboard.js"></script>
    <script src="<?=site_url('admin/')?>js/data-table.js"></script>
    <script src="<?=site_url('admin/')?>js/jquery.dataTables.js"></script>
    <script src="<?=site_url('admin/')?>js/dataTables.bootstrap4.js"></script>
    <script src="<?=site_url('admin/')?>js/jquery.cookie.js" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            $('.dropdown-toggle').dropdown();
        });

        function atualizarRelogioData() {
        const agora = new Date();

        const opcoesData = {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        };

        const opcoesHora = {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };

        const dataFormatada = agora.toLocaleDateString('pt-BR', opcoesData);
        const horaFormatada = agora.toLocaleTimeString('pt-BR', opcoesHora);

        document.getElementById('relogio-data').textContent = `${dataFormatada} ${horaFormatada}`;
        document.getElementById('relogio-data').setAttribute('style', 'color: #9B9B9B;');
    }

    setInterval(atualizarRelogioData, 1000); // Atualiza a cada 1 segundo
    atualizarRelogioData(); // Chamada inicial
    
    </script>

     

    <?=$this->renderSection('scripts')?>
</body>

</html>