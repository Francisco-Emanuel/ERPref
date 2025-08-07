# PREF-DESK - Sistema de Help Desk

<p align="center">
  <img src="https://raw.githubusercontent.com/Francisco-Emanuel/PREF-DESK/refs/heads/main/public/logo.svg" width="200" alt="Pref-desk Logo">
</p>

`PREF-DESK` é um sistema de Help Desk para gestão de chamados de TI, desenvolvido como um projeto acadêmico. O sistema permite o gerenciamento de ativos, controle de chamados, gerenciamento de usuários e departamentos, tudo em uma interface simples e moderna.

## ✨ Funcionalidades

* **Dashboard:** Visão geral com estatísticas rápidas.
* **Gestão de Chamados:** Abertura, atribuição, acompanhamento e fechamento de chamados.
* **Gestão de Usuários e Permissões:** Controle de acesso baseado em papéis (Admin, Supervisor, Técnico, etc.).
* **Relatórios:** Geração de Ordens de Serviço em PDF.

## 🛠️ Pré-requisitos

Antes de começar, certifique-se de que você tem o seguinte software instalado em sua máquina:

* **PHP** (versão ^8.2 ou superior)
* **Composer** (para gerenciamento de dependências PHP)
* **Node.js e NPM** (para gerenciamento de dependências de frontend)
* Um banco de dados compatível com o Laravel (ex: **MySQL**, **PostgreSQL**, **SQLite**)

## 🚀 Instalação e Execução

Siga os passos abaixo para configurar e executar o projeto em seu ambiente local:

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/francisco-emanuel/PREF-DESK.git](https://github.com/francisco-emanuel/PREF-DESK.git)
    cd PREF-DESK
    ```

2.  **Instale as dependências do Composer:**
    ```bash
    composer install
    ```

3.  **Crie o arquivo de ambiente:**
    Copie o arquivo de exemplo `.env.example` para criar seu próprio arquivo de configuração `.env`.
    ```bash
    cp .env.example .env
    ```

4.  **Gere a chave da aplicação:**
    Este comando irá gerar uma chave única para a sua aplicação no arquivo `.env`.
    ```bash
    php artisan key:generate
    ```

5.  **Configure o Banco de Dados:**
    Abra o arquivo `.env` e configure as variáveis de ambiente `DB_*` para que correspondam às credenciais do seu banco de dados local.

    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=PREF-DESK
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Execute as Migrations e Seeders:**
    Este comando irá criar as tabelas no banco de dados e preenchê-las com os dados iniciais (papéis, permissões e usuário administrador).
    ```bash
    php artisan migrate --seed
    ```
    > **Nota:** O usuário administrador padrão é criado com as credenciais `admin@admin.com` e a senha `Y]uqsn0.`.

7.  **Instale as dependências do NPM:**
    ```bash
    npm install
    ```

8.  **Execute o servidor de desenvolvimento:**
    Este comando, configurado em seu `composer.json`, irá iniciar o servidor do Laravel, a fila e o Vite para compilação de assets em um único terminal.
    ```bash
    composer run dev
    ```

Pronto! A aplicação estará rodando em `http://127.0.0.1:8000`.

## Em andamento
>  <del>Remover ativos.</del> <br />
>  Deixar o código limpo. <br />
>  Aprimorar as regras de negócio. <br />
>  Melhorar lógica dos chamados. <br />


## 📄 Licença

Este projeto é um software de código aberto licenciado sob a [Licença MIT](https://opensource.org/licenses/MIT).