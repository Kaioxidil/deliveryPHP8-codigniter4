<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    /* Estilos do formulário */
</style>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h4 class="m-0"><?= esc($title) ?></h4>
            </div>

            <div class="card-body">
                <?= form_open('admin/integracoes/save') ?>

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if ($integracao): ?>
                    <input type="hidden" name="id" value="<?= esc($integracao->id) ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <h5>Meta Pixel</h5>
                        <div class="form-group">
                            <label for="meta_pixel_id">ID do Pixel</label>
                            <input type="text" class="form-control" name="meta_pixel_id" id="meta_pixel_id" value="<?= old('meta_pixel_id', $integracao->meta_pixel_id ?? '') ?>">
                            <small class="form-text text-muted">Ex: 1234567890</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <h5>Google Analytics</h5>
                        <div class="form-group">
                            <label for="google_analytics_id">ID de Medição</label>
                            <input type="text" class="form-control" name="google_analytics_id" id="google_analytics_id" value="<?= old('google_analytics_id', $integracao->google_analytics_id ?? '') ?>">
                            <small class="form-text text-muted">Ex: G-XXXXXXXXXX</small>
                        </div>
                    </div>

                    <div class="col-12"><hr></div>

                    <div class="col-12 mb-4">
                        <h5>Instagram</h5>
                        <p class="text-muted">Integração para exibir fotos do perfil.</p>
                        <div class="form-group">
                            <label for="instagram_access_token">Access Token</label>
                            <input type="text" class="form-control" name="instagram_access_token" id="instagram_access_token" value="<?= old('instagram_access_token', $integracao->instagram_access_token ?? '') ?>">
                            <small class="form-text text-muted">Token gerado na plataforma de desenvolvedores do Facebook/Meta.</small>
                        </div>
                        <div class="form-group">
                            <label for="instagram_business_id">Business ID</label>
                            <input type="text" class="form-control" name="instagram_business_id" id="instagram_business_id" value="<?= old('instagram_business_id', $integracao->instagram_business_id ?? '') ?>">
                            <small class="form-text text-muted">ID da sua conta comercial no Instagram.</small>
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save"></i> Salvar</button>
                    <a href="<?= site_url('admin/integracoes/detalhes/' . ($integracao->id ?? '')) ?>" class="btn btn-secondary">Cancelar</a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <?= $this->endSection() ?>