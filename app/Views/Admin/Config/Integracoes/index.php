<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="alert alert-info">Nenhuma configuração de integração encontrada. Por favor, adicione uma.</div>
<a href="<?= site_url('admin/integracoes/form') ?>" class="btn btn-primary"><i class="mdi mdi-plus"></i> Configurar Integrações</a>
<?= $this->endSection() ?>