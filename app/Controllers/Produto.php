<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\ProdutoEspecificacaoModel;
use App\Models\ProdutoExtraModel;

class Produto extends BaseController
{
    private $produtoModel;
    private $produtoEspecificacaoModel;
    private $produtoExtraModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->produtoEspecificacaoModel = new ProdutoEspecificacaoModel();
        $this->produtoExtraModel = new ProdutoExtraModel();
    }

    public function detalhes(string $slug = null)
    {
        if (!$slug) {
            return redirect()->to(site_url('/'));
        }

        // Esta consulta busca o produto e define o seu preço inicial como o menor preço entre suas especificações.
        $produto = $this->produtoModel
            ->select([
                'produtos.*',
                'MIN(produtos_especificacoes.preco) AS preco'
            ])
            ->join('produtos_especificacoes', 'produtos_especificacoes.produto_id = produtos.id')
            ->where('produtos.slug', $slug)
            ->groupBy('produtos.id')
            ->first();

        if (!$produto) {
            return redirect()->to(site_url('/'));
        }

        // Busca as especificações do produto, incluindo a descrição da medida (ex: "Pizza Média").
        $especificacoes = $this->produtoEspecificacaoModel
            ->select('produtos_especificacoes.*, medidas.nome as descricao')
            ->join('medidas', 'medidas.id = produtos_especificacoes.medida_id')
            ->where('produtos_especificacoes.produto_id', $produto->id)
            ->findAll();

        /**
         * CORREÇÃO FINAL E MAIS IMPORTANTE:
         * A consulta agora seleciona os dados diretamente da tabela 'extras'.
         * Isso garante que `$extra->id` na view será o ID correto do extra (ex: ID da "Borda de Catupiry"),
         * e não o ID da tabela de ligação 'produtos_extras'.
         */
        $extras = $this->produtoExtraModel
            ->select('extras.id, extras.nome, extras.preco') // <-- CORREÇÃO APLICADA AQUI
            ->join('extras', 'extras.id = produtos_extras.extra_id')
            ->where('produtos_extras.produto_id', $produto->id)
            ->findAll();

        $data = [
            'titulo' => "Detalhes do Produto $produto->nome",
            'produto' => $produto,
            'especificacoes' => $especificacoes,
            'extras' => $extras,
        ];

        return view('Produto/detalhes', $data);
    }
}