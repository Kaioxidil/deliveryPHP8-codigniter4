<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SeuDelivery | <?php echo $this->renderSection('titulo'); ?></title>

    <meta property="og:title" content="SeuDelivery - Seu delivery favorito" />
    <meta property="og:description" content="Peça sua comida favorita com rapidez e segurança." />
    <meta property="og:image" content="<?php echo site_url('web/') ?>assets/logo-mini.svg" />
    <meta property="og:url" content="<?php echo current_url(); ?>" />
    <meta name="twitter:card" content="summary_large_image" />
    
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <link href="<?php echo site_url('web/') ?>assets/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo site_url('web/') ?>assets/css/font/flaticon.css" rel="stylesheet">
    <link href="<?php echo site_url('web/') ?>assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&amp;display=swap" rel="stylesheet">

    <style>
        body {
            overflow-x: hidden;
            background-color: #fdfdfd;
        }

        /* Ajuste do conteúdo principal para não ficar atrás do header fixo */
        .main-content {
            padding-top: 75px; 
        }
        
        .header.fixed-top {
            z-index: 1030; /* Garante que o header fique acima de outros elementos */
            border-bottom: 1px solid #eee;
        }
        
        /* Estilos da barra lateral (Sidebar) */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 1020;
            padding: 75px 0 0; 
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #f8f9fa;
        }

        .sidebar-sticky {
            height: calc(100vh - 75px);
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            color: #e4002b;
            background-color: #e9ecef;
        }

        /* Estilos do Menu de Usuário (Dropdown) - Integrado do segundo código */
        .user-dropdown {
            width: 220px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: 1px solid #eee;
            padding: 15px;
        }
        .user-dropdown ul {
            list-style: none;
            padding: 0;
            margin: 0 0 10px;
        }
        .user-dropdown ul li {
            margin-bottom: 10px;
        }
        .user-dropdown a.dropdown-item-link { /* Classe nova para evitar conflito */
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #e4002b;
            text-decoration: none;
            padding: 5px;
            border-radius: 5px;
        }
        .user-dropdown a.dropdown-item-link:hover {
            background-color: #f8f9fa;
        }
        .user-dropdown .icon {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .user-footer {
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 14px;
        }
        .user-footer a {
            color: #e4002b;
            font-weight: 600;
            text-decoration: none;
        }
        .btn-full-width {
             width: 100%;
        }

        /* Media queries para responsividade */
        @media (max-width: 767.98px) {
            .main-content {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
            .header .main-search {
                display: none; /* Oculta a localização no header em telas pequenas */
            }
        }
    </style>

    <?php $this->renderSection('estilos'); ?>
</head>

<body>
    <div class="header fixed-top bg-white">
        <header class="full-width">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center py-2">
                    
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
                            <i class="bi bi-list fs-5"></i>
                        </button>
                        <div class="logo">
                            <a href="<?php echo site_url('home') ?>">
                                <img src="<?php echo site_url('web/') ?>assets/logo-mini.svg" class="img-fluid" alt="Logo" style="max-height: 40px;">
                            </a>
                        </div>
                    </div>

                    <div class="main-search">
                        <a href="#" class="text-decoration-none text-dark">
                            <i class="fas fa-map-marker-alt me-1 text-danger"></i>
                            <span class="d-none d-sm-inline">Terra Roxa - Paraná</span>
                        </a>
                    </div>
                    
                    <div class="right-side fw-700 d-flex align-items-center">
                        <a href="<?php echo site_url('conta/pedidos'); ?>" title="Meus Pedidos" class="me-3 text-dark fs-5"><i class="fas fa-concierge-bell"></i></a>
                        <a href="<?php echo site_url('/carrinho')?>" title="Carrinho" class="me-3 text-dark fs-5"><i class="fas fa-shopping-bag"></i></a>

                        <div class="dropdown">
                            <?php $usuario = service('autenticacao')->pegaUsuarioLogado(); ?>
                            <a href="#" class="dropdown-toggle text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if (!$usuario): ?>
                                    <img src="<?php echo site_url('web/') ?>assets/seudelivery.png" class="rounded-circle" alt="userimg" style="width: 35px; height: 35px;">
                                    <span class="d-none d-lg-inline ms-2 text-dark">Entrar</span>
                                <?php else: ?>
                                    <?php $caminho_foto = !empty($usuario->foto_perfil) ? site_url('uploads/usuarios/' . $usuario->foto_perfil) : site_url('web/assets/seudelivery.png'); ?>
                                    <img src="<?= esc($caminho_foto) ?>" class="rounded-circle" alt="Foto de perfil" style="width: 35px; height: 35px;">
                                    <span class="d-none d-lg-inline ms-2 text-dark">Olá, <?= esc(explode(' ', $usuario->nome)[0]) ?></span>
                                <?php endif; ?>
                            </a>
                            <div class="dropdown-menu user-dropdown dropdown-menu-end mt-2">
                                <?php if (!$usuario): ?>
                                    <div class="p-2">
                                        <a href="<?= site_url('login') ?>" class="btn btn-danger text-white fw-500 mb-2 btn-full-width">Entrar</a>
                                        <a href="<?= site_url('registro') ?>" class="btn btn-outline-danger fw-500 btn-full-width">Cadastrar</a>
                                    </div>
                                <?php else: ?>
                                    <ul>
                                        <li><a href="<?php echo site_url('conta/pedidos') ?>" class="dropdown-item-link"><div class="icon"><i class="flaticon-rewind"></i></div><span class="details">Pedidos</span></a></li>
                                        <li><a href="<?php echo site_url('conta') ?>" class="dropdown-item-link"><div class="icon"><i class="flaticon-user"></i></div><span class="details">Minha Conta</span></a></li>
                                    </ul>
                                    <div class="user-footer">
                                        <a href="<?= site_url('login/logout') ?>">Sair</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarOffcanvasLabel">Categorias</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <?php if (!empty($categorias) && is_array($categorias)): ?>
                    <?php foreach ($categorias as $cat): ?>
                        <li class="nav-item">
                            <a class="nav-link sidebar-link" href="#category-<?= $cat->id; ?>">
                               <i class="bi bi-tag"></i> <?= esc($cat->nome); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="nav-item"><span class="nav-link">Nenhuma categoria encontrada.</span></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <h5 class="px-4 pt-3 pb-1 text-muted">Categorias</h5>
                    <ul class="nav flex-column">
                        <?php if (!empty($categorias) && is_array($categorias)): ?>
                            <?php foreach ($categorias as $cat): ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="#category-<?= $cat->id; ?>">
                                       <i class="bi bi-tag"></i> <?= esc($cat->nome); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="nav-item"><span class="nav-link">Nenhuma categoria.</span></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 main-content px-md-4">
                
                <?php $this->renderSection('conteudo'); ?>

                <footer class="pt-4 my-md-5 pt-md-5 border-top">
                    <div class="row">
                        <div class="col-12 text-center">
                            <p class="text-muted">© <?php echo date("Y"); ?> SeuDeliveryBR. Todos os direitos reservados.</p>
                            <a href="http://seudeliverybr.com.br" target="_blank" class="text-muted">seudeliverybr.com.br</a>
                        </div>
                    </div>
                </footer>
            </main>
        </div>
    </div>
    
    <script src="<?php echo site_url('web/') ?>assets/js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo site_url('web/') ?>assets/js/munchbox.js"></script>

    <script>
        // Script para fechar o menu offcanvas ao clicar em um link
        document.addEventListener('DOMContentLoaded', function () {
            var sidebarLinks = document.querySelectorAll('#sidebarOffcanvas .sidebar-link');
            var offcanvasElement = document.getElementById('sidebarOffcanvas');
            var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement) || new bootstrap.Offcanvas(offcanvasElement);

            sidebarLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    offcanvas.hide();
                });
            });
        });
    </script>

    <?php $this->renderSection('scripts'); ?>
</body>

</html>