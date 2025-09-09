<?php echo $this->extend('layout/principalView'); ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?php echo $this->section('conteudo'); ?>

<style>
    /* Estilos do menu lateral */
    .menu-lateral .list-group-item {
        border: none;
        border-left: 4px solid transparent;
        border-radius: 0;
        padding: 15px 20px;
        font-weight: 500;
        color: #555;
    }

    .menu-lateral .list-group-item:hover,
    .menu-lateral .list-group-item:focus {
        background-color: #e9ecef;
        color: #000;
    }

    .menu-lateral .list-group-item.active {
        border-left: 4px solid #EA1D2C;
        /* Cor principal iFood */
        background-color: #f7f7f7;
        font-weight: 700;
        color: #EA1D2C;
    }

    .menu-lateral .list-group-item i {
        margin-right: 12px;
        width: 20px;
    }

    /* Estilos para a área principal de conteúdo (usado para Perfil e Endereços) */
    .content-area {
        background-color: #fff;
        padding: 40px;
        /* Espaçamento interno generoso */
        border-radius: 8px;
        /* Cantos levemente arredondados */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        /* Sombra sutil para profundidade */
    }

    /* Estilos para cada cartão de endereço */
    .address-card {
        background-color: #f8f9fa;
        /* Fundo mais claro para se destacar do contêiner principal */
        border: 1px solid #e0e0e0;
        /* Borda sutil */
        border-radius: 6px;
        padding: 20px;
        margin-bottom: 20px;
        /* Espaçamento entre os cartões */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        /* Sombra mais leve para os cartões individuais */
    }

    .address-card h5 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 10px;
    }

    .address-card p {
        font-size: 1rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 0;
        /* Remove margem inferior padrão do parágrafo */
    }

    /* Estilos para os botões dentro dos cartões de endereço */
    .address-actions {
        display: flex;
        /* Garante que os botões fiquem lado a lado */
        gap: 10px;
        /* Espaçamento entre os botões */
        flex-wrap: wrap; /* Permite que os botões quebrem a linha se não houver espaço suficiente */
        justify-content: flex-end; /* Alinha os botões à direita por padrão */
    }
    .address-actions .btn {
        font-weight: 600;
        padding: 8px 15px;
        /* Padding adequado para botões dentro do cartão */
        border-radius: 5px;
        font-size: 0.9rem;
    }

    .address-actions .btn-outline-primary {
        color: #EA1D2C;
        border-color: #EA1D2C;
    }

    .address-actions .btn-outline-primary:hover {
        background-color: #EA1D2C;
        color: #fff;
    }

    .address-actions .btn-outline-danger {
        color: #dc3545;
        /* Vermelho padrão do Bootstrap */
        border-color: #dc3545;
    }

    .address-actions .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    /* Estilos para o botão "Adicionar Novo Endereço" */
    .btn-add-address {
        background-color: #EA1D2C;
        border-color: #EA1D2C;
        font-weight: 600;
        padding: 12px 25px;
        border-radius: 6px;
        margin-bottom: 25px;
        /* Espaçamento abaixo do botão */
    }

    .btn-add-address:hover {
        background-color: #e01b2a;
        border-color: #e01b2a;
    }


    /* --- Ajustes para Mobile --- */
    @media (max-width: 768px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Menu lateral em telas menores */
        .col-lg-3 {
            margin-bottom: 30px;
        }

        .menu-lateral {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .menu-lateral .list-group-item {
            padding: 12px 15px;
            font-size: 0.95rem;
        }

        /* Área principal do conteúdo */
        .content-area {
            padding: 25px 20px;
        }

        .content-area h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }

        /* Cartões de endereço em mobile */
        .address-card {
            padding: 15px;
        }

        .address-card h5 {
            font-size: 1.15rem;
        }

        .address-card p {
            font-size: 0.9rem;
        }

        .address-actions {
            /* flex-direction: column; REMOVIDO para manter os botões lado a lado */
            gap: 8px; /* Reduz um pouco o gap para telas menores */
            margin-top: 15px;
            justify-content: flex-start; /* Alinha os botões à esquerda no mobile */
            width: 100%; /* Garante que o container dos botões ocupe a largura total */
        }

        .address-actions .btn {
            /* width: 100%; REMOVIDO para que os botões fiquem lado a lado e se ajustem */
            flex-grow: 1; /* Permite que os botões cresçam para preencher o espaço, mas sem 100% */
            min-width: 90px; /* Garante um tamanho mínimo para cada botão */
            font-size: 0.85rem;
            padding: 10px 12px;
        }

        .btn-add-address {
            width: 100%;
            padding: 10px 15px;
            font-size: 0.95rem;
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
                    <a href="<?= site_url('conta') ?>" class="list-group-item list-group-item-action"><i class="bi bi-person-circle"></i> Meu Perfil</a>
                    <a href="<?= site_url('conta/pedidos') ?>" class="list-group-item list-group-item-action"><i class="bi bi-box-seam"></i> Meus Pedidos</a>
                    <a href="<?= site_url('conta/enderecos') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-geo-alt"></i> Meus Endereços</a>
                    <a href="<?= site_url('login/logout') ?>" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right"></i> Sair</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="content-area">
                <h2><?php echo esc($titulo); ?></h2>
                <hr>

                <?php if (session()->has('sucesso')): ?>
                    <div class="alert alert-success"><?php echo session('sucesso'); ?></div>
                <?php endif; ?>
                <?php if (session()->has('erro')): ?>
                    <div class="alert alert-danger"><?php echo session('erro'); ?></div>
                <?php endif; ?>

                <a href="<?php echo site_url('conta/enderecos/criar'); ?>" class="btn btn-primary btn-add-address">Adicionar Novo Endereço</a>

                <?php if (empty($enderecos)): ?>
                    <p class="alert alert-info">Você ainda não tem nenhum endereço cadastrado. Clique no botão acima para adicionar um!</p>
                <?php else: ?>
                    <div class="addresses-list">
                        <?php foreach ($enderecos as $endereco): ?>
                            <div class="address-card">
                                <div class="d-flex w-100 justify-content-between align-items-center flex-wrap">
                                    <div>
                                        <h5 class="mb-1"><?php echo esc($endereco->titulo); ?></h5>
                                        <p class="mb-1">
                                            <?php echo esc($endereco->logradouro); ?>, <?php echo esc($endereco->numero); ?> - <?php echo esc($endereco->bairro); ?><br>
                                            <?php echo esc($endereco->cidade); ?> - <?php esc($endereco->estado); ?>, CEP: <?php echo esc($endereco->cep); ?>
                                        </p>
                                        <?php if (!empty($endereco->complemento)): ?>
                                            <p class="text-muted"><small>Complemento: <?php echo esc($endereco->complemento); ?></small></p>
                                        <?php endif; ?>
                                        <?php if (!empty($endereco->referencia)): ?>
                                            <p class="text-muted"><small>Referência: <?php echo esc($endereco->referencia); ?></small></p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="address-actions text-nowrap mt-3 mt-sm-0">
                                        <a href="<?php echo site_url('conta/enderecos/editar/' . $endereco->id); ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                        <?php echo form_open("conta/enderecos/excluir/{$endereco->id}", ['class' => 'd-inline', 'onsubmit' => 'return confirm("Tem certeza que deseja excluir este endereço?");']); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                        <?php echo form_close(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<?php echo $this->endSection(); ?>