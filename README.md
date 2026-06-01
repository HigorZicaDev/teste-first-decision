# Gerenciamento de Produtos

Aplicação web para gerenciamento de produtos desenvolvida com Laravel 12, PostgreSQL e Docker.

O projeto disponibiliza uma interface administrativa para gerenciamento de produtos e uma API RESTful versionada protegida por autenticação via token.

---

## Funcionalidades

* Cadastro, edição, visualização e remoção de produtos
* Interface web responsiva com Blade e Tailwind CSS
* API RESTful versionada (`v1`)
* Autenticação web por sessão
* Autenticação da API via Laravel Sanctum
* Busca e filtros avançados
* Testes automatizados com PHPUnit
* Ambiente Docker pronto para execução

---

## Entidade Produto

| Campo               | Tipo    | Regras                       |
| ------------------- | ------- | ---------------------------- |
| `name`              | string  | obrigatório e único          |
| `description`       | string  | opcional                     |
| `price`             | decimal | obrigatório e maior que zero |
| `quantity_in_stock` | integer | obrigatório e não negativo   |

---

## Stack Utilizada

### Backend

* PHP 8.4
* Laravel 12
* PostgreSQL 16
* Laravel Sanctum

### Frontend

* Blade
* Tailwind CSS v4
* Starting Point UI

### Testes

* PHPUnit
* SQLite In-Memory

### Infraestrutura

* Docker
* Nginx
* PHP-FPM
* Supervisor

---

# Início Rápido

## Pré-requisitos

* Docker
* Docker Compose

## Clonando o projeto

```bash
git clone <repo-url>
cd teste-first-decision
```

## Executando a aplicação

```bash
docker compose up -d --build
```

A aplicação estará disponível em:

```text
http://localhost:8000
```

---

## Configuração Automática

Durante a primeira inicialização, o ambiente realiza automaticamente:

* Build dos assets frontend
* Instalação das dependências PHP
* Criação do arquivo `.env`
* Geração da `APP_KEY`
* Execução das migrations
* Execução dos seeders
* Inicialização do Nginx
* Inicialização do PHP-FPM
* Inicialização do PostgreSQL

Nenhuma configuração manual adicional é necessária.

---

## Credenciais de Acesso

Após a inicialização, um usuário padrão será criado:

```text
Email: firstdecision@example.com
Senha: password123
```

Também serão criados 15 produtos de exemplo para facilitar os testes da aplicação.

---

## Comandos Úteis

### Visualizar logs

```bash
docker compose logs -f app
```

### Executar testes

```bash
docker compose exec app php artisan test
```

### Acessar o container da aplicação

```bash
docker compose exec app bash
```

### Executar comandos Artisan

```bash
docker compose exec app php artisan migrate
```

### Parar os containers

```bash
docker compose down
```

### Remover containers e banco de dados

```bash
docker compose down -v
```

---

# Desenvolvimento sem Docker

Caso prefira executar a aplicação localmente:

## Pré-requisitos

* PHP 8.4+
* Composer
* Node.js 20+
* PostgreSQL 16+

## Instalação

```bash
composer install

cp .env.example .env

php artisan key:generate

npm install
npm run build

php artisan migrate --seed

php artisan serve
```

Acesse:

```text
http://localhost:8000
```

---

# Arquitetura

O projeto segue princípios de arquitetura limpa e boas práticas de desenvolvimento.

### Controllers

Responsáveis apenas pelo fluxo HTTP.

* Web:

  * `App\Http\Controllers\Painel\ProductController`

* API:

  * `App\Http\Controllers\Api\V1\ProductController`

### Form Requests

Validação centralizada e reutilizada entre web e API.

* `StoreProductRequest`
* `UpdateProductRequest`
* `LoginRequest`
* `RegisterRequest`

### Services

As regras de negócio são concentradas em:

* `ProductService`

### Resources

Padronização das respostas da API:

* `ProductResource`

### Traits

Padronização do formato das respostas:

* `ApiResponse`

---

# Testes

Executar todos os testes:

```bash
php artisan test
```

ou

```bash
vendor/bin/phpunit
```

A cobertura contempla:

* Models
* Services
* Requests
* Autenticação Web
* CRUD Web
* Autenticação API
* CRUD API

---

# API RESTful

Base URL:

```text
/api/v1
```

Todas as respostas seguem o formato:

```json
{
  "data": {},
  "message": "",
  "errors": null
}
```

---

## Autenticação

### Login

```http
POST /api/v1/login
```

Exemplo:

```bash
curl -X POST http://localhost:8000/api/v1/login \
  -H "Accept: application/json" \
  -d "email=firstdecision@example.com&password=password123"
```

Resposta:

```json
{
  "data": {
    "token": "1|xxxxxxxxxxxx",
    "token_type": "Bearer"
  },
  "message": "Autenticado com sucesso.",
  "errors": null
}
```

Utilize o token recebido no header:

```http
Authorization: Bearer <token>
```

---

## Endpoints

| Método | Endpoint                | Descrição            |
| ------ | ----------------------- | -------------------- |
| POST   | `/api/v1/login`         | Realiza autenticação |
| POST   | `/api/v1/logout`        | Revoga o token atual |
| GET    | `/api/v1/products`      | Lista produtos       |
| POST   | `/api/v1/products`      | Cria produto         |
| GET    | `/api/v1/products/{id}` | Exibe produto        |
| PUT    | `/api/v1/products/{id}` | Atualiza produto     |
| DELETE | `/api/v1/products/{id}` | Remove produto       |

---

## Filtros Disponíveis

Os filtros podem ser utilizados tanto na API quanto na interface web.

| Parâmetro | Descrição             |
| --------- | --------------------- |
| search    | Busca por nome        |
| price_min | Preço mínimo          |
| price_max | Preço máximo          |
| stock_min | Estoque mínimo        |
| stock_max | Estoque máximo        |
| per_page  | Quantidade por página |

Exemplo:

```http
GET /api/v1/products?search=mouse&price_min=10&price_max=100
```

---

## Exemplo de Resposta

```json
{
  "data": {
    "items": [
      {
        "id": 1,
        "name": "Produto Exemplo",
        "price": "10.00",
        "quantity_in_stock": 5
      }
    ],
    "meta": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 15,
      "total": 1
    }
  },
  "message": "Produtos listados com sucesso.",
  "errors": null
}
```

---

## Erro de Validação

```json
{
  "data": null,
  "message": "Os dados informados são inválidos.",
  "errors": {
    "name": [
      "The name field is required."
    ]
  }
}
```
