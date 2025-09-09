<?php

namespace App\Services;

use App\Models\ProdutoModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ExtraModel;

class CarrinhoService
{
    private $produtoModel;
    private $produtoEspecificacaoModel;
    private $extraModel;
    private $session;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->extraModel = new ExtraModel();
        $this->session = session();
    }

    /**
     * Processa o carrinho da sessão e retorna os itens detalhados e o total.
     * Esta é agora a ÚNICA fonte de verdade para os dados do carrinho.
     */
    public function getCarrinho(): array
    {
        $carrinho = $this->session->get('carrinho') ?? [];
        $itensDetalhados = [];
        $total = 0;

        foreach ($carrinho as $key => $item) {
            $produto = $this->produtoModel->find($item['produto_id']);
            if (!$produto) continue;

            $especificacao = null;
            $precoItem = $produto->preco;

            if (!empty($item['especificacao_id'])) {
                // Usando o método do model para uma busca mais limpa
                $especificacao = $this->produtoEspecificacaoModel->getEspecificacaoComDescricao($item['especificacao_id']);
                if ($especificacao) {
                    $precoItem = $especificacao->preco;
                }
            }
            
            $extrasDetalhados = [];
            if (!empty($item['extras']) && is_array($item['extras'])) {
                foreach ($item['extras'] as $extraId => $quantidadeExtra) {
                    $extra = $this->extraModel->find($extraId);
                    if ($extra) {
                        $extrasDetalhados[] = ['extra' => $extra, 'quantidade' => $quantidadeExtra];
                        $precoItem += $extra->preco * $quantidadeExtra;
                    }
                }
            }

            // Monta o array final com todos os dados, incluindo a customização (observação do item)
            $itensDetalhados[$key] = [
                'produto'           => $produto,
                'quantidade'        => $item['quantidade'],
                'especificacao'     => $especificacao,
                'extras'            => $extrasDetalhados,
                'customizacao'      => $item['customizacao'] ?? null,
                'preco_total_item'  => $precoItem * $item['quantidade'],
            ];
            
            $total += $itensDetalhados[$key]['preco_total_item'];
        }

        return ['itens' => $itensDetalhados, 'total' => $total];
    }
}