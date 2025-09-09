<?php echo $this->extend('Admin/layout/principal'); ?>

<?php echo $this->section('titulo'); ?> <?php echo $titulo; ?> <?php echo $this->endSection(); ?>

<?php echo $this->section('estilos'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
    /* Estilos personalizados para a página de Dashboard */
    .card .card-body .card-icon {
        font-size: 3rem;
    }

    /* Alertas toastr */
    .toast-info { background-color: #007bff !important; color: white; }
    .toast-success { background-color: #28a745 !important; color: white; }
    .toast-warning { background-color: #ffc107 !important; color: black; }
    .toast-error { background-color: #dc3545 !important; color: white; }
</style>
<?php echo $this->endSection(); ?>

<?php echo $this->section('conteudo'); ?> 

<div class="content-wrapper">
    <div class="row mb-4">
    <div class="col-md-3">
        <label for="data-inicio" class="form-label">Data de Início:</label>
        <input type="date" id="data-inicio" class="form-control" value="<?php echo date('Y-m-01'); ?>">
    </div>
    <div class="col-md-3">
        <label for="data-fim" class="form-label">Data de Fim:</label>
        <input type="date" id="data-fim" class="form-control" value="<?php echo date('Y-m-d'); ?>">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button id="aplicar-filtro" class="btn btn-primary w-100">Aplicar Filtro</button>
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <button id="ultimos-30-dias" class="btn btn-info w-100">Últimos 30 Dias</button>
    </div>
</div>
    
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-title text-md-center text-xl-left">Faturamento no Mês</p>
                        <h3 id="faturamento-mes" class="font-weight-bold text-success">R$ <?php echo number_format($valorPedidosMes, 2, ',', '.'); ?></h3>
                    </div>
                    <i class="fas fa-dollar-sign card-icon text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-title text-md-center text-xl-left">Pedidos no Mês</p>
                        <h3 id="total-pedidos-mes" class="font-weight-bold text-primary"><?php echo $totalPedidosMes; ?></h3>
                    </div>
                    <i class="fas fa-box-open card-icon text-primary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <p class="card-title text-md-center text-xl-left">Clientes Ativos</p>
                        <h3 id="total-clientes-ativos" class="font-weight-bold text-info"><?php echo $totalClientesAtivos; ?></h3>
                    </div>
                    <i class="fas fa-users card-icon text-info"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">📈 Faturamento nos Últimos 30 Dias</h4>
                    <canvas id="vendasChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">📊 Status dos Pedidos (Mês)</h4>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCupom" tabindex="-1" role="dialog" aria-labelledby="modalCupomLabel" aria-hidden="true">
</div>

<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(function () {
        // --- INICIALIZAÇÃO E ATUALIZAÇÃO DO DASHBOARD ---

        // (O código de inicialização dos gráficos vendasChart e statusChart não muda, pode mantê-lo)

        // Configuração do Gráfico de Vendas
        const vendasCtx = document.getElementById('vendasChart').getContext('2d');
        const vendasChart = new Chart(vendasCtx, { 
            type: 'bar', 
            data: { 
                labels: [], 
                datasets: [{ 
                    label: 'Faturamento Diário', 
                    data: [], 
                    backgroundColor: 'rgba(40, 167, 69, 0.7)', 
                    borderColor: 'rgba(40, 167, 69, 1)', 
                    borderWidth: 1 
                }] 
            }, 
            options: { 
                responsive: true, 
                scales: { 
                    y: { 
                        beginAtZero: true, 
                        ticks: { 
                            callback: function(value) { return 'R$ ' + value.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); } 
                        } 
                    } 
                }, 
                plugins: { 
                    tooltip: { 
                        callbacks: { 
                            label: function(context) { return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(context.parsed.y); } 
                        } 
                    } 
                } 
            } 
        });

        // Configuração do Gráfico de Status
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(statusCtx, { 
            type: 'doughnut', 
            data: { 
                labels: [], 
                datasets: [{ 
                    data: [], 
                    backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d', '#17a2b8', '#007bff'], 
                    hoverOffset: 4 
                }] 
            }, 
            options: { 
                responsive: true, 
                plugins: {
                    legend: { 
                        position: 'top' 
                    } 
                }
            } 
        });

        // Função principal de atualização do Dashboard
        function atualizarDashboard(dataInicio = null, dataFim = null) {
            let url = "<?php echo site_url('admin/home/atualizarDashboard'); ?>";
            
            // Se as datas foram fornecidas, adiciona à URL
            if (dataInicio && dataFim) {
                url += '?data_inicio=' + dataInicio + '&data_fim=' + dataFim;
            }

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Atualiza os cards
                    $('#faturamento-mes').text('R$ ' + data.valorPedidosPeriodo);
                    $('#total-pedidos-mes').text(data.totalPedidosPeriodo);
                    $('#total-clientes-ativos').text(data.totalClientesAtivos);

                    // Atualiza o gráfico de status
                    statusChart.data.labels = data.statusPedidos.length > 0 ? data.statusPedidos.map(item => item.status.charAt(0).toUpperCase() + item.status.slice(1).replace(/_/g, ' ')) : [];
                    statusChart.data.datasets[0].data = data.statusPedidos.length > 0 ? data.statusPedidos.map(item => item.total) : [];
                    statusChart.update();

                    // Atualiza o gráfico de faturamento
                    vendasChart.data.labels = data.faturamento.map(item => item.dia);
                    vendasChart.data.datasets[0].data = data.faturamento.map(item => item.faturamento);
                    vendasChart.update();
                },
                error: function(xhr, status, error) {
                    console.error("Erro ao atualizar o dashboard:", error);
                    toastr.error('Erro ao carregar dados do dashboard. Tente novamente mais tarde.', 'Erro!');
                }
            });
        }

        // Eventos para os botões de filtro
        $('#aplicar-filtro').on('click', function() {
            const dataInicio = $('#data-inicio').val();
            const dataFim = $('#data-fim').val();
            atualizarDashboard(dataInicio, dataFim);
        });

        $('#ultimos-30-dias').on('click', function() {
            const hoje = new Date();
            const trintaDiasAtras = new Date(hoje.setDate(hoje.getDate() - 30)).toISOString().split('T')[0];
            const hojeFormatado = new Date().toISOString().split('T')[0];

            // Atualiza os inputs para refletir o período de 30 dias
            $('#data-inicio').val(trintaDiasAtras);
            $('#data-fim').val(hojeFormatado);

            atualizarDashboard(trintaDiasAtras, hojeFormatado);
        });

        // Chama a função pela primeira vez para carregar os dados iniciais do mês atual
        atualizarDashboard($('#data-inicio').val(), $('#data-fim').val());

        // O seu setInterval também precisa ser ajustado para chamar a função com as datas
        // Vamos manter a lógica de usar os valores dos inputs.
        setInterval(function() {
            const dataInicio = $('#data-inicio').val();
            const dataFim = $('#data-fim').val();
            atualizarDashboard(dataInicio, dataFim);
        }, 5000); 

        // Configurações globais do Toastr
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    });
</script>
<?php echo $this->endSection(); ?>