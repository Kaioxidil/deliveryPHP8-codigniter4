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
.truncate-descricao {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    max-height: 3em;
    -webkit-line-clamp: 2;
    line-height: 1.5em;
}

.product-title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    line-height: 1.4em;
    max-height: 2.8em;
    word-wrap: break-word;
    word-break: break-word;
}

.product-title a {
    display: block;
    word-wrap: break-word;
    word-break: break-word;
}

.cat-name {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    -webkit-line-clamp: 2;
    line-height: 1.3em;
    max-height: 2.6em;
    word-wrap: break-word;
    word-break: break-word;
    text-align: center;
}



/* Container do rótulo do produto */
.product-label {
    position: absolute; /* Posiciona o elemento de forma absoluta */
    bottom: 20px; /* Distância da parte inferior */
    left: 20px; /* Distância da esquerda */
}

/* Estilo do botão de categoria (o texto) */
.category-btn {
    background-color: rgba(200, 200, 200, 0.6);
    color: #fff; 
    padding: 8px 12px; 
    border-radius: 5px; 
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase; 
}
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<section class="browse-cat u-line section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header-left">
                    <h3 class="text-light-black header-title title">Categorias <span class="fs-14"><a href="<?= site_url('/Vizualizar') ?>">Ver mais</a></span></h3>
                </div>
            </div>
            <div class="col-12">
                <div class="category-slider swiper-container">
                    <div class="swiper-wrapper">
                        <?php foreach ($categoria as $cat): ?>
                            <div class="swiper-slide">
                                <a href="<?= site_url('Vizualizar') . '#category-' . $cat->id ?>" class="categories">
                                    <div class="icon text-custom-white bg-light-green">
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

<section class="ex-collection section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-header-left">
                    <h3 class="text-light-black header-title title">Explore nossos produtos</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <?php if (!empty($produtos)): ?>
                <?php
                $count = 0;
                foreach ($produtos as $produto):
                    if ($produto->imagem && $count < 2):
                        $count++;
                ?>
                        <div class="col-md-6">
                            <div class="ex-collection-box mb-xl-20 position-relative overflow-hidden">
                                <a href="<?= site_url("produto/$produto->slug") ?>">
                                    <img src="<?= site_url('home/imagemProduto/' . $produto->imagem); ?>" class="img-fluid full-width" style="max-height: 200px; object-fit: cover;" alt="<?= esc($produto->nome); ?>">
                                    <div class="product-label">
                                        <span class="category-btn"><?= esc($produto->nome); ?></span>
                                    </div>
                                </a>
                            </div>
                        </div>
                <?php
                    endif;
                endforeach;
                ?>
            <?php else: ?>
                <div class="col-12"></div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-8">
                <div class="row">
                    <?php if (!empty($produtos)): ?>
                        <?php
                        $count = 0; 
                        foreach ($produtos as $produto):
                            if ($count >= 8) { break; }
                        ?>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="product-box mb-xl-20">
                                    <div class="product-img">
                                        <a href="<?= site_url("produto/$produto->slug") ?>">
                                            <?php
                                            $imagemPath = site_url('admin/images/sem-imagem.jpg'); 
                                            if ($produto->imagem && !empty($produto->imagem)) {
                                                $imagemPath = site_url('home/imagemProduto/' . $produto->imagem);
                                            }
                                            ?>
                                            <img src="<?= $imagemPath ?>" class="img-fluid full-width" alt="<?= esc($produto->nome) ?>">
                                        </a>
                                        
                                    </div>
                                    <div class="product-caption">
                                        <div class="title-box">
                                            <h6 class="product-title">
                                                <a href="<?= site_url("produto/$produto->slug") ?>" class="text-light-black">
                                                    <?= esc($produto->nome) ?>
                                                </a>
                                            </h6>
                                        </div>
                                        <p class="text-light-white truncate-descricao">
                                            <?= esc($produto->descricao ?? $produto->categoria) ?>
                                        </p>
                                        <div class="product-details">
                                            <div class="price-time" style="display: flex; flex-direction: column; align-items: flex-start;">
                                                
                                                <a href="<?= site_url("produto/$produto->slug") ?>" class="btn btn-sm mt-2" style="background-color: #dc3545; color: white; border-color: #dc3545;">Mais detalhes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        $count++; 
                        endforeach;
                        ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p>Nenhum produto encontrado no momento.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-12 text-center mt-4">
            <a href="<?= site_url('/Vizualizar') ?>" class="btn btn-outline-danger">
                <i class="fas fa-store"></i> Ver mais do estabelecimento
            </a>
        </div>

    </div>
</section>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>


<?php echo $this->endSection(); ?>