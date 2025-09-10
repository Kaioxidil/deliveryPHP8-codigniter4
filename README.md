# Delivery em PHP 8 + CodeIgniter 4 (Estilo Cardápio Web) / Delivery System in PHP 8 + CodeIgniter 4 (Web Menu Style)

## Descrição / Description

**PT-BR:**
Este projeto tem como objetivo a construção de um sistema de delivery no estilo cardápio web, desenvolvido em **PHP 8** com **CodeIgniter 4**.

**EN:**
This project aims to build a delivery system in web menu style, developed using **PHP 8** and **CodeIgniter 4**.

---

## Branches

**PT-BR:**

* Novas funcionalidades e melhorias devem ser adicionadas em *branches próprias*, identificadas com o nome do autor.
* Em cada branch, inclua um `README.md` explicando as alterações realizadas e o que diferencia o sistema da versão original.

**EN:**

* New features and improvements must be added in *separate branches*, identified with the contributor’s name.
* Each branch must include a `README.md` explaining the changes made and what differentiates the system from the original version.

---

## Regras de uso / Usage Rules

**PT-BR:**

* O sistema é **exclusivamente para fins educacionais e de desenvolvimento pessoal**.
* **Uso comercial não é permitido.** Qualquer tentativa de utilização comercial pode resultar em advertências e possíveis medidas legais.

**EN:**

* This project is **strictly for educational and personal development purposes only**.
* **Commercial use is not allowed.** Any attempt to use it for commercial purposes may lead to warnings and potential legal action.

---

## Pré-requisitos / Prerequisites

* Windows (recomendo para XAMPP) ou Linux/macOS
* XAMPP (inclui Apache, MySQL, phpMyAdmin e PHP) — use uma versão com **PHP 8**
* Git (opcional para clonar o repositório)
* Acesso ao terminal/PowerShell (Windows) ou terminal (Linux/macOS)

---

## Passo a passo de instalação (Windows + XAMPP) / Step-by-step installation (Windows + XAMPP)

> A seguir tem os passos para configurar o ambiente, criar o banco `food`, rodar migrations e seeders do CodeIgniter 4. Todos os comandos abaixo são *copy-paste*.

### 1) Instalar XAMPP

**PT-BR:**

1. Baixe o XAMPP com PHP 8 em [https://www.apachefriends.org](https://www.apachefriends.org).
2. Instale normalmente em `C:\xampp` (padrão).
3. Abra o XAMPP Control Panel e inicie **Apache** e **MySQL**.

**EN:**

1. Download XAMPP with PHP 8 from [https://www.apachefriends.org](https://www.apachefriends.org).
2. Install (default to `C:\xampp`).
3. Open XAMPP Control Panel and start **Apache** and **MySQL**.

### 2) (Opcional) Adicionar PHP do XAMPP ao PATH do sistema (Windows)

> Isso permite usar `php` e `php spark` de qualquer terminal.

**PT-BR – instrução manual:**

1. Abra *Painel de Controle > Sistema > Configurações avançadas do sistema > Variáveis de Ambiente*
2. Edite a variável `Path` (do usuário ou do sistema) e adicione: `C:\xampp\php`
3. Abra um novo PowerShell/Prompt para que a variável atualize.

**PT-BR – comando (PowerShell como Administrador):**

```powershell
setx PATH "%PATH%;C:\xampp\php"
```

> Após executar, feche e reabra o terminal.

**EN – manual:**

1. Open *Control Panel > System > Advanced system settings > Environment Variables*.
2. Edit `Path` and add `C:\xampp\php`.
3. Open a new terminal to apply changes.

**EN – command (PowerShell as Admin):**

```powershell
setx PATH "%PATH%;C:\xampp\php"
```

**Verificar PHP:**

```bash
php -v
# deve mostrar PHP 8.x
```

### 3) Clonar repositório

```bash
# no PowerShell/terminal
git clone <URL-DO-REPO> delivery-project
cd delivery-project
```

> Se você não usa Git, apenas extraia/fazer upload dos arquivos para a pasta do projeto.

### 4) Colocar projeto na pasta do Apache (opcional) ou usar servidor embutido

**Opção A – Usar XAMPP (Apache):**

* Copie a pasta do projeto para `C:\xampp\htdocs\delivery-project`
* Acesse: `http://localhost/delivery-project/public` ou configure VirtualHost.

**Opção B – Usar servidor do CodeIgniter (recomendado para desenvolvimento):**

```bash
# estando na raiz do projeto
php spark serve 
# depois acesse http://127.0.0.1:8080 (localhost:8080)
```



2. Abra `.env` e configure as variáveis do banco. Exemplo mínimo (cole e edite conforme necessário):

```
CI_ENVIRONMENT = development
app.baseURL = 'http://127.0.0.1:8080' ou (localhost:8080)

database.default.hostname = localhost
database.default.database = food
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

> No XAMPP o `username` padrão é `root` e a `password` normalmente é vazia.

**EN:**


2. Edit `.env` and set DB variables. Example:

```
CI_ENVIRONMENT = development
app.baseURL = 'http://127.0.0.1:8080' (localhost:8080)

database.default.hostname = localhost
database.default.database = food
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```

### 6) Criar banco de dados `food` no phpMyAdmin

**PT-BR:**

1. Abra `http://localhost/phpmyadmin`.
2. Clique em **New** (Novo) na barra lateral.
3. No campo *Database name* digite: `food` e clique em **Create**.
4. (Opcional) Escolha collation `utf8mb4_general_ci`.

**EN:**

1. Open `http://localhost/phpmyadmin`.
2. Click **New**.
3. Enter `food` as the database name and click **Create**.
4. (Optional) Set collation to `utf8mb4_general_ci`.

### 7) Rodar Migrations

**PT-BR:**
No terminal (raiz do projeto) execute:

```bash
php spark migrate
```

Isso executa as migrations disponíveis em `app/Database/Migrations`.

**EN:**
Run migrations from the project root:

```bash
php spark migrate
```

This will run migrations in `app/Database/Migrations`.

### 8) Rodar Seeders

**PT-BR:**

* Verifique os seeders dentro de `app/Database/Seeds` e veja os nomes das classes (ex: `FoodSeeder`, `UserSeeder`, `DatabaseSeeder`).
* Comando para rodar um seeder:

```bash
php spark db:seed FoodSeeder
```

* Se houver um seeder principal (ex.: `DatabaseSeeder`) que chama outros seeders, rode:

```bash
php spark db:seed DatabaseSeeder
```

**EN:**

* Check seeders in `app/Database/Seeds` and note the class names (e.g. `FoodSeeder`, `UserSeeder`, `DatabaseSeeder`).
* Run a specific seeder:

```bash
php spark db:seed FoodSeeder
```

* If there's a main seeder (`DatabaseSeeder`) that calls others:

```bash
php spark db:seed DatabaseSeeder
```

> Se quiser rodar vários seeders de uma vez, execute os comandos um a um.

### 9) Permissões (Linux/macOS)

**PT-BR:**
Se estiver em Linux/macOS, ajuste permissões da pasta `writable`:

```bash
sudo chown -R $USER:www-data writable
sudo chmod -R 775 writable
```

**EN:**
If on Linux/macOS, set writable permissions:

```bash
sudo chown -R $USER:www-data writable
sudo chmod -R 775 writable
```

### 10) Comandos úteis (copiar/colar)

```bash
# verificar php
php -v

# rodar servidor local (CodeIgniter)
php spark serve --host=127.0.0.1 --port=8080

# rodar migrations
php spark migrate

# rodar um seeder
php spark db:seed FoodSeeder

# rodar todos (executar cada seeder manualmente ou usar um DatabaseSeeder)
php spark db:seed DatabaseSeeder
```

---

## Dicas e resoluções de problemas / Tips & Troubleshooting

* Se `php` não for reconhecido, verifique se o diretório `C:\xampp\php` está no `PATH` e reinicie o terminal.
* Erro de conexão com banco: revise as credenciais em `.env` ou `app/Config/Database.php`.
* Se migrations não encontrarem classes, confirme namespace e nome dos arquivos em `app/Database/Migrations`.

---

## Observações finais / Final notes

**PT-BR:**

* Este README contém instruções passo a passo para você preparar seu ambiente local com XAMPP, criar o banco `food`, rodar migrations e seeders usando CodeIgniter 4.
* Se quiser, posso também gerar um arquivo `LICENSE` personalizado (uso educacional somente) pronto para adicionar ao repositório.

**EN:**

* This README provides step-by-step instructions to prepare a local environment with XAMPP, create the `food` database, and run migrations and seeders using CodeIgniter 4.
* If you want, I can also create a custom `LICENSE` file (educational use only) ready to add to the repository.

---

*Se precisar de adaptações (Linux/macOS, Docker, VirtualHost ou exemplo de seeders/migrations prontos), me diga que eu adapto.*
