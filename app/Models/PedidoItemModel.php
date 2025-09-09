<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoItemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pedidos_itens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pedido_id',
        'produto_id',
        'especificacao_id',
        'quantidade',
        'preco_unitario',
        'preco_extras',
        'subtotal',
        'observacao',
    ];

    protected $useTimestamps = false;


     /**
     * Recupera os itens de um pedido com os nomes dos produtos e medidas.
     *
     * @param integer $pedido_id ID do pedido.
     * @return array
     */
    public function recuperaItensDoPedidoParaImpressao(int $pedido_id): array
    {
        return $this->select([
                'pedidos_itens.id', // ID do item para buscar os extras
                'pedidos_itens.quantidade',
                   'pedidos_itens.observacao', 
                'produtos.nome AS produto_nome',
                'medidas.nome AS medida_nome',
            ])
            ->join('produtos', 'produtos.id = pedidos_itens.produto_id')
            ->join('produtos_especificacoes', 'produtos_especificacoes.id = pedidos_itens.especificacao_id')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->where('pedidos_itens.pedido_id', $pedido_id)
            ->findAll();
    }


    public function recuperaItensDoPedido(int $pedido_id): array
    {
        return $this->select([
                'pedidos_itens.id', // ID do item para buscar os extras
                'pedidos_itens.quantidade',
                'produtos.nome AS produto_nome',
                'medidas.nome AS medida_nome',
            ])
            ->join('produtos', 'produtos.id = pedidos_itens.produto_id')
            ->join('produtos_especificacoes', 'produtos_especificacoes.id = pedidos_itens.especificacao_id')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->where('pedidos_itens.pedido_id', $pedido_id)
            ->findAll();
    }
    
    public function recuperaItensDoPedidoParaModal(int $pedido_id): array
    {
        // 1. Buscamos os itens do pedido
        $itens = $this->select([
            'pedidos_itens.id', // Precisamos do ID do item para buscar os extras
            'pedidos_itens.quantidade',
            'pedidos_itens.preco_unitario', // Buscando o preço que foi salvo no pedido
            'pedidos_itens.observacao AS observacoes', // Alias para evitar conflito
            'produtos.nome AS produto_nome',
            'medidas.nome AS medida_nome',
        ])
        ->join('produtos', 'produtos.id = pedidos_itens.produto_id')
        ->join('produtos_especificacoes', 'produtos_especificacoes.id = pedidos_itens.especificacao_id')
        ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id', 'left')
        ->where('pedidos_itens.pedido_id', $pedido_id)
        ->findAll();

        // 2. Para cada item, buscamos seus extras.
        // O PedidoItemExtraModel precisa ser carregado dentro do loop para evitar erros.
        $pedidoItemExtraModel = new \App\Models\PedidoItemExtraModel();

        foreach ($itens as $key => $item) {
            $extras = $pedidoItemExtraModel->recuperaExtrasDoItem($item['id']);
            // Adiciona a lista de extras ao item do pedido
            $itens[$key]['extras'] = $extras;
        }

        return $itens;
    }

    public function RecuperaDadosDoProdutoPdv(){
        return $this->select([
            'produtos.id',
            'produtos.nome',
            'produtos.preco_minimo',
            'produtos.preco_maximo',
            'produtos.imagem_capa',
            'produtos.descricao',
            'produtos.ativo',
            'produtos.created_at',
            'produtos.updated_at',
        ])
        ->join('produtos', 'produtos.id = pedidos_itens.produto_id')
        ->findAll();
    }

}
