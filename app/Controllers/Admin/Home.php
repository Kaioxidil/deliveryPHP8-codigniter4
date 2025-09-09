<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;
use App\Models\EntregadorModel;


class Home extends BaseController
{
    private $pedidoModel;
    private $usuarioModel;
    private $entregadorModel;

    public function __construct()
    {
        $this->pedidoModel = new PedidoModel();
        $this->usuarioModel = new UsuarioModel();
        $this->entregadorModel = new EntregadorModel();
    }

    /**
     * Exibe a página principal do Dashboard com dados iniciais.
     */
    public function index()
    {
        // Os valores iniciais serão preenchidos pelo AJAX,
        // então podemos passar valores padrão para evitar erros na view.
        $data = [
            'titulo' => 'Painel Principal',
            'valorPedidosMes' => 0.0,
            'totalPedidosMes' => 0,
            'totalClientesAtivos' => $this->usuarioModel->recuperaTotalClientesAtivos(),
        
        ];

        return view('Admin/Home/index', $data);
        
    }

    /**
     * Responde às requisições AJAX com os dados atualizados do dashboard.
     * Recebe uma data via GET para filtrar os dados.
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    // ...
public function atualizarDashboard()
{
    if (!$this->request->isAJAX()) {
        return redirect()->back();
    }

    // Obtém as datas da requisição GET, ou usa o mês atual como padrão se não for fornecida.
    $dataInicio = $this->request->getGet('data_inicio');
    $dataFim = $this->request->getGet('data_fim');
    
    if (!$dataInicio || !$dataFim) {
        $dataInicio = date('Y-m-01');
        $dataFim = date('Y-m-d');
    }

    $data = [
        // Chamaremos métodos novos ou ajustados no Model para passar o período
        'valorPedidosPeriodo' => number_format($this->pedidoModel->valorPedidosDoPeriodo($dataInicio, $dataFim), 2, ',', '.'),
        'totalPedidosPeriodo' => $this->pedidoModel->totalPedidosDoPeriodo($dataInicio, $dataFim),
        'totalClientesAtivos' => $this->usuarioModel->recuperaTotalClientesAtivos(),
        'statusPedidos' => $this->pedidoModel->getStatusPedidosParaGrafico($dataInicio, $dataFim),
        'faturamento' => $this->pedidoModel->getFaturamentoParaGrafico($dataInicio, $dataFim),
        'token' => csrf_hash(),
    ];

    return $this->response->setJSON($data);
}

}