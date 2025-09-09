<?php echo $this->extend('layout/principal'); ?>

<?php echo $this->section('titulo'); ?>
    <?php echo $titulo; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>

<?php if (!empty($integracao) && !empty($integracao->meta_pixel_id)): ?>
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '<?= esc($integracao->meta_pixel_id) ?>');
  fbq('track', 'PageView');
</script>
<noscript>
  <img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=<?= esc($integracao->meta_pixel_id) ?>&ev=PageView&noscript=1"/>
</noscript>
<?php endif; ?>

<?php if (!empty($integracao) && !empty($integracao->google_analytics_id)): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= esc($integracao->google_analytics_id) ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', '<?= esc($integracao->google_analytics_id) ?>');
    </script>
<?php endif; ?>


<style>
/* DOCUMENTAÇÃO DOS ESTILOS:
  - Usamos variáveis CSS (:root) para facilitar a mudança de cores do site.
  - Adicionamos um estilo para o novo banner (Hero Section).
  - Refinamos os cards, sombras, títulos e botões para um visual mais limpo.
*/

:root {
    --cor-primaria: #28a745; /* Verde principal */
    --cor-secundaria: #dc3545; /* Vermelho para badges */
    --cor-texto: #333;
    --cor-fundo-claro: #f8f9fa;
    --sombra-suave: 0 8px 16px rgba(0,0,0,0.08);
    --sombra-hover: 0 16px 24px rgba(0,0,0,0.12);
    --borda-radius: 12px;
}


/* --- ESTILOS REFINADOS --- */

/* Ajuste de altura e alinhamento dos slides */
.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: stretch;
    height: auto !important;
    padding-bottom: 15px; /* Espaço para a sombra não ser cortada */
}

/* Card com design aprimorado */
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
    border: none; /* Remove a borda padrão */
    border-radius: var(--borda-radius);
    box-shadow: var(--sombra-suave);
    overflow: hidden; /* Garante que a imagem arredondada não vaze */
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: var(--sombra-hover);
}

.card-body {
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    padding: 1.5rem;
}

/* Empurra o preço para a base do card */
.card-body .text-success {
    margin-top: auto;
    font-size: 1.2rem;
}

.card-img-top {
    border-top-left-radius: var(--borda-radius);
    border-top-right-radius: var(--borda-radius);
}

/* Títulos dos produtos e descrição */
.product-title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    -webkit-line-clamp: 2;
    line-height: 1.4em;
    max-height: 2.8em;
    word-wrap: break-word;
    margin-bottom: 0.5rem;
}

.truncate-descricao {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    -webkit-line-clamp: 2;
    line-height: 1.5em;
    max-height: 3em;
    margin-bottom: 1rem;
}

/* Estilo para as categorias */
.categories {
    text-align: center;
    text-decoration: none;
    transition: transform 0.3s ease;
}

.categories:hover {
    transform: scale(1.08);
}

.categories .icon {
    border-radius: 50%;
    margin: 0 auto 10px auto;
    box-shadow: var(--sombra-suave);
    width: 125px;
    height: 125px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white !important;
}

.categories .cat-name {
    font-weight: 500;
    color: var(--cor-texto);
}

/* Estilização dos títulos das seções */
.header-title {
    position: relative;
    padding-bottom: 15px;
    margin-bottom: 30px;
    font-weight: 700;
}
.header-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background-color: var(--cor-primaria);
    border-radius: 2px;
}

/* Estilização dos botões e paginação do Swiper */
.swiper-container {
    padding: 20px 0 40px 0;
}

.swiper-button-next,
.swiper-button-prev {
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    width: 44px;
    height: 44px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: background-color 0.3s ease;
}
.swiper-button-next:hover,
.swiper-button-prev:hover {
    background-color: white;
}
.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--cor-primaria);
}

.swiper-pagination-bullet-active {
    background: var(--cor-primaria);
}

</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>



<section class="browse-cat u-line section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="text-light-black header-title">Nossas Categorias <span class="fs-14 fw-normal"><a href="<?= site_url('/Vizualizar') ?>">Ver todas</a></span></h3>
            </div>
            <div class="col-12">
                <div class="category-slider swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($categoria as $cat): ?>
                            <div class="swiper-slide">
                                <a href="<?= site_url('Vizualizar') . '#category-' . $cat->id ?>" class="categories">
                                    <div class="icon">
                                        <?php if ($cat->imagem): ?>
                                            <img src="<?= site_url("home/imagemCategoria/" . $cat->imagem) ?>"
                                                 class="rounded-circle"
                                                 style="width: 125px; height: 125px; object-fit: cover;"
                                                 alt="<?= esc($cat->nome) ?>">
                                        <?php else: ?>
                                            <img src="<?= site_url('admin/images/sem-foto.jpg') ?>"
                                                 class="rounded-circle"
                                                 style="width: 125px; height: 125px; object-fit: cover;"
                                                 alt="Categoria sem imagem">
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-light-black cat-name"><?= esc($cat->nome) ?></span>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-padding restaurent-meals section-bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h3 class="text-light-black header-title">🔥 Mais Vendidos <span class="fs-14 fw-normal"><a href="<?= site_url('/Vizualizar') ?>">Ver todos</a></span></h3>
            </div>
            <div class="col-12">
                <?php if (!empty($maisVendidos)): ?>
                    <div class="swiper-container mais-vendidos-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($maisVendidos as $produto): ?>
                                <div class="swiper-slide">
                                    <div class="card text-center">
                                        <a href="<?= site_url("produto/$produto->slug") ?>" class="text-decoration-none">
                                            <div class="position-relative">
                                                <?php
                                                  $imagemPath = !empty($produto->imagem) 
                                                      ? site_url('home/imagemProduto/' . $produto->imagem) 
                                                      : site_url('admin/images/sem-imagem.jpg');
                                                ?>
                                                <img src="<?= $imagemPath; ?>" class="card-img-top" alt="<?= esc($produto->nome); ?>" style="height:220px; object-fit:cover;">
                                                <span class="badge bg-danger position-absolute top-0 start-0 m-3 fs-6">Mais vendido</span>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-title text-dark fw-bold product-title"><?= esc($produto->nome) ?></h6>
                                                <p class="text-muted small truncate-descricao"><?= esc($produto->descricao) ?></p>
                                                <p class="text-success fw-bold">R$ <?= number_format($produto->preco, 2, ',', '.') ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                <?php else: ?>
                    <p class="text-center text-light-black">Nenhum produto mais vendido disponível.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="text-light-black header-title">🆕 Últimos Adicionados <span class="fs-14 fw-normal"><a href="<?= site_url('/Vizualizar') ?>">Ver todos</a></span></h3>
            </div>
            <div class="col-12">
                <?php if (!empty($ultimosProdutos)): ?>
                    <div class="swiper-container ultimos-adicionados-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($ultimosProdutos as $produto): ?>
                                <div class="swiper-slide">
                                    <div class="card text-center">
                                        <a href="<?= site_url("produto/$produto->slug") ?>" class="text-decoration-none">
                                            <div class="position-relative">
                                                 <?php
                                                    $imagemPath = !empty($produto->imagem) 
                                                        ? site_url('home/imagemProduto/' . $produto->imagem) 
                                                        : site_url('admin/images/sem-imagem.jpg');
                                                ?>
                                                <img src="<?= $imagemPath; ?>" class="card-img-top" alt="<?= esc($produto->nome); ?>" style="height:220px; object-fit:cover;">
                                                <span class="badge bg-success position-absolute top-0 start-0 m-3 fs-6">Novo</span>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="card-title text-dark fw-bold product-title"><?= esc($produto->nome) ?></h6>
                                                <p class="text-muted small truncate-descricao"><?= esc($produto->descricao) ?></p>
                                                <p class="text-success fw-bold">R$ <?= number_format($produto->preco, 2, ',', '.') ?></p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                <?php else: ?>
                    <p class="text-center text-light-black">Nenhum produto adicionado recentemente.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                 <a href="<?= site_url('/Vizualizar') ?>" class="btn btn-success btn-lg">Ver Todos os Produtos</a>
            </div>
        </div>

    </div>
</section>

<hr>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<script>
/*
  DOCUMENTAÇÃO DO SCRIPT:
  - Adicionamos a inicialização para o slider de categorias que estava faltando.
  - Ajustamos os 'breakpoints' para mostrar mais categorias em telas maiores.
  - Mantivemos os sliders de produtos como estavam, pois a configuração é ótima.
*/

// NOVO: Inicializa o slider de Categorias
var categorySwiper = new Swiper(".category-slider", {
    slidesPerView: 2,
    spaceBetween: 15,
    loop: false, // Loop não é ideal para categorias, a menos que tenha muitas
    navigation: {
      nextEl: ".category-slider .swiper-button-next",
      prevEl: ".category-slider .swiper-button-prev",
    },
    breakpoints: {
      576: { slidesPerView: 3 },
      768: { slidesPerView: 4 },
      992: { slidesPerView: 6 },
      1200: { slidesPerView: 7 },
    }
});

// Inicializa o slider de "Mais Vendidos"
var maisVendidosSwiper = new Swiper(".mais-vendidos-swiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    grabCursor: true,
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".mais-vendidos-swiper .swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".mais-vendidos-swiper .swiper-button-next",
      prevEl: ".mais-vendidos-swiper .swiper-button-prev",
    },
    breakpoints: {
      640: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
      1400: { slidesPerView: 4 },
    }
});

// Inicializa o slider de "Últimos Adicionados"
var ultimosAdicionadosSwiper = new Swiper(".ultimos-adicionados-swiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    grabCursor: true,
    loop: true,
    autoplay: {
      delay: 4500,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".ultimos-adicionados-swiper .swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".ultimos-adicionados-swiper .swiper-button-next",
      prevEl: ".ultimos-adicionados-swiper .swiper-button-prev",
    },
    breakpoints: {
      640: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
      1400: { slidesPerView: 4 },
    }
});
</script>

<?php echo $this->endSection(); ?>