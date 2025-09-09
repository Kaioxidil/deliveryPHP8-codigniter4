<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SeuDelivery | <?=$this->renderSection('titulo')?></title>

    <link rel="shortcut icon" href="<?=site_url('admin/')?>images/favicon.png" />
    <link rel="stylesheet" href="<?=site_url('admin/')?>vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=site_url('admin/')?>vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=site_url('admin/')?>css/style.css">

    <!-- Essa section renderizará os estilos específicos da view que estender esse layout -->
    <?=$this->renderSection('estilos')?>
</head>

<body>
    <div class="container-scroller">

        <?=$this->renderSection('conteudo')?>

       
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?=site_url('admin/')?>vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="<?=site_url('admin/')?>js/off-canvas.js"></script>
    <script src="<?=site_url('admin/')?>js/hoverable-collapse.js"></script>
    <script src="<?=site_url('admin/')?>js/template.js"></script>
    
     <?=$this->renderSection('scripts')?>
</body>

</html>