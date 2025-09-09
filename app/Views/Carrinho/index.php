<?php echo $this->extend('layout/principalView'); ?>

<?php echo $this->section('titulo'); ?>
<?= esc($titulo ?? 'Meu Carrinho') ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<style>
    /* Seus estilos CSS permanecem os mesmos */
    .cart-item {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #eee;
    }
    .cart-item-img img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .cart-item-details {
        flex: 1;
    }
    .cart-item-title {
        font-weight: 600;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    .cart-item-info {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 0.5rem;
    }
    .cart-item-extras {
        font-size: 0.9rem;
        margin-top: 1rem;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.8rem 1rem;
    }
    .cart-item-extras strong {
        font-weight: 600;
        color: #333;
    }
    .cart-item-extras ul {
        list-style: none;
        padding: 0;
        margin: 0.5rem 0 0 0;
    }
    .cart-item-extras li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: 0.4rem 0;
        border-bottom: 1px solid #eee;
    }
    .cart-item-extras li:last-child {
        border-bottom: none;
    }
    .cart-item-extras .extra-name {
        color: #555;
        margin-right: 0.5rem;
    }
    .cart-item-extras .extra-qty {
        color: #777;
        font-size: 0.85rem;
    }
    .cart-item-extras .extra-price {
        font-weight: 600;
        color: #222;
    }
    .cart-item-customization {
        margin-top: 0.75rem;
        font-size: 0.9rem;
        color: #495057;
        background-color: #f8f9fa;
        border-left: 3px solid #6c757d;
        padding: 0.5rem 0.75rem;
        border-radius: 4px;
    }
    .cart-item-price {
        min-width: 120px;
        text-align: right;
    }
    .cart-item-price div {
        font-size: 1.2rem;
        font-weight: 600;
        color: #222;
    }
    .cart-item-price .btn {
        margin-top: 0.5rem;
    }
    .cart-summary-card {
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .cart-total {
        font-size: 1.6rem;
        font-weight: 700;
    }
    .btn-finalizar {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
        transition: 0.3s;
    }
    .btn-finalizar:hover {
        background-color: #218838;
        border-color: #1e7e34;
        color: #fff;
    }

    @media (max-width: 767px) {
        .cart-item {
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .cart-item-img img {
            width: 80px;
            height: 80px;
        }
        .cart-item-details {
            flex-basis: calc(100% - 80px - 1rem); 
        }
        .cart-item-title {
            font-size: 1.1rem;
        }
        .cart-item-price {
            flex-basis: 100%; 
            min-width: auto;
            margin-top: 1rem;
            text-align: right;
        }
        .cart-item-extras li {
            justify-content: flex-start;
        }
        .extra-details {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex-basis: 70%;
        }
        .extra-price {
            flex-basis: 30%;
            text-align: right;
        }
    }
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?>
<br><br><br>
<section class="section-padding">
    <div class="container">
        <h1 class="mb-4"><?= esc($titulo) ?></h1>
        
        <div class="container"> <?php if (session()->has('sucesso')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sucesso!</strong> <?php echo session('sucesso'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if (session()->has('info')): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong>Informação:</strong> <?php echo session('info'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if (session()->has('atencao')): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Atenção:</strong> <?php echo session('atencao'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if (session()->has('erro')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro:</strong> <?php echo session('erro'); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?><?php if (session()->has('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Verifique os erros abaixo:</strong>
                <ul>
                    <?php foreach (session('errors') as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        </div>

        <?php if (empty($carrinho)): ?>
            <div class="alert alert-info text-center" role="alert">
                Seu carrinho de compras está vazio.
                <a href="<?= site_url('/') ?>" class="alert-link">Comece a comprar!</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <?php foreach ($carrinho as $key => $item): ?>
                        <div class="cart-item">
                            <div class="cart-item-img">
                                <img src="<?= $item['produto']->imagem ? site_url('home/imagemProduto/' . $item['produto']->imagem) : site_url('admin/images/sem-imagem.jpg') ?>" alt="<?= esc($item['produto']->nome) ?>">
                            </div>
                            <div class="cart-item-details">
                                <div class="cart-item-title"><?= esc($item['produto']->nome) ?></div>
                                <div class="cart-item-info">
                                    <?php if (!empty($item['especificacao']) && is_object($item['especificacao']) && property_exists($item['especificacao'], 'descricao')) : ?>
                                        <span><strong>Tamanho:</strong> <?= esc($item['especificacao']->descricao) ?></span><br>
                                    <?php endif; ?>
                                    <span><strong>Quantidade:</strong> <?= esc($item['quantidade']) ?></span>
                                </div>
                                <?php if (!empty($item['extras'])): ?>
                                <div class="cart-item-extras">
                                    <strong>Extras:</strong>
                                    <ul>
                                        <?php foreach ($item['extras'] as $extraItem): ?>
                                            <li>
                                                <div class="extra-details">
                                                    <span class="extra-name"><?= esc($extraItem['extra']->nome) ?></span>
                                                    <span class="extra-qty">(x<?= esc($extraItem['quantidade']) ?>)</span>
                                                </div>
                                                <span class="extra-price">R$ <?= number_format($extraItem['extra']->preco * $extraItem['quantidade'], 2, ',', '.') ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($item['customizacao'])): ?>
                                    <div class="cart-item-customization">
                                        <strong>Observações:</strong> <?= esc($item['customizacao']) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="cart-item-price">
                                <div>R$ <?= number_format($item['preco_total_item'], 2, ',', '.') ?></div>
                                <a href="<?= site_url(route_to('carrinho.remover', $key)) ?>" class="btn btn-sm btn-outline-danger">Remover</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="col-lg-4">
                    <div class="card cart-summary-card">
                        <div class="card-body">
                            <h5 class="card-title">Resumo do Pedido</h5>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Taxa de Entrega</span>
                                <span>A calcular</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between cart-total mb-4">
                                <span>Total</span>
                                <span>R$ <?= number_format($total, 2, ',', '.') ?></span>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="<?= site_url('/finalizar') ?>" 
                                    class="btn btn-finalizar btn-lg <?= !$podeFinalizar ? 'disabled' : '' ?>" 
                                    <?= !$podeFinalizar ? 'aria-disabled="true" tabindex="-1"' : '' ?>>
                                    Finalizar Compra
                                </a>
                                <a href="<?= site_url('/') ?>" class="btn btn-outline-secondary mt-2">Continuar Comprando</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<div class="modal fade" id="limitePedidosModal" tabindex="-1" aria-labelledby="limitePedidosModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="limitePedidosModalLabel">
                    <i class="fas fa-hourglass-half me-2"></i> Fila de Espera Virtual
                </h5>
            </div>
            <div class="modal-body">
                <p>Que ótimo ver você por aqui! 😊</p>
                <p class="lead">No momento, atingimos nossa capacidade máxima de pedidos para esta hora.</p>
                <p>Novos pedidos serão liberados em:</p>
                <div id="countdown-timer" class="display-4 fw-bold text-success my-3">--:--</div>
                <hr>
                <div id="notification-section">
                    <p>Quer ser avisado assim que liberarmos novos pedidos?</p>
                    <button class="btn btn-success" type="button" id="notify-me-btn">
                        <i class="fas fa-bell"></i> Sim, notifique-me!
                    </button>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuar navegando</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="fechadoModal" tabindex="-1" aria-labelledby="fechadoModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h5 class="modal-title" id="fechadoModalLabel">
                    <i class="fas fa-store-slash me-2"></i> Estamos Fechados no Momento
                </h5>
            </div>
            <div class="modal-body">
                <p>Agradecemos a sua visita! 😊</p>
                
                <?php // Condição para exibir a mensagem e o cronômetro corretos ?>
                <?php if (isset($dadosAbertura['mensagem'])): ?>
                    <p class="lead"><?= esc($dadosAbertura['mensagem']) ?></p>
                    <p>Tempo restante para a abertura:</p>
                    <div id="countdown-fechado" class="display-4 fw-bold text-success my-3">
                        --:--:--
                    </div>
                <?php else: ?>
                    <p class="lead">No momento nossa loja está fechada.</p>
                    <p>Por favor, volte mais tarde!</p>
                <?php endif; ?>

                <hr>
                <p>Enquanto isso, que tal navegar pelo nosso cardápio?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="<?= site_url('/Vizualizar') ?>" class="btn btn-primary">Ver Cardápio</a>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>

<?php if ($mostrarPopupLimite): ?>
<script>
// Script do pop-up de limite de pedidos (sem alterações)
document.addEventListener("DOMContentLoaded", function() {
    const countdownElement = document.getElementById('countdown-timer');
    const limiteModal = new bootstrap.Modal(document.getElementById('limitePedidosModal'));
    const notifyBtn = document.getElementById('notify-me-btn');
    const agora = new Date();
    const proximaHora = new Date(agora);
    proximaHora.setHours(agora.getHours() + 1, 0, 0, 0);
    let segundosRestantes = Math.floor((proximaHora - agora) / 1000);
    const timerInterval = setInterval(() => {
        if (segundosRestantes-- <= 0) {
            clearInterval(timerInterval);
            window.location.reload(); 
            return;
        }
        const minutos = Math.floor(segundosRestantes / 60);
        const segundos = segundosRestantes % 60;
        countdownElement.textContent = `${String(minutos).padStart(2, '0')}:${String(segundos).padStart(2, '0')}`;
    }, 1000);
    notifyBtn.addEventListener('click', () => {
        notifyBtn.disabled = true;
        askPermissionAndSubscribe();
    });
    async function askPermissionAndSubscribe() {
        if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
            alert("Seu navegador não suporta notificações push.");
            return;
        }
        const permission = await Notification.requestPermission();
        if (permission !== 'granted') {
            alert("Você precisa permitir as notificações para ser avisado.");
            notifyBtn.disabled = false;
            return;
        }
        const swRegistration = await navigator.serviceWorker.register('<?= site_url('sw.js') ?>');
        try {
            const subscription = await swRegistration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: 'SUA_CHAVE_PUBLICA_VAPID_AQUI' 
            });
            await sendSubscriptionToServer(subscription);
            document.getElementById('notification-section').innerHTML = 
                '<div class="alert alert-success">Tudo certo! Nós te avisaremos.</div>';
        } catch (error) {
            console.error('Falha ao se inscrever para notificações: ', error);
            notifyBtn.disabled = false;
        }
    }
    async function sendSubscriptionToServer(subscription) {
        await fetch('<?= site_url('carrinho/salvar-inscricao') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                "X-Requested-With": "XMLHttpRequest"
            },
            body: JSON.stringify(subscription)
        });
    }
    limiteModal.show();
});
</script>
<?php endif; ?>


<?php // 1. A condição principal agora só verifica se a loja está fechada. ?>
<?php if ($mostrarPopupFechado): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const fechadoModalElement = document.getElementById('fechadoModal');
    if (!fechadoModalElement) return; // Segurança extra

    const fechadoModal = new bootstrap.Modal(fechadoModalElement);
    
    // 2. Mostra o modal imediatamente, pois já sabemos que a loja está fechada.
    fechadoModal.show();

    <?php // 3. AGORA, verificamos se temos os dados do cronômetro para iniciá-lo. ?>
    <?php if (isset($dadosAbertura['segundos']) && $dadosAbertura['segundos'] > 0): ?>
    
    const countdownElement = document.getElementById('countdown-fechado');
    let segundosRestantes = <?= $dadosAbertura['segundos'] ?>;

    const timerInterval = setInterval(() => {
        if (segundosRestantes <= 0) {
            clearInterval(timerInterval);
            countdownElement.textContent = "Estamos Abertos!";
            window.location.reload(); 
            return;
        }
        
        segundosRestantes--;

        const horas = Math.floor(segundosRestantes / 3600);
        const minutos = Math.floor((segundosRestantes % 3600) / 60);
        const segundos = segundosRestantes % 60;

        const displayHoras = String(horas).padStart(2, '0');
        const displayMinutos = String(minutos).padStart(2, '0');
        const displaySegundos = String(segundos).padStart(2, '0');

        countdownElement.textContent = `${displayHoras}:${displayMinutos}:${displaySegundos}`;

    }, 1000);

    <?php endif; // Fim da condição que verifica os segundos. ?>
});
</script>
<?php endif; // Fim da condição $mostrarPopupFechado. ?>
<?php echo $this->endSection(); ?>