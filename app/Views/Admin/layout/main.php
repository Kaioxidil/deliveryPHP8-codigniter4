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

    <?=$this->renderSection('estilos')?>
</head>

<body>
    <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="navbar-brand-wrapper d-flex justify-content-center">
                <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
                    <a class="navbar-brand brand-logo" href="<?=site_url('admin/home')?>"><img src="<?=site_url('admin/')?>images/logo.svg" alt="logo" /></a>
                    <a class="navbar-brand brand-logo-mini" href="<?=site_url('admin/home')?>"><img src="<?=site_url('admin/')?>images/logo-mini.svg" alt="logo" /></a>
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-sort-variant"></span>
                    </button>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <div id="relogio-data" class="me-3 text-dark" style="font-weight: 500;"></div>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="<?=site_url('admin/')?>images/faces/seudelivery.png" alt="profile" />
                            <span class="nav-profile-name">
                                <?= esc(service('autenticacao')->pegaUsuarioLogado()->nome ?? 'Visitante') ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="<?= site_url("admin/empresa") ?>">
                                <i class="mdi mdi-settings text-primary"></i> Configurações
                            </a>
                            <a class="dropdown-item" href="<?= site_url("login/logout") ?>">
                                <i class="mdi mdi-logout text-primary"></i> Sair
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>

        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas sidebar-fixed" id="sidebar">
                <ul class="nav">

                    <?php $uri = service('uri'); ?>

                    <li class="nav-item <?= $uri->getSegment(2) == 'home' || $uri->getSegment(2) == '' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= site_url('admin/home') ?>">
                            <i class="mdi mdi-view-dashboard menu-icon"></i> 
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-item <?= $uri->getSegment(2) == 'empresa' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= site_url('admin/empresa') ?>">
                            <i class="mdi mdi-settings menu-icon"></i> 
                            <span class="menu-title">Dados da Empresa</span>
                        </a>
                    </li>

                    <li class="nav-item <?= $uri->getSegment(2) == 'integracoes' ? 'active' : '' ?>">
                        <a class="nav-link" href="<?= site_url('admin/integracoes') ?>">
                            <i class="mdi mdi-cloud-sync menu-icon"></i> 
                            <span class="menu-title">Integrações</span>
                        </a>
                    </li>
                    
                </ul>
            </nav>
            <div class="main-panel">
                <div class="content-wrapper">
                    <?php if (session()->has('sucesso')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert"><?=session('sucesso');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <?php endif;?>
                    <?php if (session()->has('info')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert"><?=session('info');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <?php endif;?>
                    <?php if (session()->has('atencao')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Atenção!</strong> <?=session('atencao');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <?php endif;?>
                    <?php if (session()->has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro!</strong> <?=session('error');?><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
                    <?php endif;?>

                    <?=$this->renderSection('conteudo')?>

                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://seudeliverybr.com.br" target="_blank">seudeliverybr.com.br </a><?php echo date("Y"); ?></span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    
    <script src="<?=site_url('admin/')?>vendors/base/vendor.bundle.base.js"></script>
    <script src="<?=site_url('admin/')?>js/off-canvas.js"></script>
    <script src="<?=site_url('admin/')?>js/hoverable-collapse.js"></script>
    <script src="<?=site_url('admin/')?>js/template.js"></script>
    <script src="<?=site_url('admin/')?>js/jquery.cookie.js" type="text/javascript"></script>

    <script>
        function atualizarRelogioData() {
            const agora = new Date();
            const opcoesData = { day: '2-digit', month: '2-digit', year: 'numeric' };
            const opcoesHora = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const dataFormatada = agora.toLocaleDateString('pt-BR', opcoesData);
            const horaFormatada = agora.toLocaleTimeString('pt-BR', opcoesHora);
            document.getElementById('relogio-data').textContent = `${dataFormatada} ${horaFormatada}`;
        }
        setInterval(atualizarRelogioData, 1000);
        atualizarRelogioData();
    </script>
    
    <?=$this->renderSection('scripts')?>
</body>

</html>