<?= $this->extend('Admin/layout/main') ?>

<?= $this->section('titulo') ?>
    <?= $title ?>
<?= $this->endSection() ?>

<?= $this->section('estilos') ?>
<style>
    /* Estilos Gerais para um visual mais limpo e moderno */
    body {
        background-color: #f4f7f9;
        font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
    }
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9ecef;
        border-radius: 12px 12px 0 0 !important;
        font-weight: 600;
        color: #343a40;
        padding: 1.5rem;
    }
    .card-body {
        padding: 1.5rem;
    }
    .card-footer {
        background-color: #fff;
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 12px 12px !important;
        padding: 1.25rem;
    }

    /* Estilos para os campos de formulário */
    .form-control, .form-check-input {
        border-radius: 8px;
    }
    .form-control {
        border: 1px solid #ced4da;
        padding: 10px 15px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .form-group label {
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }
    .form-check-label {
        font-weight: normal;
        color: #495057;
    }
    .alert-danger {
        border-radius: 8px;
        font-weight: 500;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    /* Títulos e linhas de separação */
    .card-title {
        font-weight: 600;
        color: #343a40;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    hr {
        margin-top: 2rem;
        margin-bottom: 2rem;
    }

    /* Botões */
    .btn {
        font-weight: 600;
        border-radius: 8px;
        padding: 10px 20px;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }
    .btn-outline-info {
        color: #17a2b8;
        border-color: #17a2b8;
        transition: all 0.3s ease;
    }
    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('conteudo') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3><?= esc($title) ?></h3>
            </div>
            <?= form_open('admin/empresa/save') ?>
                <div class="card-body">
                    <?php if (session()->has('errors')): ?>
                        <div class="alert alert-danger">
                            <?php foreach (session('errors') as $error): ?>
                                <p><?= esc($error) ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="id" value="<?= $empresa->id ?? '' ?>">
                    
                    <h5 class="card-title">Informações Principais</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome">Nome da Empresa</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= old('nome', $empresa->nome ?? '') ?>" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $empresa->email ?? '') ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="faixa_preco">Faixa de Preço</label>
                            <select class="form-control" id="faixa_preco" name="faixa_preco">
                                <option value="">Escolha...</option>
                                <option value="$" <?= (old('faixa_preco', $empresa->faixa_preco ?? '') == '$') ? 'selected' : '' ?>>$</option>
                                <option value="$$" <?= (old('faixa_preco', $empresa->faixa_preco ?? '') == '$$') ? 'selected' : '' ?>>$$</option>
                                <option value="$$$" <?= (old('faixa_preco', $empresa->faixa_preco ?? '') == '$$$') ? 'selected' : '' ?>>$$$</option>
                                <option value="$$$$" <?= (old('faixa_preco', $empresa->faixa_preco ?? '') == '$$$$') ? 'selected' : '' ?>>$$$$</option>
                                <option value="$$$$$" <?= (old('faixa_preco', $empresa->faixa_preco ?? '') == '$$$$$') ? 'selected' : '' ?>>$$$$$</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição do Restaurante</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3"><?= old('descricao', $empresa->descricao ?? '') ?></textarea>
                    </div>
                    
                    <hr>
                    <h5 class="card-title">Contatos e Redes Sociais</h5>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="telefone">Telefone Fixo</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" value="<?= old('telefone', $empresa->telefone ?? '') ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="celular">Celular / WhatsApp</label>
                            <input type="text" class="form-control" id="celular" name="celular" value="<?= old('celular', $empresa->celular ?? '') ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="link_facebook">Facebook</label>
                            <input type="url" class="form-control" id="link_facebook" name="link_facebook" placeholder="https://facebook.com/seunegocio" value="<?= old('link_facebook', $empresa->link_facebook ?? '') ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="link_instagram">Instagram</label>
                            <input type="url" class="form-control" id="link_instagram" name="link_instagram" placeholder="https://instagram.com/seunegocio" value="<?= old('link_instagram', $empresa->link_instagram ?? '') ?>">
                        </div>
                    </div>

                    <hr>
                    <h5 class="card-title">Endereço e Localização</h5>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" value="<?= old('cep', $empresa->cep ?? '') ?>">
                        </div>
                        <div class="form-group col-md-5">
                            <label for="logradouro">Logradouro</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro" value="<?= old('logradouro', $empresa->logradouro ?? '') ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="numero">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" value="<?= old('numero', $empresa->numero ?? '') ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="bairro">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" value="<?= old('bairro', $empresa->bairro ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="<?= old('cidade', $empresa->cidade ?? '') ?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="estado">Estado (UF)</label>
                            <input type="text" class="form-control" id="estado" name="estado" maxlength="2" value="<?= old('estado', $empresa->estado ?? '') ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" value="<?= old('complemento', $empresa->complemento ?? '') ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="maps_iframe">Código iFrame do Google Maps</label>
                        <textarea class="form-control" id="maps_iframe" name="maps_iframe" rows="3"><?= old('maps_iframe', $empresa->maps_iframe ?? '') ?></textarea>
                    </div>
                    
                    <hr>
                    <h5 class="card-title">Horários de Funcionamento</h5>
                    <?php 
                        $dias = ['monday' => 'Segunda-feira', 'tuesday' => 'Terça-feira', 'wednesday' => 'Quarta-feira', 'thursday' => 'Quinta-feira', 'friday' => 'Sexta-feira', 'saturday' => 'Sábado', 'sunday' => 'Domingo'];
                        $opcoes_horario = ['Fechado'];
                        for ($h = 0; $h < 24; $h++) {
                            for ($m = 0; $m < 60; $m += 30) {
                                $opcoes_horario[] = sprintf('%02d:%02d', $h, $m);
                            }
                        }
                    ?>
                    <?php foreach($dias as $key => $dia): ?>
                        <?php
                            $horario_dia = old('horarios.'.$key, $horarios[$key] ?? 'Fechado');
                            $partes = explode(' - ', $horario_dia);
                            $abertura = ($horario_dia !== 'Fechado' && isset($partes[0])) ? $partes[0] : 'Fechado';
                            $fechamento = ($horario_dia !== 'Fechado' && isset($partes[1])) ? $partes[1] : 'Fechado';
                        ?>
                        <div class="form-row align-items-center mb-2">
                            <div class="col-md-2"><label><?= $dia ?></label></div>
                            <div class="col-md-4">
                                <select class="form-control horario-abertura" name="horarios[<?= $key ?>][abertura]" id="horario-abertura-<?= $key ?>">
                                    <?php foreach($opcoes_horario as $opcao): ?>
                                        <option value="<?= $opcao ?>" <?= ($opcao == $abertura) ? 'selected' : '' ?>><?= $opcao ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-control horario-fechamento" name="horarios[<?= $key ?>][fechamento]" id="horario-fechamento-<?= $key ?>">
                                    <?php foreach($opcoes_horario as $opcao): ?>
                                        <option value="<?= $opcao ?>" <?= ($opcao == $fechamento) ? 'selected' : '' ?>><?= $opcao ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php if($key === 'monday'): ?>
                                <div class="col-md-2">
                                    <button type="button" id="replicar-horarios" class="btn btn-sm btn-outline-info">Replicar para todos</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <h5 class="card-title">Configurações de Pedidos</h5>
                    <div class="form-group col-md-3">
                        <label for="pedidos_por_hora">Pedidos Máximos por Hora</label>
                        <input type="number" min="0" class="form-control" id="pedidos_por_hora" name="pedidos_por_hora" 
                            value="<?= old('pedidos_por_hora', $empresa->pedidos_por_hora ?? 0) ?>">
                        <small class="form-text text-muted">Defina 0 para ilimitado.</small>
                    </div>

                    <hr>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="ativo" id="ativo" value="1" <?php if(old('ativo', $empresa->ativo ?? 1) ): ?> checked <?php endif; ?>> 
                            Empresa Ativa
                        </label>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-content-save"></i> Salvar</button>
                    <?php if (isset($empresa)): ?>
                        <a href="<?= site_url('admin/empresa/detalhes/' . $empresa->id) ?>" class="btn btn-secondary"><i class="mdi mdi-cancel"></i> Cancelar</a>
                    <?php endif; ?>
                </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        // Adiciona o evento de clique ao botão de replicar
        const replicarBtn = document.getElementById('replicar-horarios');
        if (replicarBtn) {
            replicarBtn.addEventListener('click', () => {
                const aberturaSegunda = document.getElementById('horario-abertura-monday').value;
                const fechamentoSegunda = document.getElementById('horario-fechamento-monday').value;

                const todasAberturas = document.querySelectorAll('.horario-abertura');
                const todosFechamentos = document.querySelectorAll('.horario-fechamento');

                for (let i = 1; i < todasAberturas.length; i++) {
                    todasAberturas[i].value = aberturaSegunda;
                }
                for (let i = 1; i < todosFechamentos.length; i++) {
                    todosFechamentos[i].value = fechamentoSegunda;
                }
            });
        }

        // Lógica para transformar os horários em string antes de enviar o formulário
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const dias = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            dias.forEach(dia => {
                const abertura = document.getElementById(`horario-abertura-${dia}`).value;
                const fechamento = document.getElementById(`horario-fechamento-${dia}`).value;

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = `horarios[${dia}]`;

                if (abertura === 'Fechado' || fechamento === 'Fechado') {
                    hiddenInput.value = 'Fechado';
                } else {
                    hiddenInput.value = `${abertura} - ${fechamento}`;
                }
                form.appendChild(hiddenInput);
            });
        });
    });
</script>
<?= $this->endSection() ?>