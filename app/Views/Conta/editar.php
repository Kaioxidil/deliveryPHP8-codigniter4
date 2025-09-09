<?php echo $this->extend('layout/principalView'); ?>

<?= $this->section('titulo') ?> <?= esc($titulo) ?> <?= $this->endSection() ?>

<?php echo $this->section('conteudo'); ?>

<style>
    /* Estilos do menu lateral (mantidos para consistência visual) */
    .menu-lateral .list-group-item {
        border: none; border-left: 4px solid transparent; border-radius: 0;
        padding: 15px 20px; font-weight: 500; color: #555;
    }
    .menu-lateral .list-group-item:hover,
    .menu-lateral .list-group-item:focus {
        background-color: #e9ecef; color: #000;
    }
    .menu-lateral .list-group-item.active {
        border-left: 4px solid #EA1D2C; /* Cor principal iFood */
        background-color: #f7f7f7; font-weight: 700; color: #EA1D2C;
    }
    .menu-lateral .list-group-item i {
        margin-right: 12px; width: 20px;
    }

    /* Estilos do formulário de edição */
    .form-section {
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .profile-photo-upload-container {
        text-align: center;
        margin-bottom: 30px; /* Espaçamento abaixo do bloco de foto */
    }
    .profile-photo-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #EA1D2C;
        padding: 3px;
        margin-bottom: 15px;
    }
    .btn-file-upload {
        display: block;
        width: fit-content;
        margin: 0 auto;
        cursor: pointer;
        padding: 8px 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f8f8f8;
        color: #555;
        font-weight: 500;
        transition: background-color 0.2s ease;
    }
    .btn-file-upload:hover {
        background-color: #eee;
    }
    .form-group label {
        font-weight: 600;
        color: #555;
        margin-bottom: 0.5rem;
    }
    .form-control {
        border-radius: 5px;
        padding: 10px 15px;
        border: 1px solid #ced4da;
    }
    .form-control:focus {
        border-color: #EA1D2C;
        box-shadow: 0 0 0 0.25rem rgba(234, 29, 44, 0.25);
    }
    .text-danger {
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block; /* Garante que o erro fique em sua própria linha */
    }
    .buttons-group {
        margin-top: 30px;
        display: flex;
        gap: 15px;
        justify-content: flex-start;
        /* Adicionado para responsividade */
        flex-wrap: wrap; /* Permite que os botões quebrem a linha */
    }
    .buttons-group .btn {
        min-width: 140px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 6px;
        /* Ajuste para mobile */
        flex-grow: 1; /* Permite que os botões cresçam para preencher o espaço */
    }
    .btn-primary {
        background-color: #EA1D2C;
        border-color: #EA1D2C;
    }
    .btn-primary:hover {
        background-color: #e01b2a;
        border-color: #e01b2a;
    }

    /* --- Ajustes para Mobile --- */
    @media (max-width: 768px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Menu lateral em telas menores */
        .col-lg-3 {
            margin-bottom: 30px; /* Espaçamento abaixo do menu lateral */
        }
        .menu-lateral {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05); /* Sombra mais sutil */
        }
        .menu-lateral .list-group-item {
            padding: 12px 15px; /* Menor padding */
            font-size: 0.95rem; /* Fonte ligeiramente menor */
        }

        /* Formulário de edição */
        .form-section {
            padding: 25px 20px; /* Menor padding em telas pequenas */
        }
        .profile-photo-preview {
            width: 120px; /* Reduz o tamanho da foto de perfil */
            height: 120px;
        }
        .buttons-group {
            flex-direction: column; /* Botões empilham em coluna */
            gap: 10px; /* Menor espaço entre os botões */
        }
        .buttons-group .btn {
            min-width: unset; /* Remove o min-width para se ajustar melhor */
            width: 100%; /* Botões ocupam toda a largura disponível */
            padding: 10px 15px; /* Menor padding nos botões */
            font-size: 0.95rem; /* Fonte ligeiramente menor */
        }
    }
</style>

<br>
<br>
<br>

<div class="container mt-5 mb-5">
    <div class="row">

        <div class="col-lg-3">
            <div class="menu-lateral bg-white rounded shadow-sm">
                <div class="list-group list-group-flush">
                    <a href="<?= site_url('conta') ?>" class="list-group-item list-group-item-action active"><i class="bi bi-person-circle"></i> Meu Perfil</a>
                    <a href="<?= site_url('conta/pedidos') ?>" class="list-group-item list-group-item-action "><i class="bi bi-box-seam"></i> Meus Pedidos</a>
                    <a href="<?= site_url('conta/enderecos') ?>" class="list-group-item list-group-item-action "><i class="bi bi-geo-alt"></i> Meus Endereços</a>
                    <a href="<?= site_url('login/logout') ?>" class="list-group-item list-group-item-action text-danger"><i class="bi bi-box-arrow-right"></i> Sair</a>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h2><?php echo esc($titulo); ?></h2>
            <hr>

            <?php if(session()->has('sucesso')): ?>
                <div class="alert alert-success"><?php echo session('sucesso'); ?></div>
            <?php endif; ?>
            <?php if(session()->has('erro')): ?>
                <div class="alert alert-danger"><?php echo session('erro'); ?></div>
            <?php endif; ?>
            <?php if(session()->has('info')): ?>
                <div class="alert alert-info"><?php echo session('info'); ?></div>
            <?php endif; ?>

            <?php if(session()->has('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-section">
                <?php echo form_open_multipart(route_to('conta.upload.foto')); ?>
                    <div class="profile-photo-upload-container">
                        <img id="image-preview" src="<?= $usuario->foto_perfil ? site_url('uploads/usuarios/' . $usuario->foto_perfil) : site_url('web/assets/seudelivery.png') ?>" alt="Prévia da Foto" class="profile-photo-preview">
                        
                        <div class="mb-3">
                            <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" accept="image/png, image/jpeg, image/jpg, image/webp">
                            <?php if (session()->has('errors.foto_perfil')): ?>
                                <span class="text-danger"><?= esc(session('errors.foto_perfil')) ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Enviar Nova Foto</button>
                            <?php if ($usuario->foto_perfil): ?>
                                <a href="<?= site_url('conta/remover-foto') ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja remover sua foto de perfil?');">Remover Foto Atual</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php echo form_close(); ?>

                <hr class="my-5">

                <?php echo form_open(route_to('conta.atualizar')); ?>
                
                    <div class="form-group mb-4">
                        <label for="nome">Nome Completo:</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= old('nome', esc($usuario->nome)) ?>">
                        <?php if (session()->has('errors.nome')): ?>
                            <span class="text-danger"><?= esc(session('errors.nome')) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= old('email', esc($usuario->email)) ?>">
                        <?php if (session()->has('errors.email')): ?>
                            <span class="text-danger"><?= esc(session('errors.email')) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-4">
                        <label for="cpf">CPF:</label>
                        <input type="text" class="form-control" id="cpf" name="cpf" value="<?= old('cpf', esc($usuario->cpf)) ?>" data-mask="000.000.000-00">
                        <?php if (session()->has('errors.cpf')): ?>
                            <span class="text-danger"><?= esc(session('errors.cpf')) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-4">
                        <label for="telefone">Telefone:</label>
                        <input type="text" class="form-control" id="telefone" name="telefone" value="<?= old('telefone', esc($usuario->telefone)) ?>" data-mask="(00) 00000-0000">
                        <?php if (session()->has('errors.telefone')): ?>
                            <span class="text-danger"><?= esc(session('errors.telefone')) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="buttons-group">
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                        <a href="<?= site_url('conta') ?>" class="btn btn-secondary">Cancelar</a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<?php echo $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        // Aplica as máscaras
        $('#cpf').mask('000.000.000-00', {reverse: true});
        $('#telefone').mask('(00) 00000-0000');

        // Pré-visualização da imagem (mantida para a experiência do usuário)
        $('#foto_perfil').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                // Se nenhum arquivo for selecionado, volta para a imagem original (ou padrão)
                $('#image-preview').attr('src', '<?= $usuario->foto_perfil ? site_url('uploads/usuarios/' . $usuario->foto_perfil) : site_url('web/assets/seudelivery.png') ?>');
            }
        });
    });
</script>
<?= $this->endSection(); ?>