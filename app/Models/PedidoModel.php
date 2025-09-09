<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PedidoModel extends Model
{
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id';
    protected $returnType       = \App\Entities\Pedido::class;
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'usuario_id',
        'entregador_id', 
        'id',
        'forma_pagamento_id',
        'status',
        'observacoes',
        'valor_entrega',
        'valor_total',
        'endereco_id'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';


   // ------------------ MÉTODOS PARA O DASHBOARD (CORRIGIDOS) ------------------ //

    /**
     * Retorna o valor total de pedidos faturados no mês da data base.
     * @param string|null $dataBase A data base para o filtro no formato 'Y-m-d'.
     * @return float
     */
     public function valorPedidosDoPeriodo(string $dataInicio, string $dataFim): float
    {
        $primeiroDia = $dataInicio . ' 00:00:00';
        $ultimoDia = $dataFim . ' 23:59:59';

        $resultado = $this->selectSum('valor_total')
                          ->where('status', 'entregue')
                          ->where('criado_em >=', $primeiroDia)
                          ->where('criado_em <=', $ultimoDia)
                          ->get()->getRow();

        return (float) ($resultado->valor_total ?? 0.0);
    }

    /**
     * Retorna o total de pedidos em um período de tempo.
     * @param string $dataInicio Data de início no formato 'Y-m-d'.
     * @param string $dataFim Data de fim no formato 'Y-m-d'.
     * @return int
     */
    public function totalPedidosDoPeriodo(string $dataInicio, string $dataFim): int
    {
        $primeiroDia = $dataInicio . ' 00:00:00';
        $ultimoDia = $dataFim . ' 23:59:59';

        return $this->where('criado_em >=', $primeiroDia)
                    ->where('criado_em <=', $ultimoDia)
                    ->countAllResults();
    }

    /**
     * Retorna o status dos pedidos para o gráfico de pizza em um período de tempo.
     * @param string $dataInicio Data de início no formato 'Y-m-d'.
     * @param string $dataFim Data de fim no formato 'Y-m-d'.
     * @return array
     */
    public function getStatusPedidosParaGrafico(string $dataInicio, string $dataFim): array
    {
        $primeiroDia = $dataInicio . ' 00:00:00';
        $ultimoDia = $dataFim . ' 23:59:59';

        return $this->select('status, COUNT(id) as total')
                    ->where('criado_em >=', $primeiroDia)
                    ->where('criado_em <=', $ultimoDia)
                    ->groupBy('status')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }
    
    /**
     * Retorna o faturamento por dia em um período de tempo para o gráfico.
     * @param string $dataInicio Data de início no formato 'Y-m-d'.
     * @param string $dataFim Data de fim no formato 'Y-m-d'.
     * @return array
     */
    public function getFaturamentoParaGrafico(string $dataInicio, string $dataFim): array
    {
        $db = \Config\Database::connect();
        return $db->query(
            "SELECT DATE_FORMAT(criado_em, '%d/%m') as dia, SUM(valor_total) as faturamento 
             FROM pedidos 
             WHERE status = 'entregue' AND criado_em BETWEEN ? AND ?
             GROUP BY dia 
             ORDER BY criado_em ASC",
            [$dataInicio . ' 00:00:00', $dataFim . ' 23:59:59']
        )->getResultArray();
    }

    public function recuperaPedidosDoUsuario(int $usuario_id): array
    {
        return $this->select('pedidos.*')
                    ->where('pedidos.usuario_id', $usuario_id)
                    ->orderBy('pedidos.criado_em', 'DESC') // Ordena pelos mais recentes
                    ->findAll();
    }

    public function recuperaDetalhesDoPedido(int $pedido_id, int $usuario_id)
    {
        return $this->select('pedidos.*, formas_pagamento.nome AS forma_pagamento')
                    ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
                    ->where('pedidos.id', $pedido_id)
                    ->where('pedidos.usuario_id', $usuario_id)
                    ->first();
    }

     public function recuperaDetalhesDoPedidoParaModal(int $pedido_id, int $usuario_id)
    {
        return $this->select([
                        'pedidos.*',
                        'formas_pagamento.nome AS forma_pagamento',
                        'entregadores.nome AS entregador_nome',
                        
                        // Campos do endereço do usuário
                        'usuarios_enderecos.logradouro',
                        'usuarios_enderecos.numero',
                        'usuarios_enderecos.cidade',
                        'usuarios_enderecos.estado',
                        'usuarios_enderecos.cep',

                        // ✅ CORREÇÃO APLICADA AQUI:
                        // Pegamos o `nome` da tabela `bairros` e o chamamos de `bairro`
                        'bairros.nome AS bairro',
                        'bairros.valor_entrega AS taxa_entrega_bairro'
                    ])
                    ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
                    ->join('usuarios_enderecos', 'usuarios_enderecos.id = pedidos.endereco_id', 'left')
                    ->join('entregadores', 'entregadores.id = pedidos.entregador_id', 'left')
                    
                    // ✅ ESTA É A LINHA MAIS IMPORTANTE DA CORREÇÃO:
                    // Juntamos a tabela `bairros` usando o ID que está na coluna `usuarios_enderecos.bairro`.
                    ->join('bairros', 'bairros.id = usuarios_enderecos.bairro', 'left')

                    ->where('pedidos.id', $pedido_id)
                    ->where('pedidos.usuario_id', $usuario_id)
                    ->first();
    }

    public function recuperaPedidoParaImpressao(int $pedido_id)
    {
        $pedido = $this->select([
                                'pedidos.*', // This already includes 'observacoes'
                                'usuarios.nome AS cliente_nome',
                                'formas_pagamento.nome AS forma_pagamento_nome',
                                'entregadores.nome AS entregador_nome',
                                
                                // Campos do endereço do usuário
                                'usuarios_enderecos.logradouro',
                                'usuarios_enderecos.numero',
                                'usuarios_enderecos.complemento',
                                'usuarios_enderecos.referencia',
                                'usuarios_enderecos.cidade',
                                'usuarios_enderecos.estado',
                                'usuarios_enderecos.cep',

                                // Nome do bairro e taxa de entrega
                                'bairros.nome AS bairro_nome',
                                'bairros.valor_entrega AS taxa_entrega_bairro'
                            ])
                            ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                            ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
                            ->join('entregadores', 'entregadores.id = pedidos.entregador_id', 'left')
                            ->join('usuarios_enderecos', 'usuarios_enderecos.id = pedidos.endereco_id', 'left')
                            ->join('bairros', 'bairros.id = usuarios_enderecos.bairro', 'left')
                            ->where('pedidos.id', $pedido_id)
                            ->first();

        if ($pedido) {
            // Anexar itens do pedido
            $pedidoItemModel = new PedidoItemModel();
            $pedidoItemExtraModel = new PedidoItemExtraModel();

            $itens = $pedidoItemModel->recuperaItensDoPedidoParaImpressao($pedido->id);
            foreach ($itens as $key => $item) {
                $extras = $pedidoItemExtraModel->recuperaExtrasDoItem($item['id']);
                if ($extras) {
                    $itens[$key]['extras'] = $extras;
                }
            }
            $pedido->itens_impressao = $itens;

            // Formatar o endereço para a impressão
            $endereco_impressao = new \stdClass();
            $endereco_impressao->logradouro = $pedido->logradouro;
            $endereco_impressao->numero = $pedido->numero;
            $endereco_impressao->complemento = $pedido->complemento;
            $endereco_impressao->referencia = $pedido->referencia;
            $endereco_impressao->bairro = $pedido->bairro_nome;
            $endereco_impressao->cidade = $pedido->cidade;
            $endereco_impressao->estado = $pedido->estado;
            $endereco_impressao->cep = $pedido->cep;

            $pedido->endereco_impressao = $endereco_impressao;
            
            // Add company information that will be used in the receipt
            $pedido->empresa_nome = 'Nome da Sua Empresa';
            $pedido->empresa_endereco = 'Endereço da Empresa';
            $pedido->empresa_telefone = '(00) 00000-0000';
        }

        return $pedido;
    }

    // ------------------ MÉTODOS PARA PEDIDOS  ------------------ //

    public function recuperaPedidosPaginados(array $filtros, int $quantidade_paginacao)
    {
        $this->select('pedidos.*, usuarios.nome AS cliente_nome, entregadores.nome AS entregador_nome');
        $this->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left');
        $this->join('entregadores', 'entregadores.id = pedidos.entregador_id', 'left');

        if (!empty($filtros['busca'])) {
            $this->groupStart();
            $this->like('usuarios.nome', $filtros['busca']);
            $this->orLike('entregadores.nome', $filtros['busca']);
            $this->orWhere('pedidos.codigo', $filtros['busca']);
            $this->groupEnd();
        }

        if (!empty($filtros['status'])) {
            $this->where('pedidos.status', $filtros['status']);
        }

        $this->orderBy('pedidos.criado_em', 'DESC');

        return $this->paginate($quantidade_paginacao);
    }


        // ------------------ MÉTODO PARA PEDIDOS DO ENTREGADOR ------------------ //

     /**
      * Recupera os pedidos atribuídos a um entregador específico.
      *
      * @param int $entregador_id O ID do entregador logado.
      * @return array
      */
   public function recuperaPedidosParaEntregador(int $entregador_id): array
     {
        return $this->select([
                                'pedidos.id',
                                'pedidos.status',
                                'usuarios.nome AS cliente_nome',
                                'usuarios_enderecos.logradouro',
                                'usuarios_enderecos.numero',
                                'bairros.nome AS bairro_nome',
                            ])
                            ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                            ->join('usuarios_enderecos', 'usuarios_enderecos.id = pedidos.endereco_id', 'left')
                            ->join('bairros', 'bairros.id = usuarios_enderecos.bairro', 'left')
                            ->where('pedidos.entregador_id', $entregador_id)
                            ->whereIn('pedidos.status', ['preparando', 'em_transito', 'saiu_para_entrega'])
                            ->orderBy('pedidos.criado_em', 'ASC')
                            ->findAll();
     }

    /**
     * PONTO-CHAVE: Recupera todos os detalhes para o modal.
     * Esta função também precisa de todos os JOINs.
     */
    public function recuperaDetalhesDoPedidoParaEntregador(int $pedido_id, int $entregador_id)
    {
        $pedido = $this->select([
                                'pedidos.*',
                                'formas_pagamento.nome AS forma_pagamento_nome',
                                'usuarios.nome AS cliente_nome',
                                'usuarios.telefone AS telefone_cliente',
                                'usuarios_enderecos.logradouro', 'usuarios_enderecos.numero', 'usuarios_enderecos.complemento',
                                'usuarios_enderecos.referencia', 'usuarios_enderecos.cidade', 'usuarios_enderecos.estado',
                                'usuarios_enderecos.cep',
                                'bairros.nome AS bairro_nome',
                            ])
                            ->join('formas_pagamento', 'formas_pagamento.id = pedidos.forma_pagamento_id', 'left')
                            ->join('usuarios', 'usuarios.id = pedidos.usuario_id', 'left')
                            ->join('usuarios_enderecos', 'usuarios_enderecos.id = pedidos.endereco_id', 'left')
                            ->join('bairros', 'bairros.id = usuarios_enderecos.bairro', 'left')
                            ->where('pedidos.id', $pedido_id)
                            ->where('pedidos.entregador_id', $entregador_id)
                            ->first();

        if ($pedido) {
            $pedidoItemModel = new \App\Models\PedidoItemModel();
            
            $pedido->produtos = $pedidoItemModel->select('quantidade, produto_nome, preco_unitario')
                                               ->where('pedido_id', $pedido->id)
                                               ->findAll();
        }

        return $pedido;
    }

    /**
     * Novo método para atualizar o status do pedido.
     * @param int $pedidoId O ID do pedido a ser atualizado.
     * @param string $novoStatus O novo status ('saiu_para_entrega' ou 'entregue').
     * @param int $entregadorId O ID do entregador logado para validação de segurança.
     * @return bool Retorna true em caso de sucesso, false caso contrário.
     */
    public function AppEntregadoratualizarStatusDoPedido(int $pedidoId, string $novoStatus, int $entregadorId): bool
    {
        // Validação adicional: garante que o entregador só pode mudar pedidos que são dele
        // e para status permitidos.
        $allowedStatuses = ['saiu_para_entrega', 'entregue'];
        
        if (!in_array($novoStatus, $allowedStatuses)) {
            log_message('warning', "Tentativa de atualizar pedido para status inválido: {$novoStatus}");
            return false; // Status não permitido
        }

        // Busca o pedido para verificar se ele pertence ao entregador
        $pedido = $this->where('id', $pedidoId)
                         ->where('entregador_id', $entregadorId)
                         ->first();

        if (!$pedido) {
            log_message('warning', "Tentativa de atualização de status para pedido não encontrado ou não atribuído ao entregador. Pedido ID: {$pedidoId}, Entregador ID: {$entregadorId}");
            return false; // Pedido não encontrado ou não atribuído
        }

        // Verifica a transição de status permitida
        $currentStatus = $pedido->status;
        $canUpdate = false;

        switch ($currentStatus) {
            case 'preparando':
            case 'em_transito': // Adicionei 'em_transito' como um status de onde pode sair para entrega
                if ($novoStatus === 'saiu_para_entrega') {
                    $canUpdate = true;
                }
                break;
            case 'saiu_para_entrega':
                if ($novoStatus === 'entregue') {
                    $canUpdate = true;
                }
                break;
            // Para outros status como 'entregue', 'cancelado', 'finalizado', etc., não permitimos a mudança por aqui.
            default:
                $canUpdate = false;
                break;
        }

        if (!$canUpdate) {
            log_message('warning', "Transição de status inválida para Pedido ID {$pedidoId}: de {$currentStatus} para {$novoStatus}");
            return false;
        }

        // Atualiza o status
        return $this->update($pedidoId, ['status' => $novoStatus]);
    }



     /**
     * Conta o número de pedidos criados na hora atual.
     * @return int
     */
    public function contaPedidosNaHoraAtual(): int
    {
        // Pega a data e hora atual usando a classe Time do CodeIgniter
        $agora = Time::now();

        // Define o início da hora atual (ex: 20:00:00)
        $inicioDaHora = $agora->setTime($agora->getHour(), 0, 0)->toDateTimeString();

        // Define o fim da hora atual (ex: 20:59:59)
        $fimDaHora = $agora->setTime($agora->getHour(), 59, 59)->toDateTimeString();

        // Conta todos os pedidos cujo 'criado_em' está entre o início e o fim da hora atual
        return $this->where('criado_em >=', $inicioDaHora)
                    ->where('criado_em <=', $fimDaHora)
                    ->countAllResults();
    }
    
    
}