<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <style>
        /* Reset básico */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }

        .main-content {
            background-color: #ffffff;
            max-width: 600px;
            width: 100%;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 24px;
            text-align: center;
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 15px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        ul.errors {
            list-style: none;
            padding-left: 15px;
            margin-top: 10px;
        }

        ul.errors li {
            margin-bottom: 5px;
        }

        a.button {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .add-button {
            background-color: #28a745;
            color: white;
        }

        .add-button:hover {
            background-color: #218838;
        }

        .edit-link {
            background-color: #ffc107;
            color: #212529;
            margin-right: 10px;
        }

        .edit-link:hover {
            background-color: #e0a800;
        }

        p {
            margin-bottom: 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    

    <div class="main-content">
        <h1><?= esc($title) ?></h1>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="message success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="message error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="message error">
                <p><strong>Por favor, corrija os seguintes erros:</strong></p>
                <ul class="errors">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!isset($empresa)) $empresa = null; ?>

        <?php if (!$empresa): ?>
            <p>Nenhuma empresa cadastrada. Por favor, 
                <br>
                <a href="<?= site_url('admin/empresa/form') ?>" class="button add-button">Cadastre a Empresa</a>
            </p>
        <?php else: ?>
            <p>A empresa já está cadastrada. Você pode 
                <a href="<?= site_url('admin/empresa/detalhes/' . $empresa->id) ?>" class="button edit-link">Ver Detalhes</a> 
                ou 
                <a href="<?= site_url('admin/empresa/form/' . $empresa->id) ?>" class="button edit-link">Editar</a> 
                as informações dela.
            </p>
        <?php endif; ?>
    </div>
</body>
</html>
