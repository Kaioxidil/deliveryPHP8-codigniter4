<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Login do Entregador' ?></title>
    <link rel="shortcut icon" href="<?php echo site_url('web/') ?>assets/favicon.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --ifood-primary: #EA1D2C; /* Vermelho iFood */
            --ifood-secondary: #00A638; /* Verde (opcional para sucesso) */
            --ifood-background: #F8F8F8; /* Fundo cinza bem claro */
            --text-color: #333;
            --light-text-color: #777;
            --border-color: #E0E0E0; /* Cinza claro para bordas */
            --error-bg: #FEE8E9; /* Rosa claro para erros */
            --error-text: #EA1D2C; /* Vermelho iFood para erros */
            --info-bg: #E3F2FD; /* Azul claro */
            --info-text: #1976D2; /* Azul escuro */
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--ifood-background);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: var(--text-color);
            overflow-x: hidden;
        }

        .desktop-message {
            display: none;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            border-top: 5px solid var(--ifood-primary);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1000;
        }
        .desktop-message h2 {
            color: var(--ifood-primary);
            margin-bottom: 15px;
        }
        .desktop-message p {
            font-size: 1.1em;
            line-height: 1.6;
            color: var(--light-text-color);
        }

        .login-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
            border-top: 5px solid var(--ifood-primary);
            box-sizing: border-box;
            transition: transform 0.3s ease;
        }
        @media (min-width: 768px) {
            .login-container {
                display: none;
            }
            .desktop-message {
                display: block;
            }
        }

        .login-container h2 {
            margin-bottom: 25px;
            color: var(--ifood-primary);
            font-weight: 700;
            font-size: 2em;
        }
        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--light-text-color);
            font-weight: 600;
            font-size: 0.9em;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            border-color: var(--ifood-primary);
            outline: none;
        }
        .btn-login {
            width: 100%;
            padding: 16px;
            background-color: var(--ifood-primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-transform: uppercase;
        }
        .btn-login:hover {
            background-color: #C01B26; /* Vermelho um pouco mais escuro */
            transform: translateY(-2px);
        }
        .message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            border: 1px solid;
        }
        .message.error {
            background-color: var(--error-bg);
            color: var(--error-text);
            border-color: var(--error-text);
        }
        .message.success {
            background-color: #E8F5E9;
            color: var(--ifood-secondary);
            border-color: var(--ifood-secondary);
        }
        .message.info {
            background-color: var(--info-bg);
            color: var(--info-text);
            border-color: var(--info-text);
        }
        .list-errors {
            list-style-type: none;
            padding: 0;
            margin: 10px 0 0 0;
            color: var(--error-text);
            font-size: 14px;
            text-align: left;
        }
        .list-errors li {
            margin-bottom: 5px;
        }
        
        .logo-entregador {
            width: 120px; /* Tamanho da logo */
            height: auto;
            margin-bottom: 20px; /* Espaçamento abaixo da logo */
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="desktop-message">
        <h2>Acesso Apenas Pelo Celular</h2>
        <p>Este aplicativo é otimizado para entregadores e foi projetado para ser usado em dispositivos móveis.</p>
        <p>Por favor, acesse-o através do seu smartphone para ter a melhor experiência.</p>
    </div>

    <div class="login-container">
        <img src="<?php echo site_url('admin/images/logo.svg') ?>" alt="Logo do Aplicativo" class="logo-entregador">
        <h2><?= $titulo ?? 'Entrar' ?></h2>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="message error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('info')): ?>
            <div class="message info">
                <?= session()->getFlashdata('info') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="message success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (isset($errors)): ?>
            <ul class="list-errors">
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?= form_open('entregador/autenticar') ?>

            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" id="nome" name="nome" value="<?= old('nome') ?>" required autofocus>
            </div>

            <div class="form-group">
                <label for="cpf">CPF (000.000.000-00)</label>
                <input type="text" id="cpf" name="cpf" value="<?= old('cpf') ?>" required placeholder="000.000.000-00">
            </div>

            <button type="submit" class="btn-login">Entrar</button>

        <?= form_close() ?>
    </div>

    <script>
        // Máscara para CPF
        document.addEventListener('DOMContentLoaded', function() {
            const cpfInput = document.getElementById('cpf');
            if (cpfInput) {
                cpfInput.addEventListener('input', function (e) {
                    let value = e.target.value;
                    value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
                    if (value.length > 0) {
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d)/, '$1.$2');
                        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                    }
                    e.target.value = value;
                });
            }

            // Lógica para esconder/mostrar em desktop
            const loginContainer = document.querySelector('.login-container');
            const desktopMessage = document.querySelector('.desktop-message');
            const mobileBreakpoint = 768; // Defina o ponto de quebra para mobile (em pixels)

            function checkDeviceSize() {
                if (window.innerWidth >= mobileBreakpoint) {
                    loginContainer.style.display = 'none';
                    desktopMessage.style.display = 'block';
                } else {
                    loginContainer.style.display = 'block';
                    desktopMessage.style.display = 'none';
                }
            }

            // Executa a função na carga da página
            checkDeviceSize();

            // Adiciona um listener para quando a janela for redimensionada
            window.addEventListener('resize', checkDeviceSize);
        });
    </script>
</body>
</html>