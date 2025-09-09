<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?= $titulo ?? 'Painel do Entregador' ?></title>
    
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    /* Cores inspiradas no iFood */
:root {
    --bg-color: #f0f0f0;
    --container-bg: #ffffff;
    --text-color: #333333;
    --header-color: #ea1d2c;
    --secondary-header-color: #d84315;
    --border-color: #eeeeee;
    --table-header-bg: #ea1d2c;
    --table-header-text: #fff;
    --button-primary-bg: #1e88e5;
    --button-secondary-bg: #ffc107;
    --modal-bg: #fefefe;
    --modal-shadow: rgba(0,0,0,0.3);
    --modal-close-color: #aaa;
    --modal-hr-color: #e0e0e0;
    --bottom-nav-bg: #ffffff;
    --bottom-nav-icon: #757575;
    --bottom-nav-icon-active: #ea1d2c;
}

body.dark-mode {
    --bg-color: #1a1a1a; /* Fundo mais escuro */
    --container-bg: #2c2c2c; /* Cards com cor de fundo distinta */
    --text-color: #e0e0e0; /* Texto claro */
    --header-color: #ff5252; /* Vermelho vibrante */
    --secondary-header-color: #ff9800; /* Laranja vibrante */
    --border-color: #444444; /* Borda sutil */
    --table-header-bg: #ff5252;
    --table-header-text: #fff;
    --button-primary-bg: #2196f3;
    --button-secondary-bg: #ffb300;
    --modal-bg: #2c2c2c;
    --modal-shadow: rgba(0,0,0,0.7);
    --modal-close-color: #e0e0e0;
    --modal-hr-color: #616161;
    --bottom-nav-bg: #212121;
    --bottom-nav-icon: #bdbdbd;
    --bottom-nav-icon-active: #ff5252;
}

/* Base de estilos com transições */
body { 
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; 
    background-color: var(--bg-color); 
    margin: 0; 
    color: var(--text-color); 
    transition: background-color 0.3s ease, color 0.3s ease; /* Transições suaves */
}
.main-content { padding: 20px 15px 80px 15px; }
.header { margin-bottom: 20px; }
h1 { color: var(--header-color); margin: 0; font-size: 1.5em; transition: color 0.3s ease; }
h2 { color: var(--secondary-header-color); font-size: 1.2em; border-bottom: 2px solid var(--secondary-header-color); padding-bottom: 5px; margin-top: 25px; transition: color 0.3s ease, border-color 0.3s ease; }
hr { border: 0; height: 1px; background: var(--border-color); margin: 20px 0; transition: background 0.3s ease; }
.pedidos-container { width: 100%; }
.pedidos-table { width: 100%; border-collapse: collapse; }
.pedidos-table tr { 
    display: flex; 
    flex-direction: column; 
    margin-bottom: 15px; 
    background-color: var(--container-bg); 
    border: 1px solid var(--border-color); 
    border-radius: 8px; 
    padding: 15px; 
    box-shadow: 0 4px 10px rgba(0,0,0,0.1); /* Sombra mais destacada */
    transition: background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}
body.dark-mode .pedidos-table tr {
    box-shadow: 0 4px 10px rgba(0,0,0,0.3); /* Sombra mais escura para o modo escuro */
}
.pedidos-table td { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border: none; text-align: right; }
.pedidos-table td::before { content: attr(data-label); font-weight: bold; color: var(--secondary-header-color); text-align: left; transition: color 0.3s ease; }
.pedidos-table td[data-label="Ações"] { flex-direction: column; align-items: stretch; gap: 8px; margin-top: 10px; }
.pedidos-table td[data-label="Ações"]::before { display: none; }
.btn-acao { 
    background-color: var(--button-primary-bg);
    color: white; 
    border: none; 
    padding: 12px; 
    border-radius: 5px; 
    cursor: pointer; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    gap: 8px; 
    text-decoration: none; 
    font-size: 1em; 
    transition: background-color 0.3s ease, opacity 0.3s ease;
}
.btn-acao:hover {
    opacity: 0.9;
}
.btn-mapa-rota { 
    background-color: var(--button-secondary-bg); 
    color: var(--text-color);
}
.btn-mudar-status[data-novo-status="saiu_para_entrega"] {
    background-color: #ffc107;
    color: #333;
}
.btn-mudar-status[data-novo-status="entregue"] {
    background-color: #28a745;
}
.no-orders-message { text-align: center; padding: 40px 20px; background-color: var(--container-bg); border-radius: 8px; font-style: italic; transition: background-color 0.3s ease; }
.bottom-nav { 
    display: flex; 
    justify-content: space-around; 
    align-items: center; 
    position: fixed; 
    bottom: 0; 
    left: 0; 
    width: 100%; 
    height: 60px; 
    background-color: var(--bottom-nav-bg); 
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1); 
    z-index: 1000; 
    padding-bottom: env(safe-area-inset-bottom);
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}
.bottom-nav a { display: flex; flex-direction: column; align-items: center; text-decoration: none; color: var(--bottom-nav-icon); padding: 5px 0; flex-grow: 1; transition: color 0.2s ease; }
.bottom-nav a.active { color: var(--bottom-nav-icon-active); }
.bottom-nav a i { font-size: 1.5em; }
.bottom-nav a span { font-size: 0.7em; margin-top: 2px; }
.modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); justify-content: center; align-items: center; padding: 0; box-sizing: border-box; }
.modal-content { 
    background-color: var(--modal-bg); 
    margin: auto; 
    border-radius: 0; 
    width: 100%; 
    height: 100%;
    max-width: 100%;
    max-height: 100%;
    overflow-y: auto; 
    position: relative; 
    box-shadow: none;
    transition: background-color 0.3s ease;
}
.modal-body { padding: 20px; }
.close-button { color: var(--modal-close-color); position: fixed; top: 20px; right: 20px; font-size: 28px; font-weight: bold; cursor: pointer; z-index: 2001; text-shadow: 0 0 5px rgba(0,0,0,0.5); }
.refresh-button-container {
    text-align: center;
    margin-top: 20px;
    margin-bottom: 20px;
}
.btn-refresh {
    background-color: #ea1d2c;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}
.btn-refresh:hover {
    background-color: #d84315;
}
/* Estilos para o formulário de status */
.status-form {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: flex-end;
    margin-top: 15px;
}
.status-form select {
    padding: 8px 12px;
    border-radius: 5px;
    border: 1px solid var(--border-color);
    background-color: var(--container-bg);
    color: var(--text-color);
    flex-grow: 1;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
}
.status-form button {
    padding: 10px 15px;
    background-color: var(--header-color);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}
.status-form button:hover {
    background-color: #d84315;
}
.alert {
    transition: background-color 0.3s ease, color 0.3s ease;
}
/* Estilo para o carregador (spinner) */
.spinner-container {
    display: none;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    color: var(--secondary-header-color);
    font-size: 1.2em;
}

.spinner {
    border: 4px solid rgba(0,0,0,0.1);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border-left-color: var(--secondary-header-color);
    animation: spin 1s ease infinite;
    margin-bottom: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Garante que o iframe e o link fiquem ocultos enquanto carrega */
.modal-map-content iframe,
.modal-map-content a.btn-acao {
    display: none;
}
    </style>
</head>
<body>

<?php if (session()->has('sucesso')): ?>
    <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 15px;">
        <?= session('sucesso') ?>
    </div>
<?php endif; ?>
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 15px;">
        <?= session('error') ?>
    </div>
<?php endif; ?>
<?php if (session()->has('info')): ?>
    <div class="alert alert-info" style="background-color: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 5px; margin: 15px;">
        <?= session('info') ?>
    </div>
<?php endif; ?>

<div class="main-content" id="mainContent">
    <div class="header">
        <h1>Olá, <strong><?= esc($entregador_nome ?? 'Entregador') ?></strong>!</h1>
        <p>Seus pedidos para hoje.</p>
    </div>
    
    <div class="pedidos-section">
        <h2>Próximas Entregas</h2>
        <div class="refresh-button-container">
            <a href="<?= site_url('entregador/painel') ?>" class="btn-refresh">
                <i class="fas fa-sync-alt"></i> Atualizar Pedidos
            </a>
        </div>
        
        <div id="pedidos-container">
            <?php if (empty($pedidos)): ?>
                <div class="no-orders-message">
                    <p>Você não tem entregas pendentes no momento. 🎉</p>
                </div>
            <?php else: ?>
                <table class="pedidos-table">
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td data-label="Código"><?= esc($pedido->id) ?></td>
                                <td data-label="Cliente"><?= esc($pedido->cliente_nome) ?></td>
                                <td data-label="Endereço"><?= esc("{$pedido->logradouro}, {$pedido->numero} - {$pedido->bairro_nome}") ?></td>
                                <td data-label="Status">
                                    <form class="status-form" action="<?= site_url('entregador/atualizar_status') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="pedido_id" value="<?= esc($pedido->id) ?>">
                                        <select name="novo_status">
                                            <option value="saiu_para_entrega" <?= $pedido->status == 'saiu_para_entrega' ? 'selected' : '' ?>>Saiu para Entrega</option>
                                            <option value="entregue" <?= $pedido->status == 'entregue' ? 'selected' : '' ?>>Entregue</option>
                                        </select>
                                        <button type="submit">Salvar</button>
                                    </form>
                                </td>
                                <td data-label="Ações">
                                    <button class="btn-acao btn-detalhes" 
                                            data-pedido-id="<?= esc($pedido->id) ?>"
                                            data-destino="<?= esc("{$pedido->logradouro}, {$pedido->numero}, {$pedido->bairro_nome}, {$pedido->cidade}, {$pedido->estado}, Brasil") ?>">
                                        <i class="fas fa-info-circle"></i> Detalhes
                                    </button>
                                    <button class="btn-acao btn-mapa-rota" 
                                            data-pedido-id="<?= esc($pedido->id) ?>"
                                            data-destino="<?= esc("{$pedido->logradouro}, {$pedido->numero}, {$pedido->bairro_nome}, {$pedido->cidade}, {$pedido->estado}, Brasil") ?>">
                                        <i class="fas fa-route"></i> Ver Rota
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<nav class="bottom-nav">
    <a href="#" class="active"><i class="fas fa-motorcycle"></i><span>Pedidos</span></a>
    <a href="#" id="open-general-map"><i class="fas fa-map-marked-alt"></i><span>Mapa</span></a>
    <a href="#" id="theme-toggle"><i class="fas fa-adjust"></i><span>Tema</span></a>
    <a href="<?= site_url('entregador/logout') ?>"><i class="fas fa-sign-out-alt"></i><span>Sair</span></a>
</nav>

<?php if (!empty($pedidos)): ?>
    <?php foreach ($pedidos as $pedido): ?>
        <div id="detalhesModal-<?= esc($pedido->id) ?>" class="modal">
            <div class="modal-content">
                <span class="close-button">×</span>
                <div class="modal-body">
                    <h2>Detalhes do Pedido #<?= esc($pedido->id) ?></h2>
                    <hr>
                    <p><strong>Cliente:</strong> <?= esc($pedido->cliente_nome) ?></p>
                    <p><strong>Endereço:</strong> <?= esc("{$pedido->logradouro}, {$pedido->numero} - {$pedido->bairro_nome}, {$pedido->cidade}") ?></p>
                    <p><strong>Ponto de Referência:</strong> <?= esc($pedido->ponto_referencia) ?></p>
                    <p><strong>Status:</strong> <span id="current-status"><?= esc(strtoupper(str_replace('_', ' ', $pedido->status))) ?></span></p>
                    <div id="status-message-<?= esc($pedido->id) ?>"></div>
                    <td data-label="Status">
                        <form class="status-form" action="<?= site_url('entregador/atualizar_status') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="pedido_id" value="<?= esc($pedido->id) ?>">
                            <select name="novo_status">
                                <option value="saiu_para_entrega" <?= $pedido->status == 'saiu_para_entrega' ? 'selected' : '' ?>>Saiu para Entrega</option>
                                <option value="entregue" <?= $pedido->status == 'entregue' ? 'selected' : '' ?>>Entregue</option>
                            </select>
                            <button type="submit">Salvar</button>
                        </form>
                    </td>
                    <hr>
                    <div class="modal-map-content">
                        <div class="spinner-container" id="spinner-detalhes-<?= esc($pedido->id) ?>">
                            <div class="spinner"></div>
                            <span>Obtendo sua localização...</span>
                        </div>
                        <iframe id="iframe-detalhes-<?= esc($pedido->id) ?>" width="100%" height="450" frameborder="0" style="border:0" src="" allowfullscreen></iframe>
                        <a id="link-detalhes-<?= esc($pedido->id) ?>" href="" target="_blank" class="btn-acao" style="margin-top: 10px;">
                            <i class="fas fa-external-link-alt"></i> Abrir no Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="mapaModal-<?= esc($pedido->id) ?>" class="modal">
            <div class="modal-content">
                <span class="close-button">×</span>
                <div class="modal-body">
                    <h2>Rota para Pedido #<?= esc($pedido->id) ?></h2>
                    <hr>
                    <div class="modal-map-content">
                        <div class="spinner-container" id="spinner-mapa-<?= esc($pedido->id) ?>">
                            <div class="spinner"></div>
                            <span>Obtendo sua localização...</span>
                        </div>
                        <iframe id="iframe-mapa-<?= esc($pedido->id) ?>" width="100%" height="450" frameborder="0" style="border:0" src="" allowfullscreen></iframe>
                        <a id="link-mapa-<?= esc($pedido->id) ?>" href="" target="_blank" class="btn-acao" style="margin-top: 10px;">
                            <i class="fas fa-external-link-alt"></i> Abrir no Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
    $locations = [];
    if (!empty($pedidos)) {
        foreach ($pedidos as $pedido) {
            $locations[] = "{$pedido->logradouro}, {$pedido->numero}, {$pedido->bairro_nome}, {$pedido->cidade}, {$pedido->estado}, Brasil";
        }
    }
    $queryString = !empty($locations) ? implode('|', $locations) : '';
?>
<div id="mapaGeralModal" class="modal">
    <div class="modal-content">
        <span class="close-button">×</span>
        <div class="modal-body">
            <h2>Mapa</h2>
            <hr>
            <div class="modal-map-content">
                <div class="spinner-container" id="spinner-geral">
                    <div class="spinner"></div>
                    <span>Obtendo sua localização...</span>
                </div>
                <iframe id="iframe-geral" width="100%" height="450" frameborder="0" style="border:0" src="" allowfullscreen></iframe>
                <a id="link-geral" href="" target="_blank" class="btn-acao" style="margin-top: 10px;">
                    <i class="fas fa-external-link-alt"></i> Abrir no Google Maps
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- FUNÇÕES DOS MODAIS ---
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeModal(modalElement) {
            if (modalElement) {
                modalElement.style.display = 'none';
            }
        }

        // Adiciona evento de clique para fechar os modais
        document.querySelectorAll('.modal .close-button').forEach(btn => {
            btn.addEventListener('click', e => closeModal(e.target.closest('.modal')));
        });
        window.addEventListener('click', e => {
            if (e.target.classList.contains('modal')) closeModal(e.target);
        });

        // Função para carregar o mapa com base na geolocalização (para rotas)
        function loadMapWithGeolocation(spinnerId, iframeId, linkId, destino) {
            const spinner = document.getElementById(spinnerId);
            const iframe = document.getElementById(iframeId);
            const link = document.getElementById(linkId);
            const apiKey = '<?= getenv('google.maps.apiKey') ?>';

            // Mostra o spinner e oculta o mapa
            spinner.style.display = 'flex';
            iframe.style.display = 'none';
            link.style.display = 'none';
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        const origem = `${lat},${lng}`;
                        
                        const embedUrl = `https://www.google.com/maps/embed/v1/directions?key=${apiKey}&origin=${origem}&destination=${encodeURIComponent(destino)}&mode=driving`;
                        const fullScreenUrl = `https://www.google.com/maps/dir/?api=1&origin=${origem}&destination=${encodeURIComponent(destino)}&travelmode=driving`;

                        iframe.src = embedUrl;
                        link.href = fullScreenUrl;

                        // Esconde o spinner e mostra o mapa e o link
                        spinner.style.display = 'none';
                        iframe.style.display = 'block';
                        link.style.display = 'flex';
                    },
                    error => {
                        console.error("Erro ao obter a localização: ", error);
                        // Fallback: usa a opção "Current+Location" se a geolocalização falhar
                        const embedUrl = `https://www.google.com/maps/embed/v1/directions?key=${apiKey}&origin=Current+Location&destination=${encodeURIComponent(destino)}&mode=driving`;
                        const fullScreenUrl = `https://www.google.com/maps/dir/?api=1&origin=Current+Location&destination=${encodeURIComponent(destino)}&travelmode=driving`;
                        
                        iframe.src = embedUrl;
                        link.href = fullScreenUrl;
                        
                        spinner.style.display = 'none';
                        iframe.style.display = 'block';
                        link.style.display = 'flex';
                    }
                );
            } else {
                console.error("Geolocalização não é suportada por este navegador.");
                // Fallback para navegadores sem suporte
                const embedUrl = `https://www.google.com/maps/embed/v1/directions?key=${apiKey}&origin=Current+Location&destination=${encodeURIComponent(destino)}&mode=driving`;
                const fullScreenUrl = `https://www.google.com/maps/dir/?api=1&origin=Current+Location&destination=${encodeURIComponent(destino)}&travelmode=driving`;
                
                iframe.src = embedUrl;
                link.href = fullScreenUrl;
                
                spinner.style.display = 'none';
                iframe.style.display = 'block';
                link.style.display = 'flex';
            }
        }

        // Nova função para carregar o mapa geral com a geolocalização, mas sem rota
        function loadGeneralMap(spinnerId, iframeId, linkId) {
            const spinner = document.getElementById(spinnerId);
            const iframe = document.getElementById(iframeId);
            const link = document.getElementById(linkId);
            const apiKey = '<?= getenv('google.maps.apiKey') ?>';

            spinner.style.display = 'flex';
            iframe.style.display = 'none';
            link.style.display = 'none';

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // URL para centrar o mapa na localização atual com um marcador
                        const embedUrlGeral = `https://www.google.com/maps/embed/v1/place?key=${apiKey}&q=${lat},${lng}`;
                        const fullScreenUrlGeral = `https://www.google.com/maps/search/?api=1&query=${lat},${lng}`;

                        iframe.src = embedUrlGeral;
                        link.href = fullScreenUrlGeral;

                        spinner.style.display = 'none';
                        iframe.style.display = 'block';
                        link.style.display = 'flex';
                    },
                    error => {
                        console.error("Erro ao obter a localização: ", error);
                        // Fallback em caso de erro na geolocalização
                        const fallbackUrl = `https://www.google.com/maps/embed/v1/view?key=${apiKey}&center=-23.55052,-46.633308&zoom=10`; // Exemplo: São Paulo
                        const fallbackLink = `https://www.google.com/maps/search/?api=1&query=Brasil`;
                        
                        iframe.src = fallbackUrl;
                        link.href = fallbackLink;
                        
                        spinner.style.display = 'none';
                        iframe.style.display = 'block';
                        link.style.display = 'flex';
                    }
                );
            } else {
                console.error("Geolocalização não é suportada por este navegador.");
                // Fallback para navegadores sem suporte
                const fallbackUrl = `https://www.google.com/maps/embed/v1/view?key=${apiKey}&center=-23.55052,-46.633308&zoom=10`; // Exemplo: São Paulo
                const fallbackLink = `https://www.google.com/maps/search/?api=1&query=Brasil`;
                
                iframe.src = fallbackUrl;
                link.href = fallbackLink;
                
                spinner.style.display = 'none';
                iframe.style.display = 'block';
                link.style.display = 'flex';
            }
        }


        // --- HANDLERS DOS BOTÕES ---
        document.querySelectorAll('.btn-detalhes').forEach(button => {
            button.addEventListener('click', function() {
                const pedidoId = this.dataset.pedidoId;
                const destino = this.dataset.destino;
                openModal(`detalhesModal-${pedidoId}`);
                loadMapWithGeolocation(`spinner-detalhes-${pedidoId}`, `iframe-detalhes-${pedidoId}`, `link-detalhes-${pedidoId}`, destino);
            });
        });

        document.querySelectorAll('.btn-mapa-rota').forEach(button => {
            button.addEventListener('click', function() {
                const pedidoId = this.dataset.pedidoId;
                const destino = this.dataset.destino;
                openModal(`mapaModal-${pedidoId}`);
                loadMapWithGeolocation(`spinner-mapa-${pedidoId}`, `iframe-mapa-${pedidoId}`, `link-mapa-${pedidoId}`, destino);
            });
        });
        
        // Handler para o botão "Mapa Geral"
        const openGeneralMapBtn = document.getElementById('open-general-map');
        if (openGeneralMapBtn) {
            openGeneralMapBtn.addEventListener('click', function(e) {
                e.preventDefault();
                openModal('mapaGeralModal');
                loadGeneralMap('spinner-geral', 'iframe-geral', 'link-geral');
            });
        }
        
        // --- LÓGICA DO MODO CLARO/ESCURO ---
        const themeToggleBtn = document.getElementById('theme-toggle');
        function applyTheme(theme) {
            const themeIcon = themeToggleBtn.querySelector('i');
            const themeText = themeToggleBtn.querySelector('span');

            if (theme === 'dark') {
                document.body.classList.add('dark-mode');
                themeIcon.classList.replace('fa-adjust', 'fa-sun');
                themeText.textContent = 'Claro';
            } else {
                document.body.classList.remove('dark-mode');
                themeIcon.classList.replace('fa-sun', 'fa-adjust');
                themeText.textContent = 'Escuro';
            }
        }

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            applyTheme(savedTheme);
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            applyTheme('dark');
        } else {
            applyTheme('light');
        }

        themeToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (document.body.classList.contains('dark-mode')) {
                applyTheme('light');
                localStorage.setItem('theme', 'light');
            } else {
                applyTheme('dark');
                localStorage.setItem('theme', 'dark');
                }
        });
    });
</script>
</body>
</html>