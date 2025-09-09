<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    /* Reset e ajustes gerais para um visual mais clean */
    body {
        background-color: #f4f7f9;
    }

    /* Card principal */
    .card {
        border-radius: 12px;
        border: none;
    }

    /* Estilos para o cabeçalho e informações */
    .info-label { 
        font-weight: 600; 
        color: #6c757d; 
        margin-bottom: 5px; 
        font-size: 0.95em; 
    }
    .info-data { 
        background-color: #e9ecef; 
        padding: 12px 15px; 
        border-radius: 8px; 
        border: 1px solid #dee2e6; 
        font-size: 1em; 
        color: #495057; 
        word-wrap: break-word; 
        min-height: 48px; 
        display: flex; 
        align-items: center; 
        transition: all 0.3s ease;
    }
    .info-data:hover {
        border-color: #adb5bd;
    }
    
    /* Estilos específicos para o status de integração */
    .integration-status .badge-success { 
        background-color: #28a745; 
        color: white; 
        font-size: 0.9em;
        padding: 6px 12px;
        border-radius: 20px;
    }
    .integration-status .badge-danger { 
        background-color: #dc3545; 
        color: white; 
        font-size: 0.9em;
        padding: 6px 12px;
        border-radius: 20px;
    }

    /* Estilos para a barra lateral de navegação */
    .list-group {
        border: none;
    }
    .list-group-item { 
        cursor: pointer; 
        border: none; 
        border-radius: 8px; 
        margin-bottom: 8px;
        font-weight: 500;
        color: #6c757d;
        transition: background-color 0.3s ease, color 0.3s ease;
        padding: 12px 15px;
    }
    .list-group-item:hover {
        background-color: #e9ecef;
    }
    .list-group-item.active { 
        background-color: #007bff; 
        border-color: #007bff; 
        color: #fff; /* O texto do item agora fica branco */
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.2);
    }
    .list-group-item.active .mdi { 
        color: #fff; /* Garante que o ícone também fique branco */
    }
    .list-group-item .mdi { 
        color: #007bff; 
        margin-right: 12px;
        font-size: 1.2em;
        transition: color 0.3s ease;
    }
    .list-group-item:hover .mdi {
        color: #0056b3;
    }
    
    /* Estilos para o conteúdo principal */
    .content-pane {
        padding-left: 20px; /* Adiciona espaçamento entre a sidebar e o conteúdo */
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center" style="border-radius: 12px 12px 0 0;">
                <div>
                    <h4 class="m-0"><?= esc($title) ?></h4>
                    <p class="m-0 text-muted">Configurações das integrações</p>
                </div>
                <a href="<?= site_url('admin/integracoes/form/' . $integracao->id) ?>" class="btn btn-primary"><i class="mdi mdi-pencil"></i> Editar</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="list-group" id="integracoes-sidebar" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="meta-link" data-target="meta-content" role="tab" aria-controls="meta-content" aria-selected="true">
                                <i class="mdi mdi-facebook-box"></i> Meta Pixel
                            </a>
                            <a class="list-group-item list-group-item-action" id="google-link" data-target="google-content" role="tab" aria-controls="google-content" aria-selected="false">
                                <i class="mdi mdi-google-analytics"></i> Google Analytics
                            </a>
                            <a class="list-group-item list-group-item-action" id="instagram-link" data-target="instagram-content" role="tab" aria-controls="instagram-content" aria-selected="false">
                                <i class="mdi mdi-instagram"></i> Instagram (Fotos)
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div id="integracoes-conteudo">

                            <div id="meta-content" class="content-pane">
                                <h5 class="mb-3">Configurações do Meta Pixel</h5>
                                <div class="form-group">
                                    <label class="info-label">ID do Pixel</label>
                                    <div class="info-data"><?= esc($integracao->meta_pixel_id ?? 'Não configurado') ?></div>
                                </div>
                                <div class="form-group integration-status">
                                    <label class="info-label">Status</label>
                                    <div class="info-data">
                                        <?php if ($integracao->meta_pixel_id): ?>
                                            <span class="badge badge-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Inativo</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div id="google-content" class="content-pane d-none">
                                <h5 class="mb-3">Configurações do Google Analytics</h5>
                                <div class="form-group">
                                    <label class="info-label">ID de Medição</label>
                                    <div class="info-data"><?= esc($integracao->google_analytics_id ?? 'Não configurado') ?></div>
                                </div>
                                <div class="form-group integration-status">
                                    <label class="info-label">Status</label>
                                    <div class="info-data">
                                        <?php if ($integracao->google_analytics_id): ?>
                                            <span class="badge badge-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Inativo</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div id="instagram-content" class="content-pane d-none">
                                <h5 class="mb-3">Configurações do Instagram (Fotos)</h5>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label class="info-label">Access Token</label>
                                        <div class="info-data"><?= esc(substr($integracao->instagram_access_token ?? 'Não configurado', 0, 30)) . '...' ?></div>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="info-label">Business ID</label>
                                        <div class="info-data"><?= esc($integracao->instagram_business_id ?? 'Não configurado') ?></div>
                                    </div>
                                </div>
                                <div class="form-group integration-status">
                                    <label class="info-label">Status</label>
                                    <div class="info-data">
                                        <?php if ($integracao->instagram_access_token && $integracao->instagram_business_id): ?>
                                            <span class="badge badge-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Inativo</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('integracoes-sidebar');
        
        sidebar.addEventListener('click', function(e) {
            e.preventDefault();
            const targetLink = e.target.closest('.list-group-item');
            if (!targetLink) {
                return;
            }

            // Remove a classe 'active' de todos os links e adiciona ao link clicado
            document.querySelectorAll('.list-group-item').forEach(link => {
                link.classList.remove('active');
            });
            targetLink.classList.add('active');

            // Oculta todos os painéis de conteúdo e exibe o painel correspondente
            document.querySelectorAll('.content-pane').forEach(pane => {
                pane.classList.add('d-none');
            });

            const targetContentId = targetLink.getAttribute('data-target');
            document.getElementById(targetContentId).classList.remove('d-none');
        });
    });
</script>
<?= $this->endSection() ?>