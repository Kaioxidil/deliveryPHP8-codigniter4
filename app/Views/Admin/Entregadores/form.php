<div class="row">
   <div class="form-group col-md-4">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" name="nome" value="<?= old('nome', $entregador->nome); ?>">
            </div>

            <div class="form-group col-md-4">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control cpf" name="cpf" value="<?= old('cpf', $entregador->cpf); ?>">
            </div>

            <div class="form-group col-md-4">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control sp_celphones" name="telefone" value="<?= old('telefone', $entregador->telefone); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" value="<?= old('email', $entregador->email); ?>">
            </div>

            <div class="form-group col-md-6">
                <label for="cnh">CNH</label>
                <input type="text" class="form-control" name="cnh" value="<?= old('cnh', $entregador->cnh); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="endereco">Endereço</label>
                <input type="text" class="form-control" name="endereco" value="<?= old('endereco', $entregador->endereco); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="veiculo">Veículo</label>
                <input type="text" class="form-control" name="veiculo" value="<?= old('veiculo', $entregador->veiculo); ?>">
            </div>

            <div class="form-group col-md-6">
                <label for="placa">Placa</label>
                <input type="text" class="form-control" name="placa" value="<?= old('placa', $entregador->placa); ?>">
            </div>
        </div>

        <div class="form-row m-lg-1">
            <div class="form-check form-check-flat form-check-primary">
                <label for="ativo" class="form-check-label">
                    <input type="hidden" name="ativo" value="0">
                    <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1"
                        <?php if (old('ativo', $entregador->ativo)): ?> checked="" <?php endif;?>>
                    Ativo
                </label>
            </div>
        </div>

<br />

<button type="submit" class="btn btn-primary btn mr-2">Salvar</button>

