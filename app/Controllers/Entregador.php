<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EntregadorModel;
use App\Models\PedidoModel;

class Entregador extends BaseController
{
    private $entregadorModel;
    private $pedidoModel;

    public function __construct()
    {
        $this->entregadorModel = new EntregadorModel();
        $this->pedidoModel = new PedidoModel();
    }

    public function login()
    {
        if (session()->get('entregador_logado')) {
            return redirect()->to(site_url('entregador/painel'));
        }
        return view('entregador/login', ['titulo' => 'Login do Entregador']);
    }

    public function autenticar()
    {
        $rules = [
            'nome' => 'required|min_length[4]',
            'cpf'  => 'required|exact_length[14]|validaCpf',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $entregador = $this->entregadorModel->where('cpf', $this->request->getPost('cpf'))->first();

        if ($entregador && $entregador->nome === $this->request->getPost('nome')) {
            session()->set([
                'entregador_logado' => true,
                'entregador_id'     => $entregador->id,
                'entregador_nome'   => $entregador->nome,
            ]);
            return redirect()->to(site_url('entregador/painel'))->with('sucesso', 'Bem-vindo(a), ' . $entregador->nome . '!');
        }
        
        return redirect()->back()->withInput()->with('error', 'Nome ou CPF inválidos.');
    }
    
    public function painel()
    {
        if (!session()->get('entregador_logado')) {
            return redirect()->to(site_url('entregador/login'))->with('info', 'Por favor, faça login para acessar o painel.');
        }

        $agent = $this->request->getUserAgent();
        if (!$agent->isMobile()) {
            return view('errors/html/error_403_mobile_only');
        }

        $entregadorId = session()->get('entregador_id');
        $pedidos = $this->pedidoModel->recuperaPedidosParaEntregador($entregadorId);
        
        $data = [
            'titulo'          => 'SeuDelivery | Painel do Entregador',
            'entregador_nome' => session()->get('entregador_nome'),
            'pedidos'         => $pedidos,
            'googleApiKey'    => getenv('google.maps.apiKey'),
        ];

        return view('entregador/painel', $data);
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('entregador/login'))->with('info', 'Você foi desconectado(a).');
    }

    // Método para processar a atualização do status do pedido
    // Método para processar a atualização do status do pedido
public function atualizarStatusPedido()
{
    // Verifica se a requisição é um POST
    if ($this->request->getMethod() != 'post') {
        return redirect()->back()->with('error', 'Ação inválida.');
    }

    // Pega os dados do formulário
    $pedidoId = $this->request->getPost('pedido_id');
    $novoStatus = $this->request->getPost('novo_status');
    $entregadorId = session()->get('entregador_id');

    // Validação básica
    if (empty($pedidoId) || empty($novoStatus) || empty($entregadorId)) {
        return redirect()->back()->with('error', 'Dados insuficientes para a atualização.');
    }

    // Chama o método do Model para tentar a atualização
    $sucesso = $this->pedidoModel->AppEntregadoratualizarStatusDoPedido((int)$pedidoId, $novoStatus, (int)$entregadorId);

    if ($sucesso) {
        return redirect()->to(site_url('entregador/painel'))->with('sucesso', 'Status do pedido atualizado com sucesso!');
    } else {
        return redirect()->back()->with('error', 'Não foi possível atualizar o status do pedido. A transição de status pode ser inválida ou o pedido não pertence a você.');
    }
}
}