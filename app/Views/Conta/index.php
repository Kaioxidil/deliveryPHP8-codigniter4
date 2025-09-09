<?php echo $this->extend('layout/principalView'); ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?php echo $this->section('conteudo'); ?>

<style>
    /* Estilos do menu lateral permanecem os mesmos */
    .menu-lateral .list-group-item {
        border: none; border-left: 4px solid transparent; border-radius: 0;
        padding: 15px 20px; font-weight: 500; color: #555;
    }
    .menu-lateral .list-group-item:hover,
    .menu-lateral .list-group-item:focus {
        background-color: #e9ecef; color: #000;
    }
    .menu-lateral .list-group-item.active {
        border-left: 4px solid #EA1D2C; /* Cor principal iFood */
        background-color: #f7f7f7; font-weight: 700; color: #EA1D2C;
    }
    .menu-lateral .list-group-item i {
        margin-right: 12px; width: 20px;
    }

    /* Estilos para a área principal do perfil */
    .profile-area {
        background-color: #fff;
        padding: 40px; /* Espaçamento interno generoso */
        border-radius: 8px; /* Cantos levemente arredondados */
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); /* Sombra sutil para profundidade */
    }

    /* Estilos da imagem de perfil */
    .profile-img-container {
        text-align: center; /* Centraliza a imagem na coluna */
        padding-right: 20px; /* Espaçamento entre a imagem e as informações */
    }
    .profile-img {
        width: 140px; /* Tamanho da imagem ligeiramente maior */
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #EA1D2C; /* Borda da cor do iFood */
        padding: 3px;
        display: block; /* Para aplicar margin auto */
        margin: 0 auto; /* Centraliza a imagem */
    }

    /* Estilos das informações do usuário */
    .profile-info-column {
        flex-grow: 1; /* Permite que esta coluna preencha o espaço restante */
    }
    .profile-info-column h5 {
        font-size: 1.6rem; /* Título "Suas Informações" maior e mais destacado */
        font-weight: 700;
        color: #222; /* Cor mais escura para o título */
        margin-bottom: 25px; /* Mais espaço abaixo do título */
    }

    /* Estilos dos itens de dados (rótulo e valor) */
    .data-item {
        margin-bottom: 1.5rem; /* Espaçamento entre cada grupo de dados */
    }
    .data-item strong {
        display: block;
        font-size: 0.8rem; /* Rótulo menor e mais discreto */
        color: #777; /* Cor mais suave para o rótulo */
        margin-bottom: 0.3rem; /* Espaço entre rótulo e valor */
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.8px; /* Aumenta o espaçamento entre letras do rótulo */
    }
    .data-item span {
        display: block;
        font-size: 1.15rem; /* Valor maior e mais legível */
        color: #333; /* Cor mais escura para o valor */
        font-weight: 600;
    }

    /* Seção de Botões */
    .buttons-section {
        margin-top: 40px; /* Mais espaço antes dos botões */
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: flex-start;
    }
    .buttons-section .btn {
        min-width: 160px; /* Garante um tamanho mínimo para os botões */
        font-weight: 600;
        padding: 12px 25px; /* Aumenta o padding para botões maiores */
        border-radius: 6px; /* Cantos levemente mais arredondados */
    }
    .buttons-section .btn-primary {
        background-color: #EA1D2C; /* Cor principal iFood */
        border-color: #EA1D2C;
    }
    .buttons-section .btn-primary:hover {
        background-color: #e01b2a; /* Tom mais escuro no hover */
        border-color: #e01b2a;
    }
    .buttons-section .btn-secondary {
        background-color: #6c757d; /* Cinza padrão do Bootstrap */
        border-color: #6c757d;
    }
    .buttons-section .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    /* Layout principal dos detalhes do perfil */
    .profile-content-wrapper {
        display: flex;
        gap: 60px; /* Espaçamento maior entre a foto e os detalhes */
        align-items: flex-start; /* Alinha o topo da foto com o topo dos detalhes */
        flex-wrap: wrap; /* Permite que os itens quebrem a linha em telas menores */
    }

    /* --- Ajustes para Mobile --- */
    @media (max-width: 768px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Menu lateral em telas menores */
        .col-lg-3 {
            margin-bottom: 30px; /* Espaçamento abaixo do menu lateral */
        }
        .menu-lateral {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Sombra mais sutil */
        }
        .menu-lateral .list-group-item {
            padding: 12px 15px; /* Menor padding */
            font-size: 0.95rem; /* Fonte ligeiramente menor */
        }

        /* Área principal do perfil */
        .profile-area {
            padding: 25px 20px; /* Menor padding em telas pequenas */
        }
        .profile-content-wrapper {
            flex-direction: column; /* Coloca a imagem e as informações em coluna */
            gap: 0; /* Remove o gap quando em coluna */
            align-items: center; /* Centraliza o conteúdo */
            text-align: center; /* Centraliza textos */
        }
        .profile-img-container {
            width: 100%; /* Ocupa toda a largura */
            padding-right: 0; /* Remove padding lateral */
            margin-bottom: 30px; /* Espaço abaixo da imagem */
        }
        .profile-img {
            width: 120px; /* Reduz o tamanho da foto de perfil */
            height: 120px;
        }
        .profile-info-column {
            width: 100%; /* Ocupa toda a largura */
        }
        .profile-info-column h5 {
            font-size: 1.4rem; /* Título ligeiramente menor */
            text-align: center; /* Centraliza o título */
            margin-bottom: 20px; /* Menor espaço abaixo do título */
        }
        .data-item {
            margin-bottom: 1rem; /* Menor espaço entre os itens de dados */
        }
        .data-item strong, .data-item span {
            text-align: center; /* Centraliza os rótulos e valores */
        }

        /* Seção de Botões */
        .buttons-section {
            flex-direction: column; /* Botões empilham em coluna */
            gap: 10px; /* Menor espaço entre os botões */
            align-items: center; /* Centraliza os botões */
        }
        .buttons-section .btn {
            min-width: unset; /* Remove o min-width para se ajustar melhor */
            width: 100%; /* Botões ocupam toda a largura disponível */
            padding: 10px 15px; /* Menor padding nos botões */
            font-size: 0.95rem; /* Fonte ligeiramente menor */
        }
    }
</style>

<br>
<br>
<br>

<div class="container mt-5 mb-5">
    <div class="row">

        <div class="col-lg-3">
            <div class="menu-lateral bg-white rounded shadow-sm">
                <div class="list-group list-group-flush">
                    <a href="<?= site_url('conta') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-person-circle"></i> Meu Perfil</a>
                    <a href="<?= site_url('conta/pedidos') ?>" class="list-group-item list-group-item-action "><i class="bi bi-box-seam"></i> Meus Pedidos</a>
                    <a href="<?= site_url('conta/enderecos') ?>" class="list-group-item list-group-item-action "><i class="bi bi-geo-alt"></i> Meus Endereços</a>
                    <a href="<?= site_url('login/logout') ?>" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right"></i> Sair</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h2><?php echo esc($titulo); ?></h2>
            <hr>

            <?php if(session()->has('sucesso')): ?>
                <div class="alert alert-success"><?php echo session('sucesso'); ?></div>
            <?php endif; ?>
            <?php if(session()->has('erro')): ?>
                <div class="alert alert-danger"><?php echo session('erro'); ?></div>
            <?php endif; ?>

            <?php if ($usuario): ?>
                <div class="profile-area">
                    <div class="profile-content-wrapper">
                        <div class="profile-img-container">
                            <?php if ($usuario->foto_perfil): ?>
                                <img src="<?= site_url('uploads/usuarios/' . $usuario->foto_perfil) ?>" alt="Foto de Perfil" class="profile-img">
                            <?php else: ?>
                                <img src="<?= site_url('web/assets/seudelivery.png') ?>" alt="Avatar Padrão" class="profile-img">
                            <?php endif; ?>
                        </div>

                        <div class="profile-info-column">
                            <h5 class="mb-4">Suas Informações</h5>
                            
                            <div class="data-item">
                                <strong>Nome Completo:</strong>
                                <span><?= esc($usuario->nome) ?></span>
                            </div>

                            <div class="data-item">
                                <strong>Email:</strong>
                                <span><?= esc($usuario->email) ?></span>
                            </div>

                            <div class="data-item">
                                <strong>CPF:</strong>
                                <span><?= esc($usuario->cpf) ?></span>
                            </div>

                            <div class="data-item">
                                <strong>Telefone:</strong>
                                <span><?= esc($usuario->telefone) ?></span>
                            </div>

                            <div class="data-item">
                                <strong>Membro Desde:</strong>
                                <span><?= esc(date('d/m/Y H:i', strtotime($usuario->criado_em))) ?></span>
                            </div>

                            <div class="buttons-section">
                                <a href="<?= site_url('conta/editar') ?>" class="btn btn-primary">Editar Perfil</a>
                                <a href="<?= site_url('password/esqueci') ?>" class="btn btn-secondary">Redefinir Senha</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p class="alert alert-warning">Não foi possível carregar as informações da sua conta. Por favor, faça login novamente.</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<br>
<br>
<?php echo $this->endSection(); ?>