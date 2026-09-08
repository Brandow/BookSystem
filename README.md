
# BookSystem

Desafio Especialista FullStack PHP TWIG


## Sobre o Projeto

O projeto é um sistema simples para cadastro/edição/exclusão de Livros, Autores, Assuntos/Generos utilizando a linguagem de programação PHP com o Framework Symfony 7 e o Twig Template Engine.

A estilização foi feita com a biblioteca Bootstrap 5.3




## Tecnologias Utilizadas

- **PHP 8.2+**
- **Symfony 7.4**
- **Twig 3**
- **Doctrine ORM 3**
- **MySQL 8.0+**
- **Bootstrap 5.3 & Bootstrap Icons**
- **DomPdf** (Geração de relatórios)

---

## Requisitos do Sistema

Antes de iniciar, certifique-se de possuir instalado em sua máquina:

- **PHP** versão `>= 8.2` (com as extensões `pdo_mysql`, `ctype`, `iconv` e `mbstring` habilitadas)
- **Composer** (gerenciador de dependências PHP)
- **MySQL** versão `>= 8.0` (ou MariaDB correspondente)
- **Symfony CLI**

---

## Instruções para Implantação / Execução

Siga os passos abaixo para configurar e executar o projeto localmente:

### 1. Clonar o Repositório
```bash
git clone https://github.com/Brandow/BookSystem
cd booksystem
```

### 2. Instalar as Dependências
Execute o Composer para instalar as bibliotecas do Symfony e demais dependências:
```bash
composer install
```

### 3. Configurar as Variáveis de Ambiente
Copie o arquivo `.env` para criar seu arquivo de configurações locais `.env.local` (ou ajuste as configurações diretamente no seu `.env`):
```bash
cp .env .env.local
```
Edite a variável `DATABASE_URL` informando o usuário, senha, host, porta e nome do banco de dados MySQL:
```dotenv
DATABASE_URL="mysql://SEU_USUARIO:SUA_SENHA@127.0.0.1:3306/booksystem?serverVersion=8.0.32&charset=utf8mb4"
```

### 4. Criação e Importação do Banco de Dados
O script SQL completo para criação das tabelas e relacionamentos está disponível no arquivo `bancodedados.sql` na raiz do projeto.

Você pode importá-lo de duas formas:

- **Via Linha de Comando (MySQL Client):**
  ```bash
  mysql -u SEU_USUARIO -p < bancodedados.sql
  ```

- **Via Ferramenta Gráfica (HeidiSQL, DBeaver, phpMyAdmin, MySQL Workbench):**
  1. Abra seu cliente de banco de dados preferido.
  2. Conecte-se ao seu servidor MySQL local.
  3. Abra o arquivo `bancodedados.sql` e execute o script.


### 5. Iniciar o Servidor de Desenvolvimento

Você pode iniciar o servidor local usando o **Symfony CLI** ou o próprio servidor embutido do **PHP**:

- **Opção 1: Usando Symfony CLI (Recomendado):**
  ```bash
  symfony server:start
  ```

- **Opção 2: Usando o servidor nativo do PHP:**
  ```bash
  php -S localhost:8000 -t public
  ```

- **Opção 3: Usando Laragon / Apache:**
  Basta apontar o `DocumentRoot` do VirtualHost para a pasta `public/` do projeto.

---

### 6. Acessar a Aplicação
Abra seu navegador e acesse:
```
http://localhost:8000
```
*(ou a URL correspondente caso utilize VirtualHost no Laragon, ex: `http://booksystem.test`)*

---

## Referências

Para a construção do projeto foram utilizados:

- [Documentação Twig 3](https://twig.symfony.com/doc/3.x/)
- [Documentação Symfony 7](https://symfony.com/doc)
- [Geração de Relatórios com DomPdf](https://dompdf.net/)
- [Documentação Bootstrap](https://getbootstrap.com/docs/5.3/getting-started/introduction)
- [Documentação QueryBuilder](https://www.doctrine-project.org/projects/doctrine-orm/en/3.6/reference/query-builder.html)
- [Ícones do Bootstrap](https://icons.getbootstrap.com/)
- [Status Cards na Página Home](https://bootstrapexamples.com/@anonymous/stats-cards-using-bootstrap-5)