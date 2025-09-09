<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    /* ---------------------------------------------------- */
    /* Estilos Customizados para um Dashboard Moderno e Limpo */
    /* Versão Aprimorada sem Efeitos de Hover Flutuante */
    /* ---------------------------------------------------- */

    body {
        background-color: #f0f2f5; /* Fundo mais suave e moderno */
        font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
    }

    /* Cards e Layout */
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Sombra suave e elegante */
        transition: box-shadow 0.3s ease; /* Transição apenas na sombra */
    }
    .card:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12); /* Sombra um pouco mais forte no hover, sem movimento */
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        border-bottom: 1px solid #e9ecef;
        background-color: #fff;
    }
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Informações Detalhadas */
    .info-group {
        margin-bottom: 1.5rem;
    }
    .info-label {
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 8px;
        font-size: 0.95em;
    }
    .info-data {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        font-size: 1em;
        color: #343a40;
        word-wrap: break-word;
        min-height: 50px;
        display: flex;
        align-items: center;
        transition: border-color 0.3s ease;
    }
    .info-data:hover {
        border-color: #adb5bd; /* Mantém a transição sutil na borda */
    }
    .info-data i {
        color: #007bff;
        margin-right: 10px;
    }

    /* Imagens de Perfil */
    .profile-image-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 20px;
    }
    .profile-image-circle {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 6px solid #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transition: none; /* Remove a transição de rotação */
    }
    .profile-image-circle:hover {
        transform: none; /* Remove a animação de rotação e escala */
    }
    
    /* Abas de Navegação */
    .nav-tabs {
        border-bottom: 2px solid #e9ecef;
    }
    .nav-tabs .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 600;
        color: #adb5bd;
        margin-right: 15px;
        padding: 15px 0;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link:hover {
        color: #495057;
    }
    .nav-tabs .nav-link.active {
        color: #007bff;
        border-bottom-color: #007bff;
        background-color: transparent;
    }
    .tab-content {
        padding-top: 30px;
    }

    /* Estilo para os Horários */
    .list-group-item {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        transition: background-color 0.3s ease, transform 0.3s ease; /* Remove o hover de flutuar */
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .list-group-item:hover {
        background-color: #f8f9fa; /* Mantém a mudança de cor, mas sem o movimento */
        transform: none;
        box-shadow: none;
    }
    .list-group-item.current-day {
        background-color: #e7f3ff;
        border-color: #007bff;
        font-weight: 700;
        color: #007bff;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
    }
    .list-group-item .badge {
        font-size: 0.9em;
        padding: 8px 16px;
        border-radius: 20px;
        background-color: #007bff;
        color: white;
    }
    .list-group-item.current-day .badge {
        background-color: #0056b3;
    }

    /* Botões de Redes Sociais */
    .social-btn {
        font-size: 1.8rem;
        margin-right: 15px;
        transition: color 0.2s ease; /* Remove o transform do hover */
    }
    .social-btn:hover {
        transform: none; /* Remove a animação de escala */
        color: #007bff; /* Adiciona um sutil efeito de cor no hover */
    }
    .social-btn.facebook { color: #3b5998; }
    .social-btn.instagram { color: #e1306c; }

    /* Estilo para o Status (melhorado) */
    /* .status-container {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 1.1em;
    }
    .status-badge {
        width: 15px;
        height: 15px;
        border-radius: 50%;
    }
    .status-active {
        background-color: #28a745;
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 1);
        animation: pulse-green 2s infinite;
    }
    .status-inactive {
        background-color: #dc3545;
    }
    @keyframes pulse-green {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
    } */
    .orders-limit {
        padding: 15px;
        border-radius: 8px;
        background-color: #f1f7f9;
        border: 1px solid #ced4da;
        color: #343a40;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white header-content">
                <div>
                    <h4 class="m-0 text-primary"><i class="mdi mdi-store mr-2"></i><?= esc($empresa->nome) ?></h4>
                    <p class="m-0 text-muted">Detalhes e Gerenciamento da Empresa</p>
                </div>
                <a href="<?= site_url('admin/empresa/form/' . $empresa->id) ?>" class="btn btn-primary btn-lg mt-2 mt-md-0"><i class="mdi mdi-pencil-outline mr-2"></i> Editar Informações</a>
            </div>

            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="principal-tab" data-toggle="tab" href="#principal" role="tab" aria-controls="principal" aria-selected="true"><i class="mdi mdi-store"></i> Principal</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="endereco-tab" data-toggle="tab" href="#endereco" role="tab" aria-controls="endereco" aria-selected="false"><i class="mdi mdi-map-marker"></i> Endereço</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="horarios-tab" data-toggle="tab" href="#horarios" role="tab" aria-controls="horarios" aria-selected="false"><i class="mdi mdi-clock-outline"></i> Horários</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    
                    <div class="tab-pane fade show active" id="principal" role="tabpanel" aria-labelledby="principal-tab">
                        <div class="row">
                            <div class="col-md-4 d-flex flex-column align-items-center justify-content-center text-center profile-image-container">
                                <img src="<?= $empresa->foto_perfil ? site_url('uploads/' . $empresa->foto_perfil) : site_url('web/assets/seudelivery.png') ?>" alt="Foto de Perfil" class="profile-image-circle mb-4">
                                <a href="<?= site_url('admin/empresa/fotos/' . $empresa->id) ?>" class="btn btn-outline-secondary btn-block"><i class="mdi mdi-image-multiple mr-2"></i> Gerenciar Fotos</a>
                            </div>
                            <div class="col-md-8 mt-4 mt-md-0">
                                <div class="row">
                                    
                                    <div class="col-md-6 info-group">
                                        <label class="info-label">Faixa de Preço</label>
                                        <div class="info-data font-weight-bold"><i class="mdi mdi-currency-usd"></i><?= esc($empresa->faixa_preco ?? 'N/A') ?></div>
                                    </div>

                                    <div class="col-md-6 info-group">
                                        <label class="info-label">Status da Empresa</label>
                                        <div class="info-data">
                                            <i class="mdi <?= esc($empresa->ativo == 1 ? 'mdi-check-circle-outline text-success' : 'mdi-close-circle-outline text-danger') ?>"></i>
                                            <?= esc($empresa->ativo == 1 ? 'Ativa' : 'Inativa') ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6 info-group"><label class="info-label">E-mail</label><div class="info-data"><i class="mdi mdi-email-outline"></i><?= esc($empresa->email ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 info-group"><label class="info-label">Telefone Fixo</label><div class="info-data"><i class="mdi mdi-phone"></i><?= esc($empresa->telefone ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 info-group"><label class="info-label">Celular / WhatsApp</label><div class="info-data"><i class="mdi mdi-whatsapp"></i><?= esc($empresa->celular ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 info-group">
                                        <label class="info-label">Redes Sociais</label>
                                        <div class="info-data d-flex align-items-center">
                                            <?php if($empresa->link_facebook): ?><a href="<?= esc($empresa->link_facebook) ?>" target="_blank" class="social-btn facebook"><i class="mdi mdi-facebook"></i></a><?php endif; ?>
                                            <?php if($empresa->link_instagram): ?><a href="<?= esc($empresa->link_instagram) ?>" target="_blank" class="social-btn instagram"><i class="mdi mdi-instagram"></i></a><?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-12 info-group">
                                        <label class="info-label">Pedidos por Hora</label>
                                        <div class="orders-limit">
                                            <?php if ($empresa->pedidos_por_hora > 0): ?>
                                                <i class="mdi mdi-timer-sand icon-color"></i> Limite de <strong><?= esc($empresa->pedidos_por_hora) ?></strong> pedidos por hora.
                                            <?php else: ?>
                                                <i class="mdi mdi-timer-off icon-color"></i> Sem limite de pedidos por hora.
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="endereco" role="tabpanel" aria-labelledby="endereco-tab">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-8 info-group"><label class="info-label">Logradouro</label><div class="info-data"><?= esc($empresa->logradouro ?? 'N/A') ?></div></div>
                                    <div class="col-md-4 info-group"><label class="info-label">Número</label><div class="info-data"><?= esc($empresa->numero ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 info-group"><label class="info-label">Bairro</label><div class="info-data"><?= esc($empresa->bairro ?? 'N/A') ?></div></div>
                                    <div class="col-md-6 info-group"><label class="info-label">Cidade</label><div class="info-data"><?= esc($empresa->cidade ?? 'N/A') ?></div></div>
                                    <div class="col-md-4 info-group"><label class="info-label">CEP</label><div class="info-data"><?= esc($empresa->cep ?? 'N/A') ?></div></div>
                                    <div class="col-md-2 info-group"><label class="info-label">UF</label><div class="info-data"><?= esc($empresa->estado ?? 'N/A') ?></div></div>
                                </div>
                            </div>
                            <div class="col-md-5 mt-4 mt-md-0">
                                <div class="info-group">
                                    <label class="info-label">Localização no Mapa</label>
                                    <?php if($empresa->maps_iframe): ?>
                                        <div class="embed-responsive embed-responsive-16by9 border rounded-lg overflow-hidden shadow-sm">
                                            <?= $empresa->maps_iframe ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="alert alert-info text-center" style="height: 100%; display: flex; align-items: center; justify-content: center; margin-bottom: 0;">Nenhum mapa cadastrado.</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
                        <p class="text-muted">Horários de funcionamento para entregas e atendimento. O dia atual está destacado para facilitar a visualização.</p>
                        <?php 
                            $dia_atual = strtolower(date('l'));
                        ?>
                        <?php if (!empty($empresa->horarios_array)): ?>
                            <ul class="list-group list-group-flush">
                                <?php $dias_semana = ['monday' => 'Segunda-feira', 'tuesday' => 'Terça-feira', 'wednesday' => 'Quarta-feira', 'thursday' => 'Quinta-feira', 'friday' => 'Sexta-feira', 'saturday' => 'Sábado', 'sunday' => 'Domingo']; ?>
                                <?php foreach($dias_semana as $key => $dia): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center <?= ($key === $dia_atual) ? 'current-day' : '' ?>">
                                        <div class="day-name"><?= $dia ?></div>
                                        <span class="badge"><?= esc($empresa->horarios_array[$key] ?? 'Fechado') ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="alert alert-warning text-center">Horários de funcionamento não cadastrados.</div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>