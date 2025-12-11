# 🛒 Projeto de PDV - MS Code

Um sistema de Ponto de Venda (PDV) e controle de estoque simples, desenvolvido com intuito acadêmico para gestão de pequenos negócios.

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.4-777BB4?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=symfony" alt="Symfony">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/status-MVP%20Concluído-brightgreen?style=for-the-badge" alt="Status: Concluído">
</p>

## 📝 Índice

* [Sobre o Projeto](#-sobre-o-projeto)
* [Design & UI](#-design--ui)
* [Visão Geral (Screenshots)](#-visão-geral)
* [Tecnologias Utilizadas](#-tecnologias-utilizadas)
* [Funcionalidades](#-principais-funcionalidades)
* [Como Rodar o Projeto](#%EF%B8%8F-como-rodar-o-projeto)
* [Aprendizados](#-aprendizados)
* [Time de Desenvolvimento](#-time-de-desenvolvimento)

---

## 💻 Sobre o Projeto

Este projeto é um *Sistema de Ponto de Venda (PDV)* desenvolvido com o objetivo de facilitar o controle de vendas de uma pequena loja e aplicar conhecimentos em Desenvolvimento Web adquiridos no curso MS Code. Construído com PHP, framework Symfony e arquitetura MVC, o sistema oferece uma solução leve e intuitiva para o controle de vendas e gestão de estoque.

O objetivo é permitir que pequenos estabelecimentos gerenciem suas operações diárias com eficiência, segurança e profissionalismo, possibilitando realizar vendas, controlar o estoque de produtos e visualizar um histórico de transações.

---

## 🎨 Design & UI

Antes de iniciar o desenvolvimento, o projeto foi prototipado para garantir uma boa experiência de usuário (UX). Abaixo, o wireframe inicial que guiou a construção do layout.

<div align="center">
  <img src="docs/wireframe-dashboard.jpeg" alt="Wireframe do Projeto" width="700px">
  <p><em>Rascunho inicial da estrutura do Dashboard</em></p>
</div>

---

## 📸 Visão Geral

Algumas telas principais do sistema:

| Tela de Venda (PDV) | Dashboard | Cadastro de Produtos |
| :---: | :---: | :---: |
| ![Dashboard](docs/Tela-PDV(NovaVenda).png) | ![Dashboard Geral](docs/dashboard-atualizado.png) | ![Cadastro de Produtos](docs/cadastro-produto.png) |

> [Clique aqui para ver todas as imagens na pasta docs](/docs)

---

## 🚀 Tecnologias Utilizadas

O projeto foi construído utilizando as seguintes tecnologias:

* **Backend:** PHP (v8.4)
* **Framework:** Symfony (v7.4)
* **Banco de Dados:** MySQL
* **Frontend:** Bootstrap (v5.x), JavaScript, Twig (Template Engine)
* **Gerenciador de Dependências:** Composer
* **Versionamento:** Git & GitHub

---

## ✨ Principais Funcionalidades

- ***🛍️ Gestão de Vendas*** - Registro e controle completo de vendas com interface intuitiva
- ***📦 Controle de Estoque*** - Gerenciamento eficiente de produtos e quantidades
- ***👥 Cadastro de Clientes*** - Registro e histórico de clientes do estabelecimento
- ***📊 Dashboard Gerencial*** - Visão estratégica do negócio com métricas e fluxo de caixa
- ***🔐 Autenticação Segura*** - Sistema de login com controle de acesso (Admin e Operador)
- ***🧾 Emissão de Recibos*** - Geração de comprovantes de venda para clientes

---

## ⚙️ Como Rodar o Projeto

### 📋 Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- [PHP 8.4 ou superior](https://www.php.net/downloads)
- [Composer](https://getcomposer.org/)
- [MySQL 8.0](https://www.mysql.com/)
- [Symfony CLI](https://symfony.com/download) (opcional, mas recomendado)

### 1️⃣ Clone o repositório

```bash
$ git clone https://github.com/JP-Pardinho/ponto-de-venda-mscode.git
$ cd ponto-de-venda-mscode
```

### 2️⃣ Instale as dependências

```bash
$ composer install
```

### 3️⃣ Configure o banco de dados

Crie um arquivo .env.local na raiz do projeto e configure a conexão com o banco:

env
DATABASE_URL="mysql://usuario:senha@127.0.0.1:3306/nome_do_banco?serverVersion=8.0"


### 4️⃣ Crie o banco de dados

```bash
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
```

### 5️⃣ (Opcional) Carregue dados de exemplo

```bash
$ php bin/console doctrine:fixtures:load
```

### 6️⃣ Inicie o servidor

```bash
$ symfony server:start
```

Ou, se não tiver o Symfony CLI instalado:

```bash
php -S localhost:8000 -t public/
```

Acesse o sistema em: *http://127.0.0.1:8000*

---

## 🔑 Usuários Padrão

Após a instalação, você pode acessar o sistema com:

*Administrador:*
- Usuário: admin
- Senha: admin123

*Operador:*
- Usuário: operador
- Senha: operador123

> ⚠️ *Importante:* Altere as senhas padrão após o primeiro acesso!

---

## 📂 Estrutura do Projeto

```text
ponto-de-venda-mscode/
├── assets/              # Arquivos estáticos (app.css, JS)
├── config/              # Arquivos de configuração
├── docs/                # Documentação e screenshots do projeto
├── public/              # Ponto de entrada (index.php)
├── src/
│   ├── Controller/      # Controladores da aplicação
│   ├── Entity/          # Entidades do Doctrine
│   ├── Exceptions/      # Tratamento de exceções personalizadas
│   ├── Form/            # Formulários
│   ├── Repository/      # Repositórios
│   ├── Security/        # Configurações de segurança
│   └── Services/        # Regras de negócio e serviços
├── templates/           # Templates Twig
├── var/                 # Cache e logs
└── composer.json        # Dependências do projeto
```
---

## 🧠 Aprendizados
Durante o desenvolvimento deste projeto, pudemos aprimorar nossos conhecimentos em:

* **Arquitetura MVC:** Estruturação profissional de pastas usando o padrão Model-View-Controller do Symfony.

* **Doctrine ORM:** Manipulação de banco de dados e relacionamentos entre entidades sem a necessidade de escrever SQL puro.

* **Twig & Bootstrap:** Criação de interfaces dinâmicas e responsivas.

* **Regras de Negócio:** Implementação de lógica para baixa de estoque e cálculo de vendas.

---

## 👥 Time de Desenvolvimento

_Nome do grupo:_ ÁPICE

**Integrantes:**

| Nome | Contato |
| :--- | :--- |
| **Amábile Kosloski** | [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](www.linkedin.com/in/amábile-kosloski-927216302) |
| **João Pedro Pardinho** | [![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/jppardinho/) |
| **Leonardo** | |

_Curso:_ MS Code - 2025 4ª Edição

---

## 🤝 Agradecimentos

Agradecemos imensamente ao curso ***MS Code*** (Móveis Simonetti) por proporcionar o ambiente de aprendizado e os recursos necessários para o desenvolvimento deste projeto. A oportunidade de aplicar conhecimentos teóricos em um projeto prático foi fundamental para nosso crescimento profissional e acadêmico.

---

## 📄 Licença

Este projeto foi desenvolvido para fins educacionais como parte do curso MS Code.

---

<p align="center">
  ⭐ <strong>Desenvolvido com dedicação pela equipe ÁPICE</strong> ⭐
</p>
