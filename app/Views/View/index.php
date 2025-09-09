<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?>
    <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
    <style>
        /* Seus estilos existentes */

       .restaurent-details .container > .row > .col-md-12 {
        position: relative;
    }

    /* 2. Posiciona o logo de forma absoluta (AGORA NA DIREITA) */
    .restaurent-logo {
        width: 100px; 
        height: 100px; 
        overflow: hidden; 
        border-radius: 8px;
        background-color: #f8f8f8; 
        border: 4px solid white;
        
        /* Mágica do posicionamento - A ALTERAÇÃO ESTÁ AQUI */
        position: absolute;
        top: -50px; 
        right: 20px; /* Alterado de 'left' para 'right' */
        z-index: 2;

        display: flex;
        justify-content: center;
        align-items: center;
    }

    .restaurent-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* 3. Ajusta o container do nome e endereço (ESPAÇAMENTO ALTERADO) */
    .restaurent-details .heading {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-right: 130px; /* Adicionado para criar espaço à direita */
        padding-left: 0;      /* Removido o espaço da esquerda */
        padding-top: 15px;
    }

        .restaurent-details .heading {
            display: flex;
            flex-direction: column; /* agora empilha o nome e o endereço */
            align-items: flex-start;
        }

        .restaurent-details .heading h3 {
            margin-right: 10px; /* Adiciona um espaço à direita do título */
        }

    .restaurent-details .heading .badge {
        font-size: 1rem;
    }

        

        html, body { scroll-behavior: smooth; height: auto; min-height: 100vh; }
        .truncate-descricao { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; max-height: 3em; }
        .restaurent-menu ul.nav-pills { overflow-x: auto; white-space: nowrap; flex-wrap: nowrap; -webkit-overflow-scrolling: touch; padding-bottom: 5px; }
        .restaurent-menu ul.nav-pills::-webkit-scrollbar { height: 8px; }
        .restaurent-menu ul.nav-pills::-webkit-scrollbar-thumb { background-color: #ccc; border-radius: 4px; }
        .restaurent-menu ul.nav-pills::-webkit-scrollbar-track { background-color: #f1f1f1; }
        .main-content-wrapper { display: flex; justify-content: center; }
        .restaurent-meals .container-fluid { padding-left: 15px; padding-right: 15px; }
        @media (min-width: 992px) { .content-after-sticky-menu { padding-top: 0; } }
        .restaurent-meals .card-header { background-color: #f8f8f8; border-bottom: 1px solid #e0e0e0; padding: 15px 20px; border-top-left-radius: 8px; border-top-right-radius: 8px; }
        .restaurent-meals .card-body.no-padding { padding: 20px; }
        .restaurent-product-list { margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #eee; display: flex; align-items: center; }
        .restaurent-product-list:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .restaurent-product-detail { display: flex; width: 100%; text-decoration: none; color: inherit; }
        .restaurent-product-left { flex-grow: 1; padding-right: 15px; }
        .restaurent-product-img { flex-shrink: 0; width: 120px; height: 120px; border-radius: 8px; overflow: hidden; }
        .restaurent-product-img img { width: 100%; height: 100%; object-fit: cover; }
        .truncate-descricao { display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; -webkit-line-clamp: 2; }
        
    </style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>


<div class="page-banner p-relative smoothscroll" id="menu">
    <img src="<?php echo !empty($empresa->banner) ? site_url('uploads/' . $empresa->banner) : site_url('web/assets/img/banner.jpg'); ?>" class="img-fluid full-width" alt="Banner da empresa <?php echo esc($empresa->nome); ?>">
    
    <div class="overlay-2">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="back-btn">
                        <button type="button" class="text-light-green"> <i class="fas fa-chevron-left"></i></button>
                    </div>
                </div>
                <div class="col-6">
                    <div class="tag-share"> <span class="text-light-green share-tag"><i class="fas fa-chevron-right"></i></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="restaurent-details u-line">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                
                <div class="restaurent-logo">
                    <img src="<?php echo !empty($empresa->foto_perfil) ? site_url('uploads/' . $empresa->foto_perfil) : site_url('web/assets/seudelivery.png'); ?>" class="img-fluid" alt="Logo da empresa <?php echo esc($empresa->nome); ?>">
                </div>

                <div class="heading padding-tb-10">
                    <div>
                        <h3 class="text-light-black title fw-700 no-margin d-flex align-items-center">
                            <?= esc($empresa->nome); ?>
                            <?php if ($empresaEstaAberta): ?>
                                <?php if ($aceitandoPedidos): ?>
                                    <span class="badge badge-success ml-2">Aberto agora</span>
                                <?php else: ?>
                                    <span class="badge badge-warning ml-2" style="color: white;">Limite de pedidos atingido</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="badge badge-danger ml-2">Fechado</span>
                            <?php endif; ?>
                        </h3>
                    </div>

                    <p class="text-light-black sub-title no-margin mt-1">
                        <?= esc($enderecoExibido); ?>
                        <span><a href="<?= site_url('conta/enderecos'); ?>" class="text-success">Mudar localização</a></span>
                    </p>
                </div>

                <div class="restaurent-menu">
                    <ul class="nav nav-pills">
                        <?php foreach ($categorias as $cat): ?>
                        <li class="nav-item">
                            <a class="nav-link text-light-white fw-700" href="#category-<?= $cat->id; ?>"><?= esc($cat->nome); ?></a>
                        </li>
                        <?php endforeach; ?>
                        <li class="nav-item">
                            <a class="nav-link text-light-white fw-700" data-toggle="collapse" href="#aboutcollapse">Sobre</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light-white fw-700" data-toggle="collapse" href="#mapgallerycollapse">Mapa</a>
                        </li>
                    </ul>
                </div>

                </div>
        </div>
    </div>
</section>


<div class="container main-content-wrapper">
    <div class="row w-100">
        <div class="col-12">
            <div id="accordion" class="content-after-sticky-menu">

                <section class="section-padding restaurent-about collapse" id="aboutcollapse" data-parent="#accordion">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-light-black fw-700 title"><?= esc($empresa->nome); ?></h3>
                                <p class="text-light-white no-margin"><?= esc($empresa->descricao ?? 'Sem descrição disponível.'); ?></p>
                                <ul class="about-restaurent">
                                    <li> <i class="fas fa-map-marker-alt"></i><span><a href="#" class="text-light-white"><?= esc($empresa->logradouro ?? 'Endereço não informado'); ?>, <?= esc($empresa->numero ?? 's/n'); ?><br><?= esc($empresa->cidade ?? 'Cidade não informada'); ?>, <?= esc($empresa->estado ?? 'Estado não informado'); ?>, <?= esc($empresa->cep ?? 'CEP não informado'); ?></a></span></li>
                                    <li> <i class="fas fa-phone-alt"></i><span><a href="tel:<?= esc($empresa->telefone ?? ''); ?>" class="text-light-white"><?= esc($empresa->telefone ?? 'Telefone não informado'); ?></a></span></li>
                                    <li> <i class="far fa-envelope"></i><span><a href="mailto:<?= esc($empresa->email ?? ''); ?>" class="text-light-white"><?= esc($empresa->email ?? 'Email não informado'); ?></a></span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <div class="restaurent-schdule">
                                    <div class="card">
                                        <div class="card-header text-light-white fw-700 fs-16">Horários</div>
                                        <div class="card-body">
                                            <?php
                                                $diasSemana = [
                                                    'monday'    => 'Segunda-feira', 'tuesday'   => 'Terça-feira', 'wednesday' => 'Quarta-feira',
                                                    'thursday'  => 'Quinta-feira',  'friday'    => 'Sexta-feira',   'saturday'  => 'Sábado',
                                                    'sunday'    => 'Domingo',
                                                ];
                                            ?>
                                            <?php if (!empty($horarios)): ?>
                                                <?php foreach ($horarios as $dia => $periodo) : ?>
                                                    <div class="schedule-box">
                                                        <div class="day text-light-black"><?= esc($diasSemana[strtolower($dia)] ?? ucfirst($dia)); ?></div>
                                                        <div class="time text-light-black">Entrega: <?= esc($periodo); ?></div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p class="text-light-black">Horários não informados.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="section-padding restaurent-about collapse" id="mapgallerycollapse" data-parent="#accordion">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-light-black fw-700 title">Nossa Localização</h3>
                                <?php if(!empty($empresa->maps_iframe)): ?>
                                    <div style="max-width: 800px; margin: auto;">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <?php echo $empresa->maps_iframe; ?>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p>Localização no mapa não informada.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="section-padding restaurent-review collapse" id="reviewcollapse" data-parent="#accordion">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="section-header-left">
                                    <h3 class="text-light-black header-title title">Avaliações para <?= esc($empresa->nome); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <section class="section-padding restaurent-meals">
                <div class="container-fluid">
                    <div class="row">
                        <?php if (!empty($produtosPorCategoria)): ?>
                            <?php foreach ($produtosPorCategoria as $id_categoria => $data_categoria): ?>
                                <div class="col-lg-12 restaurent-meal-head mb-md-40 collapse show" id="category-<?= esc($id_categoria); ?>">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="section-header-left">
                                                <h3 class="text-light-black header-title"><?= esc($data_categoria['categoria']->nome); ?></h3>
                                            </div>
                                        </div>
                                        <div class="card-body no-padding">
                                            <div class="row">
                                                <?php foreach ($data_categoria['produtos'] as $produto): ?>
                                                    <div class="col-lg-12">
                                                        <div class="restaurent-product-list">
                                                            <a class="restaurent-product-detail" href="<?= site_url("produto/$produto->slug") ?>">
                                                                <div class="restaurent-product-left">
                                                                    <h6 class="text-light-black fw-600"><?= esc($produto->nome) ?></h6>
                                                                    <p class="text-light-white truncate-descricao"><?= esc($produto->descricao) ?></p>
                                                                    <p class="text-success fw-600 no-margin">
                                                                        A partir de R$ <?= number_format($produto->preco, 2, ',', '.') ?>
                                                                    </p>
                                                                </div>
                                                                <div class="restaurent-product-img">
                                                                    <?php
                                                                        $imagemPath = site_url('admin/images/sem-imagem.jpg');
                                                                        if (!empty($produto->imagem)) {
                                                                            $imagemPath = site_url('home/imagemProduto/' . $produto->imagem);
                                                                        }
                                                                    ?>
                                                                    <img src="<?= $imagemPath; ?>" class="img-fluid" alt="<?= esc($produto->nome); ?>">
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-lg-12 text-center">
                                <p class="text-light-black">Nenhuma categoria com produtos disponível.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<?php echo $this->endSection(); ?>