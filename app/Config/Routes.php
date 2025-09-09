<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('Vizualizar', 'Home::Vizualizar');
$routes->get('vizualizar', 'Home::Vizualizar');
$routes->get('Vizualixar', 'Home::Vizualizar');
$routes->get('vizualixar', 'Home::Vizualizar');
$routes->get('login', 'Login::novo', ['filter' => 'visitante']);
$routes->get('produto/(:segment)', 'Produto::detalhes/$1');
$routes->get('registro', 'Registro::novo');
$routes->post('registro/criar', 'Registro::criar');


$routes->group('carrinho', function ($routes) {
    // Rota para exibir a página do carrinho de compras.
    // Ex: www.seusite.com/carrinho
    $routes->get('/', 'Carrinho::index', ['as' => 'carrinho']);
    $routes->post('adicionar', 'Carrinho::adicionar', ['as' => 'carrinho.adicionar']);

    $routes->get('remover/(:any)', 'Carrinho::remover/$1', ['as' => 'carrinho.remover']);

});

// Rota para a área do entregador

// app/Config/Routes.php
$routes->group('entregador', static function ($routes) {
    // Redireciona a raiz /entregador para o método login
    $routes->get('/', 'Entregador::login');
    $routes->get('login', 'Entregador::login');
    $routes->post('autenticar', 'Entregador::autenticar');
    $routes->get('painel', 'Entregador::painel', ['filter' => 'authEntregador']); // Rota protegida
    $routes->get('logout', 'Entregador::logout');
    $routes->post('atualizar_status', 'Entregador::atualizarStatusPedido');
});

$routes->get('/finalizar', 'Finalizar::index'); 
$routes->post('/finalizar/enviar', 'Finalizar::enviar');

$routes->group('admin', function($routes){

     // Rotas de Formas de Pagamento (sem alterações)
    $routes->get('formas', 'Admin\FormasPagamentos::index');
    $routes->add('formas/criar', 'Admin\FormasPagamentos::criar');
    $routes->post('formas/cadastrar', 'Admin\FormasPagamentos::cadastrar');
    $routes->get('formas/show/(:num)', 'Admin\FormasPagamentos::show/$1');
    $routes->add('formas/editar/(:num)', 'Admin\FormasPagamentos::editar/$1');
    $routes->post('formas/atualizar/(:num)', 'Admin\FormasPagamentos::atualizar/$1');
    $routes->add('formas/excluir/(:num)', 'Admin\FormasPagamentos::excluir/$1');
    $routes->get('formas/desfazerexclusao/(:num)', 'Admin\FormasPagamentos::desfazerExclusao/$1');
    $routes->get('formas/procurar', 'Admin\FormasPagamentos::procurar'); 

    // Rotas de Home (sem alterações)
    $routes->get('home', 'Admin\Home::index');
    $routes->get('home/atualizarDashboard', 'Admin\Home::atualizarDashboard');

    
    // --- ROTAS DE PEDIDOS (CORRIGIDAS E ORGANIZADAS) ---
    
    // Rota para exibir a lista de pedidos (com filtros)
    $routes->get('pedidos', 'Admin\Pedidos::index');

    
    

    
       // Rota para exibir a lista de extras
    $routes->get('extras', 'Admin\Extras::index');
    // Rota para exibir o formulário de criação de extra
    $routes->get('extras/criar', 'Admin\Extras::criar');
    // Rota para processar o cadastro de um novo extra
    $routes->post('extras/cadastrar', 'Admin\Extras::cadastrar');
    // Rota para procurar extras (usado no autocomplete)
    $routes->get('extras/procurar', 'Admin\Extras::procurar');
    // Rota para exibir detalhes de um extra específico
    $routes->get('extras/show/(:num)', 'Admin\Extras::show/$1');
    // Rota para exibir o formulário de edição de extra
    $routes->get('extras/editar/(:num)', 'Admin\Extras::editar/$1');
    // Rota para processar a atualização de um extra
    $routes->post('extras/atualizar/(:num)', 'Admin\Extras::atualizar/$1');
    // Rota para exibir a tela de confirmação de exclusão ou processar a exclusão
    $routes->add('extras/excluir/(:num)', 'Admin\Extras::excluir/$1');
    // Rota para desfazer a exclusão de um extra
    $routes->get('extras/desfazerexclusao/(:num)', 'Admin\Extras::desfazerExclusao/$1');

    $routes->get('empresa', 'Admin\EmpresaController::index');
    
    // Mostra os detalhes da empresa
    $routes->get('empresa/detalhes/(:num)', 'Admin\EmpresaController::detalhes/$1');
    
    // Formulário de criação (sem ID) ou edição (com ID)
    $routes->get('empresa/form', 'Admin\EmpresaController::form');
    $routes->get('empresa/form/(:num)', 'Admin\EmpresaController::form/$1');
    
    // Salva os dados do formulário
    $routes->post('empresa/save', 'Admin\EmpresaController::save');

    // Gerenciamento de fotos
    $routes->get('empresa/fotos/(:num)', 'Admin\EmpresaController::fotos/$1');
    $routes->post('empresa/uploadFotos', 'Admin\EmpresaController::uploadFotos');
    $routes->get('empresa/deleteFoto/(:num)/(:segment)', 'Admin\EmpresaController::deleteFoto/$1/$2');

    $routes->get('integracoes', 'Admin\IntegracoesController::index');
    $routes->get('integracoes/detalhes/(:num)', 'Admin\IntegracoesController::detalhes/$1');
    $routes->get('integracoes/form', 'Admin\IntegracoesController::form');
    $routes->get('integracoes/form/(:num)', 'Admin\IntegracoesController::form/$1');
    $routes->post('integracoes/save', 'Admin\IntegracoesController::save');
     
    $routes->group('pdv', function($routes){
        $routes->get('/', 'Admin\PdvController::index', ['as' => 'pdv.index']); // Adicionando 'index' para clareza
        $routes->post('buscarusuarios', 'Admin\PdvController::buscarUsuarios', ['as' => 'pdv.buscar.usuarios']);

        // Rota corrigida para capturar o ID do produto
        // A sua estava quase certa, apenas vamos garantir que o nome da rota seja mais claro
        $routes->get('buscaropcoes/(:num)', 'Admin\PdvController::buscarOpcoes/$1', ['as' => 'pdv.buscar.opcoes']);
        
        $routes->post('salvarvenda', 'Admin\PdvController::salvarVenda', ['as' => 'pdv.salvar.venda']);
    });
});





$routes->group('conta', ['filter' => 'login'], static function ($routes) {
    
    
    $routes->get('/', 'ContaUsuario::index', ['as' => 'conta']);
    $routes->get('editar', 'ContaUsuario::editar', ['as' => 'conta.editar']);
    $routes->post('atualizar', 'ContaUsuario::atualizar', ['as' => 'conta.atualizar']);

    // Rota para upload da foto de perfil
    $routes->post('upload-foto', 'ContaUsuario::uploadFoto', ['as' => 'conta.upload.foto']);
    // Rota para remover a foto de perfil
    $routes->get('remover-foto', 'ContaUsuario::removerFoto', ['as' => 'conta.remover.foto']);

    $routes->get('pedidos', 'OrdensController::index', ['as' => 'conta.pedidos']);
    $routes->get('pedidos/detalhes/(:num)', 'OrdensController::detalhes/$1', ['as' => 'conta.pedidos.detalhes']);

    
    // Suas rotas de endereço existentes
    $routes->get('enderecos', 'EnderecoController::index', ['as' => 'conta.enderecos']);
    $routes->get('enderecos/criar', 'EnderecoController::criar', ['as' => 'enderecos.criar']);
    $routes->post('enderecos/cadastrar', 'EnderecoController::cadastrar', ['as' => 'enderecos.cadastrar']);
    $routes->get('enderecos/editar/(:num)', 'EnderecoController::editar/$1', ['as' => 'enderecos.editar']);
    $routes->post('enderecos/atualizar/(:num)', 'EnderecoController::atualizar/$1', ['as' => 'enderecos.atualizar']);
    $routes->post('enderecos/excluir/(:num)', 'EnderecoController::excluir/$1', ['as' => 'enderecos.excluir']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
