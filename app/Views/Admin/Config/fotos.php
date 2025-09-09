<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    /* Estilos Gerais para um visual mais limpo e moderno */
    body {
        background-color: #f4f7f9;
        font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
    }
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
        color: #343a40;
        padding: 1.25rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .card-footer {
        background-color: #fff;
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 12px 12px !important;
        padding: 1.25rem;
    }

    /* Estilos específicos para as imagens de upload */
    .upload-image-preview {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 5px;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }
    .upload-image-preview:hover {
        border-color: #adb5bd;
    }

    /* Estilos para o input de arquivo */
    .form-control-file {
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .form-control-file:hover {
        background-color: #e9ecef;
    }
    .form-control-file::-webkit-file-upload-button {
        visibility: hidden;
    }
    .form-control-file::before {
        content: 'Escolher arquivo';
        display: inline-block;
        background: #007bff;
        color: white;
        border-radius: 5px;
        padding: 8px 12px;
        outline: none;
        white-space: nowrap;
        -webkit-user-select: none;
        cursor: pointer;
        font-weight: bold;
        font-size: 10pt;
        margin-right: 10px;
        transition: all 0.3s ease;
    }
    .form-control-file:hover::before {
        background: #0056b3;
    }

    /* Ajustes para os botões */
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        transition: all 0.3s ease;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        transition: all 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    /* Classes auxiliares */
    .text-center {
        text-align: center;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Foto de Perfil</h3>
            </div>
            <?= form_open_multipart('admin/empresa/uploadFotos') ?>
                <div class="card-body text-center">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $empresa->id ?>">
                    <input type="hidden" name="upload_type" value="profile">

                    <p class="text-muted"><strong>Foto de Perfil Atual:</strong></p>
                    <?php if ($empresa->foto_perfil): ?>
                        <img src="<?= site_url('uploads/' . $empresa->foto_perfil) ?>" alt="Foto de Perfil" class="upload-image-preview">
                    <?php else: ?>
                        <p class="text-muted">Nenhuma foto de perfil definida.</p>
                    <?php endif; ?>
                    
                    <hr class="my-4">
                    <div class="form-group">
                        <label for="foto_perfil_file" class="d-block mb-2">Enviar/Alterar Foto de Perfil:</label>
                        <input type="file" class="form-control-file" id="foto_perfil_file" name="foto_perfil_file" accept="image/*" required>
                        <small class="form-text text-muted">Máximo 2MB. Formatos: JPG, PNG.</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-upload"></i> Salvar Foto</button>
                    <?php if ($empresa->foto_perfil): ?>
                        <a href="<?= site_url('admin/empresa/deleteFoto/'. $empresa->id . '/foto_perfil') ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover a foto de perfil?');"><i class="mdi mdi-delete"></i> Remover</a>
                    <?php endif; ?>
                </div>
            <?= form_close() ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Banner da Empresa</h3>
            </div>
            <?= form_open_multipart('admin/empresa/uploadFotos') ?>
                <div class="card-body text-center">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id" value="<?= $empresa->id ?>">
                    <input type="hidden" name="upload_type" value="banner">
                    
                    <p class="text-muted"><strong>Banner Atual:</strong></p>
                    <?php if ($empresa->banner): ?>
                        <img src="<?= site_url('uploads/' . $empresa->banner) ?>" alt="Banner" class="upload-image-preview">
                    <?php else: ?>
                        <p class="text-muted">Nenhum banner definido.</p>
                    <?php endif; ?>
                    
                    <hr class="my-4">
                    <div class="form-group">
                        <label for="banner_file" class="d-block mb-2">Enviar/Alterar Banner:</label>
                        <input type="file" class="form-control-file" id="banner_file" name="banner_file" accept="image/*" required>
                        <small class="form-text text-muted">Máximo 5MB. Formatos: JPG, PNG.</small>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-upload"></i> Salvar Banner</button>
                    <?php if ($empresa->banner): ?>
                        <a href="<?= site_url('admin/empresa/deleteFoto/'. $empresa->id . '/banner') ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover o banner?');"><i class="mdi mdi-delete"></i> Remover</a>
                    <?php endif; ?>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-center">
        <a href="<?= site_url('admin/empresa/detalhes/' . $empresa->id) ?>" class="btn btn-secondary">
            <i class="mdi mdi-arrow-left"></i> Voltar para Detalhes da Empresa
        </a>
    </div>
</div>
<?= $this->endSection() ?>