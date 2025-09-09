 <div style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">

        <!-- Conteúdo -->
        <h1 style="color: #2c3e50; font-size: 24px; text-align: center;">Redefinição de Senha</h1>
        <p style="font-size: 16px; line-height: 1.6; text-align: center;">
            Você solicitou a redefinição da sua senha. Para continuar, clique no botão abaixo:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="<?php echo site_url('password/reset/'.$token); ?>" style="background-color: #3498db; color: #fff; text-decoration: none; padding: 12px 25px; border-radius: 5px; font-size: 16px;">
                Redefinir Senha
            </a>
        </div>

        <p style="font-size: 14px; color: #888; text-align: center;">
            Se você não solicitou essa redefinição, pode ignorar este e-mail com segurança.
        </p>

        <hr style="margin: 40px 0; border: none; border-top: 1px solid #eee;">

        <p style="font-size: 12px; color: #aaa; text-align: center;">
            &copy; <?php echo date('Y'); ?> SeuDelivery. Todos os direitos reservados.
        </p>
    </div>