<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entities\Produto;

class Produtos extends BaseController
{

    private $produtoModel;
    private $categoriaModel;
    private $extraModel;
    private $ProdutoExtraModel;
    private $medidaModel;
    private $produtoEspecificacaoModel;

    public function __construct()
    {
        $this->produtoModel = new \App\Models\ProdutoModel();
        $this->categoriaModel = new \App\Models\CategoriaModel();
        $this->extraModel = new \App\Models\ExtraModel();
        $this->ProdutoExtraModel = new \App\Models\ProdutoExtraModel();
        $this->medidaModel = new \App\Models\MedidaModel();
        $this->produtoEspecificacaoModel = new \App\Models\ProdutoEspecificacaoModel();
    }

    

    public function index()
    {
        
        $data = [

            'titulo' => 'Listando os produtos',
            'produtos' => $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
                ->join('categorias', 'categorias.id = produtos.categoria_id')
                ->withDeleted(true)
                ->paginate(10),

            'pager' => $this->produtoModel->pager,
        ];

        return view('Admin/Produtos/index', $data);

    }

    public function procurar(){
        if (!$this->request->isAJAX()) {
            exit('Página não encontrada');
        }

        $produtos = $this->produtoModel->procurar($this->request->getGet('term'));
        $retorno  = [];

        foreach ($produtos as $produto) {
            $data['id']    = $produto->id;
            $data['value'] = $produto->nome;
            $retorno[]     = $data;
        }

        return $this->response->setJSON($retorno);
    }

    public function criar() {

        $produto = new Produto(); // CORREÇÃO: Instancia a Entidade Produto
        $produto->ativo = 1;

        $data = [
            'titulo'     => "Cadastrando novo produto",
            'produto'    => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Produtos/criar', $data);
    }

    public function cadastrar()
    {
        if ($this->request->getMethod() === 'post') {

            // CORREÇÃO: Instancia a Entidade Produto, passando os dados do POST para o construtor.
            // Antes estava 'new Produtos', que tentava instanciar o próprio Controller.
            $produto = new Produto($this->request->getPost()); 

            if ($this->produtoModel->save($produto)) {
                return redirect()
                    ->to(site_url("admin/produtos/show/".$this->produtoModel->getInsertID()))
                    ->with('sucesso', "Produto cadastrado com sucesso: $produto->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->produtoModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        } else {
            // Não é POST
            return redirect()->back();
        }
    }

    public function show($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        $data    = [
            'titulo'  => "Detalhando o produto: $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/show', $data);
    }

    public function editar($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        $data    = [
            'titulo'     => "Editando o produto: $produto->nome",
            'produto'    => $produto,
            'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
        ];

        return view('Admin/Produtos/editar', $data);
    }

    public function atualizar($id = null)
    {
        if ($this->request->getMethod() === 'post') {
            $produto = $this->buscaProdutoOu404($id);

            if ($produto->deletado_em !== null) {
                return redirect()
                    ->back()
                    ->with('info', "O produto '$produto->nome' encontra-se excluído. Não é possível atualizá-lo.");
            }

            $post = $this->request->getPost();
            $produto->fill($post);

            if (!$produto->hasChanged()) {
                return redirect()->back()
                    ->with('info', 'Nenhum dado foi alterado para atualizar.');
            }

            
            log_message('debug', 'Produto a ser salvo: ' . print_r($produto, true));

           
            if ($this->produtoModel->save($produto)) { 
                return redirect()
                    ->to(site_url("admin/produtos/show/$produto->id"))
                    ->with('sucesso', "Produto atualizado com sucesso: $produto->nome.");
            } else {
                return redirect()
                    ->back()
                    ->with('errors_model', $this->produtoModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        }

        return redirect()->back();
    }

    public function editarimagem($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        $data = [
            'titulo'  => "Editando a imagem do produto: $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/editar_imagem', $data);
    }

     public function upload($id = null){
        $produto = $this->buscaProdutoOu404($id);
    
        $imagem = $this->request->getFile('foto_produto');
    
        
        if(!$imagem->isValid()){
            $codigoErro = $imagem->getError();
            
            if($codigoErro == UPLOAD_ERR_NO_FILE){
                return redirect()->back()
                    ->with('atencao', 'Nenhum arquivo foi selecionado.');
            }
            
            return redirect()->back()
                ->with('atencao', 'Ocorreu um erro no upload. Tente novamente.');
        }
    

        $tamanhoImagem = $imagem->getSizeByUnit('mb');
        if($tamanhoImagem > 2){
            return redirect()->back()
                ->with('atencao', 'O tamanho máximo permitido para a imagem é de 2MB.');
        }
    

        $tipoImagem = $imagem->getMimeType();
        $tipoImagemLimpo = explode('/', $tipoImagem)[1];
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'webp'];
    
        if(!in_array($tipoImagemLimpo, $tiposPermitidos)){
            return redirect()->back()
                ->with('atencao', 'O tipo de imagem não é permitido. Apenas JPG, JPEG, PNG e WEBP são aceitos.');
        }
    


        list($largura, $altura) = getimagesize($imagem->getPathName());
        if($largura < 400 || $altura < 400){
            return redirect()->back()
                ->with('atencao', 'A imagem deve ter no mínimo 400x400 pixels.');
        }


        $imagemCaminho = $imagem->store('produtos');
        $imagemCaminho = WRITEPATH . 'uploads/' . $imagemCaminho;

        service('image')
            ->withFile($imagemCaminho)
            ->fit(400, 400, 'center')
            ->save($imagemCaminho);


            $imagemAntiga = $produto->imagem;

            $produto->imagem = $imagem->getName();

            $this->produtoModel->save($produto);

            $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagemAntiga;
  
            if(is_file($caminhoImagem)) {

                unlink($caminhoImagem);
            }

            return redirect()
                ->to(site_url("admin/produtos/show/$produto->id"))
                ->with('sucesso', "Imagem do produto atualizada com sucesso: $produto->nome.");
    }

    public function imagem(string $imagem = null){
       
        if($imagem){

            $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagem;
            $infoImagem = new \finfo(FILEINFO_MIME);

            $tipoImagem = $infoImagem->file($caminhoImagem);

            header("Content-Type: $tipoImagem");
            header("Content-Length: " . filesize($caminhoImagem));

            readfile($caminhoImagem);

            exit;

        }

    }

    public function excluirimagem($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);
        
        if (empty($produto->imagem) || !is_file(WRITEPATH . 'uploads/produtos/' . $produto->imagem)) {
        return redirect()
            ->back()
            ->with('error', 'Este produto não possui uma imagem válida para ser excluída.');
        }
        
       
        if ($produto->deletado_em !== null) {
            return redirect()
                ->back()
                ->with('info', "Não é permitido excluir a imagem de um produto que já foi excluído.");
        }
    
     
        $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $produto->imagem;

        if (is_file($caminhoImagem)) {
            unlink($caminhoImagem);
        }
    
        $produto->imagem = null; 
        $this->produtoModel->save($produto);
    
     
        return redirect()
            ->to(site_url("admin/produtos/show/$produto->id"))
            ->with('sucesso', 'Imagem do produto removida com sucesso.');
    }


    public function extras($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        $data    = [
            'titulo'  => "Gerenciar os extras do produto: $produto->nome",
            'produto' => $produto,
            'extras' => $this->extraModel->where('ativo', true)->findAll(),
            'produtosExtras' => $this->ProdutoExtraModel->buscaExtraDoProduto($produto->id, 10),
            'pager' => $this->ProdutoExtraModel->pager,
        ];

        
        return view('Admin/Produtos/extras', $data);
    }

    public function cadastrarextras($id = null){

        if($this->request->getMethod() === 'post'){

            $produto = $this->buscaProdutoOu404($id);

           $extraProduto['extra_id'] = $this->request->getPost('extra_id');
           $extraProduto['produto_id'] = $produto->id;

           $extraExistente = $this->ProdutoExtraModel
                ->where('produto_id', $produto->id)
                ->where('extra_id', $extraProduto['extra_id'])
                ->first();

            if($extraExistente){
                return redirect()->back()
                    ->with('info', "O extra já está cadastrado para o produto: <strong>$produto->nome</strong>.")
                    ->withInput();
            }


           if($this->ProdutoExtraModel->save($extraProduto)){

                return redirect()->back()
                    ->with('sucesso', 'Extra cadastrado com sucesso.')
                    ->with('info', "O extra foi adicionado ao produto: <strong>$produto->nome</strong>.");

            }else{

                return redirect()
                    ->back()
                    ->with('errors_model', $this->ProdutoExtraModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();

            }

        }else{

            return redirect()->back();

        }

    }

    public function excluirextra($id_principal = null, $id = null){

        if($this->request->getMethod() === 'post'){

            $produto = $this->buscaProdutoOu404($id);

            $produtoExtra = $this->ProdutoExtraModel->where('id', $id_principal)
                                ->where('produto_id', $produto->id)
                                ->first();

             if(!$produtoExtra){

                return redirect()->back()
                    ->with('atencao', "O extra não foi encontrado para o produto: <strong>$produto->nome</strong>.");

             }


             if($this->ProdutoExtraModel->delete($id_principal)){

                return redirect()->back()
                    ->with('sucesso', 'Extra excluído com sucesso.')
                    ->with('info', "O extra foi removido do produto: <strong>$produto->nome</strong>.");
             }


        }else{

            return redirect()->back();

        }

    }


    public function especificacoes($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        $data    = [
            'titulo'  => "Gerenciar as especificações do produto: $produto->nome",
            'produto' => $produto,
            'medidas' => $this->medidaModel->where('ativo', true)->findAll(),
            'produtoEspecificacoes' => $this->produtoEspecificacaoModel->buscaEspecificacoesDoProduto($produto->id, 10),
            'pager' => $this->produtoEspecificacaoModel->pager,
        ];

        
        return view('Admin/Produtos/especificacoes', $data);
    }


public function cadastrarespecificacoes($id = null)
{
    if ($this->request->getMethod() === 'post') {
        $produto = $this->buscaProdutoOu404($id);

        // Valor do input 'preco' já vem como "22.90" (via JS), só converter para float
        $precoBruto = $this->request->getPost('preco');
        $precoFinal = (float) $precoBruto;

        $especificacaoId = $this->request->getPost('especificacao_id');

        $dados = [
            'produto_id'   => $produto->id,
            'medida_id'    => $this->request->getPost('medida_id'),
            'preco'        => $precoFinal,
            'customizavel' => $this->request->getPost('customizavel'),
        ];

        // Se for edição
        if (!empty($especificacaoId)) {
            if ($this->produtoEspecificacaoModel->update($especificacaoId, $dados)) {
                return redirect()->back()->with('sucesso', 'Especificação atualizada com sucesso.');
            } else {
                return redirect()->back()
                    ->with('errors_model', $this->produtoEspecificacaoModel->errors())
                    ->with('atencao', 'Verifique os erros abaixo.')
                    ->withInput();
            }
        }

        // Se for novo
        $especificacaoExistente = $this->produtoEspecificacaoModel
            ->where('produto_id', $produto->id)
            ->where('medida_id', $dados['medida_id'])
            ->first();

        if ($especificacaoExistente) {
            return redirect()->back()
                ->with('info', "Essa medida já está cadastrada para o produto <strong>$produto->nome</strong>.")
                ->withInput();
        }

        if ($this->produtoEspecificacaoModel->save($dados)) {
            return redirect()->back()->with('sucesso', 'Especificação cadastrada com sucesso.');
        } else {
            return redirect()->back()
                ->with('errors_model', $this->produtoEspecificacaoModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }
    }

    return redirect()->back();
}

        public function excluirMedida($especificacao_id = null, $produto_id = null)
        {
            // Validação simples
            if (!$especificacao_id || !$produto_id) {
                return redirect()->back()->with('atencao', 'Dados inválidos para exclusão.');
            }

            // Tenta buscar a especificação
            $especificacao = $this->produtoEspecificacaoModel->where('id', $especificacao_id)
                                                            ->where('produto_id', $produto_id)
                                                            ->first();

            if (!$especificacao) {
                return redirect()->back()->with('atencao', 'Especificação não encontrada.');
            }

            // Tenta excluir
            if ($this->produtoEspecificacaoModel->delete($especificacao_id)) {
                return redirect()->back()->with('sucesso', 'A especificação foi removida com sucesso.');
            } else {
                return redirect()->back()
                    ->with('errors_model', $this->produtoEspecificacaoModel->errors())
                    ->with('atencao', 'Erro ao tentar excluir a especificação.');
            }
    }


    public function excluir($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        if ($this->request->getMethod() === 'post') {

            $imagem = $produto->imagem;

            // Remove a imagem do disco
            if ($imagem) {
                $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagem;

                if (is_file($caminhoImagem)) {
                    unlink($caminhoImagem);
                }

                // Atualiza o campo imagem como NULL antes de deletar
                $produto->imagem = null;
                $this->produtoModel->save($produto);
            }

            // Agora sim: deleta o produto (soft delete)
            $this->produtoModel->delete($id);

            return redirect()->to(site_url('admin/produtos'))
                ->with('sucesso', "Produto excluído com sucesso: <strong>$produto->nome</strong>.");
        }

        $data = [
            'titulo'  => "Excluindo o produto: $produto->nome",
            'produto' => $produto,
        ];

        return view('Admin/Produtos/excluir', $data);
    }



    public function desfazerExclusao($id = null)
    {
        $produto = $this->buscaProdutoOu404($id);

        if (null == $produto->deletado_em) {
            return redirect()->back()->with('info', 'Apenas produtos excluídos podem ser recuperados.');
        }

        if ($this->produtoModel->desfazerExclusao($id)) {
            return redirect()->back()->with('sucesso', 'Exclusão desfeita com sucesso.');
        } else {
            return redirect()
                ->back()
                ->with('errors_model', $this->produtoModel->errors())
                ->with('atencao', 'Verifique os erros abaixo.')
                ->withInput();
        }
    }


  

    private function buscaProdutoOu404(int $id = null)
    {
        if (!$id || !$produto = $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
            ->join('categorias', 'categorias.id = produtos.categoria_id')
            ->where('produtos.id', $id)
            ->withDeleted(true)
            ->first()) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Não encontramos o produto: $id");
        }

        return $produto;
    }
}
